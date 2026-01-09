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
    <div class="col-md-6 col-xxl-6">
        <div class="card h-md-100 shadow-sm border-0">
            <div class="card-body p-4">
                @php
                $hour = date('H');
                if ($hour < 12) {
                    $greeting='Good Morning' ;
                    } elseif ($hour < 18) {
                    $greeting='Good Afternoon' ;
                    } else {
                    $greeting='Good Evening' ;
                    }

                    $docName=Auth::user()->name ?? 'Doc Name';
                    @endphp

                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <img src="{{ asset(auth()->user()->profile) }}" alt="Lab Icon" class="rounded-circle border border-primary" height="100">
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $greeting }}, {{ $docName }}!</h5>
                            <p class="mb-0 text-muted small">Here’s an overview of your doctor consultation activity.</p>
                            <p class="mb-0 text-muted small">
                                <strong>Doctor ID:</strong> {{ auth()->user()->user_id ?? 'N/A' }} <br>
                            </p>

                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Reviews -->
    <div class="col-md-3 col-xxl-3">
        <a href="{{ route('lab.reviews') }}" class="text-decoration-none">
            <div class="card h-md-100">
                <div class="card-body text-center">
                    <h6>Reviews</h6>
                    <div class="fs-3 fw-bold text-primary">{{ $reviewCount }}</div>
                    <div class="text-muted fs-11">Total Reviews</div>
                </div>
            </div>
        </a>
    </div>

    <!-- Notifications -->
    <div class="col-md-3 col-xxl-3">
        <a href="{{ route('notifications') }}" class="text-decoration-none">
            <div class="card h-md-100">
                <div class="card-body text-center">
                    <h6>New Notifications</h6>
                    <div class="fs-3 fw-bold text-warning">{{ $newNotificationCount }}</div>
                    <div class="text-muted fs-11">Unread Alerts</div>
                </div>
            </div>
        </a>
    </div>

    <!-- Pending -->
    <div class="col-md-3 col-xxl-3">
        <a href="{{ route('patient.bookings') }}" class="text-decoration-none">
            <div class="card h-md-100 border-start border-4 border-warning shadow-sm">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h6 class="fw-semibold text-warning mb-1">Pending</h6>
                    <h3 class="fw-bold mb-0">{{ $statusCounts['pending'] ?? 0 }}</h3>
                </div>
            </div>
        </a>
    </div>

    <!-- Confirmed -->
    <div class="col-md-3 col-xxl-3">
        <a href="{{ route('patient.bookings') }}" class="text-decoration-none">
            <div class="card h-md-100 border-start border-4 border-primary shadow-sm">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h6 class="fw-semibold text-primary mb-1">Confirmed</h6>
                    <h3 class="fw-bold mb-0">{{ $statusCounts['confirmed'] ?? 0 }}</h3>
                </div>
            </div>
        </a>
    </div>

    <!-- Cancelled -->
    <div class="col-md-3 col-xxl-3">
        <a href="{{ route('patient.bookings.completed') }}" class="text-decoration-none">
            <div class="card h-md-100 border-start border-4 border-danger shadow-sm">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h6 class="fw-semibold text-danger mb-1">Cancelled</h6>
                    <h3 class="fw-bold mb-0">{{ $statusCounts['cancelled'] ?? 0 }}</h3>
                </div>
            </div>
        </a>
    </div>

    <!-- Completed -->
    <div class="col-md-3 col-xxl-3">
        <a href="{{ route('patient.bookings.completed') }}" class="text-decoration-none">
            <div class="card h-md-100 border-start border-4 border-success shadow-sm">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h6 class="fw-semibold text-success mb-1">Completed</h6>
                    <h3 class="fw-bold mb-0">{{ $statusCounts['completed'] ?? 0 }}</h3>
                </div>
            </div>
        </a>
    </div>



</div>

<div class="row g-3">
    <div class="col-lg-12 mb-3">
        <div class="card h-lg-100 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-chart-line me-2 text-primary"></i> Total Consultations ({{ now()->year }})
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
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                type: 'category',
                data: months,
                axisLabel: {
                    color: '#6c757d'
                }
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    color: '#6c757d'
                }
            },
            grid: {
                left: '5%',
                right: '5%',
                bottom: '10%',
                containLabel: true
            },
            series: [{
                data: monthlyData,
                type: 'line',
                smooth: true,
                name: 'Bookings',
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgba(13,110,253,0.4)'
                        },
                        {
                            offset: 1,
                            color: 'rgba(13,110,253,0)'
                        }
                    ])
                },
                itemStyle: {
                    color: '#0d6efd'
                }
            }]
        };

        chart.setOption(option);

        // --- Filter functionality ---
        document.getElementById('bookingMonthFilter').addEventListener('change', function() {
            const value = this.value;
            if (value === 'all') {
                chart.setOption({
                    xAxis: {
                        data: months
                    },
                    series: [{
                        data: monthlyData
                    }]
                });
            } else {
                const index = parseInt(value) - 1;
                chart.setOption({
                    xAxis: {
                        data: [months[index]]
                    },
                    series: [{
                        data: [monthlyData[index]]
                    }]
                });
            }
        });

        window.addEventListener('resize', () => chart.resize());
    });
</script>

@endsection