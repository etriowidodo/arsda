<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use app\modules\pidum\models\PdmPasal;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP11 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">

<?php
        $form = ActiveForm ::begin(
            [
                'id' => 'ba3-form',
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
            ]);
		 
        ?>
		
		<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input class="form-control" readonly="true" value="<?php //echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                        </div>
                    </div>
                </div> -->
				
		<div class="col-md-6">
			 <?php
                echo Form::widget([ /* waktu kunjungan */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'jam_kunjungan' => [
                            'label' => 'Jam',
                            'labelSpan' => 2,
                            'columns' => 12,
                            'attributes' => [
                                'jam' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => '\kartik\widgets\TimePicker',
                                    'options' => [
                                        'pluginOptions'=>[
                                            //'template'=>false,
                                            'defaultTime'=>false,
                                            'showSeconds'=>false,
                                            'showMeridian'=>false,
                                            'minuteStep'=>1,
                                        ],
                                        'options' => [
                                            'placeholder'=>'Jam Mulai'
                                        ]
                                    ],
                                    'columnOptions' => ['colspan' => 6],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
        </div>
		
                <div class="col-md-6">
                <div class="form-group">
                <label class="control-label col-md-4">Tanggal Pembuatan</label>
                <div class="col-md-8">
        <?php
        echo $form->field($model, 'tgl_pembuatan')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATE,
        'ajaxConversion'=>false,
        'options' => [
		//'options' => ['place' => '26/Agustus/2015'],
        'pluginOptions' => [
        'autoclose' => true
        ]]
        ]);
        ?>
        </div>
		</div>
        </div>
		
		<div class="col-md-6">
		 <?php
                echo Form::widget([ /* nomor surat */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'lokasi' => [
                            'label' => 'Lokasi',
                            'labelSpan' => 2,
                            'columns' => 6,
                            'attributes' => [
                                'lokasi' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' =>4],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
        </div>
        </div>
        </div>
			
		<div class="box box-primary" style="border-color: #f39c12">
	<div class="box-header with-border">
  	<h3 a class="btn btn-primary addJPU2" id="popUpJpu" data-toggle="modal" data-target="#_jpupenyidik">Jaksa Penyidik</a></h3>
	</div>
	
         <div class="box-header with-border">
        <table class="table table-bordered" id="gridJPU1">
        <thead>
        <tr>
        <th></th>
        <th>NIP</th>
        <th>Nama</th>
        <th>Pangkat</th>
        <th>Jabatan</th>
        </tr>
        </thead>	
		<?php
     if (!$modelpenyidik->isNewRecord) {
		foreach ($modelpenyidik as $key => $value) { 
		?>
       <tr id='trJPU'>
		<td><a class="btn btn-danger delete" id="btn_hapus"></a></td>
        <td id='tdJPU'><input type='text' name='nip[]' id='nip' value='<?= $value->nip?>' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>
        <td id='tdJPU'><input type='text' name='nama[]' id='nama' value='<?= $value->nama ?>' style='width:250px;' readonly='true' class='form-control' readonly='true'></td>
        <td id='tdJPU'><input type='text' name='pangkat[]' id='pangkat' value='<?= $value->pangkat ?>' style='width:50px;' readonly='true' class='form-control' readonly='true'></td>
        <td id='tdJPU'><input type='text' name='jabatan[]' id='jabatan' value='<?= $value->jabatan ?>' style='width:440px;' readonly='true' class='form-control' readonly='true'></td> 
					
        </tr>
        <?php
        }
        }
        ?>
		<tbody>
        </tbody>
		</table>
</div>
</div>
		
		<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">		
	
	<div class="box-header with-border">
    <div class="form-group">
    <h3 class="box-title" style="margin-left:10px">AHLI</h3>
    </div>
    </div>
	<br>
	
	
    <div class="form-group">
        <label class="control-label col-md-2">Nama</label>
    <div class="col-md-4">
	<?= $form->field($modelMsSaksi, 'nama') ?>
    </div>
	</div>
	
	<div class="form-group">
	<label class="control-label col-md-2">Tempat Lahir</label>
    <div class="col-md-4"> 
		<?= $form->field($modelMsSaksi, 'tmpt_lahir') ?>
</div>
</div>
	

<div class="form-group">
    <label class="control-label col-md-2">Tanggal Lahir</label>
    <div class="col-md-4"> 
		<?=
    $form->field($modelMsSaksi, 'tgl_lahir')->widget(DateControl::className(), [
    'type' => DateControl::FORMAT_DATE,
    'ajaxConversion' => false,
    'options' => [
    'pluginOptions' => [
    'autoclose' => true
    ]
    ]
    ]);
    ?>
</div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Jenis Kelamin</label>
    <div class="col-md-4"> 
	<?php
    $kelamin = (new \yii\db\Query())
    ->select('id_jkl, nama')
    ->from('public.ms_jkl')
    ->all();
    $list = ArrayHelper::map($kelamin, 'id_jkl', 'nama');
    echo $form->field($modelMsSaksi, 'id_jkl')->dropDownList($list, ['prompt' => '---Pilih Jenis Kelamin---'], ['label' => '']);
    ?>
	 	
</div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Kebangsaan</label>
    <div class="col-md-4"> 
	<?php
	$kebangsaan = (new\yii\db\Query())
	->select('id, nama')
	->from('public.ms_warganegara')
	->all();
	$list = ArrayHelper::map($kebangsaan, 'id', 'nama');
	echo $form->field($modelMsSaksi, 'warganegara')->dropDownList($list, ['prompt' => '---Pilih Warganegara---'], ['label'=> '']);
	?>
	</div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Tempat Tinggal</label>
    <div class="col-md-4"> 
	 <?=$form->field($modelMsSaksi, 'alamat');?>
</div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Agama</label>
    <div class="col-md-4"> 
	   <?php
                            $agama = (new \yii\db\Query())
                                    ->select('id_agama, nama')
                                    ->from('public.ms_agama')
                                    ->all();
                            $list = ArrayHelper::map($agama, 'id_agama', 'nama');
                            echo $form->field($modelMsSaksi, 'id_agama')->dropDownList($list, ['prompt' => '---Pilih Agama---'], ['label' => '']);
                            ?>
	
</div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Pekerjaan</label>
    <div class="col-md-4"> 
	 <?=$form->field($modelMsSaksi, 'pekerjaan');?>
</div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Pendidikan</label>
    <div class="col-md-4"> 
	 <?php
        $pendidikan = (new \yii\db\Query())
        ->select('id_pendidikan, nama')
        ->from('public.ms_pendidikan')
        ->all();
        $list = ArrayHelper::map($pendidikan, 'id_pendidikan', 'nama');
        echo $form->field($modelMsSaksi, 'id_pendidikan')->dropDownList($list, ['prompt' => '---Pilih Pendidikan---'], ['label' => '']);
                            ?>
	
</div>
</div>
	
</div>

<div class="box box-primary" style="border-color: #f39c12">
	<div class="box-header with-border">
	
  	<h3 a class="btn btn-primary addJPU2" id="popUpJpu" data-toggle="modal" data-target="#_jpu">Jaksa Saksi</a></h3>
	</div>
	    <div class="box-header with-border">
        <table class="table table-bordered" id="gridJPU">
        <thead>
        <tr>
        <th></th>
        <th>NIP</th>
        <th>Nama</th>
        <th>Pangkat</th>
        <th>Jabatan</th>
        </tr>
        </thead>	
		<tbody>
        <?php
        if (!$modeljaksi->isNewRecord) {
		foreach ($modeljaksi as $key => $value) {
		?>
        <tr id='trJPU2'>
		<td><a class="btn btn-danger delete" id="btn_hapus"></a></td>
        <td id='tdJPU2'><input type='text' name='txtnip[]' id='txtnip' value='<?= $value->nip ?>' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>
        <td id='tdJPU2'><input type='text' name='txtnama[]' id='txtnama' value='<?= $value->nama ?>' style='width:250px;' readonly='true' class='form-control' readonly='true'></td>
        <td id='tdJPU2'><input type='text' name='txtpangkat[]' id='txtpangkat' value='<?= $value->pangkat ?>' style='width:50px;' readonly='true' class='form-control' readonly='true'></td>
        <td id='tdJPU2'><input type='text' name='txtjabatan[]' id='txtjabatan' value='<?= $value->jabatan ?>' style='width:440px;' readonly='true' class='form-control' readonly='true'></td>
		</tr>
        <?php
        }
        }
        ?>
        </tbody>
		</table>

</div>
</div>
	</section>
</div>
	<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-ba3/cetak?id_ba3='.$model->id_ba3] ) ?>">Cetak</a>
		<?php } ?>
    </div>
        <div id="hiddenId"></div>
		<?php ActiveForm::end(); ?>


	

<?php
Modal::begin([
    'id' => '_jpu',
    'header' => 'Data Jaksa Pelaksana',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>
	
	<script type="text/javascript">
//JPU
     window.onload = function () {
        $(document).on('click', '#btn_hapus', function () {
            $(this).parent().parent().remove();
            return false;
        });

        $('#pilih-jpu').click(function () {
            $('input:checkbox:checked').each(function (index) {
                //var keys = $('#gridKejaksaan').yiiGridView('getSelectedRows');
                // alert(keys);
                var value = $(this).val();
                var data = value.split('#');

                $('#gridJPU').append(
                        '<tr id="trjpu">' +
						'<td id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus"></a></td>' +
                        '<td><input type="text" class="form-control" name="txtnip[]" readonly="true" style="width:100px;" value="' + data[0] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtnama[]" readonly="true" style="width:250px;" value="' + data[1] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtpangkat[]" readonly="true" style="width:50px;" value="' + data[2] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtjabatan[]" readonly="true" style="width:300px;" value="' + data[3] + '"> </td>' +
                       
                        '</tr>'
                        );

            });
            $('#_jpu').modal('hide');
        });
    };
	
	
function pilihJPU(nip, nama, jabatan, pangkat) {

        var i = $('table#gridJPU1 tr:last').index() + 1;
        $('#gridJPU1').append(
                "<tr id='trJPU1" + i + "'>" +
                "<td id='tdJPU1" + i + "'><a class='btn btn-danger delete' id='btn_hapus'></a></td>" +
                "<td id='tdJPU1" + i + "'><input type='text' name='nip[]' id='nip' value='" + nip + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU1" + i + "'><input type='text' name='nama[]' id='nama' value='" + nama + "' style='width:250px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU1" + i + "'><input type='text' name='pangkat[]' id='pangkat' value='" + pangkat + "' style='width:50px;' readonly='true' class='form-control' readonly='true'></td>" +
                "<td id='tdJPU1" + i + "'><input type='text' name='jabatan[]' id='jabatan' value='" + jabatan + "' style='width:400px;' readonly='true' class='form-control' readonly='true'></td>" +
                "</tr>"
                );
        i++;

        $('#_jpupenyidik').modal('hide');

    }
	
	

	</script>
	



<?php
Modal::begin([
    'id' => '_jpupenyidik',
    'header' => 'Data Jaksa Penyidik',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_jpupenyidik', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>
		