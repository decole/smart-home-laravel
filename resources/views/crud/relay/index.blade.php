@extends('container.template')
@section('title', 'Relays CRUD (READ)')

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
                        Список Реле
                    </h3>

                    <div class="card-tools">
                        @if($relays)
                            {!! $relays->render() !!}
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
                            <td>Проверочная тема(Check Topic)</td>
                            <td>Тип</td>
                            <td>Место нахождения</td>
                            <td>Уведомления</td>
                            <td>Доступность</td>
                            <td colspan = 2>Действия</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($relays as $relay)
                            <tr>
                                <td>{{$relay->id}}</td>
                                <td>{{$relay->name}}</td>
                                <td>{{$relay->topic}}</td>
                                <td>{{$relay->check_topic}}</td>
                                <td>
                                    @if($relay->devicetype)
                                    {{$relay->devicetype->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($relay->devicelocation)
                                        {{$relay->devicelocation->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($relay->notifying)Да@endif
                                    @if(!$relay->notifying)Нет@endif
                                </td>
                                <td>
                                    @if($relay->active)Да@endif
                                    @if(!$relay->active)Нет@endif
                                </td>
                                <td>
                                    <a href="{{ route('relays.edit',$relay->id)}}" class="btn btn-primary btn-sm">Изменить</a>
                                </td>
                                <td>
                                    <form action="{{ route('relays.destroy', $relay->id)}}" method="post">
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
                    <a href="{{ route('relays.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Добавить Реле</a>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
