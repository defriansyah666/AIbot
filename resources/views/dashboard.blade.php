@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <!-- Today's Production Stats -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($todayInjection) }}</h3>
                    <p>Today's Injection</p>
                </div>
                <div class="icon">
                    <i class="fas fa-industry"></i>
                </div>
                <a href="{{ route('injection.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($todayAssembling) }}</h3>
                    <p>Today's Assembling</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tools"></i>
                </div>
                <a href="{{ route('assembling.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($todayDelivery) }}</h3>
                    <p>Today's Delivery</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <a href="{{ route('delivery.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $lowStockWip + $lowStockFg }}</h3>
                    <p>Low Stock Alerts</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('stock-wip.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Weekly Production Trend Chart -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Weekly Production Trend</h3>
                </div>
                <div class="card-body">
                    <canvas id="productionChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Stock Status -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Stock Status</h3>
                </div>
                <div class="card-body">
                    @if($lowStockWip > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $lowStockWip }} WIP items below minimum stock
                        </div>
                    @endif
                    
                    @if($lowStockFg > 0)
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $lowStockFg }} FG items below minimum stock
                        </div>
                    @endif
                    
                    @if($lowStockWip == 0 && $lowStockFg == 0)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            All stock levels are normal
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('injection.index') }}" class="btn btn-info btn-block">
                        <i class="fas fa-industry"></i> Input Injection
                    </a>
                    <a href="{{ route('assembling.index') }}" class="btn btn-success btn-block">
                        <i class="fas fa-tools"></i> Input Assembling
                    </a>
                    <a href="{{ route('delivery.index') }}" class="btn btn-warning btn-block">
                        <i class="fas fa-shipping-fast"></i> Input Delivery
                    </a>
                    <a href="{{ route('reports.production') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-chart-line"></i> View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script>
        // Weekly Production Chart
        var ctx = document.getElementById('productionChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @for($i = 6; $i >= 0; $i--)
                        '{{ now()->subDays($i)->format("M d") }}',
                    @endfor
                ],
                datasets: [{
                    label: 'Injection',
                    data: {!! json_encode($weeklyInjection) !!},
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.1
                }, {
                    label: 'Assembling',
                    data: {!! json_encode($weeklyAssembling) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.1
                }, {
                    label: 'Delivery',
                    data: {!! json_encode($weeklyDelivery) !!},
                    borderColor: 'rgb(255, 205, 86)',
                    backgroundColor: 'rgba(255, 205, 86, 0.1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop

