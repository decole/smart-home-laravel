@extends('container.template')
@section('title', 'Все данные')

@section('footer-scripts')
    @parent
    <script src="{{ asset("js/relay_v1.js") }}"></script>
    <script src="{{ asset("js/sensor.js") }}"></script>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 col-xs-12 connectedSortable">
            @foreach($relays as $swift)
                @include('snippet.relay_v1', ['swift', $swift])
            @endforeach
        </section>
        <!-- /.Left col -->
        <!-- Right col -->
        <section class="col-lg-6 col-xs-12 connectedSortable">
            @foreach($sensors as $sensor)
                @include('snippet.sensor', ['sensor', $sensor])
            @endforeach
        </section>
    </div>

@endsection
