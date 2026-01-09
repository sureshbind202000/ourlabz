@extends('backend.includes.layout')

@section('css')
<style>
    .card h3 {
        transition: transform 0.4s ease, opacity 0.4s ease;
    }
    .card:hover h3 {
        transform: scale(1.1);
        opacity: 0.9;
    }
</style>
@endsection

@section('content')

<div class="row g-3 mb-3">
    {{-- Greeting Card --}}
    <div class="col-md-12 col-xxl-12">
        <div class="card h-md-100 shadow-sm border-0">
            <div class="card-body p-4">
                @php
                    $hour = date('H');
                    $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
                    $venName = Auth::user()->name ?? 'Vendor';
                @endphp

                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset(auth()->user()->profile ?? 'backend/images/default-avatar.png') }}" 
                             alt="Vendor Icon" class="rounded-circle border border-primary" height="100" width="100">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $greeting }}, {{ $venName }}!</h5>
                        <p class="mb-0 text-muted small">Here’s an overview of your vendor activity.</p>
                        <p class="mb-0 text-muted small">
                            <strong>Vendor ID:</strong> {{ auth()->user()->user_id ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
</div>

{{-- Order Status Cards --}}
<div class="row g-3">
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 border-start border-4 border-warning shadow-sm text-center">
            <div class="card-body">
                <h6 class="fw-semibold text-warning mb-1">Pending</h6>
                <h3 class="fw-bold mb-0">{{ $statusCounts['pending'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 border-start border-4 border-info shadow-sm text-center">
            <div class="card-body">
                <h6 class="fw-semibold text-info mb-1">Processing</h6>
                <h3 class="fw-bold mb-0">{{ $statusCounts['processing'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 border-start border-4 border-secondary shadow-sm text-center">
            <div class="card-body">
                <h6 class="fw-semibold text-secondary mb-1">On Hold</h6>
                <h3 class="fw-bold mb-0">{{ $statusCounts['on_hold'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 border-start border-4 border-danger shadow-sm text-center">
            <div class="card-body">
                <h6 class="fw-semibold text-danger mb-1">Cancelled</h6>
                <h3 class="fw-bold mb-0">{{ $statusCounts['cancelled'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 border-start border-4 border-success shadow-sm text-center">
            <div class="card-body">
                <h6 class="fw-semibold text-success mb-1">Completed</h6>
                <h3 class="fw-bold mb-0">{{ $statusCounts['completed'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
     {{-- Reviews --}}
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 text-center shadow-sm border-start border-4 border-primary">
            <div class="card-body">
                <h6 class="fw-semibold text-secondary mb-2">Total Reviews</h6>
                <h3 class="fw-bold text-primary mb-0">{{ $reviewCount }}</h3>
            </div>
        </div>
    </div>

    {{-- Notifications --}}
    <div class="col-md-3 col-xxl-3">
        <div class="card h-md-100 text-center shadow-sm border-start border-4 border-warning">
            <div class="card-body">
                <h6 class="fw-semibold text-secondary mb-2">Unread Notifications</h6>
                <h3 class="fw-bold text-warning mb-0">{{ $newNotificationCount }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Orders Chart --}}
<div class="row g-3 mt-3">
    <div class="col-lg-12 mb-3">
        <div class="card h-lg-100 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-chart-line me-2 text-primary"></i> Total Orders ({{ now()->year }})
                </h6>
                <select id="bookingMonthFilter" class="form-select form-select-sm w-auto">
                    <option value="all">All Months</option>
                    @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $key => $month)
                        <option value="{{ $key+1 }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>

            <div class="card-body">
                <div id="bookingChart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chartDom = document.getElementById('bookingChart');
        if (!chartDom) return;
        const chart = echarts.init(chartDom);
        const monthlyData = @json($chartData);
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        const option = {
            tooltip: { trigger: 'axis' },
            xAxis: { type: 'category', data: months, axisLabel: { color: '#6c757d' } },
            yAxis: { type: 'value', axisLabel: { color: '#6c757d' } },
            grid: { left: '5%', right: '5%', bottom: '10%', containLabel: true },
            series: [{
                data: monthlyData,
                type: 'line',
                smooth: true,
                name: 'Orders',
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: 'rgba(13,110,253,0.4)' },
                        { offset: 1, color: 'rgba(13,110,253,0)' }
                    ])
                },
                itemStyle: { color: '#0d6efd' }
            }]
        };
        chart.setOption(option);

        // Month filter
        document.getElementById('bookingMonthFilter').addEventListener('change', function() {
            const val = this.value;
            if (val === 'all') {
                chart.setOption({ xAxis: { data: months }, series: [{ data: monthlyData }] });
            } else {
                const i = parseInt(val) - 1;
                chart.setOption({ xAxis: { data: [months[i]] }, series: [{ data: [monthlyData[i]] }] });
            }
        });
        window.addEventListener('resize', () => chart.resize());
    });
</script>
@endsection
