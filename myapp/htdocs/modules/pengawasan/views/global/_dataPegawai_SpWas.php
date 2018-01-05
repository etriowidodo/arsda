
    
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
    $from_table=$param;                        
    // $searchModel = new \app\models\KpPegawaiSearch();
    $searchModel = new \app\modules\pengawasan\models\SpWas1Search();
    $dataProvider = $searchModel->searchPenandatangan(Yii::$app->request->queryParams,$from_table);
	$dataProvider->pagination->pageSize = 6;
?>
       <?= GridView::widget([
            'id'=>'jpu-grid',
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                'nip',
                'nama_penandatangan',
                'jabatan',
                 [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                            return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary','onclick'=>'$("#'.$param.'-nama_penandatangan_'.$param.'").val("'.$model['nama_penandatangan'].'");$("#'.$param.'-nip_penandatangan_'.$param.'").val("'.(empty($model['nip']) ? $model['nip']:$model['nip']) .'");$("#'.$param.'-jabatan_penandatangan_'.$param.'").val("'.$model['jabatan'].'");$("#peg_tandatangan").modal("hide");']);
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