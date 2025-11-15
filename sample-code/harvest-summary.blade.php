{{-- resources/views/reports/harvest-summary.blade.php --}}

<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">

    <div class="reports-container">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER & FILTERS --}}
            <x-reports.header 
                title="รายงานสรุปผลผลิต"
                subtitle="ติดตามปริมาณและคุณภาพของผลผลิตที่เก็บเกี่ยวได้แต่ละช่วงเวลา"
                backRoute="reports.index"
                backText="กลับไปหน้ารายงาน"
            />

            <x-reports.filters 
                route="reports.harvest-summary"
                :startDate="$startDate"
                :endDate="$endDate"
                :gardens="$gardens"
                :plants="$plants"
                :gardenId="$gardenId"
                :plantId="$plantId"
                :showDatePresets="true"
                exportRoute="reports.harvest-summary.pdf"
            />

            {{-- SUMMARY CARDS --}}
            @php
                $summaryCards = [
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" /></svg>',
                        'label' => 'จำนวนครั้งเก็บเกี่ยว',
                        'value' => $totalHarvests,
                        'description' => 'ครั้งในช่วงที่เลือก',
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
                        'valueClass' => '',
                        'trend' => null,
                        'trendValue' => null
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /></svg>',
                        'label' => 'ปริมาณผลผลิตรวม',
                        'value' => number_format($totalQuantity, 2) . ' กก.',
                        'description' => 'กิโลกรัม',
                        'color' => '#3b82f6',
                        'gradientFrom' => '#eff6ff',
                        'gradientTo' => '#dbeafe',
                        'iconBg' => '#3b82f6',
                        'iconBgGradient1' => '#3b82f6',
                        'iconBgGradient2' => '#2563eb',
                        'iconColor' => '#ffffff',
                        'iconShadow' => 'rgba(59, 130, 246, 0.4)',
                        'shadowColor' => 'rgba(59, 130, 246, 0.15)',
                        'borderColor' => 'rgba(59, 130, 246, 0.2)',
                        'decorationColor' => 'rgba(59, 130, 246, 0.15)',
                        'labelColor' => '#1e3a8a',
                        'valueColor' => '#1e40af',
                        'descriptionColor' => '#2563eb',
                        'valueClass' => '',
                        'trend' => null,
                        'trendValue' => null
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>',
                        'label' => 'รายได้รวม',
                        'value' => '฿' . number_format($totalRevenue, 2),
                        'description' => 'จากการขาย',
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
                        'valueClass' => 'positive',
                        'trend' => null,
                        'trendValue' => null
                    ],
                    [
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>',
                        'label' => 'อัตราความสำเร็จ',
                        'value' => number_format($successRate, 1) . '%',
                        'description' => $harvestedPlantings . '/' . $totalPlantings . ' รอบปลูก',
                        'color' => '#8b5cf6',
                        'gradientFrom' => '#f5f3ff',
                        'gradientTo' => '#ede9fe',
                        'iconBg' => '#8b5cf6',
                        'iconBgGradient1' => '#8b5cf6',
                        'iconBgGradient2' => '#7c3aed',
                        'iconColor' => '#ffffff',
                        'iconShadow' => 'rgba(139, 92, 246, 0.4)',
                        'shadowColor' => 'rgba(139, 92, 246, 0.15)',
                        'borderColor' => 'rgba(139, 92, 246, 0.2)',
                        'decorationColor' => 'rgba(139, 92, 246, 0.15)',
                        'labelColor' => '#6d28d9',
                        'valueColor' => '#7c3aed',
                        'descriptionColor' => '#8b5cf6',
                        'valueClass' => '',
                        'trend' => null,
                        'trendValue' => null
                    ]
                ];
            @endphp

            <x-reports.summary-cards :cards="$summaryCards" />

            {{-- KPIs (ตัวชี้วัดเพิ่มเติม) --}}
            <x-reports.harvest-kpis :kpis="$kpis" />

            {{-- INSIGHTS & RECOMMENDATIONS --}}
            <x-reports.harvest-insights :insights="$insights" />

            {{-- TOP PERFORMANCE (ผลงานเด่น) --}}
            <x-reports.harvest-top-performance 
                :topGarden="$topGarden"
                :topPlant="$topPlant"
                :topPeriod="$topPeriod"
            />

            {{-- LEADERBOARD TOP 5 --}}
            <x-reports.harvest-leaderboard :leaderboard="$leaderboard" />

            {{-- TREND ANALYSIS --}}
            <x-reports.harvest-trend-chart :chartData="$chartData" />

            {{-- COMPARISON (เปรียบเทียบ) --}}
            <x-reports.harvest-comparison :comparison="$comparison" />

            {{-- HEATMAP (ปฏิทินความถี่) --}}
            <x-reports.harvest-heatmap :heatmap="$heatmap" />

            {{-- DETAILED METRICS (ข้อมูลเพิ่มเติม) --}}
