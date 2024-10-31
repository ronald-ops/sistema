<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SucesosExport implements FromView
{
    protected $sucesos;

    public function __construct($sucesos)
    {
        $this->sucesos = $sucesos;
    }

    public function view(): View
    {
        return view('sucesos.export', [
            'sucesos' => $this->sucesos
        ]);
    }
}
