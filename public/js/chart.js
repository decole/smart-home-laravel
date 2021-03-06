$(document).ready(function() {
    var areaChart;
    function getVal(date) {
        // Get context with jQuery - using jQuery's .get() method.
        $.get("/api/greenhouse?date="+date, function (data) {

            let areaChartCanvas = $('#areaChart').get(0).getContext('2d');
            var areaChartData = {
                labels: data['label'],
                datasets: [
                    {
                        label: 'Digital Goods',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: data['data']
                    },
                    // {
                    //     label               : 'Electronics',
                    //     backgroundColor     : 'rgba(210, 214, 222, 1)',
                    //     borderColor         : 'rgba(210, 214, 222, 1)',
                    //     pointRadius         : false,
                    //     pointColor          : 'rgba(210, 214, 222, 1)',
                    //     pointStrokeColor    : '#c1c7d1',
                    //     pointHighlightFill  : '#fff',
                    //     pointHighlightStroke: 'rgba(220,220,220,1)',
                    //     data                : [65, 59, 80, 81, 56, 55, 40]
                    // },
                ]
            };
            let areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            };

            // This will get the first returned node in the jQuery collection.
            areaChart = new Chart(areaChartCanvas, {
                type: 'line',
                data: areaChartData,
                options: areaChartOptions
            });
        });
    }

    function solum(el,day) {
        let root = $(el).parent().parent().parent().parent();
        let topic = root.data("topic");
        let select_date = $(el).parent().parent().find('.chart-date-marker').text();
        let new_day = moment(select_date, "DD-MM-YYYY").add(day, 'days').format('DD-MM-YYYY');
        $(el).parent().parent().find('.chart-date-marker').text(new_day);
        return new_day;
    }

    $( ".chart-pagination-previous" ).on( "click", function() {
        areaChart.destroy();
        getVal(solum(this,-1));
    });

    $( ".chart-pagination-next" ).on( "click", function() {
        areaChart.destroy();
        getVal(solum(this,1));
    });

    getVal($('.chart-date-marker').text());

});


