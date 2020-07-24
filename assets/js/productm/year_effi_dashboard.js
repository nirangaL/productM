var monthEffi = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
var yearEffi = [];
var EchartsCandlesticksOthers = function() {
    // Candlestick and other charts
    var _candlesticksOthersExamples = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        var gauge_basic_element = document.getElementById('gauge_basic');

        // Basic gauge
        if (gauge_basic_element) {
            // Initialize chart
            var gauge_basic = echarts.init(gauge_basic_element);

            // Options
            var gauge_basic_options = {

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Add title
                title: {
                    text: 'Year Efficiency ',
                    subtext: '',
                    left: 'center',
                    textStyle: {
                        fontSize: 20,
                        fontWeight: 500,
                        color: '#227093'
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    formatter: '{a} <br/>{b}: {c}%'
                },

                // Add series
                series: [{
                    name: 'Efficiency',
                    type: 'gauge',
                    center: ['50%', '62%'],
                    radius: '90%',
                    detail: { formatter: '{value}%' },
                    axisLine: {
                        lineStyle: {
                            color: [
                                [0.2, '#b33939'],
                                [0.8, '#218c74'],
                                [1, '#227093']
                            ],
                            width: 15
                        }
                    },
                    axisTick: {
                        splitNumber: 10,
                        length: 20,
                        lineStyle: {
                            color: 'auto'
                        }
                    },
                    splitLine: {
                        length: 22,
                        lineStyle: {
                            color: 'auto'
                        }
                    },
                    title: {
                        offsetCenter: [0, '60%'],
                        textStyle: {
                            fontSize: 13
                        }
                    },
                    detail: {
                        offsetCenter: [0, '45%'],
                        formatter: '{value}%',
                        textStyle: {
                            fontSize: 30,
                            fontWeight: 500
                        }
                    },
                    pointer: {
                        width: 5
                    },
                    data: [{ value: 0, name: 'Year Efficiency' }]
                }]
            };

            gauge_basic.setOption(gauge_basic_options);

            var timeTicket = setInterval(function() {
                gauge_basic_options.series[0].data[0].value = yearEffi;
                gauge_basic.setOption(gauge_basic_options, true);
            }, 2000);
        }

        // Resize function
        var triggerChartResize = function() {
            gauge_basic_element && gauge_basic.resize();
        };

        // On sidebar width change
        $(document).on('click', '.sidebar-control', function() {
            setTimeout(function() {
                triggerChartResize();
            }, 0);
        });

        // On window resize
        var resizeCharts;
        window.onresize = function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function() {
                triggerChartResize();
            }, 200);
        };
    };


    return {
        init: function() {
            _candlesticksOthersExamples();
        }
    }
}();

document.addEventListener('DOMContentLoaded', function() {
    EchartsCandlesticksOthers.init();
});


var EchartsColumnsWaterfalls = function() {
    // Column and waterfall charts
    var _columnsWaterfallsExamples = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        var columns_basic_element = document.getElementById('columns_basic');

        // Basic columns chart
        if (columns_basic_element) {

            // Initialize chart
            var columns_basic = echarts.init(columns_basic_element);


            //
            // Chart config
            //

            // Options
            columns_basic.setOption({

                // Define colors
                color: ['#218c74'],


                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: 0,
                    right: 40,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Monthly', 'Precipitation'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: month,
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#eee',
                            type: 'dashed'
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],

                // Add series
                series: [{
                        name: 'Monthly',
                        type: 'bar',
                        data: monthEffi,
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500
                                    }
                                }
                            }
                        },
                        markLine: {
                            data: [{ type: 'average', name: 'Average' }]
                        }
                    },

                ]
            });
        }


        // Resize charts
        //



        // Resize function
        var triggerChartResize = function() {
            columns_clustered_element && columns_clustered.resize();
        };

        // On sidebar width change
        $(document).on('click', '.sidebar-control', function() {
            setTimeout(function() {
                triggerChartResize();
            }, 0);
        });

        // On window resize
        var resizeCharts;
        window.onresize = function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function() {
                triggerChartResize();
            }, 200);
        };
    };

    return {
        init: function() {
            _columnsWaterfallsExamples();
        }
    }
}();

document.addEventListener('DOMContentLoaded', function() {
    EchartsColumnsWaterfalls.init();
});