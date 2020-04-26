@extends('container.template')
@section('title', 'Сообщения сервера')

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
        <section class="col-lg-12">


            <!-- TO DO List -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ion ion-clipboard mr-1"></i>
                        Список событий
                    </h3>

                    <div class="card-tools">
                        @if($notifications)
                            {!! $notifications->render() !!}
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>Тип</td>
                            <td>Событие</td>
                            <td>Дата</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notifications as $notify)
                            <tr>
                                <td>{{$notify->type}}</td>
                                <td>
{{--                                    {{var_export($notify->data, true)}}--}}
                                    @if(isset($notify->data['type']))<u>Тип</u>: <b>{{ $notify->data['type'] }}</b>
                                    @endif
                                    @if(isset($notify->data['topic'])) | <u>Тема</u>: <b>{{ $notify->data['topic'] }}</b>
                                    @endif
                                    @if(isset($notify->data['payload'])) | <u>Значение</u>: <b>{{ $notify->data['payload'] }}</b>
                                    @endif
                                    @if(isset($notify->data['message'])) | <u>Сообщение</u>: <b>{{ $notify->data['message'] }}</b>
                                    @endif
                                </td>
                                <td>{{$notify->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <form action="{{ route('notifications.destroy', 'all')}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Пометить все как прочитанное</button>
                    </form>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