<div class="report-section">
    <div class="section-header">
        <h3 class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
            </svg>
            ข้อมูลเพิ่มเติม
        </h3>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
        
        {{-- ราคาเฉลี่ยต่อ กก. --}}
        <div style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid rgba(16, 185, 129, 0.1); position: relative; overflow: hidden; transition: all 0.3s ease;">
            
            {{-- Decorative background pattern --}}
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#ffffff" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div style="width: 32px; height: 32px; background: rgba(16, 185, 129, 0.08); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#10b981" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                </div>
            </div>
            
            <div style="font-size: 0.6875rem; font-weight: 700; color: #059669; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">ราคาเฉลี่ยต่อ กก.</div>
            <div style="font-size: 2rem; font-weight: 800; background: linear-gradient(135deg, #047857 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.5rem; line-height: 1.2;">฿{{ number_format($avgPrice, 2) }}</div>
            <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">ราคาขายเฉลี่ย</div>
        </div>

        {{-- ปริมาณเฉลี่ยต่อครั้ง --}}
        @php
            $avgPerHarvest = $totalHarvests > 0 ? ($totalQuantity / $totalHarvests) : 0;
        @endphp
        <div style="background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%); padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid rgba(59, 130, 246, 0.1); position: relative; overflow: hidden; transition: all 0.3s ease;">
            
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(59, 130, 246, 0.05) 0%, transparent 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#ffffff" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <div style="width: 32px; height: 32px; background: rgba(59, 130, 246, 0.08); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#3b82f6" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                    </svg>
                </div>
            </div>
            
            <div style="font-size: 0.6875rem; font-weight: 700; color: #2563eb; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">ปริมาณเฉลี่ยต่อครั้ง</div>
            <div style="font-size: 2rem; font-weight: 800; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.5rem; line-height: 1.2;">{{ number_format($avgPerHarvest, 2) }}</div>
            <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">กก./ครั้งเก็บเกี่ยว</div>
        </div>

        {{-- รายได้เฉลี่ยต่อครั้ง --}}
        @php
            $avgRevenuePerHarvest = $totalHarvests > 0 ? ($totalRevenue / $totalHarvests) : 0;
        @endphp
        <div style="background: linear-gradient(135deg, #ffffff 0%, #fffbeb 100%); padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid rgba(245, 158, 11, 0.1); position: relative; overflow: hidden; transition: all 0.3s ease;">
            
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(245, 158, 11, 0.05) 0%, transparent 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#ffffff" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <div style="width: 32px; height: 32px; background: rgba(245, 158, 11, 0.08); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#f59e0b" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            
            <div style="font-size: 0.6875rem; font-weight: 700; color: #d97706; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">รายได้เฉลี่ยต่อครั้ง</div>
            <div style="font-size: 2rem; font-weight: 800; background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.5rem; line-height: 1.2;">฿{{ number_format($avgRevenuePerHarvest, 2) }}</div>
            <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">บาท/ครั้งเก็บเกี่ยว</div>
        </div>

        {{-- จำนวนแปลงที่มีการเก็บเกี่ยว --}}
        @php
            $activeGardens = $gardenSummary->count();
        @endphp
        <div style="background: linear-gradient(135deg, #ffffff 0%, #f5f3ff 100%); padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid rgba(139, 92, 246, 0.1); position: relative; overflow: hidden; transition: all 0.3s ease;">
            
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(139, 92, 246, 0.05) 0%, transparent 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#ffffff" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                    </svg>
                </div>
                <div style="width: 32px; height: 32px; background: rgba(139, 92, 246, 0.08); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#8b5cf6" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            
            <div style="font-size: 0.6875rem; font-weight: 700; color: #7c3aed; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">แปลงที่มีการเก็บเกี่ยว</div>
            <div style="font-size: 2rem; font-weight: 800; background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.5rem; line-height: 1.2;">{{ $activeGardens }}</div>
            <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">แปลงที่ใช้งาน</div>
        </div>

    </div>
</div>

            {{-- DATA TABLES (ตารางสรุป) --}}
            <x-reports.harvest-garden-table 
                :gardenSummary="$gardenSummary"
                :totalHarvests="$totalHarvests"
                :totalQuantity="$totalQuantity"
                :totalRevenue="$totalRevenue"
            />

            <x-reports.harvest-plant-table 
                :plantSummary="$plantSummary"
                :totalHarvests="$totalHarvests"
                :totalQuantity="$totalQuantity"
                :totalRevenue="$totalRevenue"
                :avgPrice="$avgPrice"
            />

        </div>
    </div>
</x-app-layout>