
    
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
  /*$(document).ready(function(){

      $("#buttonTT").click(function(){
           var keys = $('#gridPegawaiTT').yiiGridView('getSelectedRows');
    alert('test'+keys);
      });
  });*/
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
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $gridColumn =  [
    [
        'class' => '\kartik\grid\DataColumn',
     /*    'format'=>'raw',//text, html
        'attribute' => 'peg_nama',
        'value'=>function ($model, $key, $index, $widget){
                       return yii\helpers\Html::input('text',"peg_nip_".$index,$key,['readonly'=>true,'id'=>"peg_nip_".$index]);
                            },*/
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
        ]];


        echo GridView::widget([
                
                    'dataProvider'=> $dataProvider,
                   // 'filterModel' => $searchModel,
                   'id' => 'gridPegawaiTT',
                   'layout'=>"{items}",
                    'columns' => $gridColumn,
                    'responsive'=>true,
                    'hover'=>true,
             'export'=>false,
                    //'panel'=>[
                      //      'type'=>GridView::TYPE_PRIMARY,
                          //  'heading'=>$heading,
                    //],
             
            ]);  ?>
