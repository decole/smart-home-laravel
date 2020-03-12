@extends('container.template')
@section('title', 'Начальная')

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
                <form method="post" action="{{ route('sensors.update', $sensor->id) }}">
                    @csrf
                    @method('PATCH')
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Edit sensor
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
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $sensor->name }}" />
                            </div>

                            <div class="form-group">
                                <label for="topic">Topic:</label>
                                <input type="text" class="form-control" name="topic" value="{{ $sensor->topic }}" />
                            </div>

                            <div class="form-group">
                                <label for="payload">Payload:</label>
                                <input type="text" class="form-control" name="payload" value="{{ $sensor->payload }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_info">Message-info:</label>
                                <input type="text" class="form-control" name="message_info" value="{{ $sensor->message_info }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_ok">Message-ok:</label>
                                <input type="text" class="form-control" name="message_ok" value="{{ $sensor->message_ok }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_warn">Message warning:</label>
                                <input type="text" class="form-control" name="message_warn" value="{{ $sensor->message_warn }}" />
                            </div>
                            <div class="form-group">
                                <label for="type">Type sensor:</label>
                                <input type="text" class="form-control" name="type" value="{{ $sensor->type }}" />
                            </div>
                            <div class="form-group">
                                <label for="location">Location:</label>
                                <input type="text" class="form-control" name="location" value="{{ $sensor->location }}" />
                            </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Update sensor</button>
                </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
