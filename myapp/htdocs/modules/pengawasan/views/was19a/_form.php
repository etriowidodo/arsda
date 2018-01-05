<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was19a */
/* @var $form yii\widgets\ActiveForm */
?>
<script>
var url1='<?php echo  ($model->isNewRecord?Url::toRoute('was19a/create'):Url::toRoute('was19a/update')); ?>';
</script>
   
<div>
 <?php  $form = ActiveForm::begin([
        'id' => 'was19a-popup-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
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
        ]
    ]);  ?>
        
 
<?php /*echo Growl::widget([
    'type' => Growl::TYPE_SUCCESS,
    'icon' => 'glyphicon glyphicon-ok-sign',
    'title' => 'Note',
    'showSeparator' => true,
    'body' => 'This is a successful growling alert.'
]); */    ?>    
<div class="box box-primary" style="overflow: hidden;">
      <?php  
        
             $was_register = 0;
                  if ($model->isNewRecord) {
                                $session = Yii::$app->session;
                                $was_register = $session->get('was_register');
                            } else { ?>
                                 <?= $form->field($model, 'id_was_19a')->hiddenInput(['maxlength' => true,'readonly'=>true]) ?> 
                             <?php   $was_register = $model->id_register;
                            }
           
              
        
         
          $instansi = \app\modules\pengawasan\models\DugaanPelanggaran::find()->select(' a.inst_satkerkd,b.inst_nama')->from('was.dugaan_pelanggaran a')->join('inner join', 'kepegawaian.kp_inst_satker b', '(a.inst_satkerkd = b.inst_satkerkd)')->where("length(a.inst_satkerkd)= 2 and a.id_register=:id and b.is_active='1' ",[":id"=>$was_register])->asArray()->one();
         $model->inst_nama = $instansi['inst_nama'];
             $model->inst_satkerkd = $instansi['inst_satkerkd'];
        
          ?> <?= Html::hiddenInput('delete_tembusan', null, ['id' => 'delete_tembusan']); ?>
             <?= $form->field($model, 'id_register')->hiddenInput(['value'=>$was_register,'maxlength' => true]) ?>
        <?= $form->field($model, 'id_was_19a')->hiddenInput(['maxlength' => true]) ?>
             <?= $form->field($model, 'inst_satkerkd')->hiddenInput(['maxlength' => true,'readonly'=>true,'id'=>'was19a-inst_satkerkd']) ?>       
     <div class="col-md-12">
   <div class="col-md-8">
      <div class="form-group">
        <!--<label class="control-label col-md-3">WAS-1</label>-->
        <label class="control-label col-md-3">Pilih Terlapor</label>
     
        <div class="col-md-8">
           
            <?= $form->field($model, 'id_terlapor')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VTerlapor::find()->where("id_register =:id",[":id"=>$was_register])->all(),'id_terlapor','terlapor'),['prompt'=>'Pilih']) ?>
           
        </div>
      </div>  
   </div><div class="col-md-4">
       
   </div>
 
 
 </div>
    <div class="col-md-12">
   <div class="col-md-8">
      <div class="form-group">
        <!--<label class="control-label col-md-3">WAS-1</label>-->
        <label class="control-label col-md-3">Kejaksaan</label>
     
        <div class="col-md-8">
             <?= $form->field($model, 'inst_nama')->textInput(['maxlength' => true,'readonly'=>true,'id'=>'was19a-inst_nama']) ?>
           
        </div>
      </div>  
   </div><div class="col-md-4">
          <div class="col-lg-10"> <span class="pull-left" style="margin-left:-55px;"> <a class="btn btn-primary" data-toggle="modal" data-target="#p_kejaksaan"><i class="glyphicon glyphicon-user"></i> ...</a> </span> </div>
   </div>
 </div>
      <div class="col-md-12">
   <div class="col-md-6">
      <div class="form-group">
        <!--<label class="control-label col-md-3">WAS-1</label>-->
        <label class="control-label col-md-4">Nomor</label>
     
        <div class="col-md-7">
            <?= $form->field($model, 'no_was_19a')->textInput(['maxlength' => true]) ?>
           
        </div>
      </div>
   </div>
        <div class="col-md-6">
     <div class="form-group">
        <!--<label class="control-label col-md-3">WAS-1</label>-->
        <label class="control-label col-md-4">Tanggal</label>
     
        <div class="col-md-7">
          
             <?=            $form->field($model, 'tgl_was_19a')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                   
                    'ajaxConversion'=>false,
                    'displayFormat' => 'dd-MM-yyyy',
                    'options' => [
                         'id'=>'tgl_was_19a',
                        'pluginOptions' => [
                            
                            'autoclose' => true,
                             
                            
                        ]
                    ],
                    
                ]); ?> 
        </div>
     
   </div>
   </div>
 </div>
    
      <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">Sifat</label>
        <div class="col-md-8">

          <?= $form->field($model, 'sifat_surat')->dropDownList(ArrayHelper::map(app\models\LookupItem::find()->where("kd_lookup_group = '01' and kd_lookup_item = '3' ")->all(),'kd_lookup_item','nm_lookup_item'),['readonly'=>true]) ?>
        </div>
      </div>
    </div> <div class="col-md-6"></div>
  </div>
    
 <div class="col-md-12">
    <div class="col-md-6">
      <div class="form-group">
        <label class="control-label col-md-4">Jumlah Lampiran</label>
        <div class="col-md-4">
          <?= $form->field($model, 'jml_lampiran')->textInput() ?>
        </div>
        <label class="control-label col-md-3" style="text-align:left;margin-left:-16px;">Berkas</label>
      </div>
    </div>
    <div class="col-md-6">
      
    
    </div>
  </div>
    
       
 <div class="col-md-12">
    <div class="col-md-8">
      <div class="form-group">
        <label class="control-label col-md-3">Perihal</label>
        <div class="col-md-9">
          <?= $form->field($model, 'perihal')->textarea(['rows'=>5,'value'=>  app\modules\pengawasan\models\DugaanPelanggaran::find()->where('id_register = :id',[":id"=>$was_register])->one()->perihal]) ?>
        </div>
        
      </div>
    </div>
    <div class="col-md-4">
      
    
    </div>
  </div>
    
                <div class="col-md-12">
                <div class="col-md-6">

                    <div class="form-group">
                        <label class="control-label col-md-4">Kepada</label>
                        <div class="col-md-8">
                      

                            <?= $form->field($model, 'kpd_was_19a')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VPejabatPimpinan::find()->where("id_jabatan_pejabat IN (158,190,199)")->all(), 'id_jabatan_pejabat', 'jabatan'), ['prompt' => 'Pilih']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> <label class="control-label col-md-4">Dari</label>
                        <div class="col-md-8">
                            <?php
                            //  $query_sebab2 = app\models\LookupItem::find()->select('kd_lookup_item,nm_lookup_item')->where("kd_lookup_group = '07'")->all();
                            //$query_sebab=ArrayHelper::map($query_sebab2,'kd_lookup_item','nm_lookup_item');
                            $ttd_was2 = array("1" => "JAM WAS", "2" => "KAJATI");
                            ?>

                            <?= $form->field($model, 'ttd_was_19a')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VPejabatPimpinan::find()->where("id_jabatan_pejabat IN (158,190,35)")->all(), 'id_jabatan_pejabat', 'jabatan'), ['prompt' => 'Pilih']) ?>
                        </div>
                    </div>
                </div>
            </div>

              <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-4">Upload File</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'upload_file')->widget(FileInput::classname(), [

                                'options' => [
                                    'multiple' => false,
                                ],
                                'pluginOptions' => [
                                    'showPreview' => true,
//'uploadUrl' => Url::to(['/modules/pengawasan/upload']),
                                    'showUpload' => false,
//'uploadExtraData' => [
//'album_id' => 20,
//'cat_id' => 'Nature'
//],
//'maxFileCount' => 1
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-2">
                    <?php if (!$model->isNewRecord && !empty($model['upload_file'])) { ?>
                        <label class="control-label col-md-2"><?= Html::label($model['upload_file']); ?></label>
                    <?php } ?>
                </div>
            </div>
</div>
   
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);" class="col-md-12">
                        <div class="form-group">
                            <!--<label style="margin-top:5px;" class="col-md-2">Penandatangan</label>-->
                            <div class="col-lg-10"> <span class="pull-left"> <a data-target="#peg_tandatangan" data-toggle="modal" class="btn btn-primary"><i class="glyphicon glyphicon-user"></i>Pilih Penandatangan</a> </span> </div>
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
                    <?php //echo $form->field($model, 'ttd_peg_nik')->hiddenInput() ?>
                    <?php //echo $form->field($model, 'ttd_id_jabatan')->hiddenInput() ?>
                    <input type="hidden" value="<?php echo $model->ttd_peg_nik ?>" name="Was19a[ttd_peg_nik]" class="form-control" id="was19a-ttd_peg_nik">
                    <input type="hidden" value="<?php echo $model->ttd_id_jabatan ?>" name="Was19a[ttd_id_jabatan]" class="form-control" id="was19a-ttd_id_jabatan">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="margin-top:18px;" class="control-label col-md-3">Nama</label>
                            <div class="col-lg-9">
                                <div class="form-group field-was19a-ttd_peg_nik">
                                    <div class="col-sm-12">

                                    </div>
                                    <!--<div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>-->
                                </div>
                                <div class="form-group field-was19a-ttd_peg_nama">
                                    <div class="col-sm-12">

                                        <?= $form->field($model, 'ttd_peg_nama')->textInput(['class' => 'form-control']) ?>
                                    </div>
                                    <!--<div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">NIP</label>
                            <div class="col-lg-9">
                                <div class="form-group field-was19a-ttd_peg_nip">
                                    <div class="col-sm-12">
                                        <?= $form->field($model, 'ttd_peg_nip')->textInput(['class' => 'form-control']) ?>
                                    </div>
                                    <!--<div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>

                    </div>
                    <div style="margin-top:15px;" class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-3">Pangkat</label>
                            <div class="col-lg-9">
                                <div class="form-group field-was19a-ttd_peg_jabatan">
                                    <div class="col-sm-12">
                                        <?= $form->field($model, 'ttd_peg_pangkat')->textInput(['class' => 'form-control']) ?>
                                    </div>
                                    <!--<div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jabatan</label>
                            <div class="col-lg-9">
                                <div class="form-group field-was19a-ttd_peg_inst_satker">
                                    <div class="col-sm-12">
                                        <?= $form->field($model, 'ttd_peg_jabatan')->textInput(['class' => 'form-control']) ?>
                                    </div>
                                    <!--<div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9">
                                <div class="form-group field-was19a-ttd_peg_nrp">
                                    <div class="col-sm-12">

                                    </div>
                                    <div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-3">
                                <div class="form-group field-was2-ttd_peg_unitkerja">
                                    <div class="col-sm-12">

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

            <div class="panel box box-primary">
                <div style="border-color: #c7c7c7;" class="box-header with-border">
 
                    <div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
                        <div class="form-group">
                            <!--<label class="col-md-2" style="margin-top:5px;">Tembusan</label>-->
                            <div class="col-lg-10"> <span class="pull-left"> <a class="btn btn-primary" data-toggle="modal" data-target="#tembusan"><i class="glyphicon glyphicon-user"></i>Tambah Tembusan</a> </span> </div>
                        </div>
                    </div>
               </div>
                             <!--<label class="control-label col-md-2"></label>-->

                            <div class="box-header with-border">

                                <table id="table_tembusan-was19a" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tembusan</th>
                                            <th width=10%>Hapus</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbody_tembusan-was19a">
                                        <?php
                                        if (!$model->isNewRecord) {

                                            foreach ($modelTembusan as $modelTembusan2) {
                                                //       echo $modelTembusan2['id_pejabat_tembusan'];
                                                ?><tr id="tembusan-<?php echo $modelTembusan2['id_pejabat_tembusan']; ?>">
                                                    <td><input type="text" class="form-control" name="jabatan[]" readonly="true" value="<?php
                                                        $modelPejabat = app\modules\pengawasan\models\VPejabatTembusan::find()->where('id_pejabat_tembusan = :id', [':id' => $modelTembusan2['id_pejabat_tembusan']])->asArray()->one();
                                                        echo $modelPejabat['jabatan'];
                                                        ?>"> </td><input type="hidden" class="form-control" name="id_jabatanupdate[]" readonly="true" value="<?php echo $modelTembusan2['id_pejabat_tembusan']; ?>"> 
                                            <td><button onClick="removeRowUpdate('tembusan-<?php echo $modelTembusan2['id_pejabat_tembusan']; ?>')" class="btn btn-primary" type="button">Hapus</button></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
            </div>

   

   

   <div class="box-footer" style="margin:0px;padding:0px;background:none;">
  <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'was19a-submit']) ?>
  <?= Html::Button('Kembali', ['class' => 'btn btn-primary','data-dismiss'=>"modal"]) ?>

</div>

    <?php ActiveForm::end(); ?>

</div>
