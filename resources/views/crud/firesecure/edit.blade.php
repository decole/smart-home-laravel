@extends('container.template')
@section('title', 'FireSecure CRUD (UPDATE)')

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
                <form method="post" action="{{ route('fire_secure.update', $sensor->id) }}">
                    @csrf
                    @method('PATCH')
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Изменение Пожарного датчика
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
                                <input type="text" class="form-control" name="topic" autocomplete="off" value="{{ $sensor->topic }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">normal_condition:</label>
                                <input type="text" class="form-control" name="normal_condition" autocomplete="off" value="{{ $sensor->normal_condition }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">alarm_condition:</label>
                                <input type="text" class="form-control" name="alarm_condition" autocomplete="off" value="{{ $sensor->alarm_condition }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_info">Текст информации о датчике:</label>
                                <input type="text" class="form-control" name="message_info" autocomplete="off" value="{{ $sensor->message_info }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_ok">Текст успешного выполнения:</label>
                                <input type="text" class="form-control" name="message_ok" autocomplete="off" value="{{ $sensor->message_ok }}" />
                            </div>
                            <div class="form-group">
                                <label for="message_warn">Текст ошибки:</label>
                                <input type="text" class="form-control" name="message_warn" autocomplete="off" value="{{ $sensor->message_warn }}" />
                            </div>
                            <div class="form-group">
                                <label for="type">Тип датчика:</label>
                                {{ Form::select('type', $types, $sensor->type, ['class'=> 'form-control'])  }}
                            </div>
                            <div class="form-group">
                                <label for="location">Место нахождения датчика:</label>
                                {{ Form::select('location', $locations, $sensor->location, ['class'=> 'form-control'])  }}
                            </div>
                            <div class="form-group">
                                <label for="topic">Уведомлять:</label>
                                {{ Form::checkbox('notifying', 'state', $sensor->notifying, ['class'=> 'form-control']) }}
                            </div>
                            <div class="form-group">
                                <label for="topic">Доступность:</label>
                                {{ Form::checkbox('active', 'state', $sensor->active, ['class'=> 'form-control']) }}
                            </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a class="btn btn-info" href="{{ route('fire_secure.index') }}">К списку Пожарных датчиков</a>
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Изменить Пожарный датчик</button>
                </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>
        </div>
    </section>
@endsection
