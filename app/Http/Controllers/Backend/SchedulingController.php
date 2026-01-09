<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class SchedulingController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.superadmin.scheduling.list');
    }

    // Add Schedules
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'scheduler_id' => 'required',
            'scheduling_for' => 'required|array',
            'start_date' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'time_gap' => 'nullable|integer|min:1',
            'excluding_days' => 'nullable|array',
            'slots' => 'nullable|integer|min:1',
        ]);

        // Get the time_gap value, ensure it's an integer
        $timeGap = (int) $request->time_gap; // Default to 0 if empty

        // Create a CarbonPeriod for the given date range
        $dates = CarbonPeriod::create($request->start_date, $request->end_date);

        // Loop through each date in the range
        foreach ($dates as $date) {
            $day = $date->format('l');

            // Skip dates based on excluding_days
            if ($request->excluding_days && in_array($day, $request->excluding_days)) {
                continue;
            }

            // Loop through each scheduling type (Visiting, Home Collection, Corporate)
            foreach ($request->scheduling_for as $type) {
                $start = Carbon::parse($request->start_time);
                $end = Carbon::parse($request->end_time);

                // If time_gap is set, create time slots
                if ($timeGap > 0) {
                    while ($start->lt($end)) {
                        $slotStart = $start->copy();
                        $slotEnd = $start->copy()->addMinutes($timeGap);

                        // Stop if the slot end time exceeds the final end time
                        if ($slotEnd->gt($end)) break;

                        // Create the schedule for the slot
                        Schedule::create([
                            'scheduler_id' => $request->scheduler_id,
                            'scheduling_for' => $type,
                            'day' => $day,
                            'date' => $date->format('Y-m-d'),
                            'from_time' => $slotStart->format('H:i'),
                            'to_time' => $slotEnd->format('H:i'),
                            'slots' => $request->slots,
                        ]);

                        // Move to the next time slot
                        $start->addMinutes($timeGap);
                    }
                } else {
                    // No time_gap provided, create a single schedule
                    Schedule::create([
                        'scheduler_id' => $request->scheduler_id,
                        'scheduling_for' => $type,
                        'day' => $day,
                        'date' => $date->format('Y-m-d'),
                        'from_time' => $start->format('H:i'),
                        'to_time' => $end->format('H:i'),
                        'slots' => $request->slots,
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Schedule(s) created successfully.']);
    }

    // Edit Schedules
    public function edit($id)
    {
        return Schedule::findOrFail($id);
    }

    // Update Schedules
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->only([
            'from_time',
            'to_time',
            'scheduling_for'
        ]));

        return response()->json(['message' => 'Schedule updated successfully']);
    }

    // Fectch Schedules
    public function filter(Request $request)
    {
        $auth = auth()->user();
        $role = auth()->user()->role;
        $query = Schedule::query();
        if ($role == 2) {
            $query->where('scheduler_id', $auth->lab_id);
        }elseif($role == 3){
            $query->where('scheduler_id', $auth->user_id);
        }
        if ($request->filled('filterDate')) {
            $query->whereDate('date', $request->filterDate);
        } else {
            if ($request->filled('day')) {
                $query->where('day', $request->day);
            }

            if ($request->filled('month')) {
                $month = Carbon::parse($request->month);
                $query->whereMonth('date', $month->month)
                    ->whereYear('date', $month->year);
            } else {
                $query->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year);
            }
        }

        if ($request->filled('scheduling_for')) {
            $query->where('scheduling_for', $request->scheduling_for);
        }

        // Execute query
        $schedules = $query->latest()->get();

        // Add booked_count
        foreach ($schedules as $schedule) {
            $schedule->booked_count = Booking::where('lab_id', auth()->user()->lab_id)
                ->whereDate('booking_date', $schedule->date)
                ->count();
        }

        // ✅ Return the modified $schedules
        return response()->json($schedules);
    }


    // Delete Schedules
    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully']);
    }

    public function deleteByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $deleted = Schedule::where('date', $request->date)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Schedules deleted successfully.']);
        } else {
            return response()->json(['message' => 'No schedules found for this date.'], 404);
        }
    }

    // Update Slot
    public function updateSlotsByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'slots' => 'required|integer|min:1',
        ]);

        Schedule::where('scheduler_id', auth()->user()->lab_id)
            ->whereDate('date', $request->date)
            ->update(['slots' => $request->slots]);

        return response()->json(['message' => 'Slots updated for all schedules on that date.']);
    }
}
