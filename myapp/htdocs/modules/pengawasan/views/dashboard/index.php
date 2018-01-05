<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\web\View;
use yii\helpers\Url;

$this->title = 'DASHBOARD';
?>
<script>
    var url1 = '<?php echo Url::toRoute('dashboard/view'); ?>';

</script>
<?php
$this->registerJs("
    $(document).ready(function(){
      $('#lihat_semua').click(function(e){
        e.preventDefault();  
       $.ajax(
        {
            type: 'POST',
            url: url1,
            data: 'type='+$(this).val(),
            dataType : 'json',
            cache: false,
            success: function(data)
            {
            $('#p_lwas5').modal('show'); 
             $('#popup_lwas5').html(data.view_pemberitahuan);
         
            }
        });

      });
      
$('#p_test').on('shown.bs.modal', function (event) {
   $.ajax(
        {
            type: 'POST',
            url: url1,
            data: 'type='+$(this).val(),
            dataType : 'json',
            cache: false,
            success: function(data)
            { 
    var button = $(event.relatedTarget);
    var modal = $(this);
    var canvas = modal.find('.modal-body canvas');

   
    var ctx = document.getElementById('heightChart').getContext('2d');
    var chart = new Chart(ctx).HorizontalBar({
        labels: data.kejaksaan,
        datasets: [
            {
                label: 'Total Proses',
                fillColor: 'rgba(341,84,51,0.5)',
                strokeColor: 'rgba(341,84,51,0.8)',
                highlightFill: 'rgba(341,84,51,0.75)',
                highlightStroke: 'rgba(341,84,51,1)',
                data: data.total_proses
            },
            {
                label: 'Total Selesai',
                fillColor: 'rgba(14,69,57,0.5)',
                strokeColor: 'rgba(14,69,57,0.8)',
                highlightFill: 'rgba(14,69,57,0.75)',
                highlightStroke: 'rgba(14,69,57,1)',
                data: data.total_selesai
            },
            {
                label: 'Total Terbukti',
                fillColor: 'rgba(300,69,54,0.5)',
                strokeColor: 'rgba(300,69,54,0.8)',
                highlightFill: 'rgba(300,69,54,0.75)',
                highlightStroke: 'rgba(300,69,54,1)',
                data: data.total_terbukti
            },
            {
                label: 'Total tidak Terbukti',
                fillColor: 'rgba(54,86,65,0.5)',
                strokeColor: 'rgba(54,86,65,0.8)',
                highlightFill: 'rgba(54,86,65,0.75)',
                highlightStroke: 'rgba(54,86,65,1)',
                data: data.total_tdkterbukti
            },
            {
                label: 'Total Sebelum Bulan Ini',
                fillColor: 'rgba(93,84,57,0.5)',
                strokeColor: 'rgba(93,84,57,0.8)',
                highlightFill: 'rgba(93,84,57,0.75)',
                highlightStroke: 'rgba(93,84,57,1)',
                data: data.total_sblmblnini
            },
            {
                label: 'Total Bulan Ini',
                fillColor: 'rgba(0,0,0,0.5)',
                strokeColor: 'rgba(0,0,0,0.8)',
                highlightFill: 'rgba(0,0,0,0.75)',
                highlightStroke: 'rgba(0,0,0,1)',
                data: data.totalblnini
            },
            {
                label: 'Jumlah sampai Bulan ini',
                fillColor: 'rgba(151,187,05,0.5)',
                strokeColor: 'rgba(151,187,05,0.8)',
                highlightFill: 'rgba(151,187,05,0.75)',
                highlightStroke: 'rgba(151,187,05,1)',
                data: data.jmlsampaiblnini
            },
        ]
    }, { tooltipEvents: ['mousemove', 'touchstart', 'touchmove', 'mouseout'],showTooltips: true,responsive: true});
    document.getElementById('legendchart_lwas5_all').innerHTML = chart.generateLegend();
      }
        });
});

/*$('#p_test').on('shown.bs.modal', function (event) {
    

    var button = $(event.relatedTarget);
    var modal = $(this);
    var canvas = modal.find('.modal-body canvas');

   
    var ctx = document.getElementById('heightChart').getContext('2d');
    var chart = new Chart(ctx).Line({
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                fillColor: 'rgba(190,144,212,0.2)',
                strokeColor: 'rgba(190,144,212,1)',
                pointColor: 'rgba(190,144,212,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
                fillColor: 'rgba(151,187,205,0.2)',
                strokeColor: 'rgba(151,187,205,1)',
                pointColor: 'rgba(151,187,205,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(151,187,205,1)',
                data: [65, 59, 80, 81, 56, 55, 40]
            }
        ]
    }, {});
});
      
*/

}); ", \yii\web\View::POS_END);
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <div class="box box-primary" style="border: none;">
            <div class="box-header with-border" style="background-color: #73a8de;text-align:center;color: #fff;box-shadow: 0 0 11px 0 rgba(0, 0, 0, 0.29) inset;">

                L.WAS-5
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <div class="col-md-6">
                    <?php
                    $kejaksaan = array();
                    $total_proses = array();
                    $total_selesai = array();
                    $total_terbukti = array();
                    $total_tdkterbukti = array();
                    $total_sblmblnini = array();
                    $totalblnini = array();
                    $jmlsampaiblnini = array();
                    $total1 = 0;
                    $total2 = 0;
                    $i = 0;
                    $j = 0;



                    foreach ($model as $datamodel) {
                        array_push($kejaksaan, $datamodel['inst_nama']);
                        array_push($total_proses, $datamodel['total_proses']);
                        array_push($total_selesai, $datamodel['total_selesai']);
                        array_push($total_terbukti, $datamodel['total_terbukti']);
                        array_push($total_tdkterbukti, $datamodel['total_tdkterbukti']);
                        array_push($total_sblmblnini, $datamodel['total_sblmblnini']);
                        array_push($totalblnini, $datamodel['total_blnini']);
                        array_push($jmlsampaiblnini, $datamodel['jml_smpai_blninni']);
                        $total1 = $datamodel['total_sblmblnini'];
                        $total2 = $datamodel['total_blnini'];
                        /* if($i == 5){
                          break;
                          } */
                        $i++;
                    }



                    echo ChartJs::widget([
                        'type' => 'Bar',
                        'options' => [
                            'height' => 600,
                            'width' => 600,
                            'id' => 'lwas5',
                        ],
                        'data' => [
                            'labels' => $kejaksaan,
                            'datasets' => [

                                [
                                    'label' => "Total Proses",
                                    'fillColor' => "rgba(341,84,51,0.5)",
                                    'strokeColor' => "rgba(341,84,51,0.8)",
                                    'highlightFill' => "rgba(341,84,51,0.75)",
                                    'highlightStroke' => "rgba(341,84,51,1)",
                                    'data' => $total_proses
                                //   'data'=> [1]
                                ],
                                [
                                    'label' => "Total Selesai",
                                    'fillColor' => "rgba(124,69,57,0.5)",
                                    'strokeColor' => "rgba(124,69,57,0.8)",
                                    'highlightFill' => "rgba(124,69,57,0.75)",
                                    'highlightStroke' => "rgba(124,69,57,1)",
                                    'data' => $total_selesai
                                //     'data'=> [2]
                                ],
                                [
                                    'label' => "Total Terbukti",
                                    'fillColor' => "rgba(300,69,54,0.5)",
                                    'strokeColor' => "rgba(300,69,54,0.8)",
                                    'highlightFill' => "rgba(300,69,54,0.75)",
                                    'highlightStroke' => "rgba(300,69,54,1)",
                                    'data' => $total_terbukti
                                //   'data'=> [3]
                                ],
                                [
                                    'label' => "Total tidak Terbukti",
                                    'fillColor' => "rgba(54,86,65,0.5)",
                                    'strokeColor' => "rgba(54,86,65,0.8)",
                                    'highlightFill' => "rgba(54,86,65,0.75)",
                                    'highlightStroke' => "rgba(54,86,65,1)",
                                    'data' => $total_tdkterbukti
                                //  'data'=> [4]
                                ],
                            ]
                    ]]);
                    ?>
                </div>
                <div class="col-md-3">
                    <div id="legendchart_lwas5" class="chart-legend"></div>
                </div>
                <div class="col-md-3">

                    <?php
                    echo ChartJs::widget([
                        'type' => 'Pie',
                        'options' => [
                            'height' => 200,
                            'width' => 200,
                            'id' => 'lwas5pie',
                        ],
                        'data' => [
                            //    'labels' => $kejaksaan,


                            [
                                // 'value'=> 50,
                                'color' => "#46BFBD",
                                'highlight' => "#5AD3D1",
                                'label' => "Total Sebelum Bulan ini",
                                'value' => $total1
                            //   'data'=> [1]
                            ],
                            [
                                //   'value'=> 100,
                                'color' => "#FDB45C",
                                'highlight' => "#FFC870",
                                'label' => "Total Bulan ini",
                                'value' => $total2
                            //     'data'=> [2]
                            ],
                    ]]);
                    ?>
                    <div id="legendchart_lwas5pie" class="chart-legend"></div>

                </div>
            </div>


            <div class="col-md-12">
                <hr style="border-color: #c7c7c7;margin: 10px 0;">
                <div style="margin-bottom: 12px;padding:0px;background:none;" class="box-footer">

                    <button type="button" id="exampleModal" class="btn btn-primary" data-toggle="modal" data-target="#p_test">Lihat semua</button>
                </div>
            </div>
        </div>
        <div class="box box-primary" style="border: none;margin-bottom: 0px;">
            <div class="box-header with-border" style="background-color: #73a8de;text-align:center;color: #fff;box-shadow: 0 0 11px 0 rgba(0, 0, 0, 0.29) inset;">

                L.WAS-6
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <div class="col-md-8">
                    <?php
                    $kejaksaan2 = array();
                    $ringan_tu = array();
                    $ringan_jaksa = array();
                    $sedang_tu = array();
                    $sedang_jaksa = array();
                    $berat_tu = array();
                    $berat_jaksa = array();





                    foreach ($model2 as $datamodel) {
                        array_push($kejaksaan2, $datamodel['inst_nama']);
                        array_push($ringan_tu, $datamodel['ringan_tu']);
                        array_push($ringan_jaksa, $datamodel['ringan_jaksa']);
                        array_push($sedang_tu, $datamodel['sedang_tu']);
                        array_push($sedang_jaksa, $datamodel['sedang_jaksa']);
                        array_push($berat_tu, $datamodel['berat_tu']);
                        array_push($berat_jaksa, $datamodel['berat_jaksa']);

                        /* if($i == 5){
                          break;
                          } */
                        $j++;
                    }



                    echo ChartJs::widget([
                        'type' => 'Bar',
                        'options' => [
                            'id' => 'lwas6',
                            'height' => 600,
                            'width' => 600,
                        ],
                        'data' => [
                            'labels' => $kejaksaan2,
                            'datasets' => [

                                [
                                    'label' => "Ringan TU",
                                    'fillColor' => "rgba(341,84,51,0.5)",
                                    'strokeColor' => "rgba(341,84,51,0.8)",
                                    'highlightFill' => "rgba(341,84,51,0.75)",
                                    'highlightStroke' => "rgba(341,84,51,1)",
                                    'data' => $ringan_tu
                                ],
                                [
                                    'label' => "Ringan Jaksa",
                                    'fillColor' => "rgba(124,69,57,0.5)",
                                    'strokeColor' => "rgba(124,69,57,0.8)",
                                    'highlightFill' => "rgba(124,69,57,0.75)",
                                    'highlightStroke' => "rgba(124,69,57,1)",
                                    'data' => $ringan_jaksa
                                //  'data'=> [2]
                                ],
                                [
                                    'label' => "Sedang TU",
                                    'fillColor' => "rgba(300,69,54,0.5)",
                                    'strokeColor' => "rgba(300,69,54,0.8)",
                                    'highlightFill' => "rgba(300,69,54,0.75)",
                                    'highlightStroke' => "rgba(300,69,54,1)",
                                    'data' => $sedang_tu
                                //   'data'=> [3]
                                ],
                                [
                                    'label' => "Sedang Jaksa",
                                    'fillColor' => "rgba(54,86,65,0.5)",
                                    'strokeColor' => "rgba(54,86,65,0.8)",
                                    'highlightFill' => "rgba(54,86,65,0.75)",
                                    'highlightStroke' => "rgba(54,86,65,1)",
                                    'data' => $sedang_jaksa
                                //   'data'=> [4]
                                ],
                                [
                                    'label' => "Berat TU",
                                    'fillColor' => "rgba(93,84,257,0.5)",
                                    'strokeColor' => "rgba(93,84,257,0.8)",
                                    'highlightFill' => "rgba(93,84,257,0.75)",
                                    'highlightStroke' => "rgba(93,84,257,1)",
                                    'data' => $berat_tu
                                //   'data'=> [5]
                                ],
                                [
                                    'label' => "Berat Jaksa",
                                    'fillColor' => "rgba(220,220,220,0.5)",
                                    'strokeColor' => "rgba(220,220,220,0.8)",
                                    'highlightFill' => "rgba(220,220,220,0.75)",
                                    'highlightStroke' => "rgba(220,220,220,1)",
                                    'data' => $berat_jaksa
                                //  'data'=> [6]
                                ],
                            ]
                    ]]);
                    ?></div><div class="col-md-4"><div id="legendchart_lwas6" class="chart-legend"></div>
                </div>
            </div>

            <div class="col-md-12">
                <hr style="border-color: #c7c7c7;margin: 10px 0;">
                <div style="margin-bottom: 12px;padding:0px;background:none;" class="box-footer">

                    <button type="button" id="exampleModal" class="btn btn-primary" data-toggle="modal" data-target="#p_test">Lihat semua</button>
                </div>
            </div>

        </div>
    </div>
</section>




<?php
Modal::begin([
    'id' => 'p_lwas5',
    'size' => 'modal-lg',
    'header' => 'Lihat Semua Laporan',
]);
?>
<div class="canvas-holder">
    <canvas id="heightChart2" class="chart"></canvas>
</div>
<div id="popup_lwas5"></div>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'id' => 'p_test',
    'size' => 'modal-lg',
    'header' => 'Lihat Semua Laporan',
]);
?>
<div style="padding: 15px 0px;" class="box box-primary">
    <div class="canvas-holder" style="margin: 0px 10px;">
        <canvas id="heightChart" class="chart"></canvas>
        <div id="legendchart_lwas5_all" class="chart-legend">
        </div>
        <?php Modal::end(); ?>
    </div>
</div>



