@extends('admin.adminPage')

@section('content')
<style>
* {
    margin: 0;
    font-family: "Montserrat", sans-serif;
}

.dashboard-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 32px 24px 24px 24px;
    margin-bottom: 32px;
    margin-top: 24px;
}
.dashboard-container h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 24px;
    color: #222;
}
.chart-section {
    margin-bottom: 40px;
}
</style>

<div class="dashboard-container">
    <h2>Sales Dashboard</h2>

    <div class="chart-section">
        <h4>Badminton Products</h4>
        <canvas id="badsChart"></canvas>
    </div>
    <div class="chart-section">
        <h4>Bag Products</h4>
        <canvas id="bagsChart"></canvas>
    </div>
    <div class="chart-section">
        <h4>Shoe Products</h4>
        <canvas id="shoesChart"></canvas>
    </div>
    <div class="chart-section">
        <h4>Accessories</h4>
        <canvas id="accessoriesChart"></canvas>
    </div>
    <div class="chart-section">
        <h4>Apparels</h4>
        <canvas id="apparelsChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function renderChart(canvasId, labels, stocks, color) {
        new Chart(document.getElementById(canvasId), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stock',
                    data: stocks,
                    backgroundColor: color
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false }
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    }

    renderChart(
        'badsChart',
        {!! $bads->pluck('Name')->toJson() !!},
        {!! $bads->pluck('Stock')->toJson() !!},
        'rgba(54, 162, 235, 0.7)'
    );
    renderChart(
        'bagsChart',
        {!! $bags->pluck('Name')->toJson() !!},
        {!! $bags->pluck('Stock')->toJson() !!},
        'rgba(255, 99, 132, 0.7)'
    );
    renderChart(
        'shoesChart',
        {!! $shoes->pluck('Name')->toJson() !!},
        {!! $shoes->pluck('Stock')->toJson() !!},
        'rgba(255, 206, 86, 0.7)'
    );
    renderChart(
        'accessoriesChart',
        {!! $accessories->pluck('Name')->toJson() !!},
        {!! $accessories->pluck('Stock')->toJson() !!},
        'rgba(75, 192, 192, 0.7)'
    );
    renderChart(
        'apparelsChart',
        {!! $apparels->pluck('Name')->toJson() !!},
        {!! $apparels->pluck('Stock')->toJson() !!},
        'rgba(153, 102, 255, 0.7)'
    );
});
</script>
@endsection