@extends('container.template')
@section('title', 'Настройки пользователя')

@section('footer-scripts')
    @parent
    <script src="{{ asset("js/relay_v1.js") }}"></script>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">

        <!-- Left col -->
        <section class="col-lg-6 col-xs-12 connectedSortable ui-sortable">
            @include('snippet.relay_v1', ['swift' => $relays])
        </section>
        <!-- /.Left col -->

    </div>

@endsection
