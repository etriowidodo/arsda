
    
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php
/*
$this->registerJs( "
    $(document).ready(function(){
         
          $('#buttonTT').click(function(){
           var keys = $('#gridPegawaiTT').yiiGridView('getSelectedRows');

      });
}); ", \yii\web\View::POS_END);*/

?>


<?php 
                        
    // $searchModel = new \app\models\KpPegawaiSearch();
	$from_tabel = $param;
    $searchModel = new \app\modules\pengawasan\models\PegawaiSearch();
    $dataProvider = $searchModel->searchPenandaTanganspwas1(Yii::$app->request->queryParams,$from_tabel);

?>
       <?= GridView::widget([
            'id'=>'spwas1-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'Nama penandatangan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nama_penandatangan',    
                ],

                
                ['label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan_penandatangan',
                ],

                ['label'=>'Jabatan Alias',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan',
                ],   
                
                 [  'header'=>'Action',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                            return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary','onclick'=>'$("#'.$param.'-nip_penandatangan").val("'.$model['nip'].'");$("#'.$param.'-nama_penandatangan").val("'.$model['nama_penandatangan'].'");$("#'.$param.'-golongan_penandatangan").val("'.$model['golongan'].'");$("#'.$param.'-jabatan_penandatangan").val("'.$model['jabatan'].'");$("#'.$param.'-pangkat_penandatangan").val("'.$model['pangkat'].'");$("#'.$param.'-jbtn_penandatangan").val("'.$model['jabatan_penandatangan'].'");$("#'.$param.'-status_penandatangan").val("'.$model['id_jabatan'].'");$("#peg_tandatangan").modal("hide");$("#peg_tandatanganeks").modal("hide");']);
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