@extends('container.template')
@section('title', 'Сообщения')

@section('footer-scripts')
    @parent
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">

        <!-- Left col -->
        <section class="col-lg-6 col-xs-12 connectedSortable">
            messages
        </section>
        <!-- /.Left col -->

    </div>

@endsection
