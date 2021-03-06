<div class="col-md-6 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="far fa-hdd"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">{{ $swift->name }}</span>
            <div class="btn-group relay-control" data-swift-topic="{{ $swift->topic }}" data-swift-topic-check="{{ $swift->check_topic }}" data-swift-id="{{ $swift->id }}" data-swift-on="{{ $swift->check_command_on }}" data-swift-off="{{ $swift->check_command_off }}">
                <button type="button" class="btn btn-success" value="on">On</button>
                <button type="button" class="btn btn-danger" value="off">Off</button>
            </div>
            <span class="info-box-text">status: <span data-swift-value="{{ $swift->topic }}"></span></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
