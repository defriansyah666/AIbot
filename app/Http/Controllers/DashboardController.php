<?php

namespace App\Http\Controllers;

use App\Models\InjectionDataInput;
use App\Models\AssemblingDataInput;
use App\Models\DeliveryDataInput;
use App\Models\StockWip;
use App\Models\StockFg;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get today's production data
        $todayInjection = InjectionDataInput::whereDate('tanggal_input', today())->sum('qty_hasil');
        $todayAssembling = AssemblingDataInput::whereDate('tanggal_input', today())->sum('qty_assembly');
        $todayDelivery = DeliveryDataInput::whereDate('tanggal_delivery', today())->sum('qty_delivery');

        // Get low stock alerts
        $lowStockWip = StockWip::where('qty_wip', '<', 10)->count();
        $lowStockFg = StockFg::where('qty_fg', '<', 5)->count();

        // Get weekly trend data for charts
        $weeklyInjection = [];
        $weeklyAssembling = [];
        $weeklyDelivery = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weeklyInjection[] = InjectionDataInput::whereDate('tanggal_input', $date)->sum('qty_hasil');
            $weeklyAssembling[] = AssemblingDataInput::whereDate('tanggal_input', $date)->sum('qty_assembly');
            $weeklyDelivery[] = DeliveryDataInput::whereDate('tanggal_delivery', $date)->sum('qty_delivery');
        }

        return view('dashboard', compact(
            'todayInjection',
            'todayAssembling', 
            'todayDelivery',
            'lowStockWip',
            'lowStockFg',
            'weeklyInjection',
            'weeklyAssembling',
            'weeklyDelivery'
        ));
    }
}

