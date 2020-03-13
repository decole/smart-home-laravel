@extends('container.template')
@section('title', 'Location CRUD (UPDATE)')

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
                <form method="post" action="{{ route('locations.update', $location->id) }}">
                    @csrf
                    @method('PATCH')
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Изменение Места расположения датчиков
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
                                <label for="name">Название:</label>
                                <input type="text" class="form-control" name="name" value="{{ $location->name }}" />
                            </div>

                            <div class="form-group">
                                <label for="topic">Место:</label>
                                <input type="text" class="form-control" name="location" value="{{ $location->location }}" />
                            </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a class="btn btn-info" href="{{ route('locations.index') }}">К списку Мест датчиков</a>
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Изменить место</button>
                </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
