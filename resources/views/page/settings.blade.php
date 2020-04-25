@extends('container.template')
@section('title', 'Настройки пользователя')

@section('footer-scripts')
    @parent
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">

        <!-- Left col -->
        <section class="col-lg-6 col-xs-12 connectedSortable ui-sortable">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="far fa-hdd"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Лампа в пристройке</span>
                        <div class="btn-group relay-control" data-swift-topic="margulis/lamp01" data-swift-topic-check="margulis/check/lamp01" data-swift-id="2" data-swift-on="1" data-swift-off="0">
                            <button type="button" class="btn btn-outline-success" value="on">On</button>
                            <button type="button" class="btn btn-outline-danger" value="off">Off</button>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fas fa-microchip"></i></span>

                    <div class="info-box-content sensor-control" data-sensor-topic="margulis/temperature" data-sensor-id="2">
                        <span class="info-box-text">Пристройка - температура</span>
                        <span class="info-box-number"><span data-sensor-value="margulis/temperature">20.0</span>

              </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fas fa-microchip"></i></span>

                    <div class="info-box-content sensor-control" data-sensor-topic="margulis/humidity" data-sensor-id="12">
                        <span class="info-box-text">Пристройка - влажность</span>
                        <span class="info-box-number"><span data-sensor-value="margulis/humidity">33.0</span>

              </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </section>
        <!-- /.Left col -->

    </div>

@endsection
