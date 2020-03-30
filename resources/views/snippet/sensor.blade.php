<div class="col-md-6 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fas fa-microchip"></i></span>

        <div class="info-box-content sensor-control" data-sensor-topic="{{ $sensor->topic }}" data-sensor-id="{{ $sensor->id }}">
            <span class="info-box-text">{{ $sensor->name }}</span>
            <span class="info-box-number"><span data-sensor-value="{{ $sensor->topic }}"></span>
{{--                  <span>{{ $sensor_format }}</span>--}}
              </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
