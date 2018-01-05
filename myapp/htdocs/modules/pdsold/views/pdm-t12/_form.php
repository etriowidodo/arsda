<?php

use app\components\GlobalConstMenuComponent;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT9 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">


        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 't12-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false
                            ]
        ]);
        ?>

        <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=>'_t12']) ?>

        <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">

            <div class="col-md-12" style="margin-top: 15px;">
                <div class="form-group">
                    <label class="control-label col-sm-2">Nama Terdakwa</label>
                    <div class="col-sm-3">
                        <?php
                        echo $form->field($model, 'id_tersangka')->hiddenInput();
                        echo $form->field($model, 'nama')->hiddenInput();
                        
                        echo $form->field($model, 'no_reg_tahanan_jaksa')->dropDownList(
                                ArrayHelper::map($modelTersangka, 'no_reg_tahanan', 'nama'), // Flat array ('id'=>'label')
                                ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa']    // options
                        );
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div id="data-terdakwa">
                    <?php
                    if (!empty($model->no_reg_tahanan_jaksa))
                        echo Yii::$app->globalfunc->getIdentitasTerdakwaT2($model->no_register_perkara,$model->id_tersangka);
                    ?>
                </div>
            </div> 
            

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Dilaksanakan Oleh</label>
                    <div class="col-md-3">
                            <?php echo $form->field($model, 'nip_jaksa')->dropDownList(
                                ArrayHelper::map($modeljaksi, 'nip', 'nama'), // Flat array ('id'=>'label')
                                ['prompt' => 'Pilih jaksa', 'class' => 'cmb_jaksa']);
                            ?>
                    </div>
                </div>
            </div>

        </div>

        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T12, 'id_table' => $model->no_surat_t12]) ?>

         <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord): ?>
                <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-t12/cetak?id_t12=' . $model->no_surat_t12]) ?>">Cetak</a>
            <?php endif; ?>
        </div>


    </div>
    </section>
    <?php ActiveForm::end(); ?>
    <?php
    $script = <<< JS
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<br /><input type="text" class="form-control" style="margin-left:60px"name="mytext[]">'
                )
            });
            
            $('.cmb_terdakwa').change(function(){
                var id_tersangka = $(this).val();
                $.ajax({
                    type: "POST",
                    url: '/pdsold/pdm-t12/terdakwa',
                    data: 'no_reg_tahanan='+id_tersangka,
                    success:function(data){
                        console.log(data);
                        $('#data-terdakwa').html(
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Tempat Lahir</label>'+
                                '<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Tanggal Lahir</label>'+
                                '<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Jenis Kelamin</label>'+
                                '<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Tempat Tinggal</label>'+
                                '<div class="col-sm-4">'+data.alamat+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Agama</label>'+
                                '<div class="col-sm-4">'+data.agama+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Pekerjaan</label>'+
                                '<div class="col-sm-4">'+data.pekerjaan+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Pendidikan</label>'+
                                '<div class="col-sm-4">'+data.pendidikan+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">No Regsiter Perkara</label>'+
                                '<div class="col-sm-4">'+data.no_register_perkara+'</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="control-label col-sm-2">No Regsiter Tahanan</label>'+
                                '<div class="col-sm-4">'+data.no_reg_tahanan+'</div>'+
                            '</div>'+
                             '<div class="form-group">'+
                                '<label class="control-label col-sm-2">Ditahan Sejak</label>'+
                                '<div class="col-sm-4">'+data.ditahan_sejak+'</div>'+
                            '</div>'
                        );
						var lel = $("#pdmt12-no_reg_tahanan_jaksa :selected").text();
                        $('#pdmt12-nama').val(lel);
                        $('#pdmt12-id_tersangka').val(data.no_urut_tersangka);

						var tglawal = new Date(data.ditahan_sejak);
						console.log(tglawal);
						function pad(s) {
							return (s < 10) ? '0' + s : s;
						}
						var tgl = [pad(tglawal.getDate()), pad(tglawal.getMonth() + 1), tglawal.getFullYear()].join('-');
						var tgl2 = [tglawal.getFullYear(), pad(tglawal.getMonth() + 1), pad(tglawal.getDate())].join('-');
						console.log(tgl);
						console.log(tgl2);
    					$("#pdmt12-tgl_penahanan-disp").val(tgl);
    					$("#pdmt12-tgl_penahanan").val(tgl2);
						
                    }
                });
            });
JS;
    $this->registerJs($script);
    ?>		
    

</div>
