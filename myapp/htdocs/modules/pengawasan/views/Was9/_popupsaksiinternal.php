<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\models\MsAgama;
use app\models\MsPendidikan;

?>

<script>
var url1='<?php echo  Url::toRoute('was9/create'); ?>';
</script>
  <?php
$script= <<<JS
        
                
$('#tgl_eks_waktu').change(function(){
       
   var d = new Date($('#tgl_eks_waktu').val());
  
   
var weekday = new Array(7);
weekday[0]=  "Minggu";
weekday[1] = "Senin";
weekday[2] = "Selasa";
weekday[3] = "Rabu";
weekday[4] = "Kamis";
weekday[5] = "Jumat";
weekday[6] = "Sabtu";

var n = weekday[d.getDay()];  
    $('#was9-hari').val(n);
     });  
    function removeRow(id)
    {
     
      $("#"+id).remove();
        

    }
        
        function removeRowUpdate(id)
    {
        var id_2= id.split("-");
        var nilai = $("#delete_tembusan").val()+"#"+id_2[1];
       
     $("#delete_tembusan").val(nilai);
      $("#"+id).remove();
        

    }
     
        
     
JS;
$this->registerJs($script,View::POS_BEGIN);


?>    


<div>
 <?php $form = ActiveForm::begin([
        'id' => 'was9eks-popup-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ],
        'options' =>[
            'enctype' => 'multipart/form-data',
            'onkeypress'=>" if(event.keyCode == 13){return false;}",
            'actions' => ($model->isNewRecord?Url::toRoute('was9/create'):Url::toRoute('was9/update')),
        ]
    ]); ?>
<div class="box box-primary" style="overflow: hidden;">

<?php 
  //   $from_table=$param;                        
  //   // $searchModel = new \app\models\KpPegawaiSearch();
  //   $searchModel = new \app\modules\pengawasan\models\SpWas1Search();
  //   $dataProvider = $searchModel->searchPenandatangan(Yii::$app->request->queryParams,$from_table);
  // $dataProvider->pagination->pageSize = 6;
?>
       <?
       // = GridView::widget([
       //      'id'=>'jpu-grid',
       //      'dataProvider'=> $dataProvider,
       //      'filterModel' => $searchModel,
       //      'layout' => "{items}\n{pager}",
       //      'columns' => [
       //          ['class' => 'yii\grid\SerialColumn'],
                
       //          'nip',
       //          'nama_penandatangan',
       //          'jabatan',
       //           [
       //              'class' => 'yii\grid\ActionColumn',
       //              'template' => '{pilih}',
       //              'buttons' => [
       //                  'pilih' => function ($url, $model,$key) use ($param){
       //                      return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary','onclick'=>'$("#'.$param.'-nama_penandatangan_'.$param.'").val("'.$model['nama_penandatangan'].'");$("#'.$param.'-nip_penandatangan_'.$param.'").val("'.(empty($model['nip']) ? $model['nip']:$model['nip']) .'");$("#'.$param.'-jabatan_penandatangan_'.$param.'").val("'.$model['jabatan'].'");$("#peg_tandatangan").modal("hide");']);
       //                  },
       //              ]
       //          ],
               
       //      ],
       //      'export' => false,
       //      'pjax' => true,
       //      'responsive'=>true,
       //      'hover'=>true,
       //      'panel' => [
       //          'type' => GridView::TYPE_PRIMARY,
       //          'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
       //      ],

       //      'pjaxSettings'=>[
       //          'options'=>[
       //              'enablePushState'=>false,
       //          ],
       //          'neverTimeout'=>true,
       //        //  'beforeGrid'=>['columns'=>'peg_nip'],
       //      ]

       //  ]); ?>
</div>
  <div class="box-footer" style="margin:0px;padding:0px;background:none;">
  <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'was9int-submit']) ?>
  <?= Html::Button('Kembali', ['class' => 'btn btn-primary','data-dismiss'=>"modal"]) ?>

</div>
  <?php ActiveForm::end(); ?>
</div>