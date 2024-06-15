
$(document).ready(function() {
    $('#range-blt-data').hide();
    $('#gender-percents').hide();
    $('#blood-type-percents').hide();
});

/** Gender Semi Circle */
Highcharts.chart('percents-by-gender', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: 'Total Persentase Jenis Kelamin Pasien<br/>Tahun ' + new Date().getFullYear(),
        align: 'center',
        verticalAlign: 'middle',
        y: -135
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                distance: -30,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '75%'],
            size: '120%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Persentase',
        innerSize: '50%',
        data: [
            {name : 'Perempuan', y: genderPercents('female'), color: '#ff80bf'},
            {name : 'Laki-Laki', y: genderPercents('male'), color: '#bf80ff'},
        ]
    }]
});

function xMonth() {
    var xmon = [];
    var data = $('#range-blt-data').text();
    var item = $.parseJSON(data);
    for (var i = (item.length-1); i >= 0; i--) {
        var str = item[i].range;
        if (!xmon.includes(str)) {
            xmon.push(str);
        }
    }
    
    return xmon;
}

function yData(type) {
    var extra = [];
    var range = [];
    var data = $('#range-blt-data').text();
    var item = $.parseJSON(data);
    for (var i = (item.length-1); i >= 0; i--) {
        var mon = item[i].range;
        if (item[i].blood_type == type) {
            if (!range.includes(mon)) {
                extra.push(parseFloat(item[i].percents));
                range.push(mon);
            }
        } else {
            if (!range.includes(mon)) {
                extra.push(0.00);
                range.push(mon);
            }
        }
    }
    
    //console.log('type-' + type + ': ' + extra);
    //console.log('Mon('+type+'): ' + range);
    return extra;
}

Highcharts.chart('range-blood-types', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Grafik Persentase berdasarkan Golongan Darah'
    },
    subtitle: {
        text: 'Persentase Sahabat Thalassaemia per Bulan'
    },
    xAxis: {
        categories: xMonth()
    },
    yAxis: {
        title: {
            text: 'Persentase (%)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'A',
        data: yData('A')
    }, {
        name: 'B',
        data: yData('B')
    }, {
        name: 'AB',
        data: yData('AB')
    }, {
        name: 'O',
        data: yData('O')
    }]
});

var colors = Highcharts.getOptions().colors;

/** Blood Type Pie */
Highcharts.chart('percents-by-blood-type', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Total Persentase berdasarkan Gol. Darah<br />Tahun ' + new Date().getFullYear()
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: 'Persentase',
        data: [
            { name: 'A', y: bloodTypePercents('A'), color: '#8080ff' },
            { name: 'B', y: bloodTypePercents('B'), color: '#ffa31a' },
            { name: 'AB', y: bloodTypePercents('AB'), color: '#cc9966' },
            { name: 'O', y: bloodTypePercents('O'), color: '#00b300' },
        ]
    }]
});

function bloodTypePercents(key) {
    var items   = $('#blood-type-percents').text();
    var object  = $.parseJSON(items);
    var output  = 0;
    
    for (var i = 0; i < object.length; i++) {
        if (key == object[i].blood_type) {
            output = parseFloat(object[i].percents);
            break;
        }
    }
    
    return output;
}

function genderPercents(key) {
    var items   = $('#gender-percents').text();
    var object  = $.parseJSON(items);
    var output  = 0;
    
    for (var i = 0; i < object.length; i++) {
        if (key == object[i].gender) {
            output = parseFloat(object[i].percents);
            break;
        }
    }
    
    return output;
}