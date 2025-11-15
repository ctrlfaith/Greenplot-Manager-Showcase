{{-- resources/views/reports/profit-loss.blade.php --}}

<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">

    <div class="reports-container">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <x-reports.header 
                title="รายงานกำไร-ขาดทุน"
                subtitle="วิเคราะห์รายได้และต้นทุนเพื่อดูภาพรวมการเงินของแต่ละแปลงและพืช"
                backRoute="reports.index"
                backText="กลับไปหน้ารายงาน"
            />

            {{-- Filters Section --}}
            <x-reports.filters 
                route="reports.profit-loss"
                :startDate="$startDate"
                :endDate="$endDate"
                :gardens="$gardens"
                :plants="$plants"
                :gardenId="$gardenId"
                :plantId="$plantId"
                :showDatePresets="true"
                exportRoute="reports.profit-loss.pdf"
            />

            {{-- Summary Cards --}}
            @php
                $revenueChange = isset($comparison['year_changes']['revenue']) ? $comparison['year_changes']['revenue'] : null;
                $costsChange = isset($comparison['year_changes']['costs']) ? $comparison['year_changes']['costs'] : null;
                $profitChange = isset($comparison['year_changes']['profit']) ? $comparison['year_changes']['profit'] : null;
                $roiChange = isset($comparison['year_changes']['roi']) ? $comparison['year_changes']['roi'] : null;

                $summaryCards = [
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>',
                        'label' => 'รายได้ทั้งหมด',
                        'value' => '฿' . number_format($totalRevenue, 2),
                        'description' => 'รายรับจากการขายผลผลิต',
                        'color' => '#10b981',
                        'gradientFrom' => '#ecfdf5',
                        'gradientTo' => '#d1fae5',
                        'iconBg' => '#10b981',
                        'iconBgGradient1' => '#10b981',
                        'iconBgGradient2' => '#059669',
                        'iconColor' => '#ffffff',
                        'iconShadow' => 'rgba(16, 185, 129, 0.4)',
                        'shadowColor' => 'rgba(16, 185, 129, 0.15)',
                        'borderColor' => 'rgba(16, 185, 129, 0.2)',
                        'decorationColor' => 'rgba(16, 185, 129, 0.15)',
                        'labelColor' => '#065f46',
                        'valueColor' => '#047857',
                        'descriptionColor' => '#059669',
                        'valueClass' => 'positive',
                        'trend' => ($revenueChange && $revenueChange['direction'] !== 'neutral') ? $revenueChange['direction'] : null,
                        'trendValue' => ($revenueChange && $revenueChange['direction'] !== 'neutral') ? $revenueChange['display'] : null
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                        'label' => 'ต้นทุนทั้งหมด',
                        'value' => '฿' . number_format($totalCosts, 2),
                        'description' => 'ค่าใช้จ่ายในการผลิต',
                        'color' => '#ef4444',
                        'gradientFrom' => '#fef2f2',
                        'gradientTo' => '#fee2e2',
                        'iconBg' => '#ef4444',
                        'iconBgGradient1' => '#ef4444',
                        'iconBgGradient2' => '#dc2626',
                        'iconColor' => '#ffffff',
                        'iconShadow' => 'rgba(239, 68, 68, 0.4)',
                        'shadowColor' => 'rgba(239, 68, 68, 0.15)',
                        'borderColor' => 'rgba(239, 68, 68, 0.2)',
                        'decorationColor' => 'rgba(239, 68, 68, 0.15)',
                        'labelColor' => '#991b1b',
                        'valueColor' => '#b91c1c',
                        'descriptionColor' => '#dc2626',
                        'valueClass' => 'negative',
                        'trend' => ($costsChange && $costsChange['direction'] !== 'neutral') ? ($costsChange['direction'] === 'up' ? 'down' : 'up') : null,
                        'trendValue' => ($costsChange && $costsChange['direction'] !== 'neutral') ? $costsChange['display'] : null
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>',
                        'label' => 'กำไรสุทธิ',
                        'value' => '฿' . number_format($netProfit, 2),
                        'description' => 'รายได้หักต้นทุน',
                        'color' => $netProfit >= 0 ? '#8b5cf6' : '#ef4444',
                        'gradientFrom' => $netProfit >= 0 ? '#f5f3ff' : '#fef2f2',
                        'gradientTo' => $netProfit >= 0 ? '#ede9fe' : '#fee2e2',
                        'iconBg' => $netProfit >= 0 ? '#8b5cf6' : '#ef4444',
                        'iconBgGradient1' => $netProfit >= 0 ? '#8b5cf6' : '#ef4444',
                        'iconBgGradient2' => $netProfit >= 0 ? '#7c3aed' : '#dc2626',
                        'iconColor' => '#ffffff',
                        'iconShadow' => $netProfit >= 0 ? 'rgba(139, 92, 246, 0.4)' : 'rgba(239, 68, 68, 0.4)',
                        'shadowColor' => $netProfit >= 0 ? 'rgba(139, 92, 246, 0.15)' : 'rgba(239, 68, 68, 0.15)',
                        'borderColor' => $netProfit >= 0 ? 'rgba(139, 92, 246, 0.2)' : 'rgba(239, 68, 68, 0.2)',
                        'decorationColor' => $netProfit >= 0 ? 'rgba(139, 92, 246, 0.15)' : 'rgba(239, 68, 68, 0.15)',
                        'labelColor' => $netProfit >= 0 ? '#6d28d9' : '#991b1b',
                        'valueColor' => $netProfit >= 0 ? '#7c3aed' : '#b91c1c',
                        'descriptionColor' => $netProfit >= 0 ? '#8b5cf6' : '#dc2626',
                        'valueClass' => $netProfit >= 0 ? 'positive' : 'negative',
                        'trend' => ($profitChange && $profitChange['direction'] !== 'neutral') ? $profitChange['direction'] : null,
                        'trendValue' => ($profitChange && $profitChange['direction'] !== 'neutral') ? $profitChange['display'] : null
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>',
                        'label' => 'ROI',
                        'value' => number_format($roi, 1) . '%',
                        'description' => 'ผลตอบแทนจากการลงทุน',
                        'color' => '#f59e0b',
                        'gradientFrom' => '#fffbeb',
                        'gradientTo' => '#fef3c7',
                        'iconBg' => '#f59e0b',
                        'iconBgGradient1' => '#f59e0b',
                        'iconBgGradient2' => '#d97706',
                        'iconColor' => '#ffffff',
                        'iconShadow' => 'rgba(245, 158, 11, 0.4)',
                        'shadowColor' => 'rgba(245, 158, 11, 0.15)',
                        'borderColor' => 'rgba(245, 158, 11, 0.2)',
                        'decorationColor' => 'rgba(245, 158, 11, 0.15)',
                        'labelColor' => '#92400e',
                        'valueColor' => '#b45309',
                        'descriptionColor' => '#d97706',
                        'valueClass' => $roi >= 0 ? 'positive' : 'negative',
                        'trend' => ($roiChange && $roiChange['direction'] !== 'neutral') ? $roiChange['direction'] : null,
                        'trendValue' => ($roiChange && $roiChange['direction'] !== 'neutral') ? $roiChange['display'] : null
                    ]
                ];
            @endphp

            <x-reports.summary-cards :cards="$summaryCards" />

            {{-- Comparison Section --}}
            @if(isset($comparison))
                <x-reports.comparison-section :comparison="$comparison" />
            @endif

            {{-- Break-even Analysis --}}
            @if(isset($breakEven))
                <x-reports.break-even-section :breakEven="$breakEven" />
            @endif

            {{-- Cost Breakdown --}}
            @if(isset($costBreakdown))
                <x-reports.cost-breakdown 
                    :costBreakdown="$costBreakdown"
                    :costPieData="$costPieData"
                    :totalCosts="$totalCosts"
                />
            @endif

            {{-- Cost Per Unit --}}
            @if(isset($costPerUnit))
                <x-reports.cost-per-unit :costPerUnit="$costPerUnit" />
            @endif

            {{-- Charts --}}
            @if(isset($chartData))
                <x-reports.chart 
                    :chartData="$chartData"
                    :profitabilityTrend="$profitabilityTrend ?? null"
                />
            @endif

            {{-- Garden Summary Table --}}
            @if(isset($gardenSummary))
                <x-reports.garden-table :gardenSummary="$gardenSummary" />
            @endif

            {{-- Plant Summary Table --}}
            @if(isset($plantSummary))
                <x-reports.plant-table :plantSummary="$plantSummary" />
            @endif

            {{-- Customer Analysis --}}
            @if(isset($customerAnalysis))
                <x-reports.customer-analysis :customerAnalysis="$customerAnalysis" />
            @endif

            {{-- Key Metrics --}}
            @if(isset($insights))
                <x-reports.key-metrics :insights="$insights" />
            @endif

            {{-- Insights & Recommendations --}}
            @if(isset($insights))
                <x-reports.insights :insights="$insights" />
            @endif

        </div>
    </div>
</x-app-layout>