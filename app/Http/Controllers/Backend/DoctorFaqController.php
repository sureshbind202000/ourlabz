<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DoctorFaqController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.superadmin.doctors.faq');
    }

    // List
    public function list()
    {
        $faq = Faq::orderBy('is_active', 'desc')->get();
        return response()->json($faq);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $faq = Faq::create([
                'faq_for' => 'Doctor',
                'question' =>$request->question,
                'answer' =>$request->answer,
            ]);

            DB::commit();

            return response()->json(['success' => 'FAQ added successfully!', 'data' => $faq]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store FAQ: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);

        return response()->json(['faq' => $faq]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $faq = Faq::findOrFail($id);

            $faqData = [
                'question' => $request->question,
                'answer' => $request->answer,
            ];

            $faq->update($faqData);


            DB::commit();
            return response()->json(['success' => 'FAQ updated successfully!', 'data' => $faq]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update FAQ: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $faq = Faq::find($request->id);
        if ($faq) {
            $faq->is_active = $request->status;
            $faq->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

     // Delete
    public function destroy($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return response()->json(['success' => false, 'message' => 'FAQ not found.'], 404);
        }

        $faq->delete();

        return response()->json(['success' => true, 'message' => 'FAQ deleted successfully.']);
    }
}
