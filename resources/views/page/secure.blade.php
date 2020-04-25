@extends('container.template')
@section('title', 'Система безопасности')

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
                                    <th>Состояние</th>
                                    <th>Команда</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>[ ОШС-1 ] - холодная прихожка</td>
                                    <td>Не взведен</td>
                                    <td class="text-right py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-danger"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-outline-success active"><i class="fas fa-eye-slash"></i></a>
                                        </div>
                                    </td>
                                </tr><tr>
                                    <td>[ ОШС-1 ] - холодная прихожка</td>
                                    <td>Взведен</td>
                                    <td class="text-right py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-secondary active"><i class="fas fa-lock"></i></a>
                                            <a href="#" class="btn btn-outline-secondary"><i class="fas fa-lock-open"></i></a>
                                        </div>
                                    </td>
                                </tr><tr>
                                    </tr><tr>
                                    <td>[ ОШС-1 ] - холодная прихожка</td>
                                    <td>Взведен</td>
                                    <td class="text-right py-0 align-middle">
                                        <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="success" data-on-color="danger">
                                    </td>
                                </tr><tr>
                                    <td>[ ОШС-1 ] - холодная прихожка</td>
                                    <td>Взведен</td>
                                    <td class="text-right py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-danger active"><i class="fas fa-key"></i></a>
                                            <a href="#" class="btn btn-outline-danger"><i class="fas fa-ban"></i></a>
                                        </div>
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
                                <td>21.04.2020 07:31</td>
                                <td>ОШС-1 взведен</td>
                            </tr><tr>
                                <td>2.</td>
                                <td>21.04.2020 08:19</td>
                                <td>ОШС-1 - детектирование движения</td>
                            </tr><tr>
                                <td>3.</td>
                                <td>21.04.2020 12:07</td>
                                <td>ОШС-1 - детектирование движения</td>
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
