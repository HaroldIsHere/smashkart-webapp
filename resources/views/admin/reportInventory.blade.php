@extends('admin.adminPage')

@section('content')
<style>
* {
    margin: 0;
    font-family: "Montserrat", sans-serif;
}
body {
    background: #f4f4f4;
    font-family: "Montserrat", sans-serif;
}
.report-inventory-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 32px 16px 64px 16px;
}
.report-inventory-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    padding: 32px 32px 24px 32px;
    margin-bottom: 32px;
    min-width: 300px;
    flex: 1 1 320px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.report-inventory-card h2 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 18px;
    color: #3131D4;
}
.report-inventory-card label {
    font-weight: 500;
    color: #222;
    margin-bottom: 8px;
}
.report-inventory-card select {
    margin-bottom: 18px;
    padding: 6px 12px;
    border-radius: 6px;
    border: 1px solid #ddd;
    font-size: 1rem;
    background: #f7f7f7;
    color: #222;
}
.chart-section {
    width: 100%;
}
.report-inventory-card canvas {
    margin-top: 12px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    padding: 12px;
    width: 100% !important;
    max-width: 100%;
    height: 240px !important;
}
@media (max-width: 900px) {
    .report-inventory-card {
        min-width: 0;
        width: 100%;
        padding: 18px 8px 12px 8px;
    }
    .report-inventory-card canvas {
        height: 180px !important;
    }
}
</style>

<div class="report-inventory-wrapper">
    <div class="report-inventory-card">
        <h2>Stock Report</h2>
        <label for="chartSelector">Select Product Category:</label>
        <select id="chartSelector">
            <option value="badsChart">Badminton Products</option>
            <option value="bagsChart">Bag Products</option>
            <option value="shoesChart">Shoe Products</option>
            <option value="accessoriesChart">Accessories</option>
            <option value="apparelsChart">Apparels</option>
        </select>
        <div class="chart-section" id="badsChartSection">
            <canvas id="badsChart" height="120"></canvas>
        </div>
        <div class="chart-section" id="bagsChartSection" style="display:none;">
            <canvas id="bagsChart" height="120"></canvas>
        </div>
        <div class="chart-section" id="shoesChartSection" style="display:none;">
            <canvas id="shoesChart" height="120"></canvas>
        </div>
        <div class="chart-section" id="accessoriesChartSection" style="display:none;">
            <canvas id="accessoriesChart" height="120"></canvas>
        </div>
        <div class="chart-section" id="apparelsChartSection" style="display:none;">
            <canvas id="apparelsChart" height="120"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartSelector = document.getElementById('chartSelector');
    const chartSections = [
        'badsChartSection',
        'bagsChartSection',
        'shoesChartSection',
        'accessoriesChartSection',
        'apparelsChartSection'
    ];
    chartSelector.addEventListener('change', function() {
        chartSections.forEach(function(sectionId) {
            document.getElementById(sectionId).style.display = 'none';
        });
        document.getElementById(chartSelector.value + 'Section').style.display = '';
    });

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
