@extends('container.template')
@section('title', 'Relays CRUD (UPDATE)')

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
                <form method="post" action="{{ route('relays.update', $sensor->id) }}">
                    @csrf
                    @method('PATCH')
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Изменение Реле
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
                                <label for="topic">Проверочная Тема (Topic):</label>
                                <input type="text" class="form-control" name="check_topic" autocomplete="off" value="{{ $sensor->check_topic }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">Команда включить:</label>
                                <input type="text" class="form-control" name="command_on" autocomplete="off" value="{{ $sensor->command_on }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">Команда выключить:</label>
                                <input type="text" class="form-control" name="command_off" autocomplete="off" value="{{ $sensor->command_off }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">Проверочная команда включения:</label>
                                <input type="text" class="form-control" name="check_command_on" autocomplete="off" value="{{ $sensor->check_command_on }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">Проверочная команда выключения:</label>
                                <input type="text" class="form-control" name="check_command_off" autocomplete="off" value="{{ $sensor->check_command_off }}" />
                            </div>
                            <div class="form-group">
                                <label for="topic">Последняя команда:</label>
                                <input type="text" class="form-control" name="last_command" autocomplete="off" value="{{ $sensor->last_command }}" />
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
                    <a class="btn btn-info" href="{{ route('relays.index') }}">К списку Реле</a>
                    <button type="submit" class="btn btn-info float-right"><i class="fas fa-plus"></i> Изменить Реле</button>
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
