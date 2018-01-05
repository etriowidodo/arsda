<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaranSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
$this->registerJs("
    $(document).ready(function(){
$('#dugaan-pelanggaransearch-form form').submit(function(){

 $.pjax.reload({container: '#dugaangrid-index'});
   // $.fn.yiiGridView.update('table-dugaan', {
     //   data: $(this).serialize()
   // });
   e.preventDefault();
    return false;
}); 
$('#reset_dugaan').click(function(){
 document.forms['dugaan-pelanggaransearch-form'].reset();
});
});
", \yii\web\View::POS_END);

?>
<div class="dugaan-pelanggaran-search">

    <?php //$form = ActiveForm::begin([
        //'action' => ['index'],
        //'method' => 'get',
    //]); 
     $form = ActiveForm::begin([
                'id' => 'dugaan-pelanggaransearch-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'method' => 'GET',
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
          //  'actions' => Url::toRoute('was9/create'),
        ]
    ]);
    
    
    ?>

    

     <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-4">NO. Surat</label>
                        <div class="col-md-8">
                            <?= $form->field($searchModel, 'no_register')->textInput() ?>
                        </div>
                    </div>
                </div>
     </div>

    <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-4">TERLAPOR</label>
                        <div class="col-md-8">
                           <?= $form->field($searchModel, 'terlapor')->textInput() ?>
                        </div>
                    </div>
                </div>
     </div>
      <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-4">INSTANSI</label>
                        <div class="col-md-8">
                          
                           <?= $form->field($searchModel, 'inst_nama')->textInput() ?>
                        </div>
                    </div>
                </div>
           <div class="col-md-6">
          <div class="col-lg-10"> <span class="pull-left" style="margin-left:-55px;"> <a class="btn btn-primary" data-toggle="modal" data-target="#p_kejaksaan"><i class="glyphicon glyphicon-user"></i> ...</a> </span> </div>  <?= $form->field($searchModel, 'inst_satkerkd')->hiddenInput() ?>
     </div>
      </div>
     <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-4">Tanggal Dugaan</label>
                        <div class="col-md-8">
                          <?=
                            $form->field($searchModel, 'tgl_dugaan')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Tanggal Dugaan'],
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'pluginOptions' => [
                                    'autoclose' => true
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
         <div class="col-md-6"></div>
     </div>
    <?php //$form->field($model, 'inst_satkerkd') ?>

    

    <?php // echo $form->field($model, 'tgl_dugaan') ?>

    <?php // echo $form->field($model, 'sumber_dugaan') ?>

    <?php // echo $form->field($model, 'perihal') ?>

    <?php // echo $form->field($model, 'ringkasan') ?>

    <?php // echo $form->field($model, 'sumber_pelapor') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'upload_file') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>
<div class="box-footer" style="margin:0px;padding:0px;background:none;">
   
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::Button('Reset', ['id'=>"reset_dugaan",'class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
    Modal::begin([
		'id' => 'p_kejaksaan',
		'size' => 'modal-lg',
		'header' => '<h2>Pilih Kejaksaan</h2>',
	]);
	echo $this->render( '@app/modules/pengawasan/views/global/_dataKejaksaan', ['param'=> 'vdugaanpelanggaranindexsearch'] );
Modal::end();?>