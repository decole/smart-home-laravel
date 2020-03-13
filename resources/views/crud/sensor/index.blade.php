@extends('container.template')
@section('title', 'Sensors CRUD (READ)')

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
                        Список Сенсоров
                    </h3>

                    <div class="card-tools">
                        @if($sensors)
                            {!! $sensors->render() !!}
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
                            <td>Тип</td>
                            <td>Место нахождения</td>
                            <td colspan = 2>Действия</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sensors as $sensor)
                            <tr>
                                <td>{{$sensor->id}}</td>
                                <td>{{$sensor->name}}</td>
                                <td>{{$sensor->topic}}</td>
                                <td>
                                    @if($sensor->devicetype)
                                    {{$sensor->devicetype->name}}
                                    @endif
                                </td>
                                <td>
                                    @if($sensor->devicelocation)
                                        {{$sensor->devicelocation->name}}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('sensors.edit',$sensor->id)}}" class="btn btn-primary btn-sm">Изменить</a>
                                </td>
                                <td>
                                    <form action="{{ route('sensors.destroy', $sensor->id)}}" method="post">
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
                    <a href="{{ route('sensors.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Добавить сенсор</a>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
