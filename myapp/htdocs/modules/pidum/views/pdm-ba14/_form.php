<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\web\View;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\MsLoktahanan;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA14 */
/* @var $form yii\widgets\ActiveForm */
?>



<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">

<?php $form = ActiveForm::begin(
	[
                'id' => 'ba14-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]

	);
	?>
	
	 <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Pembuatan</label>
                        <div class="col-md-8">
                          <?php
                            echo $form->field($model, 'tgl_pembuatan')->widget(DateControl::classname(), [
                            'type'=>DateControl::FORMAT_DATE,
                            'ajaxConversion'=>false,
                            'options' => [
                            'pluginOptions' => [
                            'autoclose' => true
                            ]]
                            ]);
                          ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Jaksa Pelaksana</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="jaksa_pelaksana">
                                <option value=""></option>                            
                            <?php
                                foreach ($modeljaksi as $value) {
                            ?>
                                <option <?php echo $value['nip'] == $modeljaksiChoosen->nip ? 'selected' : ''; ?> value="<?php echo $value['nip'] . "#" . $value['nama'] . "#" . $value['jabatan'] . "#" . $value['pangkat']; ?>">
                                    <?php echo $value['nama'];?>
                                </option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		

         <div class="panel box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="glyphicon glyphicon-user"></i> Tersangka
                </h3>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Nama</label>
                <div class="col-sm-4">
                    <?php
                        echo Yii::$app->globalfunc->getTerdakwa($form, $model, $modelSpdp, $this);
                    ?>
                </div>
            </div>
                <div class="clearfix"></div>
            
            <div id="data-terdakwa">
                <?php
                    if($model->id_tersangka != null)
                        echo Yii::$app->globalfunc->getIdentitasTerdakwa($model->id_tersangka);
                ?>

            </div>
        </div>   


<?php
					if(count($terdakwa)>0){
					foreach($terdakwa as $rowTerdakwa){
					?>
					
					<?php
					}
					}
					?>
			


<div class="panel box box-warning">
<div class="box-header with-border">
 <div class="form-group">
    <label class="control-label col-md-2">No. Reg. Perkara</label>
    <div class="col-md-4">
          <?= $form->field($model, 'no_reg_perkara')->textInput(['value' => $modelRp9->no_urut, 'readonly' => true]) ?>
    </div>
  <label class="control-label col-md-2">Di tahan sejak</label>
    <div class="col-md-3"> 
	<?php
        echo $form->field($model, 'tgl_mulai_tahan')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATE,
        'ajaxConversion'=>false,
        'options' => [
        'pluginOptions' => [
        'autoclose' => true
        ]]
        ]);
        ?>
	</div>
  </div>

   <div class="form-group hide">
    <label class="control-label col-md-2">No. Reg. Tahanan</label>
    <div class="col-md-4">
        <?= $form->field($model, 'no_reg_tahanan')->textInput(['value' => $modelRt3->no_urut, 'readonly' => true]) ?>
       </div>
		
    </div>
	</div>
	
	</div>

   


	<div class="box-header with-border">
	
	<!--<h3 class="box-title"> ACUAN </h3></div> -->
	<br>
	<div class="form-group">
	<!--
    <label class="control-label col-md-2">No SP Kepala kejaksaan</label>
	
    <div class="col-md-3">
	<?= $form->field($model, 'no_sp_kepala')->textInput(['maxlength'=>true]) ?>  
	</div>
	-->
	<!--
    <label class="control-label col-md-2">Tanggal Surat</label>
    <div class="col-md-3">
   <?php
        echo $form->field($model, 'tgl_sp_kejaksaan')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATE,
        'ajaxConversion'=>false,
        'options' => [
        'pluginOptions' => [
        'autoclose' => true
        ]]
        ]);
        ?>
  </div>
  -->
  </div>

 
  <!--
  <div class="form-group">
    <label class="control-label col-md-2">Kepala kejaksaan Asal</label>
    <div class="col-md-3"> 
	<?= $form->field($model, 'kepala_rutan')->textInput(['maxlength' => true]) ?>
  </div>
  </div>
  -->


  
  <div class="panel box box-warning">
	<div class="box-header with-border">
	<h3 class="box-title"> TINDAKAN </h3></div>
	<br>
    <div class="form-group">
    <label class="control-label col-md-2">Di berikan</label>
    <div class="col-md-4"> 
  <?= $form->field($model, 'tindakan')->dropDownList(['1' => 'Penangguhan Penahanan Terdakwa', '2' => 'Penangguhan Penahanan Tersangka']) ?>
  </div>
  </div>
  </div>
   
 <!--       
  	<div class="form-group">
    <label class="control-label col-md-2">Atas Pasal</label>
    <div class="col-md-3"> 
	<?php $pasal = PdmPasal::findOne(['id_perkara' =>$model->id_perkara]);?>
	<input type="text" class="form-control" readonly="true" value="<?php echo $pasal->pasal; ?> ">
  </div>
  </div>
