@extends('container.template')
@section('title', 'History Sensor Data of GreenHouse')

@section('footer-scripts')
    @parent
    <script>
$(document).ready(function() {
    // Get context with jQuery - using jQuery's .get() method.
    $.get("/api/greenhouse", function (data) {
        let areaChartCanvas = $('#areaChart').get(0).getContext('2d');
        console.log(data);
        var areaChartData = {
            labels  : data['label'],
            datasets: [
                {
                    label               : 'Digital Goods',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : data['data']
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
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines : {
                        display : false,
                    }
                }],
                yAxes: [{
                    gridLines : {
                        display : false,
                    }
                }]
            }
        };

        // This will get the first returned node in the jQuery collection.
        let areaChart       = new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        });
    });

});
    </script>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">

        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
            <!-- TO DO List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Исторические данные сенсора в теплице
                    </h3>

                    <div class="card-tools">
                        @if($sensors)
                            {!! $sensors->render() !!}
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>Показание</td>
                            <td>Дата</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sensors as $sensor)
                            <tr>
                                <td>{{$sensor->payload}}</td>
                                <td>{{$sensor->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
{{--                    <a href="{{ route('types.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Добавить Тип датчиков</a>--}}
{{--                    <button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add item</button>--}}
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
        <section class="col-lg-6 connectedSortable">
            <!-- AREA CHART -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Area Chart</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
    </div>

@endsection
