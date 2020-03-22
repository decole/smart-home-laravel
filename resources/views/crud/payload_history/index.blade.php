@extends('container.template')
@section('title', 'History Sensor Data of GreenHouse')

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
        <section class="col-lg-6 connectedSortable">
            <!-- TO DO List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Исторические данные сенсора в теплице
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
                            <td>Показание</td>
                            <td>Дата</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sensors as $sensor)
                            <tr>
                                <td>{{$sensor->payload}}</td>
                                <td>{{$sensor->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
{{--                    <a href="{{ route('types.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Добавить Тип датчиков</a>--}}
{{--                    <button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add item</button>--}}
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
