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
$script= <<<JS
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
<?php
$form = ActiveForm::begin([
      'options' => ['enctype' => 'multipart/form-data'],
      'id' => 'was16d-form',
      'type' => ActiveForm::TYPE_HORIZONTAL,
      'enableAjaxValidation' => false,
      'action' => (empty($model['id_was_16d']) ? Url::toRoute('was16d/create') : Url::toRoute('was16d/update2?id='.$model["id_was_16d"].'')),
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
              $inst_nama=KpInstSatker::findOne(['inst_satkerkd'=>$model->inst_satkerkd]);
              ?>
              <input id="inst_satkerkd" class="form-control" type="hidden" readonly="true" name="inst_satkerkd" value="<?=$model->inst_satkerkd;?>">
              <input id="inst_nama" class="form-control" type="text" readonly="true" name="inst_nama" value="<?=$inst_nama->inst_nama;?>">
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
          <label class="control-label col-md-3">Pilih Terlapor</label>
          <div class="col-md-9">	
            <?php
            if ($model->isNewRecord) {
              $sql = (new \yii\db\Query())
              ->select('v_riwayat_jabatan.peg_nama, v_riwayat_jabatan.peg_nip_baru, v_riwayat_jabatan.jabatan,terlapor.id_terlapor')
              ->addSelect(["CONCAT(v_riwayat_jabatan.peg_nip_baru, ' - ', v_riwayat_jabatan.peg_nama) AS nama"])
              ->from('was.v_riwayat_jabatan')
              ->innerjoin('was.terlapor', 'v_riwayat_jabatan.id = terlapor.id_h_jabatan')
              ->where(['terlapor.id_register' => $model->id_register])
              ->andWhere(['not in', 'terlapor.id_terlapor', (new \yii\db\Query())->select('id_terlapor')->from('was.was_16d')->where(['was_16d.id_register' => $model->id_register])->andWhere('flag != :del', ['del'=>'3'])])
              ->all();

              $data = ArrayHelper::map($sql, 'id_terlapor', 'nama');

              echo $form->field($model, 'id_terlapor')->dropDownList($data,
                ['prompt' => '---Pilih---',
                 'onchange'=>'
                    var e = $(this).find("option:selected").text();
                    var temp = e.split("-");
                    $("#was16d-perihal").val("Pemberitahuan Usulan Untuk Dijatuhi Hukuman Disiplin Berat terhadap Terlapor Atas Nama"+temp[1]);
                  '
                ],
                ['label'=>'']);
            }else{
              $sql = (new \yii\db\Query())
              ->select('v_riwayat_jabatan.peg_nama, v_riwayat_jabatan.peg_nip_baru, v_riwayat_jabatan.jabatan,terlapor.id_terlapor')
              ->addSelect(["CONCAT(v_riwayat_jabatan.peg_nip_baru, ' - ', v_riwayat_jabatan.peg_nama) AS nama"])
              ->from('was.v_riwayat_jabatan')
              ->innerjoin('was.terlapor', 'v_riwayat_jabatan.id = terlapor.id_h_jabatan')
              ->where(['terlapor.id_register' => $model->id_register])
              ->all();

              $data = ArrayHelper::map($sql, 'id_terlapor', 'nama');

              echo $form->field($model, 'id_terlapor')->dropDownList($data,['label'=>'', 'disabled'=>'disabled']);
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
                <input class="form-control" type="text" id="no_was_16d" name="no_was_16d">
              </div>
            <?php } else { ?>
              <div class="input-group">
                <span class="input-group-addon"><?php echo substr($model->no_was_16d, 0, 3); ?></span>
                <input class="form-control" type="text" id="no_was_16d" name="no_was_16d" value="<?php echo substr($model->no_was_16d, 3); ?>">
              </div>
            <?php } ?>
          </div>
          <!--<div class="col-md-4">
            <input id="no_was_16d" class="form-control" type="text" readonly="true" value="ND-" style="text-align:right;width:50px" name="no_was_16d">
          </div>
          <div class="col-md-4">
            <?php //echo $form->field($model, 'no_was_16d')->textInput(['maxlength' => true,'style'=>'margin-left:-80px']) ?>
          </div>-->
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label class="control-label col-md-4">Tanggal</label>
          <div class="col-md-8">
            <?= $form->field($model, 'tgl_was_16d')->widget(DateControl::className(),[
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
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label col-md-3">Sifat</label>
          <div class="col-md-9">	
            <?php
            /*$sql = (new \yii\db\Query())
                    ->select('kd_lookup_item, nm_lookup_item')
                    ->from('was.lookup_item')
                    ->where(['kd_lookup_group' => '01'])
                    ->andWhere(['kd_lookup_item'=>'3'])
                    ->all();
            $data = ArrayHelper::map($sql,'kd_lookup_item','nm_lookup_item');
            echo $form->field($model, 'sifat_surat')->dropDownList($data,['label'=>'','readonly'=>true]);*/
            $data = LookupItem::find()->where("kd_lookup_group='01' and kd_lookup_item='3'")->one();
            ?>
            <input id="kd_lookup_item" class="form-control" type="hidden" readonly="true" name="kd_lookup_item" value="<?=$data->kd_lookup_item;?>">
            <input id="nm_lookup_item" class="form-control" type="text" readonly="true" name="nm_lookup_item" value="<?=$data->nm_lookup_item;?>">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12" style="margin-top:10px;">
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label col-md-3">Lampiran</label>
          <div class="col-md-2">	
            <?php //echo $form->field($model, 'jml_lampiran')->textInput(['maxlength' => true]); 
            if($model->isNewRecord){
              echo MaskedInput::widget([
                'name' => 'jml_lampiran',
                'mask' => '9',
                'id' => 'jml_lampiran',
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
              ]);
            }else{
              echo MaskedInput::widget([
                'name' => 'jml_lampiran',
                'mask' => '9',
                'id' => 'jml_lampiran',
                'clientOptions' => ['repeat' => 10, 'greedy' => false],
                'value'=>$model->jml_lampiran
              ]);
            }
            ?>
          </div>
        </div>
      </div>
      <!-- <text class="control-label col-md-4">Lampiran</text> -->
    </div>
    <div class="col-md-12" style="margin-top:10px;">
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label col-md-3">Perihal</label>
          <div class="col-md-9">	
            <?php echo $form->field($model, 'perihal')->textarea(['rows' => 3,'style'=>'width:637px']);?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label col-md-3">Kepada</label>
          <div class="col-md-9">	
            <?php
            /*$sql = (new \yii\db\Query())
                    ->select('id_jabatan_pejabat,jabatan')
                    ->from('was.v_pejabat_pimpinan')
                    ->where(['id_jabatan_pejabat' => 35])
                    ->all();
            $data = ArrayHelper::map($sql,'id_jabatan_pejabat','jabatan');
            echo $form->field($model, 'kpd_was_16d')->dropDownList($data, 
              ['label'=>'','style'=>'width:350px']);*/
            $data = VPejabatPimpinan::find()->where('id_jabatan_pejabat=35')->one();
            ?>
            <input id="id_jabatan_pejabat" class="form-control" type="hidden" readonly="true" name="id_jabatan_pejabat" value="<?=$data->id_jabatan_pejabat;?>">
            <input id="jabatan" class="form-control" type="text" readonly="true" name="jabatan" value="<?=$data->jabatan;?>">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12" style="margin-top:10px;">
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label col-md-3">Dari</label>
          <div class="col-md-9">	
            <?php
            $sql = (new \yii\db\Query())
                    ->select('id_jabatan_pejabat,jabatan')
                    ->from('was.v_pejabat_pimpinan')
                    ->all();
            $data = ArrayHelper::map($sql,'id_jabatan_pejabat','jabatan');
            echo $form->field($model, 'ttd_was_16d')->dropDownList($data,['label'=>'']);
            ?>
          </div>
        </div>
      </div>
    </div>
		
    <div class="col-md-12">
      <div class="col-md-8">
        <div class="form-group">
          <label class="control-label col-md-3">Batas Pengajuan</label>
          <div class="col-md-9">	
            <?php
            $sql = (new \yii\db\Query())
                    ->select('kd_lookup_item, nm_lookup_item')
                    ->from('was.lookup_item')
                    ->where(['kd_lookup_group' => '16'])
                    ->all();
            $data = ArrayHelper::map($sql,'kd_lookup_item','nm_lookup_item');
            echo $form->field($model, 'batas_waktu')->dropDownList($data, ['prompt' => '---Pilih---'], ['label'=>'']);
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
                    'options'=>[
                      'multiple'=>false,
                    ],
                    'pluginOptions' => [
                      'showPreview'=>true, 
                      'showUpload' => false,
                    ]
            ]); ?>
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
      <span class="pull-left"> 
        <a data-target="#peg_tandatangan" data-toggle="modal" class="btn btn-primary">
          <i class="fa fa-user-plus"></i> Tambah Penandatangan
        </a> 
      </span>
    </div>
    <?php  
    if(!$model->isNewRecord){
            $searchModel2 = new \app\models\KpPegawaiSearch();
            $modelKepegawaian = $searchModel2->searchPegawaiTtd($model->ttd_peg_nik,$model->ttd_id_jabatan);
            $model->ttd_peg_nama = $modelKepegawaian['peg_nama'];
            $model->ttd_peg_nip = (empty($modelKepegawaian['peg_nip_baru']) ? $modelKepegawaian['peg_nip']:$modelKepegawaian['peg_nip_baru']);
            $model->ttd_peg_pangkat = $modelKepegawaian['gol_pangkat'];
            $model->ttd_peg_jabatan = $modelKepegawaian['jabatan'];
    } 
    ?>
    
    <input id="was16d-ttd_peg_nik" class="form-control" type="hidden" name="Was16d[ttd_peg_nik]" value="<?php echo $model->ttd_peg_nik; ?>">
    <input id="was16d-ttd_id_jabatan" class="form-control" type="hidden" name="Was16d[ttd_id_jabatan]" value="<?php echo $model->ttd_id_jabatan; ?>">
    <div class="col-md-6">
      <div class="form-group">
        <label style="margin-top:18px;" class="control-label col-md-3">Nama</label>
        <div class="col-lg-9">
          <div class="form-group field-was16d-ttd_peg_nik">
            <div class="col-sm-12">

            </div>
            <div class="col-sm-12"></div>
            <div class="col-sm-12">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="form-group field-was16d-ttd_peg_nama">
            <div class="col-sm-12">

               <?= $form->field($model, 'ttd_peg_nama')->textInput(['class' => 'form-control','readonly'=>true]) ?>
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
          <div class="form-group field-was16d-ttd_peg_nip">
            <div class="col-sm-12">
               <?= $form->field($model, 'ttd_peg_nip')->textInput(['class' => 'form-control','readonly'=>true]) ?>
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
          <div class="form-group field-was16d-ttd_peg_jabatan">
            <div class="col-sm-12">
              <?= $form->field($model, 'ttd_peg_pangkat')->textInput(['class' => 'form-control','readonly'=>true]) ?>
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
          <div class="form-group field-was16d-ttd_peg_inst_satker">
            <div class="col-sm-12">
               <?= $form->field($model, 'ttd_peg_jabatan')->textInput(['class' => 'form-control','readonly'=>true]) ?>
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
      <span class="pull-left"> 
        <a class="btn btn-primary" data-toggle="modal" data-target="#tembusan">
          <i class="fa fa-user-plus"></i> Tambah Tembusan
        </a>
      </span>
    </div>
    <table id="table_tembusan" class="table table-bordered">
      <thead>
        <tr>
          <th>Tembusan</th>
          <th width=10%>Hapus</th>
        </tr>
      </thead>
      <tbody id="tbody_tembusan-was16d">
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
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div style="margin:0px;padding:0px;background:none;" class="box-footer">
  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil-square-o"></i> Simpan' : '<i class="fa fa-pencil-square-o"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
  </div>
</div>

    <?php ActiveForm::end(); ?>