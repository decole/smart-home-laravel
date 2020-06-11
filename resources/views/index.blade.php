@extends('container.template')
@section('title', 'Начальная')

@section('footer-scripts')
    @parent
    <script>
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'bottom',
        });
    </script>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <section class="">
            <div class="info-box">
                <div class="info-box-content sobies">
                    <img src="{{ asset('images/home.svg') }}" alt="home picture">
                </div>
                <div class="server">
                    <i class="fas fa-server" data-toggle="tooltip" title="сервернвя стойка с сервером"></i>
                </div>

                <div class="water">
                    <i class="water0 fas fa-caret-square-up" data-toggle="tooltip" title="клапан главный"></i>
                    <i class="water1 fas fa-caret-square-up" data-toggle="tooltip" title="клапан 1"></i>
                    <i class="water2 fas fa-caret-square-up" data-toggle="tooltip" title="клапан 2"></i>
                    <i class="water3 fas fa-caret-square-up" data-toggle="tooltip" title="клапан 3"></i>
                </div>

                <i class="fire fire1 fas fa-bullseye" data-toggle="tooltip" title="пожарная система"></i>
                <i class="fire fire2 fas fa-bullseye" data-toggle="tooltip" title="пожарная система"></i>

                <i class="temper temper1 fas fa-thermometer-half">12</i>
                <i class="temper temper2 fas fa-thermometer-half">12</i>
                <i class="temper temper3 fas fa-thermometer-half">12</i>
                <i class="temper temper4 fas fa-thermometer-half">12</i>
                <i class="temper temper5 fas fa-thermometer-half">12</i>

                <i class="move move1 fas fa-street-view" data-toggle="tooltip" title="датчик движения"></i>
                <i class="move move2 fas fa-street-view" data-toggle="tooltip" title="датчик движения"></i>
            </div>
        </section>
    </div>
<style>
    .sobies {  position: relative; }
    .server, .water, .fire, .temper, .move { position: absolute; color: #352d2d; }
    .server {  top: 95px;  left: 145px; }
    .water {   top: -7px;  left: 100px; }
    .fire1 {   top: 75px;  left: 145px; }
    .fire2 {   top: 200px; left: 415px; }
    .temper1 { top: 180px; left: 418px; }
    .temper2 { top: 180px; left: 227px; }
    .temper3 { top: 245px; left: 238px; }
    .temper4 { top: 75px;  left: 210px; }
    .temper5 { top: 100px; left: 112px; }
    .move1 {   top: 76px;  left: 237px; }
    .move2 {   top: 125px; left: 295px; }
</style>
@endsection
