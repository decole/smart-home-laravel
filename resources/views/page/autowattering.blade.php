@extends('container.template')
@section('title', 'Система автополива')

@section('footer-scripts')
    @parent
    <script src="{{ asset("js/relay_v1.js") }}"></script>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- Left col -->
                <section class="col-12">
                    <div class="row">
                        <div class="col-xl-8 col-md-8">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Пульт управления автополивом</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Клапан</th>
                                            <th class="text-center">Топик</th>
                                            <th class="text-center" style="width: 120px;">Состояние</th>
                                            <th class="text-center">Следующее включение</th>
                                            <th class="text-center">Следующее выключение</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $_i = 0;?>
                                        @foreach($state as $swift)
                                        <tr>
                                            <td>[ {{ $_i++ }} ] - {{$swift->name}}</td>
                                            <td class="watering-state">{{ $swift->topic }}</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group relay-control" data-swift-topic="{{ $swift->topic }}" data-swift-topic-check="{{ $swift->check_topic }}" data-swift-id="{{ $swift->id }}" data-swift-on="{{ $swift->check_command_on }}" data-swift-off="{{ $swift->check_command_off }}">
                                                    <button type="button" class="btn btn-outline-success" data-swift-topic="{{ $swift->topic }}" data-swift-check="{{ $swift->check_command_on }}" value="{{ $swift->command_on }}">On</button>
                                                    <button type="button" class="btn btn-outline-danger" data-swift-topic="{{ $swift->topic }}" data-swift-check="{{ $swift->check_command_off }}" value="{{ $swift->command_off }}">Off</button>
                                                </div>
                                            </td>
                                            <td class="text-right py-0 align-middle">{{ $swift->watering_start['start_time'] }} &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('scheduler.edit',$swift->watering_start['start_time_job_id']) }}" class="btn btn-default"><i class="fas fa-cogs"></i></a></td>
                                            <td class="text-right py-0 align-middle">{{ $swift->watering_start['end_time'] }} &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('scheduler.edit',$swift->watering_start['end_time_job_id']) }}" class="btn btn-default"><i class="fas fa-cogs"></i></a></td>
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
                        <div class="col-xl-4 col-md-4">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Произошедшие события</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Событие</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($history as $moment)
                                        <tr>
                                            <td>{{ $moment->created_at }}</td>
                                            <td>{{ $moment->topic }} - {{ $moment->value }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    @if($history)
                                        {!! $history->render() !!}
                                    @endif
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
