@extends('container.template')
@section('title', 'Система автополива')

@section('footer-scripts')
    @parent
    <script src="{{ asset("plugins/bootstrap-switch/js/bootstrap-switch.min.js") }}"></script>
    <script>
        $(function () {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });
        });
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
                                            <th>Состояние</th>
                                            <th>Команда</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>[ 0 ] - Главный клапан</td>
                                            <td>Включен</td>
                                            <td class="text-right py-0 align-middle">
                                                <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="success" data-on-color="danger">
                                            </td>
                                        </tr><tr>
                                            <td>[ 1 ] - Клапан 1</td>
                                            <td>Включен</td>
                                            <td class="text-right py-0 align-middle">
                                                <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="success" data-on-color="danger">
                                            </td>
                                        </tr><tr>
                                        </tr><tr>
                                            <td>[ 2 ] - Клапан 2</td>
                                            <td>Выключен</td>
                                            <td class="text-right py-0 align-middle">
                                                <input type="checkbox" name="my-checkbox" data-bootstrap-switch data-off-color="success" data-on-color="danger">
                                            </td>
                                        </tr><tr>
                                            <td>[ 3 ] - Клапан 3</td>
                                            <td>Выключен</td>
                                            <td class="text-right py-0 align-middle">
                                                <input type="checkbox" name="my-checkbox" data-bootstrap-switch data-off-color="success" data-on-color="danger">
                                            </td>

                                        </tr></tbody>
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

                                        <tr>
                                            <td>[ 0 ] - Главный клапан</td>
                                            <td>
                                                Включится 22.04.2020 в 07:00 <br>
                                                Выключится 22.04.2020 в 10:00
                                            </td>
                                            <td class="text-right py-0 align-middle">
                                                <button type="button" class="btn btn-default" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-cogs"></i></button>
                                            </td>
                                        </tr><tr>
                                            <td>[ 1 ] - Клапан 1</td>
                                            <td>
                                                Включится 22.04.2020 в 07:00 <br>
                                                Выключится 22.04.2020 в 08:00
                                            </td>
                                            <td class="text-right py-0 align-middle">
                                                <button type="button" class="btn btn-default" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-cogs"></i></button>
                                            </td>
                                        </tr><tr>
                                        </tr><tr>
                                            <td>[ 2 ] - Клапан 2</td>
                                            <td>
                                                Включится 22.04.2020 в 08:00 <br>
                                                Выключится 22.04.2020 в 09:00
                                            </td>
                                            <td class="text-right py-0 align-middle">
                                                <button type="button" class="btn btn-default" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-cogs"></i></button>
                                            </td>
                                        </tr><tr>
                                            <td>[ 3 ] - Клапан 3</td>
                                            <td>
                                                Включится 22.04.2020 в 09:00 <br>
                                                Выключится 22.04.2020 в 10:00
                                            </td>
                                            <td class="text-right py-0 align-middle">
                                                <button type="button" class="btn btn-default" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-cogs"></i></button>
                                            </td>

                                        </tr></tbody>
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
