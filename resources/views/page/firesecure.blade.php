@extends('container.template')
@section('title', 'Система пожарной безопасности')

@section('footer-scripts')
    @parent
    <script src="{{ asset("js/fire_secure.js") }}"></script>
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
                                    <h3 class="card-title">Пульт пожарной системы</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Датчик</th>
                                            <th class="text-center">Состояние</th>
                                            <th class="text-center" style="width: 30px">Статус</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sensors as $sensor)
                                        <tr>
                                            <td>[ ППК-{{ $sensor->id }} ] - {{ $sensor->name }}</td>
                                            <td class="text-center">Работает</td>
                                            <td class="text-center py-0 align-middle">
                                                <div class="btn-group btn-group-sm fire-sensor-control" data-secstate-topic="{{ $sensor->topic }}" data-secstate-id="{{ $sensor->id }}" data-condition-normal="{{ $sensor->normal_condition }}" data-condition-alarm="{{ $sensor->alarm_condition }}">
                                                    <a class="btn btn-outline-success"><i class="fas fa-lightbulb"></i></a>
                                                    <a style="display: none;" class="btn btn-outline-danger"><i class="fas fa-fire"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{--<tr>--}}
                                            {{--<td>[ ППК-2 ] - пристройка</td>--}}
                                            {{--<td>Работает</td>--}}
                                            {{--<td class="text-right py-0 align-middle">--}}
                                                {{--<div class="btn-group btn-group-sm">--}}
                                                    {{--<a href="#" class="btn btn-outline-danger active"><i class="fas fa-fire"></i></a>--}}
                                                {{--</div>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}

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
