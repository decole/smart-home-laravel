<!-- AREA CHART -->
<div class="card area-chart" data-topic="{{ $topic }}">
    <div class="card-header">
        <h3 class="card-title">Area Chart</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <ul class="pagination chart-pagination pagination-sm m-0 ">
            <li class="page-item" aria-label="pagination.previous">
                <a class="page-link chart-pagination-previous" href="#" rel="previous">‹</a>
            </li>
            <li class="page-item">
                <span class="page-link chart-date-marker"><?php echo date('d-m-Y')?></span>
            </li>
            <li class="page-item">
                <a class="page-link chart-pagination-next" href="#" rel="next">›</a>
            </li>
        </ul>
    </div>
</div>
<!-- /.card -->
