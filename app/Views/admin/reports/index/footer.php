<script>
    "use strict";

    // Class definition
    var KTDashboard = function() {
        // Order Statistics.
        // Based on Chartjs plugin - http://www.chartjs.org/
        var orderStatistics = function() {
            var container = KTUtil.getByID('kt_chart_order_statistics');

            if (!container) {
                return;
            }

            var color = Chart.helpers.color,
                error = 'Something Went Wrong';

            $('#kt_chart_order_statistics')
                .ajaxSubmit({
                url: '<?=base_url()?>/rest/admin/orders/statistics',
                data: {
                    'freq':	'all'
                },
                type:'POST',
                error: function(response, status, xhr, $form) {
                    if (response.responseJSON) {
                        error = response.responseJSON.error;
                    }

                    swal.fire({
                        "title": "",
                        "text":  error,
                        "type": "error",
                        "buttonStyling": false,
                        "confirmButtonClass": "btn btn-brand btn-sm btn-bold"
                    });
                },
                success: function(response, status, xhr, $form) {
                    if (response.Status) {
                        var barChartData = {
                                labels: response.Statistics.months,
                                datasets : [
                                    {
                                        fill: true,
                                        //borderWidth: 0,
                                        backgroundColor: color(KTApp.getStateColor('brand')).alpha(0.6).rgbString(),
                                        borderColor : color(KTApp.getStateColor('brand')).alpha(0).rgbString(),

                                        pointHoverRadius: 4,
                                        pointHoverBorderWidth: 12,
                                        pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                                        pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                                        pointHoverBackgroundColor: KTApp.getStateColor('brand'),
                                        pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),

                                        data: response.Statistics.data
                                    }
                                ]
                            };

                        renderChart(container, barChartData);
                    } else {
                        swal.fire({
                            "title": "",
                            "text": response.Message,
                            "type": "error",
                            "confirmButtonClass": "btn btn-secondary"
                        });
                    }
                }
            })
                .ajaxSubmit({
                    url: '<?=base_url()?>/rest/admin/orders/extra',
                    type:'GET',
                    error: function(response, status, xhr, $form) {
                        if (response.responseJSON) {
                            error = response.responseJSON.error;
                        }

                        swal.fire({
                            "title": "",
                            "text":  error,
                            "type": "error",
                            "buttonStyling": false,
                            "confirmButtonClass": "btn btn-brand btn-sm btn-bold"
                        });
                    },
                    success: function(response, status, xhr, $form) {
                        if (response.Status) {
                            var pieChartData = response.cData,
                                ordersStats = response.Stats;

                            $('#freeOrdersStats').text(ordersStats.freeOrdersStats);
                            $('#paidOrdersStats').text(ordersStats.paidOrdersStats);
                            $('#paypalOrdersStats').text(ordersStats.paypalOrdersStats);
                            $('#bitcoinOrdersStats').text(ordersStats.bitcoinOrdersStats);
                            $('#activeUsers').text(ordersStats.activeUsers);
                            $('#freeUsers').text(ordersStats.freeUsers);
                            renderPieCharts(pieChartData);
                        } else {
                            swal.fire({
                                "title": "",
                                "text": response.Message,
                                "type": "error",
                                "confirmButtonClass": "btn btn-secondary"
                            });
                        }
                    }
                });
        };
        var renderChart = function(container, barChartData) {
            var ctx = container.getContext('2d'),
                chart = new Chart(ctx, {
                type: 'line',
                data: barChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: false,
                    scales: {
                        xAxes: [{
                            categoryPercentage: 0.35,
                            barPercentage: 0.70,
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            },
                            gridLines: false,
                            ticks: {
                                display: true,
                                beginAtZero: true,
                                fontColor: KTApp.getBaseColor('shape', 3),
                                fontSize: 13,
                                padding: 10
                            }
                        }],
                        yAxes: [{
                            categoryPercentage: 0.35,
                            barPercentage: 0.70,
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Value'
                            },
                            gridLines: {
                                color: KTApp.getBaseColor('shape', 2),
                                drawBorder: false,
                                offsetGridLines: false,
                                drawTicks: false,
                                borderDash: [3, 4],
                                zeroLineWidth: 1,
                                zeroLineColor: KTApp.getBaseColor('shape', 2),
                                zeroLineBorderDash: [3, 4]
                            },
                            ticks: {
                                stepSize: 50,
                                display: true,
                                beginAtZero: true,
                                fontColor: KTApp.getBaseColor('shape', 3),
                                fontSize: 13,
                                padding: 10
                            }
                        }]
                    },
                    title: {
                        display: false
                    },
                    hover: {
                        mode: 'index'
                    },
                    tooltips: {
                        enabled: true,
                        intersect: false,
                        mode: 'nearest',
                        bodySpacing: 5,
                        yPadding: 10,
                        xPadding: 10,
                        caretPadding: 0,
                        displayColors: false,
                        backgroundColor: KTApp.getStateColor('brand'),
                        titleFontColor: '#ffffff',
                        cornerRadius: 4,
                        footerSpacing: 0,
                        titleSpacing: 0
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 5,
                            bottom: 5
                        }
                    }
                }
            });
        };
        var renderPieCharts = function(pieChartData) {
            if (!KTUtil.getByID('kt_chart_paypal-bitcoin') || !KTUtil.getByID('kt_chart_free-paid')) {
                return;
            }

            $.each(pieChartData, function(i, v) {
                var config = {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: v.data,
                                backgroundColor: [
                                    KTApp.getStateColor('success'),
                                    KTApp.getStateColor('brand')
                                ]
                            }],
                            labels: v.labels
                        },
                        options: {
                            cutoutPercentage: 75,
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                display: false,
                                position: 'top',
                            },
                            title: {
                                display: false,
                                text: 'Technology'
                            },
                            animation: {
                                animateScale: true,
                                animateRotate: true
                            },
                            tooltips: {
                                enabled: true,
                                intersect: false,
                                mode: 'nearest',
                                bodySpacing: 5,
                                yPadding: 10,
                                xPadding: 10,
                                caretPadding: 0,
                                displayColors: false,
                                backgroundColor: KTApp.getStateColor('brand'),
                                titleFontColor: '#ffffff',
                                cornerRadius: 4,
                                footerSpacing: 0,
                                titleSpacing: 0
                            }
                        }
                    },
                    ctx = KTUtil.getByID(v.id).getContext('2d'),
                    myDoughnut = new Chart(ctx, config);
            });
        };
        var filterStatistics = function() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            $('#filterStatistics').daterangepicker({
                buttonClasses: ' btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',

                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function(start, end, label) {
                $('#filterStatistics .form-control').val( start.format('MM/DD/YYYY') + ' / ' + end.format('MM/DD/YYYY'));
            });
        }


        return {
            init: function() {
                orderStatistics();
                filterStatistics();
            }
        };
    }();

    jQuery(document).ready(function() {
        KTDashboard.init();
    });
</script>