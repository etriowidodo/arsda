<?php
/**
 * Created by PhpStorm.
 * User: rio
 * Date: 13/11/15
 * Time: 11:02
 */
use dosamigos\chartjs\ChartJs;

?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Monthly Recap Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>

                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                    $data = json_decode($json, true);
                ?>
                <?=
                ChartJs::widget([
                    'type' => 'Bar',
                    'options' => [
                        'height' => 400,
                        'width' => 1000,
                    ],
                    'data' => [
                        'labels' => ["Total - Selesai SPDP", "Total - Selesai Tuntutan", "Total - Selesai Eksekusi"],
                        'datasets' => [
                            [
                                'fillColor' => "rgba(2,20,220,0.8)",
                                'strokeColor' => "rgba(220,220,220,1)",
                                'pointColor' => "rgba(220,220,220,1)",
                                'pointStrokeColor' => "#fff",
                                'data' => $data[0]
                            ],
                            [
                                'fillColor' => "rgba(14,235,73,0.8)",
                                'strokeColor' => "rgba(220,220,220,1)",
                                'pointColor' => "rgba(220,220,220,1)",
                                'pointStrokeColor' => "#fff",
                                'data' => $data[1]
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
            <!-- ./box-body -->
            <div class="box-footer">

            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">SPDP</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>

                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                    $spdp = json_decode($jsonSpdp, true);

                    $label = [];
                    $data1 = [];
                    $data2 = [];
                    foreach ($spdp['data'] as $key => $value) {
                        $label[] = $value['label'];
                        $data1[] = $value['data'][0];
                        $data2[] = $value['data'][1];
                    }

                ?>
                <?=
                ChartJs::widget([
                    'type' => 'Line',
                    'options' => [
                        'height' => 400,
                        'width' => 1000,
                    ],
                    'data' => [
                        'labels' => $label,
                        'datasets' => [
                            [
                                'label'=> "data1",
                                'fillColor'=> "rgba(220,220,220,0.2)",
                                'strokeColor'=> "rgba(220,220,220,1)",
                                'pointColor'=> "rgba(220,220,220,1)",
                                'pointStrokeColor'=> "#fff",
                                'pointHighlightFill'=> "#fff",
                                'pointHighlightStroke'=> "rgba(220,220,220,1)",
                                'data' => $data1
                            ],
                            [
                                'label'=> "data2",
                                'fillColor'=> "rgba(151,187,205,0.2)",
                                'strokeColor'=> "rgba(151,187,205,1)",
                                'pointColor'=> "rgba(151,187,205,1)",
                                'pointStrokeColor'=> "#fff",
                                'pointHighlightFill'=> "#fff",
                                'pointHighlightStroke'=> "rgba(151,187,205,1)",
                                'data' => $data2
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>
            <!-- ./box-body -->
            <div class="box-footer">

            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Tuntutan</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>

                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                    $tuntutan = json_decode($jsonTuntutan, true);

                    $label = [];
                    $data1 = [];
                    $data2 = [];
                    foreach ($tuntutan['data'] as $key => $value) {
                        $label[] = $value['label'];
                        $data1[] = $value['data'][0];
                        $data2[] = $value['data'][1];
                    }

                ?>
                <?=
                ChartJs::widget([
                    'type' => 'Line',
                    'options' => [
                        'height' => 400,
                        'width' => 1000,
                    ],
                    'data' => [
                        'labels' => $label,
                        'datasets' => [
                            [
                                'label'=> "data1",
                                'fillColor'=> "rgba(220,220,220,0.2)",
                                'strokeColor'=> "rgba(220,220,220,1)",
                                'pointColor'=> "rgba(220,220,220,1)",
                                'pointStrokeColor'=> "#fff",
                                'pointHighlightFill'=> "#fff",
                                'pointHighlightStroke'=> "rgba(220,220,220,1)",
                                'data' => $data1
                            ],
                            [
                                'label'=> "data2",
                                'fillColor'=> "rgba(151,187,205,0.2)",
                                'strokeColor'=> "rgba(151,187,205,1)",
                                'pointColor'=> "rgba(151,187,205,1)",
                                'pointStrokeColor'=> "#fff",
                                'pointHighlightFill'=> "#fff",
                                'pointHighlightStroke'=> "rgba(151,187,205,1)",
                                'data' => $data2
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>
            <!-- ./box-body -->
            <div class="box-footer">

            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Eksekusi</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>

                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                    $eksekusi = json_decode($jsonEksekusi, true);

                    $label = [];
                    $data1 = [];
                    $data2 = [];
                    foreach ($eksekusi['data'] as $key => $value) {
                        $label[] = $value['label'];
                        $data1[] = $value['data'][0];
                        $data2[] = $value['data'][1];
                    }

                ?>
                <?=
                ChartJs::widget([
                    'type' => 'Line',
                    'options' => [
                        'height' => 400,
                        'width' => 1000,
                    ],
                    'data' => [
                        'labels' => $label,
                        'datasets' => [
                            [
                                'label'=> "data1",
                                'fillColor'=> "rgba(220,220,220,0.2)",
                                'strokeColor'=> "rgba(220,220,220,1)",
                                'pointColor'=> "rgba(220,220,220,1)",
                                'pointStrokeColor'=> "#fff",
                                'pointHighlightFill'=> "#fff",
                                'pointHighlightStroke'=> "rgba(220,220,220,1)",
                                'data' => $data1
                            ],
                            [
                                'label'=> "data2",
                                'fillColor'=> "rgba(151,187,205,0.2)",
                                'strokeColor'=> "rgba(151,187,205,1)",
                                'pointColor'=> "rgba(151,187,205,1)",
                                'pointStrokeColor'=> "#fff",
                                'pointHighlightFill'=> "#fff",
                                'pointHighlightStroke'=> "rgba(151,187,205,1)",
                                'data' => $data2
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>
            <!-- ./box-body -->
            <div class="box-footer">

            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
