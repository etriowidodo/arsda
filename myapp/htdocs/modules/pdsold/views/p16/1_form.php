<?php

use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;


require('..\modules\pidum\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP16 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-header"></div>

    <?php $form = ActiveForm::begin([
        'id' => 'p16-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ]
    ]); ?>
    <div class="box-body">
        <div class="form-group">
            <label class="control-label col-md-2">Wilayah Kerja</label>
            <div class="col-md-4">
                <input class="form-control" value="<?php echo \Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Kode Print</label>
            <div class="col-md-4">
                <?= $form->field($model, 'no_surat')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="panel box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Tersangka
                </h3>
            </div>
            <table id="table_jpu" class="table table-bordered">
                <thead>
                <tr>
                    <th>Nama</th>
                </tr>
                </thead>
                <tbody id="tbody_tersangka">

                <?php
                if($modelTersangka != null){
                    foreach($modelTersangka as $key => $value){
                        echo "<tr><td>".$value['nama']."</td></tr>";
                    }
                }
                ?>

                </tbody>
            </table>
        </div>
        <div class="panel box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a class="btn btn-primary" id="popUpJpu"><i class="glyphicon glyphicon-plus"></i> Tambah Jaksa Peneliti</a>
                </h3>
            </div>
            <table id="table_jpu" class="table table-bordered">
                <thead>
                <tr>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>PANGKAT</th>
                    <th>JABATAN</th>
                </tr>
                </thead>
                <tbody id="tbody_jpu">
					<?php if(!$model->isNewRecord): ?>
                       <?php foreach ($modelJpu as $value): ?>
                           <tr id="trjpu<?= $value['id_jpu'] ?>">
                              <td><input type="text" name="nip_jpu_update[]" class="form-control" readonly="true" value="<?= $value['nip'] ?>"></td>
                              <td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->namaPegawai->peg_nama ?>"></td>
                              <td><input type="text" name="gol_jpu_update[]" class="form-control" readonly="true" value="Jaksa Fungsional"></td>
                              <td><input type="text" name="jabatan_jpu_update[]" class="form-control" readonly="true" value="IV/d (Jaksa Utama Madya)"></td>
                              <td><a id="hapus-jpu" class="btn btn-danger" onclick="hapusJpu(<?= $value['id_jpu'] ?>)">Hapus</a> </td>
                           </tr>
                      <?php endforeach; ?>
					<?php endif; ?>
                </tbody>
            </table>
        </div>
        

        <div class="form-group">
            <label class="control-label col-md-2">Dikeluarkan</label>
            <div class="col-md-4">
                <?= $form->field($model, 'dikeluarkan')->input('text',['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]) ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Tanggal Ttd</label>
           <div class="col-md-4">
                <?= $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Penandatangan</label>
            <div class="col-md-2">
                <?php
                        $penandatangan=(new \yii\db\Query())
                                        ->select('peg_nik,nama')
                                        ->from('pidum.vw_penandatangan')
                                        ->where(['is_active' =>'1'])
                                        ->all();
                        $list = ArrayHelper::map($penandatangan,'peg_nik','nama');
                        echo $form->field($model, 'id_penandatangan')->dropDownList($list, 
                                ['prompt' => '---Pilih---'], 
                                ['label'=>'']);
                        ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Tembusan</label>
            <div class="col-md-2 tembusan">
                <?php
                        $modelTembusan = (new \yii\db\Query())
                                ->from('pidum.pdm_tembusan')
                                ->where(['id_table' => $model->id_p16])
                                ->andWhere(['kode_table' => 'P-16'])
                                ->all();
                        foreach ($modelTembusan as $key) {
                            $temp[] = $key;
                        }
                        $count = (new \yii\db\Query())
                                ->from('pidum.pdm_tembusan')
                                ->where(['id_table' => $model->id_p16])
                                ->andWhere(['kode_table' => 'P-16'])
                                ->count();
                        $x = 0;

                        while ($x < $count) {
                            $modelTembusan->{'keterangan' . $x};
                            //print_r($temp[$x]['keterangan']);
                            ?>
                            <input type="text" class="form-control" value="<?= $temp[$x]['keterangan'] ?>" name="mytext_"></br>
                            <?php
                            $x++;
                        }
                        ?>
            </div>
			<br><br><br><br><br>
							                    <div class="box-body">   
<br>												
											<div>
							                    <div>
					                            <?=$viewFormFunction->returnTembusanDynamicpidum ($form,'p-16',$this)?>
					                             
								                		
					                            </div>
					                        </div>           		
					                        </div></div>
	
	
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-info" href="<?= \yii\helpers\Url::to(['p16/cetak?id='.$model->id_perkara]) ?>">Cetak</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script1 = <<< JS
	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pdsold/p16/jpu');
        $('#m_jpu').modal('show');
	});
JS;
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah JPU</h7>'
]);
Modal::end();
?>
