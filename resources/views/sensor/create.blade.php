@extends('container.template')
@section('title', 'Sensors CRUD (CREATE)')

@section('footer-scripts')
    @parent
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

        {{ route('sensors.index') }}
            <!-- TO DO List -->
            <div class="card">
                <form method="post" action="{{ route('sensors.store') }}">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Create sensor
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
                                <label for="topic">Topic:</label>
                                <input type="text" class="form-control" name="topic" value="{{ old('topic') }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_info">Message-info:</label>
                                <input type="text" class="form-control" name="message_info" value="{{ old('message_info') }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_ok">Message-ok:</label>
                                <input type="text" class="form-control" name="message_ok" value="{{ old('message_ok') }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_warn">Message warning:</label>
                                <input type="text" class="form-control" name="message_warn" value="{{ old('message_warn') }}" />
                            </div>
                            <div class="form-group">
                                <label for="type">Type sensor:</label>
                                <input type="text" class="form-control" name="type" value="{{ old('type') }}" />
                            </div>
                            <div class="form-group">
                                <label for="location">Location:</label>
                                <input type="text" class="form-control" name="location" value="{{ old('location') }}" />
                            </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a class="btn btn-info" href="{{ route('sensors.index') }}">к списку сеносров</a>
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add sensor</button>
                </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
