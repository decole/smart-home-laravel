@extends('container.template')
@section('title', 'Secure CRUD (READ)')

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
                        Список Датчиков Охраны
                    </h3>

                    <div class="card-tools">
                        @if($secures)
                            {!! $secures->render() !!}
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Название</td>
                            <td>Тема(Topic)</td>
                            <td>Взведен</td>
                            <td>Текущая команда</td>
                            <td>Тип</td>
                            <td>Место нахождения</td>
                            <td>Уведомления</td>
                            <td>Доступность</td>
                            <td colspan = 2>Действия</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($secures as $secure)
                            <tr>
                                <td>{{$secure->id}}</td>
                                <td>{{$secure->name}}</td>
                                <td>{{$secure->topic}}</td>
                                <td>
                                    @if($secure->trigger)Да@endif
                                    @if(!$secure->trigger)Нет@endif
                                </td>
                                <td>{{$secure->current_command}}</td>
                                <td>
                                    @if($secure->devicetype)
                                    {{$secure->devicetype->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($secure->devicelocation)
                                        {{$secure->devicelocation->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($secure->notifying)Да@endif
                                    @if(!$secure->notifying)Нет@endif
                                </td>
                                <td>
                                    @if($secure->active)Да@endif
                                    @if(!$secure->active)Нет@endif
                                </td>
                                <td>
                                    <a href="{{ route('secure.edit',$secure->id)}}" class="btn btn-primary btn-sm">Изменить</a>
                                </td>
                                <td>
                                    <form action="{{ route('secure.destroy', $secure->id)}}" method="post">
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
                    <a href="{{ route('secure.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Добавить Датчик</a>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
