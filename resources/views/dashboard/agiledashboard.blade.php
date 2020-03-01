@extends('container.template')
@section('title', 'Доска ловкости')

@section('head')
    @parent
    <!-- Custom VOKOD styles -->
    <link rel="stylesheet" href="{{ asset("сss/custom.css") }}">
@endsection

@section('footer-scripts')
    @parent
@endsection

@section('content')
<section class="content dashboard-container">
    <div class="container-fluid">

        <section class="p-2 col dashboard-card">
            <div class="row">
                <div class="col-lg-9">
                    <span class="dashboard-title container-fluid">Подготовка</span>
                </div>
                <div class="col-lg-3">
                    <button type="button" class="btn btn-default btn-sm dashboard-extras" data-toggle="modal" data-target="#modal-fix-column">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
        <div class="connectedSortable">
            <div class="card dashboard-card-container">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <h3 class="card-title dashboard-title-text">
                                Написать документацию по объекту
                            </h3>
                        </div>

                        <div class="card-tools col-lg-2">
                            <button type="button" class="btn btn-tool dashboard-extras" data-toggle="modal" data-target="#modal-fix-card">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-title col-lg-12">
                        <span data-toggle="tooltip" title="Есть записи внутри карточки" class="badge badge-card">
                            <i class="fas fa-file-signature"></i>
                        </span>
                            <span data-toggle="tooltip" title="Элементы списка задач" class="badge badge-card">
                            <i class="far fa-check-square"></i>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
            <div class="card dashboard-card-container">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <h3 class="card-title dashboard-title-text">
                                Написать документацию по объекту
                            </h3>
                        </div>

                        <div class="card-tools col-lg-2">
                            <button type="button" class="btn btn-tool dashboard-extras" data-toggle="modal" data-target="#modal-fix-card">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-title col-lg-12">
                            <span data-toggle="tooltip" title="Есть записи внутри карточки" class="badge badge-card">
                                <i class="fas fa-file-signature"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
            <div class="card dashboard-card-container">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <h3 class="card-title dashboard-title-text">
                                Написать документацию по объекту
                            </h3>
                        </div>

                        <div class="card-tools col-lg-2">
                            <button type="button" class="btn btn-tool dashboard-extras" data-toggle="modal" data-target="#modal-fix-card">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-title col-lg-12">
                            <span data-toggle="tooltip" title="Есть записи внутри карточки" class="badge badge-card">
                                <i class="fas fa-file-signature"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
            <button type="button" class="btn btn-block btn-default btn-sm" data-toggle="modal" data-target="#modal-add-card">Создать задачу</button>
        </section>

        <section class="p-2 col dashboard-card">
            <div class="row">
                <div class="col-lg-9">
                    <span class="dashboard-title container-fluid">Проектирование</span>
                </div>
                <div class="col-lg-3">
                    <button type="button" class="btn btn-default btn-sm dashboard-extras" data-toggle="modal" data-target="#modal-fix-column">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
            <div class="connectedSortable">
                <div class="card dashboard-card-container">
                    <div class="card-header">
                        <h3 class="card-title dashboard-title-text">
                            Имя карточки
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool dashboard-extras" data-toggle="modal" data-target="#modal-fix-card">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>

                        <div class="card-title">
                            <span title="дата окончания задачи 25 января 16:30" class="badge badge-warning badge-card">
                                <i class="far fa-clock"></i> 25 января 16:30
                            </span>
                            <span title="Есть записи внутри карточки" class="badge badge-card">
                                <i class="fas fa-file-signature"></i>
                            </span>
                            <span title="Элементы списка задач" class="badge badge-card">
                            <i class="far fa-check-square"></i>
                        </span>

                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <button type="button" class="btn btn-block btn-default btn-sm" data-toggle="modal" data-target="#modal-add-card">Создать задачу</button>
        </section>

        <section class="p-2 col dashboard-card">
            <div class="row">
                <div class="col-lg-9">
                    <span class="dashboard-title container-fluid">Создание</span>
                </div>
                <div class="col-lg-3">
                    <button type="button" class="btn btn-default btn-sm dashboard-extras dashboard-extras" data-toggle="modal" data-target="#modal-fix-column">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
            <div class="connectedSortable">

            </div>
            <button type="button" class="btn btn-block btn-default btn-sm" data-toggle="modal" data-target="#modal-add-card">Создать задачу</button>
        </section>

        <section class="p-2 col dashboard-card">

            <button type="button" class="btn btn-block btn-default btn-sm" data-toggle="modal" data-target="#modal-add-column">Добавить колонку</button>

            {{--<button type="button" class="btn btn-default btn-sm" data-card-widget="collapse">--}}
                {{--<i class="fas fa-cog"></i>--}}
            {{--</button>--}}


        </section>

    </div><!--/. container-fluid -->
</section>
<!-- /.content -->

<!-- Fix column params -->
<div class="modal fade" id="modal-fix-column">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Изменение параметров колонки</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Add column -->
<div class="modal fade" id="modal-add-column">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Добавление колонки</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Add card and params -->
<div class="modal fade" id="modal-add-card">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Добавление катрочки</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Fix card params -->
<div class="modal fade" id="modal-fix-card">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Изменения катрочки</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection