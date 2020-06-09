@extends('container.template')
@section('title', 'Начальная')

@section('footer-scripts')
    @parent
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
    <div class="row">
        <!-- Left col -->
        <section class="">
            <div class="info-box">
                <div class="info-box-content sobies">
                    <img src="{{ asset('images/home.svg') }}" alt="home picture">
                </div>
                <!-- /.info-box-content -->
                <div class="server">
                    <i class="fas fa-server"></i>
                </div>
            </div>
            <!-- /.info-box -->
        </section>
        <!-- /.Left col -->
    </div>
<style>
    .sobies {
        position: relative;
    }
    .server{
        position: absolute;
        top: 200px;
        left: 300px;
    }
</style>
@endsection
