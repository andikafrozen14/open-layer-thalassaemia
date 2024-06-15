$(document).ready(function() {
    $('#total-patient-data').hide();
});

document.addEventListener("DOMContentLoaded", function () {
    
    var patientData = $.parseJSON($('#minor-patient-data').text());
    var sum = 0;
    const xline = [];
    const yline = [];
    for (var i = 0; i < patientData.length; i++) {
        sum += parseInt(patientData[i].totals);
        xline.push(patientData[i].years);
        yline.push(patientData[i].totals);
    }
    
    sum = String(new Intl.NumberFormat().format(sum)).replaceAll(',', '.');
    $('#sum-minor-patients').html('<i class="ti ti-wheelchair"></i> ' + sum);
    window.ApexCharts && (new ApexCharts(document.getElementById('chart-minor-patients'), {
        chart: {
            type: 'area',
            fontFamily: 'inherit',
            height: 40.0,
            sparkline: {
                enabled: true
            },
            animations: {
                enabled: false
            },
        },
        dataLabels: {
            enabled: false,
        },
        fill: {
            opacity: .16,
            type: 'solid'
        },
        stroke: {
            width: 2,
            lineCap: "round",
            curve: "smooth",
        },
        series: [{
            name: "Jumlah Pasien",
            data: yline
        }],
        grid: {
            strokeDashArray: 4,
        },
        xaxis: {
            labels: {
                padding: 0,
            },
            tooltip: {
                enabled: false
            },
            axisBorder: {
                show: false,
            },
            type: 'text',
        },
        yaxis: {
            labels: {
                padding: 4
            },
        },
        labels: xline,
        colors: ["#b32d00"],
        legend: {
            show: false,
        },
    })).render();
});