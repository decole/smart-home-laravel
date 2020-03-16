@extends('container.template')
@section('title', 'Secure CRUD (UPDATE)')

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
                <form method="post" action="{{ route('secure.update', $sensor->id) }}">
                    @csrf
                    @method('PATCH')
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Изменение Датчика Охраны
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
                            <input type="text" class="form-control" name="name" autocomplete="off" value="{{ $sensor->name }}" />
                        </div>
                        <div class="form-group">
                            <label for="topic">Тема (Topic):</label>
                            <input type="text" class="form-control" name="topic" autocomplete="off" value="{{ $sensor->topic }}" />
                        </div>

                        <div class="form-group">
                            <label for="topic">Взведен:</label>
                            {{ Form::checkbox('trigger', 'state', $sensor->trigger, ['class'=> 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <label for="topic">Текущая команда:</label>
                            <input type="text" class="form-control" name="current_command" autocomplete="off" value="{{ $sensor->current_command }}" />
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
                    <a class="btn btn-info" href="{{ route('secure.index') }}">К списку Датчиков Охраны</a>
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Изменить Датчик</button>
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
