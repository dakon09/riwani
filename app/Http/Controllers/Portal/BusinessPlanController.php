<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessPlanController extends Controller
{
    public function index(Request $request)
    {
        // Check if user has already started the business plan
        // For now, we use a session flag. In real DB, we would check 'business_plan_entries' table
        if ($request->session()->has('bp_started')) {
            return redirect()->route('portal.business-plan.step', ['step' => 1]);
        }

        return view('portal.business_plan.intro');
    }

    public function showStep($step)
    {
        $step = (int) $step;
        if ($step < 1 || $step > 10) {
            return redirect()->route('portal.business-plan.step', ['step' => 1]);
        }

        // Mock Data for now (Will be replaced by DB fetch)
        $data = [
            'step' => $step,
        ];

        return view('portal.business_plan.index', compact('step'));
    }

    public function storeStep(Request $request, $step)
    {
        // Set started flag
        $request->session()->put('bp_started', true);

        // Mock Save Logic
        return redirect()->route('portal.business-plan.step', ['step' => $step + 1])
            ->with('success', 'Data tahap ' . $step . ' berhasil disimpan (Draft).');
    }
}