-->
	  
  <div class="form-group">
    <label class="control-label col-md-2">Lokasi Rutan</label>
    <div class="col-md-3"> 
	<?=
		$form->field($model, 'id_ms_loktahanan')->dropDownList(
				ArrayHelper::map(MsLoktahanan::find()->all(), 'id_loktahanan', 'nama'), ['prompt' => 'Pilih Jenis Tahanan',
			'id' => 'cbLoktahanan',
				]
		)
		?>
  
  </div>
  </div>
  
  
    <div class="form-group">
    <label class="control-label col-md-2">Terhitung Sejak</label>
    <div class="col-md-3"> 
	<?php
        echo $form->field($model,'tgl_mulai')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATE,
        'ajaxConversion'=>false,
        'options' => [
        'pluginOptions' => [
        'autoclose' => true
        ]]
        ]);
        ?>
    </div>
    </div>
	           
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
    
    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if(!$model->isNewRecord ): ?>
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-ba14/cetak?id='.$model->id_ba14]) ?>">Cetak</a>
        <?php endif ?>  
    </div>

 
 <?php ActiveForm::end(); ?>
 
 </div>
 </section>
<?php
/*Modal::begin([
'id' => 'm_tersangka',
'header' => 'Data Tersangka',
'options'=>[
'data-url'=>'',
],
]);
?> 

<?= $this->render('_m_tersangka', [
        'model' => $model,
		'dataTersangka' => $dataTersangka,
]) ?>
	
<?php
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'jpu_',
    'header' => 'Data Jaksa Pelaksana',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('jpu_', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
*/
?>



<script type="text/javascript">
//JPU
    window.onload = function () {
	        $(document).on('click', '#btn_hapus', function () {
            $(this).parent().parent().remove();
            return false;
        });
		
				
	//Terdakwa
        $('#pilih-tersangka').click(function(){
		$('input:checkbox:checked').each(function(index) {
		var value = $(this).val();
		var data = value.split('#');

		$('#tbody_tersangka').append(
			'<tr id="trtersangka'+data[0]+'">' +
			'<td><a class="btn btn-danger delete" id="btn_hapus"></a></td>' +
				'<td><input type="hidden" class="form-control" name="id_tersangka[]" readonly="true" value="'+data[0]+'"><input type="text" class="form-control" name="nama[]" readonly="true" value="'+data[1]+'"> </td>' +
				'<td><input type="text" class="form-control" name="alamat[]" readonly="true" value="'+data[2]+'"> </td>' +
				'<td><input type="text" class="form-control" name="pekerjaan[]" readonly="true" value="'+data[3]+'"> </td>' +
				
			'</tr>'
		);

	});
	$('#m_tersangka').modal('hide');
	 });

};
     
    function pilihJPU(nip, nama, jabatan, pangkat) {

        var i = $('table#gridJPU tr:last').index() + 1;

        $('#gridJPU').append(
                "<tr id='trJPU" + i + "'>" +
                "<td id='tdJPU" + i + "'><a class='btn btn-danger delete' id='btn_hapus'></a></td>" +
                "<td id='tdJPU" + i + "'><input type='text' name='txtnip[]' id='txtnip' value='" + nip + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU" + i + "'><input type='text' name='txtnama[]' id='txtnama' value='" + nama + "' style='width:250px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU" + i + "'><input type='text' name='txtpangkat[]' id='txtpangkat' value='" + pangkat + "' style='width:50px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU" + i + "'><input type='text' name='txtjabatan[]' id='txtjabatan' value='" + jabatan + "' style='width:510px;' readonly='true' class='form-control' readonly='true'></td>" +
                "</tr>"
                );
        i++;

        $('#jpu_').modal('hide');

    }
	
	

</script>