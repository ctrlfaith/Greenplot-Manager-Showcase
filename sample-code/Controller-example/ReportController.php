<?php

namespace App\Http\Controllers;

use App\Models\Garden;
use App\Models\Plant;
use App\Models\PlantingRecord;
use App\Models\YieldRecord;
use App\Models\Cost;
use App\Services\Reports\ProfitLossService;
use App\Services\Reports\HarvestSummaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected $profitLossService;
protected $harvestSummaryService;
protected $harvestKPIService;

public function __construct(
    ProfitLossService $profitLossService,
    HarvestSummaryService $harvestSummaryService,
    \App\Services\Reports\HarvestKPIService $harvestKPIService
) {
    $this->middleware('auth');
    $this->profitLossService = $profitLossService;
    $this->harvestSummaryService = $harvestSummaryService;
    $this->harvestKPIService = $harvestKPIService;
}

    /**
     * แสดงหน้าเลือกประเภทรายงาน
     */
    public function index()
    {
        $gardens = Garden::where('user_id', Auth::id())->get();
        $plants = Plant::all();
        
        // ดึงข้อมูลสถิติเพิ่มเติม
        $activePlantings = PlantingRecord::whereHas('garden', function($q) {
            $q->where('user_id', Auth::id());
        })->where('status', 'active')->count();
        
        $totalRevenue = YieldRecord::whereHas('plantingRecord.garden', function($q) {
            $q->where('user_id', Auth::id());
        })->sum('revenue');
        
        $totalCosts = Cost::whereHas('plantingRecord.garden', function($q) {
            $q->where('user_id', Auth::id());
        })->sum('amount');

        return view('reports.index', compact(
            'gardens', 
            'plants', 
            'activePlantings', 
            'totalRevenue', 
            'totalCosts'
        ));
    }

    /**
     * รายงานกำไร-ขาดทุน
     */
    public function profitLoss(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'garden_id' => 'nullable|exists:gardens,id',
            'plant_id' => 'nullable|exists:plants,id',
        ]);

        // เรียกใช้ Service
        $data = $this->profitLossService->generate($validated);

        // ข้อมูลสำหรับ View
        $gardens = Garden::where('user_id', Auth::id())->get();
        $plants = Plant::all();

        // แยกข้อมูลเพื่อส่งให้ View
        return view('reports.profit-loss', array_merge($data, [
            'gardens' => $gardens,
            'plants' => $plants,
            'startDate' => $data['params']['start_date'],
            'endDate' => $data['params']['end_date'],
            'gardenId' => $data['params']['garden_id'],
            'plantId' => $data['params']['plant_id'],
            'totalRevenue' => $data['total_revenue'],
            'totalCosts' => $data['total_costs'],
            'netProfit' => $data['net_profit'],
            'roi' => $data['roi'],
            'gardenSummary' => $data['garden_summary'],
            'plantSummary' => $data['plant_summary'],
            'costBreakdown' => $data['cost_breakdown'],
            'insights' => $data['insights'],
            'chartData' => $data['chart_data'],
            'costPieData' => $data['cost_pie_data'],
            'comparison' => $data['comparison'],
            'breakEven' => $data['break_even'],
            'customerAnalysis' => $data['customer_analysis'],
            'costPerUnit' => $data['cost_per_unit'],
            'profitabilityTrend' => $data['profitability_trend']
        ]));
    }

    /**
     * รายงานสรุปผลผลิต
     */
    public function harvestSummary(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'garden_id' => 'nullable|exists:gardens,id',
            'plant_id' => 'nullable|exists:plants,id',
        ]);

        $data = $this->harvestSummaryService->generate($validated);

        // ข้อมูลสำหรับ Filters
        $gardens = Garden::where('user_id', Auth::id())->get();
        $plants = Plant::all();

        // ส่งข้อมูลไปยัง View
        return view('reports.harvest-summary', [
            // ข้อมูลพื้นฐาน
            'totalHarvests' => $data['total_harvests'],
            'totalQuantity' => $data['total_quantity'],
            'totalRevenue' => $data['total_revenue'],
            'avgPrice' => $data['avg_price'],
            
            // สรุปตามมิติ
            'gardenSummary' => $data['garden_summary'],
            'plantSummary' => $data['plant_summary'],
            
            // อัตราความสำเร็จ
            'successRate' => $data['success_rate'],
            'totalPlantings' => $data['total_plantings'],
            'harvestedPlantings' => $data['harvested_plantings'],
            
            // แนวโน้มและผลงานเด่น
            'chartData' => $data['chart_data'],
            'topGarden' => $data['top_garden'],
            'topPlant' => $data['top_plant'],
            'topPeriod' => $data['top_period'],
            
            // การเปรียบเทียบ
            'comparison' => $data['comparison'],
            
            // KPIs เพิ่มเติม
            'kpis' => $data['kpis'] ?? null,
            
            // Insights & Recommendations
            'insights' => $data['insights'] ?? [],
            
            // Calendar Heatmap
            'heatmap' => $data['heatmap'] ?? null,
            
            // Leaderboard Top 5
            'leaderboard' => [
                'top_5_gardens' => $data['top_5_gardens'] ?? [],
                'top_5_plants' => $data['top_5_plants'] ?? []
            ],
            
            // Params สำหรับ Filters
            'startDate' => $data['params']['start_date'],
            'endDate' => $data['params']['end_date'],
            'gardenId' => $data['params']['garden_id'],
            'plantId' => $data['params']['plant_id'],
            
            // ข้อมูล Filters
            'gardens' => $gardens,
            'plants' => $plants,
        ]);
    }

    /**
     * Export PDF - Profit/Loss
     */
    public function exportProfitLossPdf(Request $request)
    {
        try {
            $validated = $request->validate([
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'garden_id' => 'nullable|exists:gardens,id',
                'plant_id' => 'nullable|exists:plants,id',
            ]);

            $data = $this->profitLossService->generateForPdf($validated);
            
            $data['params'] = [
                'garden_id' => $validated['garden_id'] ?? null,
                'plant_id' => $validated['plant_id'] ?? null,
            ];
            
            $fontDir = str_replace('\\', '/', storage_path('fonts')) . '/';
            $chroot = str_replace('\\', '/', base_path());
            
            mb_internal_encoding('UTF-8');
            
            $pdf = Pdf::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'thsarabunnew',
                'fontDir' => $fontDir,
                'fontCache' => $fontDir,
                'chroot' => $chroot,
                'enable_font_subsetting' => false,
                'dpi' => 96,
                'debugPng' => false,
                'debugKeepTemp' => false,
                'debugCss' => false,
                'debugLayout' => false,
            ])
            ->loadView('reports.pdf.profit-loss', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);
            
            $startDateStr = $data['start_date']->format('Y-m-d');
            $endDateStr = $data['end_date']->format('Y-m-d');
            $filename = "profit-loss-report-{$startDateStr}-to-{$endDateStr}.pdf";
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('PDF Export Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'เกิดข้อผิดพลาดในการสร้าง PDF: ' . $e->getMessage());
        }
    }

    /**
     * Export PDF - Harvest Summary
     */
    public function exportHarvestSummaryPdf(Request $request)
{
    try {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'garden_id' => 'nullable|exists:gardens,id',
            'plant_id' => 'nullable|exists:plants,id',
        ]);

        // เรียกใช้ Service
        $data = $this->harvestSummaryService->generateForPdf($validated);
        
        $data['params'] = [
            'garden_id' => $validated['garden_id'] ?? null,
            'plant_id' => $validated['plant_id'] ?? null,
        ];
        
        if (!isset($data['kpis']) || empty($data['kpis'])) {
            \Log::warning('KPIs not found in Service data, calculating manually...');
            
            try {
                $data['kpis'] = $this->harvestKPIService->calculate(
                    $data['start_date'],
                    $data['end_date'],
                    $validated['garden_id'] ?? null,
                    $validated['plant_id'] ?? null
                );
                
                \Log::info('Manual KPIs calculated successfully:', $data['kpis']);
                
            } catch (\Exception $kpiError) {
                \Log::error('KPI Calculation failed: ' . $kpiError->getMessage());
                
                $data['kpis'] = [
                    'yield_per_area' => [
                        'total_area_sqm' => 0,
                        'total_area_rai' => 0,
                        'yield_per_rai' => 0,
                        'total_quantity' => 0
                    ],
                    'total_plants' => [
                        'total_plantings' => 0,
                        'unique_plants' => 0
                    ],
                    'avg_days_to_harvest' => [
                        'average_days' => 0,
                        'fastest_days' => null,
                        'slowest_days' => null,
                        'sample_count' => 0
                    ]
                ];
            }
        }
        
        $fontDir = str_replace('\\', '/', storage_path('fonts')) . '/';
        $chroot = str_replace('\\', '/', base_path());
        
        mb_internal_encoding('UTF-8');
        
        // สร้าง PDF
        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'thsarabunnew',
            'fontDir' => $fontDir,
            'fontCache' => $fontDir,
            'chroot' => $chroot,
            'enable_font_subsetting' => false,
            'dpi' => 96,
            'debugPng' => false,
            'debugKeepTemp' => false,
            'debugCss' => false,
            'debugLayout' => false,
        ])
        ->loadView('reports.pdf.harvest-summary', $data)
        ->setPaper('a4', 'portrait')
        ->setWarnings(false);
        
        // Generate filename
        $startDateStr = $data['start_date']->format('Y-m-d');
        $endDateStr = $data['end_date']->format('Y-m-d');
        $filename = "harvest-summary-report-{$startDateStr}-to-{$endDateStr}.pdf";
        
        return $pdf->download($filename);
        
    } catch (\Exception $e) {
        \Log::error('PDF Export Error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return back()->with('error', 'เกิดข้อผิดพลาดในการสร้าง PDF: ' . $e->getMessage());
    }
}

    /**
     * รายงานต้นทุนการผลิต
     */
    public function productionCosts(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'garden_id' => 'nullable|exists:gardens,id',
            'plant_id' => 'nullable|exists:plants,id',
        ]);

        $startDate = $request->start_date ? 
            \Carbon\Carbon::parse($request->start_date) : 
            \Carbon\Carbon::parse(config('app.default_report_start_date'));
        
        $endDate = $request->end_date ? 
            \Carbon\Carbon::parse($request->end_date) : 
            \Carbon\Carbon::now();
        
        $gardenId = $request->garden_id;
        $plantId = $request->plant_id;

        // ดึงข้อมูลต้นทุน
        $costsQuery = Cost::with(['plantingRecord.garden', 'plantingRecord.plant'])
            ->whereHas('plantingRecord.garden', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->whereBetween('date', [$startDate, $endDate]);

        if ($gardenId) {
            $costsQuery->whereHas('plantingRecord', function($q) use ($gardenId) {
                $q->where('garden_id', $gardenId);
            });
        }

        if ($plantId) {
            $costsQuery->whereHas('plantingRecord', function($q) use ($plantId) {
                $q->where('plant_id', $plantId);
            });
        }

        $costs = $costsQuery->get();

        // คำนวดสถิติ
        $totalCosts = $costs->sum('amount');
        $costCount = $costs->count();
        $avgCost = $costCount > 0 ? ($totalCosts / $costCount) : 0;

        // แยกตามประเภท
        $byCostType = $costs->groupBy('cost_type')->map(function($items) {
            return [
                'count' => $items->count(),
                'amount' => $items->sum('amount'),
            ];
        });

        // แยกตามแปลง
        $byGarden = $costs->groupBy('plantingRecord.garden.name')->map(function($items) {
            return [
                'count' => $items->count(),
                'amount' => $items->sum('amount'),
            ];
        });

        // แยกตามพืช
        $byPlant = $costs->groupBy('plantingRecord.plant.name')->map(function($items) {
            return [
                'count' => $items->count(),
                'amount' => $items->sum('amount'),
            ];
        });

        $gardens = Garden::where('user_id', Auth::id())->get();
        $plants = Plant::all();

        return view('reports.production-costs', compact(
            'totalCosts',
            'costCount',
            'avgCost',
            'byCostType',
            'byGarden',
            'byPlant',
            'gardens',
            'plants',
            'startDate',
            'endDate',
            'gardenId',
            'plantId'
        ));
    }

    /**
     * Export PDF - Production Costs
     */
    public function exportProductionCostsPdf(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'garden_id' => 'nullable|exists:gardens,id',
                'plant_id' => 'nullable|exists:plants,id',
            ]);

            $startDate = $request->start_date ? 
                \Carbon\Carbon::parse($request->start_date) : 
                \Carbon\Carbon::parse(config('app.default_report_start_date'));
            
            $endDate = $request->end_date ? 
                \Carbon\Carbon::parse($request->end_date) : 
                \Carbon\Carbon::now();
            
            $gardenId = $request->garden_id;
            $plantId = $request->plant_id;

            $costsQuery = Cost::with(['plantingRecord.garden', 'plantingRecord.plant'])
                ->whereHas('plantingRecord.garden', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->whereBetween('date', [$startDate, $endDate]);

            if ($gardenId) {
                $costsQuery->whereHas('plantingRecord', function($q) use ($gardenId) {
                    $q->where('garden_id', $gardenId);
                });
            }

            if ($plantId) {
                $costsQuery->whereHas('plantingRecord', function($q) use ($plantId) {
                    $q->where('plant_id', $plantId);
                });
            }

            $costs = $costsQuery->get();

            $totalCosts = $costs->sum('amount');
            $costCount = $costs->count();
            $avgCost = $costCount > 0 ? ($totalCosts / $costCount) : 0;

            $byCostType = $costs->groupBy('cost_type')->map(function($items) {
                return [
                    'count' => $items->count(),
                    'amount' => $items->sum('amount'),
                ];
            });

            $byGarden = $costs->groupBy('plantingRecord.garden.name')->map(function($items) {
                return [
                    'count' => $items->count(),
                    'amount' => $items->sum('amount'),
                ];
            });

            $byPlant = $costs->groupBy('plantingRecord.plant.name')->map(function($items) {
                return [
                    'count' => $items->count(),
                    'amount' => $items->sum('amount'),
                ];
            });

            $data = compact(
                'totalCosts',
                'costCount',
                'avgCost',
                'byCostType',
                'byGarden',
                'byPlant',
                'startDate',
                'endDate'
            );

            $data['generated_at'] = \Carbon\Carbon::now();
            $data['user'] = Auth::user();

            $fontDir = str_replace('\\', '/', storage_path('fonts')) . '/';
            $chroot = str_replace('\\', '/', base_path());
            
            mb_internal_encoding('UTF-8');
            
            $pdf = Pdf::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'thsarabunnew',
                'fontDir' => $fontDir,
                'fontCache' => $fontDir,
                'chroot' => $chroot,
                'enable_font_subsetting' => false,
                'dpi' => 96,
            ])
            ->loadView('reports.pdf.production-costs', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);
            
            return $pdf->download('production-costs-report-' . date('Y-m-d') . '.pdf');
            
        } catch (\Exception $e) {
            \Log::error('PDF Export Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'เกิดข้อผิดพลาดในการสร้าง PDF: ' . $e->getMessage());
        }
    }

    /**
     * รายงานประสิทธิภาพการปลูก
     */
    public function plantingEfficiency(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'garden_id' => 'nullable|exists:gardens,id',
            'plant_id' => 'nullable|exists:plants,id',
        ]);

        $startDate = $request->start_date ? 
            \Carbon\Carbon::parse($request->start_date) : 
            \Carbon\Carbon::parse(config('app.default_report_start_date'));
        
        $endDate = $request->end_date ? 
            \Carbon\Carbon::parse($request->end_date) : 
            \Carbon\Carbon::now();
        
        $gardenId = $request->garden_id;
        $plantId = $request->plant_id;

        // ดึงข้อมูลการปลูก
        $plantingsQuery = PlantingRecord::with(['garden', 'plant', 'yieldRecords', 'costs'])
            ->whereHas('garden', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->whereBetween('planting_date', [$startDate, $endDate]);

        if ($gardenId) {
            $plantingsQuery->where('garden_id', $gardenId);
        }

        if ($plantId) {
            $plantingsQuery->where('plant_id', $plantId);
        }

        $plantings = $plantingsQuery->get();

        // คำนวดสถิติ
        $totalPlantings = $plantings->count();
        $activePlantings = $plantings->where('status', 'active')->count();
        $harvestedPlantings = $plantings->where('status', 'harvested')->count();
        $failedPlantings = $plantings->where('status', 'failed')->count();

        $successRate = $totalPlantings > 0 ? (($harvestedPlantings / $totalPlantings) * 100) : 0;

        // คำนวดประสิทธิภาพแต่ละรอบ
        $efficiencyData = $plantings->map(function($planting) {
            $totalYield = $planting->yieldRecords->sum('quantity');
            $totalRevenue = $planting->yieldRecords->sum('revenue');
            $totalCosts = $planting->costs->sum('amount');
            $netProfit = $totalRevenue - $totalCosts;
            $roi = $totalCosts > 0 ? (($netProfit / $totalCosts) * 100) : 0;

            // คำนวดระยะเวลา
            $plantingDate = \Carbon\Carbon::parse($planting->planting_date);
            $harvestDate = $planting->harvest_date ? 
                \Carbon\Carbon::parse($planting->harvest_date) : 
                \Carbon\Carbon::now();
            $duration = $plantingDate->diffInDays($harvestDate);

            return [
                'id' => $planting->id,
                'garden' => $planting->garden->name,
                'plant' => $planting->plant->name,
                'planting_date' => $planting->planting_date,
                'harvest_date' => $planting->harvest_date,
                'status' => $planting->status,
                'duration' => $duration,
                'total_yield' => $totalYield,
                'total_revenue' => $totalRevenue,
                'total_costs' => $totalCosts,
                'net_profit' => $netProfit,
                'roi' => $roi,
                'yield_per_day' => $duration > 0 ? ($totalYield / $duration) : 0,
                'profit_per_day' => $duration > 0 ? ($netProfit / $duration) : 0,
            ];
        })->sortByDesc('roi');

        // สรุปตามแปลง
        $byGarden = $plantings->groupBy('garden.name')->map(function($items) {
            $total = $items->count();
            $harvested = $items->where('status', 'harvested')->count();
            $rate = $total > 0 ? (($harvested / $total) * 100) : 0;

            return [
                'total' => $total,
                'harvested' => $harvested,
                'success_rate' => $rate,
                'total_yield' => $items->sum(function($item) {
                    return $item->yieldRecords->sum('quantity');
                }),
                'total_revenue' => $items->sum(function($item) {
                    return $item->yieldRecords->sum('revenue');
                }),
            ];
        });

        // สรุปตามพืช
        $byPlant = $plantings->groupBy('plant.name')->map(function($items) {
            $total = $items->count();
            $harvested = $items->where('status', 'harvested')->count();
            $rate = $total > 0 ? (($harvested / $total) * 100) : 0;

            return [
                'total' => $total,
                'harvested' => $harvested,
                'success_rate' => $rate,
                'total_yield' => $items->sum(function($item) {
                    return $item->yieldRecords->sum('quantity');
                }),
                'total_revenue' => $items->sum(function($item) {
                    return $item->yieldRecords->sum('revenue');
                }),
            ];
        });

        $gardens = Garden::where('user_id', Auth::id())->get();
        $plants = Plant::all();

        return view('reports.planting-efficiency', compact(
            'totalPlantings',
            'activePlantings',
            'harvestedPlantings',
            'failedPlantings',
            'successRate',
            'efficiencyData',
            'byGarden',
            'byPlant',
            'gardens',
            'plants',
            'startDate',
            'endDate',
            'gardenId',
            'plantId'
        ));
    }

    /**
     * Export PDF - Planting Efficiency
     */
    public function exportPlantingEfficiencyPdf(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'garden_id' => 'nullable|exists:gardens,id',
                'plant_id' => 'nullable|exists:plants,id',
            ]);

            $startDate = $request->start_date ? 
                \Carbon\Carbon::parse($request->start_date) : 
                \Carbon\Carbon::parse(config('app.default_report_start_date'));
            
            $endDate = $request->end_date ? 
                \Carbon\Carbon::parse($request->end_date) : 
                \Carbon\Carbon::now();
            
            $gardenId = $request->garden_id;
            $plantId = $request->plant_id;

            $plantingsQuery = PlantingRecord::with(['garden', 'plant', 'yieldRecords', 'costs'])
                ->whereHas('garden', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->whereBetween('planting_date', [$startDate, $endDate]);

            if ($gardenId) {
                $plantingsQuery->where('garden_id', $gardenId);
            }

            if ($plantId) {
                $plantingsQuery->where('plant_id', $plantId);
            }

            $plantings = $plantingsQuery->get();

            $totalPlantings = $plantings->count();
            $activePlantings = $plantings->where('status', 'active')->count();
            $harvestedPlantings = $plantings->where('status', 'harvested')->count();
            $failedPlantings = $plantings->where('status', 'failed')->count();

            $successRate = $totalPlantings > 0 ? (($harvestedPlantings / $totalPlantings) * 100) : 0;

            $efficiencyData = $plantings->map(function($planting) {
                $totalYield = $planting->yieldRecords->sum('quantity');
                $totalRevenue = $planting->yieldRecords->sum('revenue');
                $totalCosts = $planting->costs->sum('amount');
                $netProfit = $totalRevenue - $totalCosts;
                $roi = $totalCosts > 0 ? (($netProfit / $totalCosts) * 100) : 0;

                $plantingDate = \Carbon\Carbon::parse($planting->planting_date);
                $harvestDate = $planting->harvest_date ? 
                    \Carbon\Carbon::parse($planting->harvest_date) : 
                    \Carbon\Carbon::now();
                $duration = $plantingDate->diffInDays($harvestDate);

                return [
                    'garden' => $planting->garden->name,
                    'plant' => $planting->plant->name,
                    'planting_date' => $planting->planting_date,
                    'status' => $planting->status,
                    'duration' => $duration,
                    'total_yield' => $totalYield,
                    'roi' => $roi,
                ];
            })->sortByDesc('roi')->take(10);

            $byGarden = $plantings->groupBy('garden.name')->map(function($items) {
                $total = $items->count();
                $harvested = $items->where('status', 'harvested')->count();
                $rate = $total > 0 ? (($harvested / $total) * 100) : 0;

                return [
                    'total' => $total,
                    'harvested' => $harvested,
                    'success_rate' => $rate,
                ];
            });

            $byPlant = $plantings->groupBy('plant.name')->map(function($items) {
                $total = $items->count();
                $harvested = $items->where('status', 'harvested')->count();
                $rate = $total > 0 ? (($harvested / $total) * 100) : 0;

                return [
                    'total' => $total,
                    'harvested' => $harvested,
                    'success_rate' => $rate,
                ];
            });

            $data = compact(
                'totalPlantings',
                'activePlantings',
                'harvestedPlantings',
                'failedPlantings',
                'successRate',
                'efficiencyData',
                'byGarden',
                'byPlant',
                'startDate',
                'endDate'
            );

            $data['generated_at'] = \Carbon\Carbon::now();
            $data['user'] = Auth::user();

            $fontDir = str_replace('\\', '/', storage_path('fonts')) . '/';
            $chroot = str_replace('\\', '/', base_path());
            
            mb_internal_encoding('UTF-8');
            
            $pdf = Pdf::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'thsarabunnew',
                'fontDir' => $fontDir,
                'fontCache' => $fontDir,
                'chroot' => $chroot,
                'enable_font_subsetting' => false,
                'dpi' => 96,
            ])
            ->loadView('reports.pdf.planting-efficiency', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);
            
            return $pdf->download('planting-efficiency-report-' . date('Y-m-d') . '.pdf');
            
        } catch (\Exception $e) {
            \Log::error('PDF Export Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'เกิดข้อผิดพลาดในการสร้าง PDF: ' . $e->getMessage());
        }
    }

    /**
     * รายงานการขาย
     */
    public function sales(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'garden_id' => 'nullable|exists:gardens,id',
            'plant_id' => 'nullable|exists:plants,id',
            'buyer_id' => 'nullable|exists:buyers,id',
        ]);

        $startDate = $request->start_date ? 
            \Carbon\Carbon::parse($request->start_date) : 
            \Carbon\Carbon::parse(config('app.default_report_start_date'));
        
        $endDate = $request->end_date ? 
            \Carbon\Carbon::parse($request->end_date) : 
            \Carbon\Carbon::now();
        
        $gardenId = $request->garden_id;
        $plantId = $request->plant_id;
        $buyerId = $request->buyer_id;

        // ดึงข้อมูลการขาย
        $yieldsQuery = YieldRecord::with(['plantingRecord.garden', 'plantingRecord.plant', 'buyer'])
            ->whereHas('plantingRecord.garden', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->whereBetween('harvest_date', [$startDate, $endDate]);

        if ($gardenId) {
            $yieldsQuery->whereHas('plantingRecord', function($q) use ($gardenId) {
                $q->where('garden_id', $gardenId);
            });
        }

        if ($plantId) {
            $yieldsQuery->whereHas('plantingRecord', function($q) use ($plantId) {
                $q->where('plant_id', $plantId);
            });
        }

        if ($buyerId) {
            $yieldsQuery->where('buyer_id', $buyerId);
        }

        $yields = $yieldsQuery->get();

        // สถิติรวม
        $totalSales = $yields->count();
        $totalQuantity = $yields->sum('quantity');
        $totalRevenue = $yields->sum('revenue');
        $avgPrice = $totalQuantity > 0 ? ($totalRevenue / $totalQuantity) : 0;

        // แยกตามลูกค้า
        $byBuyer = $yields->groupBy('buyer.name')->map(function($items) {
            return [
                'sales' => $items->count(),
                'quantity' => $items->sum('quantity'),
                'revenue' => $items->sum('revenue'),
            ];
        })->sortByDesc('revenue');

        // แยกตามพืช
        $byPlant = $yields->groupBy('plantingRecord.plant.name')->map(function($items) {
            return [
                'sales' => $items->count(),
                'quantity' => $items->sum('quantity'),
                'revenue' => $items->sum('revenue'),
            ];
        })->sortByDesc('revenue');

        // แยกตามแปลง
        $byGarden = $yields->groupBy('plantingRecord.garden.name')->map(function($items) {
            return [
                'sales' => $items->count(),
                'quantity' => $items->sum('quantity'),
                'revenue' => $items->sum('revenue'),
            ];
        })->sortByDesc('revenue');

        // ข้อมูลการขายรายวัน
        $dailySales = $yields->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->harvest_date)->format('Y-m-d');
        })->map(function($items, $date) {
            return [
                'date' => $date,
                'sales' => $items->count(),
                'quantity' => $items->sum('quantity'),
                'revenue' => $items->sum('revenue'),
            ];
        })->sortBy('date');

        $gardens = Garden::where('user_id', Auth::id())->get();
        $plants = Plant::all();
        $buyers = \App\Models\Buyer::all();

        return view('reports.sales', compact(
            'totalSales',
            'totalQuantity',
            'totalRevenue',
            'avgPrice',
            'byBuyer',
            'byPlant',
            'byGarden',
            'dailySales',
            'gardens',
            'plants',
            'buyers',
            'startDate',
            'endDate',
            'gardenId',
            'plantId',
            'buyerId'
        ));
    }

    /**
     * Export PDF - Sales Report
     */
    public function exportSalesPdf(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'garden_id' => 'nullable|exists:gardens,id',
                'plant_id' => 'nullable|exists:plants,id',
                'buyer_id' => 'nullable|exists:buyers,id',
            ]);

            $startDate = $request->start_date ? 
                \Carbon\Carbon::parse($request->start_date) : 
                \Carbon\Carbon::parse(config('app.default_report_start_date'));
            
            $endDate = $request->end_date ? 
                \Carbon\Carbon::parse($request->end_date) : 
                \Carbon\Carbon::now();
            
            $gardenId = $request->garden_id;
            $plantId = $request->plant_id;
            $buyerId = $request->buyer_id;

            $yieldsQuery = YieldRecord::with(['plantingRecord.garden', 'plantingRecord.plant', 'buyer'])
                ->whereHas('plantingRecord.garden', function($q) {
                    $q->where('user_id', Auth::id());
                })
                ->whereBetween('harvest_date', [$startDate, $endDate]);

            if ($gardenId) {
                $yieldsQuery->whereHas('plantingRecord', function($q) use ($gardenId) {
                    $q->where('garden_id', $gardenId);
                });
            }

            if ($plantId) {
                $yieldsQuery->whereHas('plantingRecord', function($q) use ($plantId) {
                    $q->where('plant_id', $plantId);
                });
            }

            if ($buyerId) {
                $yieldsQuery->where('buyer_id', $buyerId);
            }

            $yields = $yieldsQuery->get();

            $totalSales = $yields->count();
            $totalQuantity = $yields->sum('quantity');
            $totalRevenue = $yields->sum('revenue');
            $avgPrice = $totalQuantity > 0 ? ($totalRevenue / $totalQuantity) : 0;

            $byBuyer = $yields->groupBy('buyer.name')->map(function($items) {
                return [
                    'sales' => $items->count(),
                    'quantity' => $items->sum('quantity'),
                    'revenue' => $items->sum('revenue'),
                ];
            })->sortByDesc('revenue')->take(10);

            $byPlant = $yields->groupBy('plantingRecord.plant.name')->map(function($items) {
                return [
                    'sales' => $items->count(),
                    'quantity' => $items->sum('quantity'),
                    'revenue' => $items->sum('revenue'),
                ];
            })->sortByDesc('revenue')->take(10);

            $data = compact(
                'totalSales',
                'totalQuantity',
                'totalRevenue',
                'avgPrice',
                'byBuyer',
                'byPlant',
                'startDate',
                'endDate'
            );

            $data['generated_at'] = \Carbon\Carbon::now();
            $data['user'] = Auth::user();

            $fontDir = str_replace('\\', '/', storage_path('fonts')) . '/';
            $chroot = str_replace('\\', '/', base_path());
            
            mb_internal_encoding('UTF-8');
            
            $pdf = Pdf::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'thsarabunnew',
                'fontDir' => $fontDir,
                'fontCache' => $fontDir,
                'chroot' => $chroot,
                'enable_font_subsetting' => false,
                'dpi' => 96,
            ])
            ->loadView('reports.pdf.sales', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);
            
            return $pdf->download('sales-report-' . date('Y-m-d') . '.pdf');
            
        } catch (\Exception $e) {
            \Log::error('PDF Export Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'เกิดข้อผิดพลาดในการสร้าง PDF: ' . $e->getMessage());
        }
    }
}