@extends('container.template')
@section('title', 'Scheduler CRUD (READ)')

@section('footer-scripts')
    @parent
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">

            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Задачи планировщика
                    </h3>

                    <div class="card-tools">
                        @if($scheduler)
                            {!! $scheduler->render() !!}
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Команда</td>
                            <td>Интервал</td>
                            <td>Последний старт</td>
                            <td>Следующий запуск</td>
                            <td colspan = 2>Действия</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($scheduler as $schedule)
                            <tr>
                                <td>{{$schedule->id}}</td>
                                <td>{{$schedule->command}}</td>
                                <td>{{$schedule->interval}}</td>
                                <td>{{$schedule->last_run}}</td>
                                <td>{{$schedule->next_run}}</td>
                                <td>
                                    <a href="{{ route('scheduler.edit',$schedule->id) }}" class="btn btn-primary btn-sm">Изменить</a>
                                </td>
                                <td>
                                    <form action="{{ route('scheduler.destroy', $schedule->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="{{ route('scheduler.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Добавить Задачу</a>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>
        </div>
    </section>
@endsection
