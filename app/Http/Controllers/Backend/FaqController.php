<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    // Index
    public function index()
    {
        return view('backend.website.faq.list');
    }

    // List
    public function list()
    {
        $faq = Faq::where('faq_for', 'Website')->orderBy('is_active', 'desc')->get();
        return response()->json($faq);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $faq = Faq::create([
                'faq_for' => 'Website',
                'question' => $request->question,
                'answer' => $request->answer,
            ]);

            DB::commit();

            return response()->json(['success' => 'FAQ added successfully!', 'data' => $faq]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to store FAQ: ' . $e->getMessage()], 500);
        }
    }
}
