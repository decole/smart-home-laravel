@extends('container.template')


@section('title', 'Настройки пользователя')


@section('head')
    @parent

@endsection


@section('footer-scripts')
    @parent

    <!-- FastClick -->
    <script src="{{ asset("bower_components/fastclick/lib/fastclick.js") }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") }}"></script>
    <script type="text/javascript">
        $('#some-textarea').wysihtml5({
            toolbar: {
                "link": false,
                "image": false,
                "blockquote": false,
                "lists": false,
            }

        });
    </script>
@endsection

@section('content')
    <div class="col-md-4">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Настройки почтовых уведомлений</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="box-body p-2">
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Accaunt</label>
                                <input type="text" name="acaunt" class="form-control" id="exampleInputEmail1" placeholder="accaunt">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">ФИО</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="ФИО">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="email">
                            </div>
                            <div class="form-group">
                                <label>TimeZone</label>
                                <select class="form-control">
                                    <option value="+12:00">+12:00</option>
                                    <option value="+11:30">+11:30</option>
                                    <option value="+11:00">+11:00</option>
                                    <option value="+10:30">+10:30</option>
                                    <option value="+10:00">+10:00</option>
                                    <option value="+09:30">+09:30</option>
                                    <option value="+09:00">+09:00</option>
                                    <option value="+08:30">+08:30</option>
                                    <option value="+08:00">+08:00</option>
                                    <option value="+07:30">+07:30</option>
                                    <option value="+07:00">+07:00</option>
                                    <option value="+06:30">+06:30</option>
                                    <option value="+06:00">+06:00</option>
                                    <option value="+05:30">+05:30</option>
                                    <option value="+05:00">+05:00</option>
                                    <option value="+04:30">+04:30</option>
                                    <option value="+04:00" selected>+04:00</option>
                                    <option value="+03:30">+03:30</option>
                                    <option value="+03:00">+03:00</option>
                                    <option value="+02:30">+02:30</option>
                                    <option value="+02:00">+02:00</option>
                                    <option value="+01:30">+01:30</option>
                                    <option value="+01:00">+01:00</option>
                                    <option value="+00:30">+00:30</option>
                                    <option value=" 00:00"> 00:00</option>
                                    <option value="-00:00">-00:00</option>
                                    <option value="-00:30">-00:30</option>
                                    <option value="-01:00">-01:00</option>
                                    <option value="-01:30">-01:30</option>
                                    <option value="-02:00">-02:00</option>
                                    <option value="-02:30">-02:30</option>
                                    <option value="-03:00">-03:00</option>
                                    <option value="-03:30">-03:30</option>
                                    <option value="-04:00">-04:00</option>
                                    <option value="-04:30">-04:30</option>
                                    <option value="-05:00">-05:00</option>
                                    <option value="-05:30">-05:30</option>
                                    <option value="-06:00">-06:00</option>
                                    <option value="-06:30">-06:30</option>
                                    <option value="-07:00">-07:00</option>
                                    <option value="-07:30">-07:30</option>
                                    <option value="-08:00">-08:00</option>
                                    <option value="-08:30">-08:30</option>
                                    <option value="-09:00">-09:00</option>
                                    <option value="-09:30">-09:30</option>
                                    <option value="-10:00">-10:00</option>
                                    <option value="-10:30">-10:30</option>
                                    <option value="-11:00">-11:00</option>
                                    <option value="-11:30">-11:30</option>
                                    <option value="-12:00">-12:00</option>
                                </select>
                            </div>


                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Check me out
                                </label>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
@endsection