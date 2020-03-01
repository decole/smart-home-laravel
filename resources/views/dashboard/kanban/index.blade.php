@extends('container.template')
@if ($curent_project !== null)
    @section('title', 'Доска проекта "'.$curent_project["name"].'"')
@else
    @section('title', 'Доска не существует или нет доступа')
@endif
@section('head')
    @parent
    <!-- Custom VOKOD styles -->
    <link rel="stylesheet" href="{{ asset("сss/custom.css") }}">
@endsection

@section('footer-scripts')
    @parent
    <script src="{{ asset("js/descboard.js") }}"></script>
@endsection

@section('content')

    @if ($curent_project !== null)
<section class="content dashboard-container">
    <div>
        <div id="current_project_id" data-project_id="{{ $curent_project['id'] }}"></div>
        <a href="<?=route('agile_project');?>">К списку проектов</a> | <a href="#">Посмотреть архив</a> | <a href="#">Посмотреть удаленное</a>
        @if ($errors->any())
            <div class="info-block">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('message'))
            <div> {{ Session::get('message') }}</div>
        @endif
        @if($page_message)
            {{ $page_message }}
        @endif
        <div class="result"></div>
    </div>
    <div class="container-columns-board contacts-no-wrap"> <!-- ++ class="container-fluid"  -->

        <section class="p-2 col dashboard-card" id="add-column">

            <button
                    type="button"
                    class="btn btn-block btn-default btn-sm"
                    data-toggle="modal"
                    data-target="#modal-add-column"
                    data-project-id="{{ $curent_project['id'] }}"
            >Добавить колонку</button>

        </section>

        <!-- EXAMPLE COLUMN  -->
        <section class="p-2 col dashboard-card dashboard-card-media column-example" id="clone">
            <div class="row row--additional">
                <div class="col-lg-9">
                    <span class="dashboard-title container-fluid dashboard-column-text">Создание</span>
                </div>
                <div class="col-lg-3">
                    <button
                            type="button"
                            class="btn btn-default btn-sm dashboard-extras"
                            data-toggle="modal"
                            data-target="#modal-fix-column"
                            data-project-id="{{ $curent_project['id'] }}"
                    >
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
            <div class="connectedSortable">

            </div>
            <button type="button" class="btn btn-block btn-default btn-sm dashboard-add-card" data-toggle="modal" data-target="#modal-add-card">Создать задачу</button>
        </section>
        <!-- / EXAMPLE COLUMN  -->

        <!-- EXAMPLE CARD -->
        <div class="card dashboard-card-container card-example"id="clone_card" >
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title dashboard-title-text">
                    Имя карточки
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool dashboard-extras dashboard-update-card" data-toggle="modal" data-target="#modal-fix-card">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
            <div class="card-footer card-kanban-footer clearfix">
                <span title="дата окончания задачи" class="badge badge-warning badge-card card-deadline-badge" style="display: none;">
                    <i class="far fa-clock"></i> <span class="card-deadline">25 января 16:30</span>
                </span>
                <span title="Есть записи внутри карточки" class="badge badge-card card-comment-badge" style="display: none;">
                    <i class="fas fa-file-signature"></i>
                </span>
                <span title="Элементы списка задач" class="badge badge-card card-tasks-badge" style="display: none;">
                    <i class="far fa-check-square"></i>
                </span>
            </div>
        </div>
        <!-- / EXAMPLE CARD  -->



    </div><!--/. container-fluid -->
</section>
<!-- /.content -->

<!-- Add column -->
<div class="modal fade" id="modal-add-column">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/agiledashboard/project/add_column" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Добавление колонки</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Имя колонки</label>
                        <input type="text" class="form-control" name="column_name" id="newColumnName" placeholder="Введите имя колонки" autocomplete="off">

                        <input type="hidden" name="project_id" value="{{ $curent_project['id'] }}">
                        <input type="hidden" name="sort_number" value="new">
                    </div>

                    <div class="form-group">
                        <label>Комментарии к карточке</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Комментарии к новой колонке"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Тип колонки:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="0" checked>
                            <label class="form-check-label">Простая</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="1" disabled>
                            <label class="form-check-label">задачи нужно сделать</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="2" disabled>
                            <label class="form-check-label">задачи в процессе</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="3" disabled>
                            <label class="form-check-label">выполненные задачи</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="4" disabled>
                            <label class="form-check-label">bug-tracker заявки</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="5" disabled>
                            <label class="form-check-label">bug-tracker выполненные заявки</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Fix column params -->
