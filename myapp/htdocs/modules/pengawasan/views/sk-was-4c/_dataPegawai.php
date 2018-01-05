
    
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
function pilihPegawaiTT(){
    
    var keys = $('#gridPegawaiTT').yiiGridView('getSelectedRows');
    alert('test'+keys);
}
</script>
<?php

$this->registerJs( "
    $(document).ready(function(){
         
          $('#buttonTT').click(function(){
           var keys = $('#gridPegawaiTT').yiiGridView('getSelectedRows');
    alert('test'+keys);
      });
}); ", \yii\web\View::POS_END);

?>
<?php
    $searchModel = new \app\models\KpPegawaiSearch();
    $dataProvider = $searchModel->searchPegawai(Yii::$app->request->queryParams);
?>
       <?= GridView::widget([
            'id'=>'jpu-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                'peg_nip',
                'peg_nip_baru',
                'peg_nama',
                            
                'jabat_tmt',
              //  'jabat_tmt',
                'jabatan',
                 [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) {
                            return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary','onclick'=>'
																						$("#skwas4c-ttd_peg_nama").val("'.$model['peg_nama'].'");
																						$("#skwas4c-ttd_peg_nip").val("'.(empty($model['peg_nip_baru']) ? $model['peg_nip']:$model['peg_nip_baru']) .'");
																						$("#skwas4c-ttd_peg_pangkat").val("'.$model['gol_pangkat'].'");
																						$("#skwas4c-ttd_peg_jabatan").val("'.$model['jabatan'].'");
																						$("#skwas4c-ttd_peg_nik").val("'.$model['peg_nik'].'");
																						$("#skwas4c-ttd_id_jabatan").val("'.$model['id'].'");
																						$("#penandatangan").modal("hide");']);
                        },
                    ]
                ],
               
            ],
            'export' => false,
            'pjax' => true,
            'responsive'=>true,
            'hover'=>true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
            ],

            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                ],
                'neverTimeout'=>true,
              //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]

        ]); ?>