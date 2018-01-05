
    
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
                        
    $searchModel = new \app\models\KpInstSatkerSearch();
    $dataProvider = $searchModel->searchSatker(Yii::$app->request->queryParams);
/*    $gridColumn =  [
    [
        'class' => '\kartik\grid\DataColumn',
         'format'=>'raw',//text, html
        'attribute' => 'peg_nama',
        'value'=>function ($model, $key, $index, $widget){
                       return yii\helpers\Html::input('text',"peg_nip_".$index,$key,['readonly'=>true,'id'=>"peg_nip_".$index]);
                            },
        'attribute'=>'peg_nama',
        'label' => 'Nama',
         
       
    ],
                         [
        'class' => '\kartik\grid\DataColumn',
        //  'format'=>'raw',//text, html
        'attribute' => 'peg_nip',
       
        'label' => 'NIP',
        
       
    ],
        
         [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'pns_jnsjbtfungsi',
        'label' => 'Gol/Pangkat',
         
       
    ],
        [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_instakhir',
        'label' => 'Wilayah',
         
       
    ],
           [
        'class' => '\kartik\grid\ActionColumn',
         'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model,$key) {
                        return Html::button('Pilih', ['id'=>'buttonTT']);
                    }
        
       
    ],
        ]];*/

?>
       <?= GridView::widget([
            'id'=>'datakejaksaan-grid',
            'dataProvider'=> $dataProvider,
             'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                'inst_satkerkd',
                'inst_nama',
                
                 [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                            return Html::button('Pilih', ['class' => 'btn btn-primary','onclick'=>'$("#'.$param.'-inst_nama").val("'.$model['inst_nama'].'");$("#'.$param.'-inst_satkerkd").val("'.$model['inst_satkerkd'].'");$("#p_kejaksaan").modal("hide");$("#p_kejaksaaneks").modal("hide");']);
          //  return Html::button('Pilih', ['class' => 'btn btn-primary','onclick'=>'alert($("#was9-internal").val());$("#p_kejaksaan").modal("hide");']);
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
                'heading' => '<i class="glyphicon glyphicon-book"></i>',
            ],

            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                ],
                'neverTimeout'=>true,
              //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]

        ]); ?>