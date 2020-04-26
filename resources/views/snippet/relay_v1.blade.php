<div class="col-md-6 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="far fa-hdd"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">{{ $swift->name }}</span>
            <div class="btn-group relay-control" data-swift-topic="{{ $swift->topic }}" data-swift-topic-check="{{ $swift->check_topic }}" data-swift-id="{{ $swift->id }}" data-swift-on="{{ $swift->check_command_on }}" data-swift-off="{{ $swift->check_command_off }}">
                <button type="button" class="btn btn-outline-success" data-swift-topic="{{ $swift->topic }}" data-swift-check="{{ $swift->check_command_on }}" value="{{ $swift->command_on }}">On</button>
                <button type="button" class="btn btn-outline-danger" data-swift-topic="{{ $swift->topic }}" data-swift-check="{{ $swift->check_command_off }}" value="{{ $swift->command_off }}">Off</button>
            </div>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
