@extends('container.template')
@section('title', 'Scheduler CRUD (UPDATE)')

@section('footer-scripts')
    @parent
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">

            <div class="card">
                <form method="post" action="{{ route('scheduler.update', $schedule->id) }}">
                    @csrf
                    @method('PATCH')
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Изменение Задачи планировщика
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                    @endif
                        <div class="form-group">
                            <label for="name">Команда:</label>
                            <input type="text" class="form-control" name="command" autocomplete="off" value="{{ $schedule->command }}" />
                        </div>
                        <div class="form-group">
                            <label for="topic">Интервал:</label>
                            <input type="text" class="form-control" name="interval" autocomplete="off" value="{{ $schedule->interval }}" />
                        </div>

                        <div class="form-group">
                            <label for="topic">Последний старт:</label>
                            <input type="text" class="form-control" name="last_run" autocomplete="off" value="{{ $schedule->last_run }}" />
                        </div>
                        <div class="form-group">
                            <label for="topic">Следующий запуск:</label>
                            <input type="text" class="form-control" name="next_run" autocomplete="off" value="{{ $schedule->next_run }}" />
                        </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a class="btn btn-info" href="{{ route('scheduler.index') }}">К списку Задач</a>
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Изменить Задачу</button>
                </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>
        </div>
    </section>
@endsection
