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
        <section class="col-lg-7 connectedSortable">


            <!-- TO DO List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Sernsor list
                    </h3>

                    <div class="card-tools">
                        <ul class="pagination pagination-sm">
                            <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item"><a href="#" class="page-link">3</a></li>
                            <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Topic</td>
                            <td>Type</td>
                            <td>Location</td>
                            <td colspan = 2>Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sensors as $sensor)
                            <tr>
                                <td>{{$sensor->id}}</td>
                                <td>{{$sensor->name}}</td>
                                <td>{{$sensor->topic}}</td>
                                <td>{{$sensor->type}}</td>
                                <td>{{$sensor->location}}</td>
                                <td>
                                    <a href="{{ route('sensors.edit',$sensor->id)}}" class="btn btn-primary">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ route('sensors.destroy', $sensor->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a style="margin: 19px;" href="{{ route('sensors.create')}}" class="btn btn-info float-right"><i class="fas fa-plus"></i> New sensor</a>
{{--                    <button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add item</button>--}}
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