<div class="modal fade" id="modal-fix-column">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/agiledashboard/project/update_column" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Изменение параметров колонки</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Имя колонки</label>
                        <input type="text" class="form-control" name="column_name" id="UpdateColumnName" placeholder="Введите имя колонки" autocomplete="off">
                        <input type="hidden" name="project_id" value="{{ $curent_project['id'] }}">
                        <input type="hidden" name="column_id" id="UpdateColumnId">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Место в очереди</label>
                        <select name="sort_number" class="form-control" id="UpdateColumnSortNumberSelect"></select>
                        <label>Вид изменения:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="change_type" value="before" checked id="updateBeforeType">
                            <label class="form-check-label" for="updateBeforeType">Поместить перед</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="change_type" value="move" id="updateMoveType">
                            <label class="form-check-label" for="updateMoveType">Вместо</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Комментарии к карточке</label>
                        <textarea class="form-control" name="description" rows="3" id="UpdateColumnDescription"
                                  placeholder="Комментарии к новой колонке"></textarea>
                    </div>

                    <div class="form-group" id="UpdateColumnType">
                        <label>Тип колонки:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="0"
                                   data-column_type_edit="0" checked>
                            <label class="form-check-label">Простая</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="1"
                                   data-column_type_edit="1" disabled>
                            <label class="form-check-label">Задачи нужно сделать</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="2"
                                   data-column_type_edit="2" disabled>
                            <label class="form-check-label">Задачи в процессе</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="3"
                                   data-column_type_edit="3" disabled>
                            <label class="form-check-label">Выполненные задачи</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="4"
                                   data-column_type_edit="4" disabled>
                            <label class="form-check-label">bug-tracker заявки</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_type" value="5"
                                   data-column_type_edit="5" disabled>
                            <label class="form-check-label">bug-tracker выполненные заявки</label>
                        </div>
                    </div>

                    <div class="form-group" id="UpdateColumnState">
                        <label>Тип колонки:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_state" value="active" data-column_state_edit="1" id="UpdateColumnActive">
                            <label class="form-check-label" for="UpdateColumnActive">В работе</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_state" value="archive" data-column_state_edit="2" id="UpdateColumnArchive">
                            <label class="form-check-label" for="UpdateColumnArchive">Архивная</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="column_state" value="disable" data-column_state_edit="0" id="UpdateColumnDisable">
                            <label class="form-check-label" for="UpdateColumnDisable">Удаленная</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
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
            <form action="/agiledashboard/project/card/create" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Добавление карточки</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Имя карточки</label>
                        <input type="text" class="form-control" name="card_name" placeholder="Введите имя карточки" autocomplete="off">

                        <input type="hidden" name="project_id" value="{{ $curent_project['id'] }}">
                        <input type="hidden" name="column_id" value="">
                        {{--<input type="hidden" name="sort_number" value="new">--}}
                    </div>

                    <div class="form-group">
                        <label>Комментарии к карточке</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Комментарии к новой карточке"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Тип карточки:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="card_type" value="active" checked id="AddCardActive">
                            <label class="form-check-label" for="AddCardActive">Активная</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="card_type" value="bug" id="AddCardBug">
                            <label class="form-check-label" for="AddCardBug">Bug-tracker заявка</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="card_type" value="archive" disabled id="AddCardArhive">
                            <label class="form-check-label" for="AddCardArhive">Архивная</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="card_type" value="disable" disabled id="AddCardDisable">
                            <label class="form-check-label" for="AddCardDisable">Удаленна</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Срок исполнения:</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            <input type="text" name="finish_time" class="form-control float-right" id="reservationtime" autocomplete="off">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-info" onclick="$('#reservationtime').val('');">Отчистить</button>
                            </span>
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary form_column_create">Save changes</button>
                </div>
            </form>
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
            <form action="/agiledashboard/project/card/update" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Изменения катрочки</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-9">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Имя карточки</label>
                                <input type="text" class="form-control" name="card_name" placeholder="Введите имя карточки" autocomplete="off">
                                <input type="hidden" name="project_id" value="{{ $curent_project['id'] }}">
                                <input type="hidden" name="card_id" value="">
                            </div>
                            <div class="form-group">
                                <label>Комментарии к карточке</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Комментарии к новой карточке"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Тип карточки:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="card_type" value="active" data-card_type_int="1" checked id="UpdateAddCardActive">
                                    <label class="form-check-label" for="UpdateAddCardActive">Активная</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="card_type" value="bug" data-card_type_int="3" id="UpdateAddCardBug">
                                    <label class="form-check-label" for="UpdateAddCardBug">Bug-tracker заявка</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="card_type" value="archive" data-card_type_int="2" id="UpdateAddCardArchive">
                                    <label class="form-check-label" for="UpdateAddCardArchive">Архивная</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="card_type" value="disable" data-card_type_int="0" id="UpdateAddCardDisable">
                                    <label class="form-check-label" for="UpdateAddCardDisable">Удаленна</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Срок исполнения:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="text" name="finish_time" class="form-control float-right" id="updateRservationTime" autocomplete="off">
                                    <span class="input-group-append">
                                            <button type="button" class="btn btn-info" onclick="$('#updateRservationTime').val('');">Отчистить</button>
                                        </span>
                                </div>
                                <!-- /.input group -->
                            </div>

                            <div class="form-group">
                                <div class="to-do-list-show">
                                </div>
                                <!-- /div to-do-list-show -->
                                <ul class="todo-decole-style todo-list ui-sortable task-list-example" data-widget="todo-list">
                                    <div>
{{-- @Todo сделать сценарии открытия и скрытия - изменения данных титульника --}}
                                        <div>
                                            <div class="input-group">
                                                <div class="todo-decole-name">Example List</div>
                                                <input type="text" class="form-control todo-decole-title-name-edit" style="display: none;">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-default task-list-button-apply" style="display: none;">Сохранить</button>
                                                    <button type="button" class="btn btn-danger task-list-button-delete" style="display: none;">Удалить</button>
                                                    <button type="button" class="btn btn-default task-list-button-cancel" style="display: none;">Отмена</button>
                                                </div>
                                                <!-- /btn-group -->
                                            </div>
                                        </div>

                                        <div class="fixing-contetn-button-task-add">
                                            <div class="input-group">
                                                <input type="text" class="form-control task-decole-text-edit-input" style="display: none;">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-default add-task-element-in-list">Добавить задачу</button>
                                                    <button type="button" class="btn btn-default task-list-button-text-edit-apply" style="display: none;">Сохранить</button>
                                                    <button type="button" class="btn btn-default task-list-button-text-edit-cancel" style="display: none;">Отмена</button>
                                                </div>
                                                <!-- /btn-group -->
                                            </div>
                                        </div>
                                    </div>
                                </ul>

                                <li class="todo-decole-element task-list-element-example" style="">
                                            <span class="handle ui-sortable-handle">
                                              <i class="fas fa-ellipsis-v"></i>
                                              <i class="fas fa-ellipsis-v"></i>
                                            </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo0" id="todoCheck0">
                                        <label for="todoCheck0"></label>
                                    </div>
                                    <span class="todo-decole-text">Example text on task</span>
                                    <div class="tools">
                                        <i class="fas fa-edit"></i>
                                        <i class="fas fa-trash-alt"></i>
                                    </div>
                                    <div class="todo-decole-text-edit-hide">
                                        <div class="input-group">
                                            <input type="text" class="form-control todo-decole-text-edit">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-default task-list-button-apply">Сохранить</button>
                                                <button type="button" class="btn btn-default task-list-button-cancel">Отмена</button>
                                            </div>
                                            <!-- /btn-group -->
                                        </div>
                                    </div>
                                </li>

                            </div>
                        </div>
                        <div class="col-lg-3">
                            <p>Добавить на карточку:</p>
                            <div class="form-group">
                                <a
                                    role="button"
                                    data-toggle="collapse"
                                    href="#collapseExample"
                                    aria-expanded="false"
                                    aria-controls="collapseExample"
                                    class="btn btn-block btn-default task-list-add-button"
                                >
                                    <i class="fas fa-tasks"></i> Чек-лист
                                </a>
                                <div class="input-group collapse" id="collapseExample">
                                    <span class="small pt-2">Добавление нового такс-листа:</span>
                                    <input id="new-task-list" type="text" class="form-control" placeholder="Название списка задач">
                                    <div class="input-group-append well">
                                        <button id="add-new-task-list" type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <!-- /btn-group -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onsubmit="return false;">Сохранить изменения</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
    @endif
@endsection
