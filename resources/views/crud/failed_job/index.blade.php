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
                        Список неисполненных задач
                    </h3>

                    <div class="card-tools">
                        {{--@if($notifications)--}}
                            {{--{!! $notifications->render() !!}--}}
                        {{--@endif--}}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>Тип</td>
                            <td>Событие</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notifications as $notify)
                            <tr>
                                <td>{{$notify->connection}} {{$notify->queue}} {{$notify->failed_at}}</td>
                                <td>
                                    <pre style="text-align: left;">@if(isset($notify->payload))<u>Payload</u>: <b>{{ $notify->payload }}</b> @endif @if(isset($notify->exception))
<br><u>Exception</u>: <b>{{ $notify->exception }}</b> @endif </pre>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                <a href="{{ route('failed_jobs_destroy') }}" class="btn btn-danger btn-sm" type="submit">Удалить все дефекты</a>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

@endsection
