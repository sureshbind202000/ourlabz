<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NotificationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationMessageController extends Controller
{
    // index
    public function index()
    {
        return view('backend.superadmin.notifications.message');
    }

    // List
    public function list()
    {
        $message = NotificationMessage::orderBy('notification_for', 'asc')->get();
        return response()->json($message);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'notification_for' => 'required',
                'message' => 'required',
                'link' => 'required',
            ]);

            // Create message
            $message = NotificationMessage::create([
                'notification_for' => $request->notification_for,
                'slug' => Str::slug($request->notification_for),
                'message' => $request->message,
                'link' => $request->link,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Notification message added successfully!',
                'data' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store message: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $message = NotificationMessage::findOrFail($id);

        return response()->json(['message' => $message]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $message = NotificationMessage::findOrFail($id);

            $validated = $request->validate([
                'message' => 'required',
            ]);

            $message->notification_for = $request->notification_for;
            $message->slug = Str::slug($request->notification_for);
            $message->message = $request->message;
            $message->link = $request->link ?? '#';

            $message->save();

            DB::commit();

            return response()->json([
                'success' => 'Notification message updated successfully!',
                'data' => $message
            ]);
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update message: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        try {

            $message = NotificationMessage::findOrFail($id);
            $message->delete();

            return response()->json(['success' => true, 'message' => 'Message deleted successfully.']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Failed to delete message: ' . $e->getMessage()], 500);
        }
    }
}
