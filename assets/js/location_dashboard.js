
var LocaEffi = 0;
var team = [];
var expectEff = [];
var actualEff = [];
var date = [];
var focastEff = [];
var facEff = [];

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
          text: 'Factory Efficiency',
          subtext: 'See how factory drive',
          left: 'center',
          textStyle: {
            fontSize: 20,
            fontWeight: 500,
            color: '#008acd'
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
        series: [
          {
            name: 'Efficiency',
            type: 'gauge',
            center: ['50%', '62%'],
            radius: '90%',
            detail: {formatter:'{value}%'},
            axisLine: {
              lineStyle: {
                color: [[0.2, '#d87a80'], [0.8, '#5ab1ef'], [1, '#2ecc71']],
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
            data: [{value:0, name: 'Current Efficiency'}]
          }
        ]
      };

      gauge_basic.setOption(gauge_basic_options);

      var timeTicket = setInterval(function () {
        gauge_basic_options.series[0].data[0].value = LocaEffi;
        gauge_basic.setOption(gauge_basic_options, true);
      }, 2000);
    }

    // Resize function
    var triggerChartResize = function() {
      gauge_basic_element && gauge_basic.resize();
    };

    // On sidebar width change
    $(document).on('click', '.sidebar-control', function() {
      setTimeout(function () {
        triggerChartResize();
      }, 0);
    });

    // On window resize
    var resizeCharts;
    window.onresize = function () {
      clearTimeout(resizeCharts);
      resizeCharts = setTimeout(function () {
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

    var columns_clustered_element = document.getElementById('columns_clustered');

    // Stacked clustered columns
    if (columns_clustered_element) {

      // Initialize chart
      var columns_clustered = echarts.init(columns_clustered_element);

      //
      // Chart config
      //

      // Options
      var  columns_clustered_options = {

        // Define colors
        color: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

        // Global text styles
        textStyle: {
          fontFamily: 'Roboto, Arial, Verdana, sans-serif',
          fontSize: 14
        },

        // Chart animation duration
        animationDuration: 750,

        // Setup grid
        grid: {
          left: 0,
          right: 5,
          top: 55,
          bottom: 0,
          containLabel: true
        },

        // Add legend
        legend: {
          data: [
            'Expected Effi','Actual Effi',''
          ],
          itemHeight: 2,
          itemGap: 8,
          textStyle: {
            padding: [0, 10]
          }
        },

        // Add tooltip
        tooltip: {
          trigger: 'axis',
          backgroundColor: 'rgba(0,0,0,0.75)',
          padding: [10, 15],
          textStyle: {
            fontSize: 14,
            fontFamily: 'Roboto, sans-serif'
          }
        },

        // Horizontal axis
        xAxis: [
          {
            type: 'category',
            data: [],
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
          },
          {
            type: 'category',
            axisLine: {show:false},
            axisTick: {show:false},
            axisLabel: {show:false},
            splitArea: {show:false},
            splitLine: {show:false},
            data: []
          }
        ],

        // Vertical axis
        yAxis: [{
          type: 'value',
          axisLabel: {
            color: '#333',
            formatter: '{value} %',
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
        series: [
          {
            name: 'Actual Effi',
            type: 'bar',
            z: 2,
            itemStyle: {
              normal: {
                color: '#0a0e11',
                label: {
                  show: true,
                  padding: 5,
                  position: 'top',
                  textStyle: {
                    color: '#0a0e11',
                    fontSize: 14
                  }
                }
              }
            },
            data: []
          },
          {
            name: 'Expected Effi',
            type: 'bar',
            z: 1,
            xAxisIndex: 1,
            itemStyle: {
              normal: {
                color: '#adb6bc',
                label: {
                  show: true,
                  padding: 5,
                  position: 'top',
                  textStyle: {
                    color: '#adb6bc',
                    fontSize: 14
                  }
                }
              }
            },
            data: []
          },
        ]
      };
      columns_clustered.setOption(columns_clustered_options);


      var timeTicket = setInterval(function () {
        columns_clustered_options.xAxis[0].data = team;
        columns_clustered_options.series[0].data = actualEff;
        columns_clustered_options.series[1].data = expectEff;
        columns_clustered.setOption(columns_clustered_options, true);
      }, 2000);

    }
    //
    // Resize charts
    //

    // Resize function
    var triggerChartResize = function() {
      columns_clustered_element && columns_clustered.resize();
    };

    // On sidebar width change
    $(document).on('click', '.sidebar-control', function() {
      setTimeout(function () {
        triggerChartResize();
      }, 0);
    });

    // On window resize
    var resizeCharts;
    window.onresize = function () {
      clearTimeout(resizeCharts);
      resizeCharts = setTimeout(function () {
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


/////// ***************************************Line Chart for Monthly Factory Efficiency ***************************************////////////
var EchartsLines = function() {

    //
    // Setup module components
    //

    // Line charts
    var _lineChartExamples = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        var line_values_element = document.getElementById('line_values');


        //
        // Charts configuration
        //
        // Zoom option
        // Display point values
        if (line_values_element) {

            // Initialize chart
            var line_values = echarts.init(line_values_element);

            //
            // Chart config
            //

            // Options
          var line_values_option = {

            // Define colors
            color: ['#EA007B','#49C1B6'],

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
                data: ['Forcast_Efficiency','Efficiency',],
                itemHeight: 8,
                itemGap: 20
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
                boundaryGap: false,
                data: [],
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
                }
            }],

            // Vertical axis
            yAxis: [{
                type: 'value',
                axisLabel: {
                    formatter: '{value} %',
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
            series: [
                {
                    name: 'Forcast_Efficiency',
                    type: 'line',
                    data: [],
                    smooth: true,
                    symbolSize: 7,
                    label: {
                        normal: {
                            show: true
                        }
                    },
                    itemStyle: {
                        normal: {
                            borderWidth: 2
                        }
                    }
                },
                {
                    name: 'Efficiency',
                    type: 'line',
                    data: [],
                    smooth: true,
                    symbolSize: 7,
                    label: {
                        normal: {
                            show: true
                        }
                    },
                    itemStyle: {
                        normal: {
                            borderWidth: 2
                        }
                    }
                }
            ]
}
            line_values.setOption(line_values_option);

            var facEffFunction = setInterval(function () {
              line_values_option.xAxis[0].data = date;
              // line_values_option.series[0].data = focastEff;
              line_values_option.series[1].data = facEff;
              line_values.setOption(line_values_option, true);
            }, 200);


        }



        // Resize function
        var triggerChartResize = function() {
            line_values_element && line_values.resize();
        };

        // On sidebar width change
        $(document).on('click', '.sidebar-control', function() {
            setTimeout(function () {
                triggerChartResize();
            }, 0);
        });

        // On window resize
        var resizeCharts;
        window.onresize = function () {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        };
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _lineChartExamples();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsLines.init();
});
