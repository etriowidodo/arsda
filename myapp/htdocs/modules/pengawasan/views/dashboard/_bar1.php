<?php
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\web\View;
?>

<div class="col-md-12">
          <div class="form-group">
<div class="col-md-8">
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$kejaksaan = array();
$total_proses = array();
$total_selesai = array();
$total_terbukti = array();
$total_tdkterbukti = array();
$total_sblmblnini = array();
$totalblnini = array();
$jmlsampaiblnini = array();
$i=0;



foreach ($model as $datamodel) {
     array_push($kejaksaan, $datamodel['inst_nama']);
     array_push($total_proses, $datamodel['total_proses']);
     array_push($total_selesai, $datamodel['total_selesai']);
     array_push($total_terbukti, $datamodel['total_terbukti']);
     array_push($total_tdkterbukti, $datamodel['total_tdkterbukti']);
     array_push($total_sblmblnini, $datamodel['total_sblmblnini']);
     array_push($totalblnini, $datamodel['total_blnini']);
     array_push($jmlsampaiblnini, $datamodel['jml_smpai_blninni']);
    /* if($i == 5){
         break;
     }*/
    $i++;
}
echo ChartJs::widget([
    'type' => 'Bar',
    'options' => [
        'height' => 800,
        'width' => 800,
        'id'=>'lwas5_all',
       
    ],
    'data' => [
    'labels'=> $kejaksaan,
    
    'datasets'=> [
        
         [
            'label'=> "Total Proses",
            'fillColor'=> "rgba(341,84,51,0.5)",
            'strokeColor'=> "rgba(341,84,51,0.8)",
            'highlightFill'=> "rgba(341,84,51,0.75)",
            'highlightStroke'=> "rgba(341,84,51,1)",
            'data'=> $total_proses
             
        ],
         [
            'label'=> "Total Selesai",
            'fillColor'=> "rgba(14,69,57,0.5)",
            'strokeColor'=> "rgba(14,69,57,0.8)",
            'highlightFill'=> "rgba(14,69,57,0.75)",
            'highlightStroke'=> "rgba(14,69,57,1)",
            'data'=> $total_selesai
             
        ],
        
        [
            'label'=> "Total Terbukti",
            'fillColor'=> "rgba(300,69,54,0.5)",
            'strokeColor'=> "rgba(300,69,54,0.8)",
            'highlightFill'=> "rgba(300,69,54,0.75)",
            'highlightStroke'=> "rgba(300,69,54,1)",
            'data'=> $total_terbukti
             
        ],
        
         [
            'label'=> "Total tidak Terbukti",
            'fillColor'=> "rgba(54,86,65,0.5)",
            'strokeColor'=> "rgba(54,86,65,0.8)",
            'highlightFill'=> "rgba(54,86,65,0.75)",
            'highlightStroke'=> "rgba(54,86,65,1)",
            'data'=> $total_tdkterbukti
             
        ],
        
         [
            'label'=> "Total Sebelum Bulan Ini",
            'fillColor'=> "rgba(93,84,57,0.5)",
            'strokeColor'=> "rgba(93,84,57,0.8)",
            'highlightFill'=> "rgba(93,84,57,0.75)",
            'highlightStroke'=> "rgba(93,84,57,1)",
            'data'=> $total_sblmblnini
            
        ],
        [
            'label'=> "Total Bulan Ini",
            'fillColor'=> "rgba(0,0,0,0.5)",
            'strokeColor'=> "rgba(0,0,0,0.8)",
            'highlightFill'=> "rgba(0,0,0,0.75)",
            'highlightStroke'=> "rgba(0,0,0,1)",
            'data'=> $totalblnini
           
        ],
        [
            'label'=> "Jumlah sampai Bulan ini",
            'fillColor'=> "rgba(151,187,05,0.5)",
            'strokeColor'=> "rgba(151,187,05,0.8)",
            'highlightFill'=> "rgba(151,187,05,0.75)",
            'highlightStroke'=> "rgba(151,187,05,1)",
            'data'=> $jmlsampaiblnini
     
        ]
    ]
    
]]);

?>

</div><div class="col-md-4"><div id="legendchart_lwas5_all" class="chart-legend"></div>
</div>
          </div>
    
</div>

 

