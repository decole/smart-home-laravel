@extends('container.template')
@section('title', 'Weight CRUD (READ)')

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
                        Вес данных
                    </h3>

                    <div class="card-tools">
                        @if($weights)
                            {!! $weights->render() !!}
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>Дата</td>
                            <td>Вес</td>
                            <td colspan = 2>Действия</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($weights as $weight)
                            <tr>
                                <td>{{$weight->created_at}}</td>
                                <td>{{$weight->weight}}</td>
                                <td>
                                    <a href="{{ route('weight.edit',$weight->id)}}" class="btn btn-primary btn-sm">Изменить</a>
                                </td>
                                <td>
                                    <form action="{{ route('weight.destroy', $weight->id)}}" method="post">
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
                    <a href="{{ route('weight.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Добавить Вес</a>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>
        </div>
    </section>
@endsection
