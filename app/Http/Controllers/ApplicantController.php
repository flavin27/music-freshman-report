<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    public function index(): View
    {
        $dataByInstrument = Applicant::select('instrument',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN is_approved = 1 THEN 1 ELSE 0 END) as aprovados'),
            DB::raw('ROUND(SUM(CASE WHEN is_approved = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) as porcentagem')
        )
            ->groupBy('instrument')
            ->orderBy('instrument')
            ->get();

        return view('applicants.index', [
            'data' => $dataByInstrument,
        ]);
    }

    public function show(string $instrument): View
    {
        $dataBySemester = Applicant::select('semester',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN is_approved = 1 THEN 1 ELSE 0 END) as aprovados'),
            DB::raw('ROUND(SUM(CASE WHEN is_approved = 1 THEN 1 ELSE 0 END) / COUNT(*) * 100, 2) as porcentagem')
        )
            ->where('instrument', $instrument)
            ->groupBy('semester')
            ->orderBy('semester', 'desc')
            ->get();

        return view('applicants.details', [
            'instrument' => $instrument,
            'data' => $dataBySemester,
        ]);
    }
}
