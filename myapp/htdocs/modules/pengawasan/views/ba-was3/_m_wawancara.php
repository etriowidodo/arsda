<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use kartik\widgets\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php
	$form = ActiveForm::begin([
            'id' => 'ba_was_3_terlapor',
            'type' => ActiveForm::TYPE_HORIZONTAL,
			'action' => ['ba-was3/create'],
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ],
            'options' => ['enctype' => 'multipart/form-data']
        ]);
	?>



    <div class="box box-primary" style="overflow:hidden;padding:15px 0px 8px 0px;">
	<?php
		$searchModel = new \app\modules\pengawasan\models\Was1Search();
        $data_satker = $searchModel->searchSatker($id_register);
        $model->inst_satkerkd = $data_satker['inst_satkerkd'];
        $model->inst_nama = $data_satker['inst_nama'];
    ?>
	
	<!------------- Hidden Field -------------------->
	
	<input type="hidden" id="counter-terlapor" value="0" />
	<input id="inst_satkerkd_ba-was3" value="<?php echo $model->inst_satkerkd; ?>" type="hidden" name="BaWas3[inst_satkerkd]">
	<input id="id_register" value="<?php echo $id_register; ?>" type="hidden" name="BaWas3[id_register]">
	<input id="sebagai" type="hidden" name="BaWas3[sebagai]">
	
	<!------------- Hidden Field -------------------->
	
	
		<div class="col-md-12">
		<div class="col-md-10">
        <div class="form-group">
        <label class="control-label col-md-3">Kejaksaan</label>
        <div class="col-md-7">
		<div class="input-group">
		<?= $form->field($model, 'inst_nama')->textInput(['maxlength' => true, 'readonly' => 'readonly', 'id' => 'inst_nama_ba-was3']) ?>
                                                <span class="input-group-btn"">
                                                    <button style="margin-top:-10px;" type="button" class="btn btn-primary"
                                                            data-target="#m_kejaksaan_ba-was3"
                                                            data-toggle="modal">...
                                                    </button>
                                                </span>
        </div>
								
          
        </div>
        </div>
        </div>
	    </div>
  
	
	
        <div class="col-md-12">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-3">Tanggal</label>
                    <div class="col-md-3">
                        
                        <?=
                            $form->field($model, 'tgl')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'id'=>'tgl_tambah_wawancara',
                                    'pluginOptions' => [

                                        'autoclose' => true,
                                        'startDate' => '0',
                                        'endDate' => '+5y',
                                    ]
                                ],
                            ]);
                            ?>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="col-md-12">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-3">Hari</label>
                    <div class="col-md-3">
                        <?= $form->field($model,'hari')->textInput(['readonly'=>true,'id'=>'hari_tambah']); ?>	
                    </div>
                </div>
            </div>
        </div>
		
		<div class="col-md-12">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-3">Bertempat Di</label>
                    <div class="col-md-8">
                       <?= $form->field($model, 'tempat')->textInput(['maxlength' => 60]) ?>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="col-md-12">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-3">Pemeriksa</label>
                    <div class="col-md-8">
                        <?php
                        $queryPemeriksa = new Query;
                        $queryPemeriksa->select(["CONCAT(a.peg_nip, ' - ', a.peg_nama) AS nama", "a.id_pemeriksa"])
                                ->from('was.v_pemeriksa a')
                                ->where("id_register= :id", [':id' => $id_register]);

                        $pemeriksa = $queryPemeriksa->all();
                        ?>
                        <?=
                        $form->field($model, 'id_pemeriksa')->dropDownList(
                                ArrayHelper::map($pemeriksa, 'id_pemeriksa', 'nama'), ['prompt' => 'Pilih Pemeriksa',
								'id' => 'pemeriksa',
                                ]
                        )
                        ?>
                    </div>	
                </div>
            </div>
        </div>
		
        <div class="col-md-12">
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-3"><span id='id_peran_title'></span></label>
                    <div class="col-md-6">
					
                        
						<select id="id_peran" class="form-control" name="BaWas3[id_peran]">
						</select>
						</div>
						<div class="col-sm-12"></div>
						<div class="col-sm-12">
						<div class="help-block"></div>
						</div>
						
						
                    </div>	
                </div>
            </div>
			
			
        </div>
    


    <!--=====================================================3-->
	<div class="box box-primary">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <!--<label style="margin-top:5px;" class="control-label col-md-2">&nbsp;<strong>Penandatangan</strong></label>-->
                <span class="pull-left"> <a id="btn_tambah_terlapor" class="btn btn-primary">Tambah</a> </span>

            </div> 
	    <div class="box-header with-border">
            <table id="table_tembusan" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="6%">No</th>
                        <th align="center">Pertanyaan</th>
						<th align="center">Jawaban</th>
                        <th width="10%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody id="tbody-wawancaraTerlapor">

                </tbody>
            </table>
        </div>
    </div>
    <!--=====================================================3-->
	
	
    <div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-md-3">Upload File</label>
                    <div class="col-md-9">
                        <?php
							$url = Url::to(['pengawasan/upload_file/ba_was_3/'.$model->upload_file]);
                            echo $form->field($model, 'upload_file')->widget(FileInput::classname(), [
                                'options' => [
                                    'multiple' => false,
                                ],
                                'pluginOptions' => [
                                    'showPreview' => true,
                                    'showUpload' => false,
                                ]
                            ]);
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
			<?php echo Html::Button('<i class="fa fa-arrow-left"></i> Kembali', ['class' => 'btn btn-primary', 'id' => 'btn_batal_wawancara']); ?>
        </div>

    <?php ActiveForm::end(); ?>