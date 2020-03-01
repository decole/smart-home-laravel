@extends('container.template')
@section('title', 'Доска ловкости')

@section('head')
    @parent
    <!-- Custom VOKOD styles -->
    <link rel="stylesheet" href="{{ asset("сss/custom.css") }}">
@endsection

@section('footer-scripts')
    @parent
    <script src="{{ asset("js/projects.js") }}"></script>
@endsection

@section('content')
<section class="content dashboard-container">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Список проектов</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Название проекта</th>
                        <th style="width: 150px">Владелец</th>
                        <th style="width: 150px">Тип</th>
                        <th style="width: 60px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $int = 0;?>
                    @foreach ($project_list as $project)
                    <tr style="background-color:
                        @if ($project->project_state === 0) #d4d4d4
                        @elseif ($project->project_state === 2) #989898
                        @endif
                    ;">
                        <td>{{ ++$int }}</td>
                        <td>
                            @if($project->project_state === 2)
                                <u>
                            @endif
                            <a style="color: #1d1e1f;" href="/agiledashboard/project/{{ $project->id }}">
                                {{ $project->name }} [ {{ $project->project_state_name }} ]
                            </a>
                            @if($project->project_state === 2)
                                </u>
                            @endif
                        </td>
                        <td>
                            {{ $project->users->name }}
                        </td>
                        <td>
                            <span class="badge bg-danger">55%</span> {{ $project->project_type_name }}
                        </td>
                        <td>
                            @if($project->owner == Auth::id())
                            <button type="button" class="btn btn-default btn-sm form_project_edite"
                                    data-toggle="modal"
                                    data-target="#modal-edit-project"
                                    data-project_id="{{ $project->id }}"
                                    data-project="{{ $project->name }}"
                                    data-project_type="{{ $project->project_type }}"
                                    data-project_state="{{ $project->project_state }}"
                            ><i class="fas fa-cogs"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-1">
                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-project">Добавить проект</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        {!! $project_list->render() !!}
                    </div>
                </div>
            </div>
        </div>

    </div><!--/. container-fluid -->
</section>
<!-- /.content -->

<!-- Fix column params -->
<div class="modal fade" id="modal-add-project">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form method="post" action="/agiledashboard/project/create" name="modal_new_project">
            <div class="modal-header">
                <h4 class="modal-title">Добавление нового проекта</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                  @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Имя проекта</label>
                    <input type="text" class="form-control" name="project_name" id="newProjectName" placeholder="Введите имя проекта">
                </div>
                {{--<div class="form-group">--}}
                    {{--<label>Примечание к проекту</label>--}}
                    {{--<textarea class="form-control" rows="3" name="project_comments" id="newProjectComments" placeholder="..."></textarea>--}}
                {{--</div>--}}
                <div class="form-group">
                    <label>Тип проекта:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="project_type" value="public" checked>
                        <label class="form-check-label">Публичный</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="project_type" value="private">
                        <label class="form-check-label">Приватный</label>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary form_project_save">Сохранить</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Fix column params -->
<div class="modal fade" id="modal-edit-project">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="/agiledashboard/project/edit" name="modal_new_project">
                <div class="modal-header">
                    <h4 class="modal-title">Изменение проекта</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Имя проекта</label>
                        <input type="text" class="form-control" name="project_name" id="ProjectName" placeholder="Введите имя проекта">
                        <input type="hidden" name="project_id" id="ProjectIdName">
                    </div>
                    <div class="form-group" id="ProjectEditType">
                        <label>Тип проекта:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="project_type" value="public" data-project_type_edit="0">
                            <label class="form-check-label">Публичный</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="project_type" value="private" data-project_type_edit="1">
                            <label class="form-check-label">Приватный</label>
                        </div>
                    </div>
                    <div class="form-group" id="ProjectEditState">
                        <label>Тип проекта:</label>
                        <div class="form-check">
                            {{-- 0 - disable , 1 - active , 2 - archive --}}
                            <input class="form-check-input" type="radio" name="project_state" value="active" data-project_state_edit="1">
                            <label class="form-check-label">В работе</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="project_state" value="archive" data-project_state_edit="2">
                            <label class="form-check-label">Архивный</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="project_state" value="disable" data-project_state_edit="0">
                            <label class="form-check-label">Закрытый</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary form_project_save">Сохранить</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection
