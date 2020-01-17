/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Pie and Donut charts
 *
 *  Demo JS code for echarts_pies_donuts.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var reasons = [];
var totalCount = [];

var EchartsPiesDonuts = function() {
    //
    // Setup module components
    //

    // Pie and donut charts
    var _piesDonutsExamples = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define elements
        var pie_basic_element = document.getElementById('totalDataChart');
        // var pie_rose_labels_element = document.getElementById('totalDataChart');

        //
        // Charts configuration
        //

        // Rose with labels
        if (pie_basic_element) {
            // Initialize chart
            var pie_basic = echarts.init(pie_basic_element);


            //
            // Chart config
            //

            // Options
            var pie_basic_labels_option = {

                // Colors
                color: [
                    '#2ec7c9', '#b6a2de', '#5ab1ef', '#ffb980', '#d87a80',
                    '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa',
                    '#07a2a4', '#9a7fd1', '#588dd5', '#f5994e', '#c05050',
                    '#59678c', '#c9ab00', '#7eb00a', '#6f5553', '#c14089'
                ],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Add title
                title: {
                    text: 'Quality is everyone\'s responsibility',
                    subtext: 'Total Defect',
                    left: 'center',
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
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
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    top: 'center',
                    left: 0,
                    data: reasons,
                    // data: ['IE', 'Opera', 'Safari', 'Firefox', 'Chrome'],
                    itemHeight: 8,
                    itemWidth: 8
                },

                // Add series
                series: [{
                    name: 'Defect',
                    type: 'pie',
                    radius: '70%',
                    center: ['50%', '57.5%'],
                    itemStyle: {
                        normal: {
                            borderWidth: 1,
                            borderColor: '#fff'
                        }
                    },
                    data: totalCount,
                    // data: [
                    //     { value: 335, name: 'IE' },
                    //     { value: 310, name: 'Opera' },
                    //     { value: 234, name: 'Safari' },
                    //     { value: 135, name: 'Firefox' },
                    //     { value: 1548, name: 'Chrome' }
                    // ]
                }]
            };


            pie_basic.setOption(pie_basic_labels_option);

            setInterval(function() {
                // pie_rose_labels_option.legend[0].data = reasons;
                // pie_rose_labels_option.series[0].data = totalCount;
                pie_basic_labels_option.legend.data = reasons;
                pie_basic_labels_option.series[0].data = totalCount;
                pie_basic.setOption(pie_basic_labels_option, true);
                // console.log(pie_rose_labels_option);
            }, 500);

            // console.log(pie_rose_labels_option);

        }




        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            pie_basic_element && pie_basic.resize();
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


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _piesDonutsExamples();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsPiesDonuts.init();
});