@extends('container.template')
@section('title', 'Система автополива')

@section('footer-scripts')
    @parent
    <script src="{{ asset("js/relay_v1.js") }}"></script>
{{--    <script src="{{ asset("plugins/bootstrap-switch/js/bootstrap-switch.min.js") }}"></script>--}}
    <script>
        /*
$(document).ready(function() {
    $(function () {
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    });

    $("input[data-bootstrap-switch]").on('switchChange.bootstrapSwitch', function(event, state) {
        let $this = $(this);
        let topic = $this.data('topic');
        let topic_on = $this.data('topic-command-on');
        let topic_off = $this.data('topic-command-off');
        let payload;

        if (state)  { payload = topic_on; }
        if (!state) { payload = topic_off; }
        $.post( "/api/mqtt/post", { topic: topic, payload: payload })
    });

    function swiftStateRefrash() {
        let $this = $("input[data-bootstrap-switch]");
        if($this.length > 0) {
            $this.map(function (key, value) {
                let topic           = $(value).data('topic');
                let topic_check_on  = $(value).data('check-command-on');
                let topic_check_off = $(value).data('check-command-off');
                let topic_check     = $(value).data('check-topic');
                $.get("/api/mqtt/get?topic="+topic_check, function (data) {
                    let payload = data['payload'];
                    let tdState = $this.parent().parent().parent().parent().find('td[class="watering-state"]')
                    if (payload == topic_check_on)  {
                        $(value).bootstrapSwitch('state', true);
                        $(tdState).html('Включен');
                    }
                    if (payload == topic_check_off) {
                        $(value).bootstrapSwitch('state', false);
                        $(tdState).html('Выключен');
                    }
                });

            });

            setTimeout(swiftStateRefrash, 10000);
        }
    }

    swiftStateRefrash();

});
*/
    </script>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Left col -->
                <section class="col-lg-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Пульт управления автополивом</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Клапан</th>
                                            <th>Топик</th>
                                            <th>Команда</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $_i = 0;?>
                                        @foreach($swifts as $swift)
                                        <tr>
                                            <td>[ {{ $_i++ }} ] - {{$swift->name}}</td>
                                            <td class="watering-state">{{ $swift->topic }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group relay-control" data-swift-topic="{{ $swift->topic }}" data-swift-topic-check="{{ $swift->check_topic }}" data-swift-id="{{ $swift->id }}" data-swift-on="{{ $swift->check_command_on }}" data-swift-off="{{ $swift->check_command_off }}">
                                                    <button type="button" class="btn btn-outline-success" data-swift-topic="{{ $swift->topic }}" data-swift-check="{{ $swift->check_command_on }}" value="{{ $swift->command_on }}">On</button>
                                                    <button type="button" class="btn btn-outline-danger" data-swift-topic="{{ $swift->topic }}" data-swift-check="{{ $swift->check_command_off }}" value="{{ $swift->command_off }}">Off</button>
                                                </div>
{{--<input type="checkbox" name="{{ $swift->topic }}" data-topic="{{ $swift->topic }}" data-check-topic="{{ $swift->check_topic }}"--}}
{{--    data-check-command-on="{{ $swift->check_command_on }}" data-check-command-off="{{ $swift->check_command_off }}"--}}
{{--    data-topic-command-on="{{ $swift->command_on }}" data-topic-command-off="{{ $swift->command_off }}"--}}
{{--    data-bootstrap-switch data-off-color="success" data-on-color="danger">--}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Планировщик автополива</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Клапан</th>
                                            <th>Следующий старт</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $_i = 0?>
                                        @foreach($state as $swift)
                                        <tr>
                                            <td rowspan="2" class="text-left py-0 align-middle">[ {{ $_i++ }} ] - {{$swift->name}}</td>
                                            <td class="text-right py-0 align-middle">Включится&nbsp;&nbsp;&nbsp;&nbsp;{{ $swift->watering_start['start_time'] }}</td>
                                            <td class="text-center py-0 align-middle"><a href="{{ route('scheduler.edit',$swift->watering_start['start_time_job_id']) }}" class="btn btn-default"><i class="fas fa-cogs"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right py-0 align-middle">Выключится&nbsp;{{ $swift->watering_start['end_time'] }}</td>
                                            <td class="text-center py-0 align-middle"><a href="{{ route('scheduler.edit',$swift->watering_start['end_time_job_id']) }}" class="btn btn-default"><i class="fas fa-cogs"></i></a></td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.right col -->
                        <div class="col-md-6">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Произошедшие события</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Дата</th>
                                        <th>Событие</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Главный клапан - <b>включен</b></td>
                                    </tr><tr>
                                        <td>2.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Клапан 1 - <b>включен</b></td>
                                    </tr><tr>
                                        <td>3.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Клапан 1 - <b>включен</b></td>
                                    </tr><tr>
                                        <td>4.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Клапан 1 - <b>включен</b></td>
                                    </tr><tr>
                                        <td>5.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Клапан 1 - <b>включен</b></td>
                                    </tr><tr>
                                        <td>6.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Клапан 1 - <b>включен</b></td>
                                    </tr><tr>
                                        <td>7.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Клапан 1 - <b>включен</b></td>
                                    </tr><tr>
                                        <td>8.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Клапан 1 - <b>включен</b></td>
                                    </tr><tr>
                                        <td>9.</td>
                                        <td>21.04.2020 07:00</td>
                                        <td>Клапан 1 - <b>включен</b></td>
                                    </tr>

                                    </tbody>
                                </table>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <ul class="pagination pagination-sm m-0 float-right">
                                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.left col -->
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
