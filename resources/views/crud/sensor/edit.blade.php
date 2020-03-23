@extends('container.template')
@section('title', 'Sensors CRUD (UPDATE)')

@section('footer-scripts')
    @parent
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">

            <div class="card">
                <form method="post" action="{{ route('sensors.update', $sensor->id) }}">
                    @csrf
                    @method('PATCH')
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Изменение Сенсора
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
                                <input type="text" class="form-control" name="name" value="{{ $sensor->name }}" />
                            </div>

                            <div class="form-group">
                                <label for="topic">Тема (Topic):</label>
                                <input type="text" class="form-control" name="topic" value="{{ $sensor->topic }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">занчение от:</label>
                                <input type="text" class="form-control" name="from_condition" autocomplete="off" value="{{ $sensor->from_condition }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">занчение до:</label>
                                <input type="text" class="form-control" name="to_condition" autocomplete="off" value="{{ $sensor->to_condition }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_info">Текст информации о датчике:</label>
                                <input type="text" class="form-control" name="message_info" value="{{ $sensor->message_info }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_ok">Текст успешного выполнения:</label>
                                <input type="text" class="form-control" name="message_ok" value="{{ $sensor->message_ok }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_warn">Текст ошибки:</label>
                                <input type="text" class="form-control" name="message_warn" value="{{ $sensor->message_warn }}" />
                            </div>
                        <div class="form-group">
                            <label for="type">Тип датчика:</label>
                            {{--                                <input type="text" class="form-control" name="type" value="{{ old('type') }}" />--}}
                            {{ Form::select('type', $types, $sensor->type, ['class'=> 'form-control'])  }}
                        </div>
                        <div class="form-group">
                            <label for="location">Место нахождения датчика:</label>
                            {{ Form::select('location', $locations, $sensor->location, ['class'=> 'form-control'])  }}
                        </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a class="btn btn-info" href="{{ route('sensors.index') }}">К списку Сеносров</a>
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Изменить Сенсор</button>
                </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
