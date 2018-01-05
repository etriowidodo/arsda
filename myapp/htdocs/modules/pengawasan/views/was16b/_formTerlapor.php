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
use app\modules\pengawasan\models\KpInstSatker;
use app\modules\pengawasan\models\LookupItem;
use app\modules\pengawasan\models\VPejabatPimpinan;
use yii\widgets\MaskedInput;
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
            'id' => 'was16b-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'action' => (empty($model['id_was_16b']) ? Url::toRoute('was16b/create') : Url::toRoute('was16b/update2?id=' . $model["id_was_16b"] . '')),
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
          <div class="input-group margin" style="margin: 10px 0px;">
            <?php
            $inst_nama = KpInstSatker::findOne(['inst_satkerkd' => $model->inst_satkerkd]);
            ?>
            <input id="inst_satkerkd" class="form-control" type="hidden" readonly="true" name="inst_satkerkd" value="<?= $model->inst_satkerkd; ?>">
            <input id="inst_nama" class="form-control" type="text" readonly="true" name="inst_nama" value="<?= $inst_nama->inst_nama; ?>">
            <!--<span class="input-group-btn">
                <div class="col-md-2"><a data-target="#m_kejaksaan" data-toggle="modal" class="btn btn-primary">...</a></div>
            </span>-->
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" data-target="#m_kejaksaan" data-toggle="modal">...</button>
            </span>
          </div>
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
                    ->select('v_riwayat_jabatan.peg_nip_baru, v_riwayat_jabatan.jabatan,terlapor.id_terlapor')
                    ->addSelect(["CONCAT(v_riwayat_jabatan.peg_nip_baru, ' - ', v_riwayat_jabatan.peg_nama) AS nama"])
                    ->from('was.v_riwayat_jabatan')
                    ->innerjoin('was.terlapor', 'v_riwayat_jabatan.id = terlapor.id_h_jabatan')
                    ->where(['terlapor.id_register' => $model->id_register])
                    ->andWhere(['not in', 'terlapor.id_terlapor', (new \yii\db\Query())->select('id_terlapor')->from('was.was_16b')->where(['was_16b.id_register' => $model->id_register])->andWhere('flag != :del', ['del' => '3'])])
                    ->all();

            $data = ArrayHelper::map($sql, 'id_terlapor', 'nama');

            echo $form->field($model, 'id_terlapor')->dropDownList($data, ['prompt' => '---Pilih---',
                'onChange' => 'var e = $(this).find("option:selected").text();var temp = e.split("-");$("#was16b-perihal").val("Pemberitahuan Usulan Untuk  Dijatuhi Hukuman Disiplin Berat terhadap Terlapor an. "+temp[1]);'], ['label' => '']);
          } else {
            $sql = (new \yii\db\Query())
                    ->select('v_riwayat_jabatan.peg_nip_baru, v_riwayat_jabatan.jabatan,terlapor.id_terlapor')
                    ->addSelect(["CONCAT(v_riwayat_jabatan.peg_nip_baru, ' - ', v_riwayat_jabatan.peg_nama) AS nama"])
                    ->from('was.v_riwayat_jabatan')
                    ->innerjoin('was.terlapor', 'v_riwayat_jabatan.id = terlapor.id_h_jabatan')
                    ->where(['terlapor.id_register' => $model->id_register])
                    ->all();

            $data = ArrayHelper::map($sql, 'id_terlapor', 'nama');

            echo $form->field($model, 'id_terlapor')->dropDownList($data, ['label' => '', 'disabled' => 'disabled']);
          }
          ?>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-12">
    <div class="col-md-8">
      <div class="form-group">
        <label class="control-label col-md-3">Nomor</label>
        <div class="col-md-4">
          <?php if ($model->isNewRecord) { ?>
            <div class="input-group">
              <span class="input-group-addon">ND-</span>
              <input class="form-control" type="text" id="no_was_16b" name="no_was_16b">
            </div>
          <?php } else { ?>
            <div class="input-group">
              <span class="input-group-addon"><?php echo substr($model->no_was_16b, 0, 3); ?></span>
              <input class="form-control" type="text" id="no_was_16b" name="no_was_16b" value="<?php echo substr($model->no_was_16b, 3); ?>">
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
          $form->field($model, 'tgl_was_16b')->widget(DateControl::className(), [
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
        <label class="control-label col-md-3">Sifat</label>
        <div class="col-md-9">	
          <?php
          $sql = (new \yii\db\Query())
                  ->select('kd_lookup_item, nm_lookup_item')
                  ->from('was.lookup_item')
                  ->where(['kd_lookup_group' => '01'])
                  ->andWhere(['kd_lookup_item' => '3'])
                  ->one();
//						$data = ArrayHelper::map($sql,'kd_lookup_item','nm_lookup_item');
//						echo $form->field($model, 'sifat_surat')->dropDownList($data,['label'=>'','readonly'=>true]);
          ?>
          <input type="hidden" value="<?php echo $sql['kd_lookup_item']; ?>" name="Was16b[sifat_surat]" class="form-control">
          <input type="text" value="<?php echo $sql['nm_lookup_item']; ?>" class="form-control" readonly=TRUE>

        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12" style="margin-top:10px;">
    <div class="col-md-8">
      <div class="form-group">
        <label class="control-label col-md-3">Lampiran</label>
        <div class="col-md-2">	
          <?php
          if ($model->isNewRecord) {
            echo MaskedInput::widget([
                'name' => 'Was16b[jml_lampiran]',
                'mask' => '9',
                'id' => 'jml_lampiran',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
          } else {
            echo MaskedInput::widget([
                'name' => 'Was16b[jml_lampiran]',
                'mask' => '9',
                'id' => 'jml_lampiran',
                'clientOptions' => ['repeat' => 10, 'greedy' => false],
                'value' => $model->jml_lampiran
            ]);
          }
          ?>
        </div>
        <!--<text class="control-label col-md-4">Lampiran</text>-->

      </div>
    </div>
    <!-- <div class="col-md-4">	
      <?php echo "Lampiran"; ?>
    </div> -->
  </div>
  <div class="col-md-12" style="margin-top:10px;">
    <div class="col-md-12">
      <div class="form-group">
        <label class="control-label col-md-2">Perihal</label>
        <div class="col-md-10">	
          <?php echo $form->field($model, 'perihal')->textarea(['rows' => 3]); ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="col-md-8">
      <div class="form-group">
        <label class="control-label col-md-3">Dari</label>
        <div class="col-md-9">	
          <?php
          $sql = (new \yii\db\Query())
                  ->select('id_jabatan_pejabat,jabatan')
                  ->from('was.v_pejabat_pimpinan')
                  ->where(['id_jabatan_pejabat' => 35])
                  ->one();
//						$data = ArrayHelper::map($sql,'id_jabatan_pejabat','jabatan');
//						echo $form->field($model, 'ttd_was_16b')->dropDownList($data, 
//                                ['label'=>'','readonly'=>true,'style'=>'width:350px']);
          ?>
          <input type="hidden" value="<?php echo $sql['id_jabatan_pejabat']; ?>" name="Was16b[ttd_was_16b]" class="form-control" >
          <input type="text" value="<?php echo $sql['jabatan']; ?>" class="form-control" readonly=TRUE>

        </div>



      </div>
    </div>
  </div>

  <div class="col-md-12" style="margin-top:10px;">
    <div class="col-md-8">
      <div class="form-group">
        <label class="control-label col-md-3">Kepada</label>
        <div class="col-md-9">	
          <?php
          $userQuery = [1, 2, 19, 35, 59, 72, 100, 133];

          $sql = (new \yii\db\Query())
                  ->select('id_jabatan_pejabat,jabatan')
                  ->from('was.v_pejabat_pimpinan')
                  ->where(['id_jabatan_pejabat' => $userQuery])
                  ->all();
          $data = ArrayHelper::map($sql, 'id_jabatan_pejabat', 'jabatan');
          echo $form->field($model, 'kpd_was_16b')->dropDownList($data, ['label' => '',]);
          ?>

        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12">
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
 
  <input id="was16b-ttd_peg_nik" type="hidden" value="<?php echo $model->ttd_peg_nik; ?>" name="Was16b[ttd_peg_nik]">
  <input id="was16b-ttd_id_jabatan" type="hidden" value="<?php echo $model->ttd_id_jabatan; ?>" name="Was16b[ttd_id_jabatan]">
  <div class="col-md-6">
    <div class="form-group">
      <label style="margin-top:18px;" class="control-label col-md-3">Nama</label>
      <div class="col-lg-9">
        <div class="form-group field-was16b-ttd_peg_nik">
          <div class="col-sm-12">

          </div>
          <div class="col-sm-12"></div>
          <div class="col-sm-12">
            <div class="help-block"></div>
          </div>
        </div>
        <div class="form-group field-was16b-ttd_peg_nama">
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
        <div class="form-group field-was16b-ttd_peg_nip">
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
        <div class="form-group field-was16b-ttd_peg_jabatan">
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
        <div class="form-group field-was16b-ttd_peg_inst_satker">
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
    <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
      <div class="form-group">
        <!--<label class="control-label col-md-2" style="margin-top:5px;">Tembusan</label>-->
        <div class="col-lg-10"> <span class="pull-left" style="margin-left: 15px;"> <a class="btn btn-primary" data-toggle="modal" data-target="#tembusan"><i class="glyphicon glyphicon-user"></i>Tambah Tembusan</a> </span> </div>
      </div>
    </div>
  </div>
  <div class="box-header with-border">
    <table id="table_tembusan" class="table table-bordered">
      <thead>
        <tr>
          <th>Tembusan</th>
          <th width=10%>Hapus</th>
        </tr>
      </thead>
      <tbody id="tbody_tembusan-was16b">
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
    <?php echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil-square-o"></i> Simpan' : '<i class="fa fa-pencil-square-o"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);
    if (!$model->isNewRecord) {
      echo " ".Html::a('<i class ="fa fa-times"></i> Hapus', ['/pengawasan/was16b/hapus', 'id' => $model->id_was_16b], ['id' => 'hapusWas16b', 'class' => 'btn btn-primary']);
    }
    ?>
  </div>
</div>
<?php ActiveForm::end(); ?>