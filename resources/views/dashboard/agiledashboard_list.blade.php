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
                        <th>Состояние</th>
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
                                {{ $project->name }} [ {{ $project->project_state_name }} ]</a>
                            @if($project->project_state === 2)
                                </u>
                            @endif
                        </td>
                        <td>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                            </div>
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
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-project">Добавить проект</button>

                {{--<ul class="pagination pagination-sm m-0 float-right">--}}
                    {{--<li class="page-item"><a class="page-link" href="#">«</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">1</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">2</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">3</a></li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">»</a></li>--}}
                {{--</ul>--}}
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