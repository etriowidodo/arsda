<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\MaskedInput;
use app\modules\pengawasan\models\KpInstSatker;
use app\modules\pengawasan\models\LookupItem;
use app\modules\pengawasan\models\VPejabatPimpinan;
use app\modules\pengawasan\models\VPejabatTembusan;
?>
<?php
$script = <<<JS
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
$this->registerJs($script, View::POS_BEGIN);
?>

<?php
$form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'sk-was-4b-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'action' => (empty($model['id_sk_was_4b']) ? Url::toRoute('sk-was-4b/create') : Url::toRoute('sk-was-4b/update2?id='.$model["id_sk_was_4b"].'')),
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ],
        ]);
?>


<div class="box box-primary">
    
  <div class="col-md-12">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3" style="margin-top: 10px;">Kejaksaan</label>
                <div class="col-md-9 kejaksaan">
                    <div class="input-group margin" style="margin: 10px 0px;" >
                        <?php
                        $inst_nama = KpInstSatker::findOne(['inst_satkerkd' => $model->inst_satkerkd]);
                        ?>
                        <input id="inst_satkerkd" class="form-control" type="hidden" readonly="true" name="inst_satkerkd" value="<?= $model->inst_satkerkd; ?>">
                        <input id="inst_nama" class="form-control" type="text" readonly="true" name="inst_nama" value="<?= $inst_nama->inst_nama; ?>">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" data-target="#m_kejaksaan" data-toggle="modal" >...</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Keputusan</label>
                <div class="col-md-9">	
                    <?php
                    $sql = (new \yii\db\Query())
                            ->select('id_jabatan_pejabat,jabatan ')
                            ->from('was.v_pejabat_pimpinan ')
                            ->where(['id_jabatan_pejabat'  =>[1,198,100]])
                            ->all();

                    $data = ArrayHelper::map($sql, 'id_jabatan_pejabat', 'jabatan');

                    echo $form->field($model, 'ttd_sk_was_4b')->dropDownList($data, ['prompt' => '---Pilih---'], ['label' => '', 'style' => 'width:400px']);  
