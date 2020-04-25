@extends('container.template')
@section('title', 'Система пожарной безопасности')

@section('footer-scripts')
    @parent
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
                                            <th>Состояние</th>
                                            <th style="width: 30px">Статус</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>[ ППК-1 ] - дом</td>
                                            <td>Работает</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="#" class="btn btn-outline-success active"><i class="fas fa-lightbulb"></i></a>
                                                </div>
                                            </td>
                                        </tr><tr>
                                            <td>[ ППК-2 ] - пристройка</td>
                                            <td>Работает</td>
                                            <td class="text-right py-0 align-middle">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="#" class="btn btn-outline-danger active"><i class="fas fa-fire"></i></a>
                                                </div>
                                            </td>
                                        </tr>

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
                                        <th style="width: 140px;">Дата</th>
                                        <th>Событие</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>21.04.2020 07:31</td>
                                        <td>ППК-1 сработка</td>
                                    </tr><tr>
                                        <td>21.04.2020 08:19</td>
                                        <td>ППК-1 - не отвечает</td>
                                    </tr><tr>
                                        <td>21.04.2020 12:07</td>
                                        <td>ППК-2 - не отвечает</td>
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
