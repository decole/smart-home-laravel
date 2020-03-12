@extends('container.template')
@section('title', 'Location CRUD (CREATE)')

@section('footer-scripts')
    @parent
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

            <!-- TO DO List -->
            <div class="card">
                <form method="post" action="{{ route('locations.store') }}">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Create location
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
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
                            </div>

                            <div class="form-group">
                                <label for="topic">Location:</label>
                                <input type="text" class="form-control" name="location" value="{{ old('location') }}" />
                            </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a class="btn btn-info" href="{{ route('locations.index') }}">К списку мест датчиков</a>
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add location</button>
                </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
