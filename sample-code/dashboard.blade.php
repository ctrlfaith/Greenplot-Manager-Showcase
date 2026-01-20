<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="dashboard-container">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Hero Section with Filter --}}
            <div class="dashboard-hero">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title">Dashboard</h1>
                        <p class="hero-subtitle">ภาพรวมและสถิติของระบบจัดการสวนของคุณ</p>
                    </div>
                    
                    {{-- Garden Filter --}}
                    <div class="garden-filter">
                        <form method="GET" action="{{ route('dashboard') }}" id="gardenFilterForm">
                            <label for="garden_id" class="filter-label">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                </svg>
                                กรองตามแปลง
                            </label>
                            <select name="garden_id" id="garden_id" class="filter-select" onchange="document.getElementById('gardenFilterForm').submit()">
                                <option value="">ทั้งหมด</option>
                                @foreach($allGardens as $garden)
                                    <option value="{{ $garden->id }}" {{ $selectedGardenId == $garden->id ? 'selected' : '' }}>
                                        {{ $garden->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            @include('dashboard.partials.stats-cards')

            {{-- Performance Metrics --}}
            @include('dashboard.partials.performance-metrics')

            {{-- Charts --}}
            @include('dashboard.partials.charts')

            {{-- Notifications --}}
            @include('dashboard.partials.notifications')

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</x-app-layout>