<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TestsExport implements FromView
{
    protected $tests;

    public function __construct($tests)
    {
        $this->tests = $tests;
    }

    public function view(): View
    {
        return view('exports.tests_template', [
            'tests' => $this->tests
        ]);
    }
}