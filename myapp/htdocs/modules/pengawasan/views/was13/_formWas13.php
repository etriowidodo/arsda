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
use app\modules\pengawasan\models\KpInstSatker;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16c */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'was13-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'action' => (empty($model['id_was_13']) ? Url::toRoute('was13/create') : Url::toRoute('was13/update2?id=' . $model["id_was_13"] . '')),
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
  <div class="box-header with-border">
    <div class="col-md-12">
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label col-md-3">Kejaksaan</label>
          <div class="col-md-9 kejaksaan">
            <div class="input-group margin" style="margin: 10px 0px;">
              <?php
              $inst_nama = KpInstSatker::findOne(['inst_satkerkd' => $model->inst_satkerkd]);
              ?>
              <input id="inst_satkerkd" class="form-control" type="hidden" readonly="true" name="inst_satkerkd" value="<?= $model->inst_satkerkd; ?>">
              <input id="inst_nama" class="form-control" type="text" readonly="true" name="inst_nama" value="<?= $inst_nama->inst_nama; ?>">
              <span class="input-group-btn">
                <div class="col-md-2"><a data-target="#m_kejaksaan" data-toggle="modal" class="btn btn-primary">...</a></div>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--<div class="col-md-12">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label col-md-4">Hari</label>
          <div class="col-md-8">	
    <?php
//            $hari = array("1" => "Senin",
//                "2" => "Selasa",
//                "3" => "Rabu",
//                "4" => "Kamis",
//                "5" => "Jumat");
//            echo $form->field($model, 'hari')->dropDownList($hari, ['prompt' => '--Pilih--'])
    ?>
          </div>
        </div>
      </div>
    </div-->
    <div class="col-md-12">
      <div class="col-md-6">
        <div class="form-group">
          <label class="control-label col-md-4">Tanggal</label>
          <div class="col-md-8">	
            <?=
            $form->field($model, 'tgl')->widget(DateControl::className(), [
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
          <label class="control-label col-md-3">Nomor Surat</label>
          <div class="col-md-9 kejaksaan">
            <div class="input-group margin" style="margin: 10px 0px;">
              <?php
              if ($model->isNewRecord) {
                $was9 = (new \yii\db\Query())
                        ->select('*')
                        ->from('was.v_drop_was13')
                        ->where(['id_register' => $no_register->id_register])
                        ->all();
                $data = ArrayHelper::map($was9, 'id_surat', 'no_surat');

                echo $form->field($model, 'id_surat')->dropDownList($data, ['label' => '', 'style' => 'width:400px']);
              } else {
                $was9 = (new \yii\db\Query())
                        ->select('*')
                        ->from('was.v_drop_was13')
                        ->where(['id_surat' => $model->id_surat])
                        ->all();
                $data = ArrayHelper::map($was9, 'id_surat', 'no_surat');

                echo $form->field($model, 'id_surat')->dropDownList($data, ['label' => '', 'style' => 'width:400px']);
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="box box-primary">		
  <div class="box-header with-border">	
    <div style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);" class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-2" style="margin-top:5px;">Pengirim</label>
        <div class="col-lg-10"> <span style="margin-left:-55px;margin-right:20px;" class="pull-right"> <a data-target="#peg_tandatangan" data-toggle="modal" class="btn btn-primary"><i class="glyphicon glyphicon-user"></i> Tambah</a> </span> </div>
      </div>
    </div>
    <hr>
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
          <div class="form-group field-was13-ttd_peg_nik">
            <div class="col-sm-12">

            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="form-group field-was13-ttd_peg_nama">
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
          <div class="form-group field-was13-ttd_peg_nip">
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
          <div class="form-group field-was13-ttd_peg_jabatan">
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
          <div class="form-group field-was13-ttd_peg_inst_satker">
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
</div>	


<div class="col-md-12">
  <div class="col-md-6">
    <div class="form-group">
      <label class="control-label col-md-4">Nama Penerima</label>
      <div class="col-md-8">	
        <?= $form->field($model, 'menerima_nama')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class="col-md-6">
    <div class="form-group">
      <label class="control-label col-md-4">Upload File</label>
      <div class="col-md-8">	
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
</div>



<div style="margin:0px;padding:0px;background:none;" class="box-footer">
  <div class="form-group">
    <?php
    echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil-square-o"></i> Simpan' : '<i class="fa fa-retweet"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);
    if (!$model->isNewRecord) {
      echo " ".Html::a('<i class ="fa fa-times"></i> Hapus', ['/pengawasan/was13/hapus', 'id' => $model->id_was_13], ['id' => 'hapusWas13', 'class' => 'btn btn-primary']);
    }
    ?>
  </div>
</div>

<?php ActiveForm::end(); ?>