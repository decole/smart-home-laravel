@extends('container.template')
@section('title', 'Система безопасности')

@section('footer-scripts')
    @parent
    <script src="{{ asset("js/secure.js") }}"></script>
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
                            <h3 class="card-title">Пульт управления охранной системой</h3>

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
                                    <th class="text-center">Команда</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sensors as $sensor)
                                <tr>
                                    <td>[ ОШС-{{ $sensor->id }} ] - {{ $sensor->name }}</td>
                                    <td class="text-center secure-sensor-state-text">
                                        @if( $sensor->trigger )Взведен
                                        @endif
                                        @if( !$sensor->trigger )Не взведен
                                        @endif
                                    </td>
                                    <td class="text-center py-0 align-middle">
                                        <div class="btn-group btn-group-sm secure-sensor-control" data-secstate-topic="{{ $sensor->topic }}">
                                            <a class="btn secure-trigger-on  btn-outline-danger @if( $sensor->trigger ) active @endif"><i class="fas fa-eye"></i></a>
                                            <a class="btn secure-trigger-off btn-outline-success @if( !$sensor->trigger ) active @endif"><i class="fas fa-eye-slash"></i></a>
                                            <a class="btn secure-state-info btn-outline-info active">.</a>
                                        </div>
                                    </td>
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