?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-md-12">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">No. SK</label>
                <div class="col-md-9">
                  <?php if ($model->isNewRecord) { ?>
                    <div class="input-group">
                      <span class="input-group-addon">KEP-</span>
                      <input class="form-control" type="text" id="no_sk_was_4b" name="no_sk_was_4b">
                    </div>
                  <?php } else { ?>
                    <div class="input-group">
                      <span class="input-group-addon"><?php echo substr($model->no_sk_was_4b, 0, 4); ?></span>
                      <input class="form-control" type="text" id="no_sk_was_4b" name="no_sk_was_4b" value="<?php echo substr($model->no_sk_was_4b, 4); ?>">
                    </div>
                  <?php } ?>
                </div>
                </div>
            </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-4">Tanggal</label>
                <div class="col-md-8">
                    <?=
                    $form->field($model, 'tgl_sk_was_4b')->widget(DateControl::className(), [
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
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Pilih Terlapor</label>
                <div class="col-md-9">
 <?php
                   if ($model->isNewRecord) {
                      $sql = (new \yii\db\Query())
                      ->select('a.id_terlapor')
                      ->addSelect(["CONCAT(a.peg_nip, ' - ', a.peg_nama) AS terlapor"])
                      ->from('was.v_terlapor a')
                      ->innerjoin('was.was_15_saran b', 'a.id_terlapor = b.id_terlapor')
                      ->where(['b.tingkat_kd' => '18'])
                      ->andWhere(['not in', 'a.id_terlapor', (new \yii\db\Query())->select('id_terlapor')->from('was.sk_was_4b')->where(['sk_was_4b.id_register' => $model->id_register])->andWhere('flag != :del', ['del'=>'3'])])
                      ->andWhere(['a.id_register' => $model->id_register])
                      ->all();

                  $data = ArrayHelper::map($sql, 'id_terlapor', 'terlapor');

                  echo $form->field($model, 'id_terlapor')->dropDownList($data, ['prompt' => '---Pilih---'], ['label' => '', 'style' => 'width:400px']);
              }
              else{
                      $sql = (new \yii\db\Query())
                      ->select('a.id_terlapor')
                      ->addSelect(["CONCAT(a.peg_nip, ' - ', a.peg_nama) AS terlapor"])
                      ->from('was.v_terlapor a')
                      ->innerjoin('was.was_15_saran b', 'a.id_terlapor = b.id_terlapor')
                      ->where(['b.tingkat_kd' => '18'])
                      ->andWhere(['a.id_register' => $model->id_register])
                      ->all();

                  $data = ArrayHelper::map($sql, 'id_terlapor', 'terlapor');

                  echo $form->field($model, 'id_terlapor')->dropDownList($data, ['label' => '', 'style' => 'width:400px', 'disabled'=>'disabled']);
              }
?>      
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12" style="margin-top:10px;">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Upload File</label>
                <div class="col-md-9">	
                    <?php
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

          <?php if (!$model->isNewRecord) { ?>
          <div class="col-md-4">
            <div class="form-group">
              <div class="col-md-8">
                <?php echo $model->upload_file; ?>
              </div>
            </div>
          </div>
        <?php } ?>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
        <!--<label class="control-label col-md-2" style="margin-top:5px;">Penandatangan</label>-->
        <span class="pull-left"> <a data-target="#peg_tandatangan" data-toggle="modal" class="btn btn-primary"><i class="fa fa-user-plus"></i> Tambah Penandatangan</a> </span>
    </div>
    <?php
    if (!$model->isNewRecord) {
        $searchModel2 = new \app\models\KpPegawaiSearch();
        $modelKepegawaian = $searchModel2->searchPegawaiTtd($model->ttd_peg_nik, $model->ttd_id_jabatan);
        $model->ttd_peg_nama = $modelKepegawaian['peg_nama'];
        $model->ttd_peg_nip = (empty($modelKepegawaian['peg_nip_baru']) ? $modelKepegawaian['peg_nip'] : $modelKepegawaian['peg_nip_baru']);
        $model->ttd_peg_pangkat = $modelKepegawaian['gol_pangkat'];
        $model->ttd_peg_jabatan = $modelKepegawaian['jabatan'];
    }
    ?>
    <?= $form->field($model, 'ttd_peg_nik')->hiddenInput() ?>
    <?= $form->field($model, 'ttd_id_jabatan')->hiddenInput() ?>
    <div class="col-md-6">
        <div class="form-group">
            <label style="margin-top:18px;" class="control-label col-md-3">Nama</label>
            <div class="col-lg-9">
                <div class="form-group field-sk-was-4b-ttd_peg_nik">
                    <div class="col-sm-12">

                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group field-sk-was-4b-ttd_peg_nama">
                    <div class="col-sm-12">

                        <?= $form->field($model, 'ttd_peg_nama')->textInput(['class' => 'form-control', 'readonly' => true]) ?>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                        <div class="help-block"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">NIP</label>
            <div class="col-lg-9">
                <div class="form-group field-sk-was-4b-ttd_peg_nip">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'ttd_peg_nip')->textInput(['class' => 'form-control', 'readonly' => true]) ?>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                        <div class="help-block"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div style="margin-top:15px;" class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-3">Pangkat</label>
            <div class="col-lg-9">
                <div class="form-group field-sk-was-4b-ttd_peg_jabatan">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'ttd_peg_pangkat')->textInput(['class' => 'form-control', 'readonly' => true]) ?>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                        <div class="help-block"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Jabatan</label>
            <div class="col-lg-9">
                <div class="form-group field-sk-was-4b-ttd_peg_inst_satker">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'ttd_peg_jabatan')->textInput(['class' => 'form-control', 'readonly' => true]) ?>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                        <div class="help-block"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
                <!--<label class="control-label col-md-2" style="margin-top:5px;">Tembusan</label>-->
                <span class="pull-left"> <a class="btn btn-primary" data-toggle="modal" data-target="#tembusan"><i class="fa fa-user-plus"></i> Tambah Tembusan</a> </span>
    </div>
    <div class="box-header with-border">
        <table id="table_tembusan" class="table table-bordered">
            <thead>
                <tr>
                    <th>Tembusan</th>
                    <th width=10%>Hapus</th>
                </tr>
            </thead>
            <tbody id="tbody_tembusan-sk-was-4b">
            <?php if (!$model->isNewRecord): ?>
            <?php foreach ($modelTembusan as $data): ?>
                  <tr id="tembusan-<?= $data['id_pejabat_tembusan'] ?>">
                    <td><input type="text" name="jabatan[]" class="form-control" readonly="true" value="<?= VPejabatTembusan::findOne(['id_pejabat_tembusan' => $data->id_pejabat_tembusan])->jabatan; ?>"></td>
                <input type="hidden" class="form-control" name="id_jabatan[]"  value="<?= $data['id_pejabat_tembusan'] ?>">
                <td><button onclick="removeRow('tembusan-<?= $data['id_pejabat_tembusan'] ?>')" class="btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div style="margin:0px;padding:0px;background:none;" class="box-footer">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil-square-o"></i> Simpan' : '<i class="fa fa-retweet"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>