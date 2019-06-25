require.config({
    paths: {
        echarts: '/frontend/assets/global/plugins/echarts/'
    }
});

// DEMOS
require(
    [
        'echarts',
        'echarts/chart/bar',
        'echarts/chart/chord',
        'echarts/chart/eventRiver',
        'echarts/chart/force',
        'echarts/chart/funnel',
        'echarts/chart/gauge',
        'echarts/chart/heatmap',
        'echarts/chart/k',
        'echarts/chart/line',
        'echarts/chart/map',
        'echarts/chart/pie',
        'echarts/chart/radar',
        'echarts/chart/scatter',
        'echarts/chart/tree',
        'echarts/chart/treemap',
        'echarts/chart/venn',
        'echarts/chart/wordCloud'
    ],
    function(ec) {
        //--- BAR ---
        var myChart = ec.init(document.getElementById('echarts_bar'));
        myChart.setOption({
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['Visites', 'Réponses']
            },
            toolbox: {
                show: false,
                feature: {
                    mark: {
                        show: true
                    },
                    dataView: {
                        show: true,
                        readOnly: false
                    },
                    magicType: {
                        show: true,
                        type: ['line', 'bar']
                    },
                    restore: {
                        show: true
                    },
                    saveAsImage: {
                        show: true
                    }
                }
            },
            calculable: true,
            xAxis: [{
                type: 'category',
                data: ['Jan', 'Fev', 'Mar', 'Avr', 'May', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec']
            }],
            yAxis: [{
                type: 'value',
                splitArea: {
                    show: true
                }
            }],
            series: [{
                name: 'Visites',
                type: 'bar',
                data: [2, 4, 7, 23, 25, 76, 135, 162, 32, 20, 6, 3]
            }, {
                name: 'Réponses',
                type: 'bar',
                data: [2, 5, 9, 26, 28, 70, 175, 182, 48, 18, 6, 2]
            }]
        });
    });