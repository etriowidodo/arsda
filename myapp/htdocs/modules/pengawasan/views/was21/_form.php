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
use kartik\builder\Form;
/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was21 */
/* @var $form yii\widgets\ActiveForm */
?>
<script>

</script>
<?php 
$this->registerJs("
    $(document).ready(function(){
  
          $('#tambah_tanggapan_was21').click(function(){
         
          $('#tbody_tanggapan-was21').append(
		'<tr id=\"tanggapan\"><td><textarea rows=\"3\" name=\"tanggapan[]\" class=\"form-control\" id=\"tanggapan_was21\"></textarea></td><td>" .trim(preg_replace('/\s+/', ' ',  Html::checkBox('remove', false, array('class'=>'removecheck'))))."</td></tr>');
                    
          

      }); 
      
 $('#tambah_alasan_was21').click(function(){
         
          $('#tbody_alasan-was21').append(
		'<tr id=\"alasan\"><td><textarea rows=\"3\" name=\"alasan[]\" class=\"form-control\" id=\"alasan_was21\"></textarea></td><td>" .trim(preg_replace('/\s+/', ' ',  Html::checkBox('remove', false, array('class'=>'removecheck'))))."</td></tr>');
                    
          

      }); 
      
 $('#tambah_kesimpulan_was21').click(function(){
         
          $('#tbody_kesimpulan-was21').append(
		'<tr id=\"kesimpulan\"><td><textarea rows=\"3\" name=\"kesimpulan[]\" class=\"form-control\" id=\"kesimpulan_was21\"></textarea></td><td>" .trim(preg_replace('/\s+/', ' ',  Html::checkBox('remove', false, array('class'=>'removecheck'))))."</td></tr>');
                    
          

      });
      

      }); ", \yii\web\View::POS_END);
?>
<div>

 <?php $form = ActiveForm::begin([
        'id' => 'was21-popup-form',
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
    ]); ?>
   <div class="box box-primary" style="overflow: hidden;">    
       <div id='test1'></div>
  <?php  
     
           $was_register = 0;
                  if ($model->isNewRecord) {
                                $session = Yii::$app->session;
                                $was_register = $session->get('was_register');
                            } else { ?>
                                 <?= $form->field($model, 'id_was_21')->hiddenInput(['maxlength' => true,'readonly'=>true]) ?> 
                             <?php   $was_register = $model->id_register;
                            }
           
              
        
         
          $instansi = \app\modules\pengawasan\models\DugaanPelanggaran::find()->select(' a.inst_satkerkd,b.inst_nama')->from('was.dugaan_pelanggaran a')->join('inner join', 'kepegawaian.kp_inst_satker b', '(a.inst_satkerkd = b.inst_satkerkd)')->where("length(a.inst_satkerkd)= 2 and a.id_register=:id and b.is_active='1' ",[":id"=>$was_register])->asArray()->one();
         $model->inst_nama = $instansi['inst_nama'];
          $model->inst_satkerkd = $instansi['inst_satkerkd']; ?>
        
          <?= Html::hiddenInput('delete_tembusan', null, ['id' => 'delete_tembusan']); ?>
             <?= $form->field($model, 'id_register')->hiddenInput(['value'=>$was_register,'maxlength' => true]) ?>
             <?= $form->field($model, 'inst_satkerkd')->hiddenInput(['maxlength' => true,'readonly'=>true,'id'=>'was21-inst_satkerkd']) ?> 
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
             <?= $form->field($model, 'inst_nama')->textInput(['maxlength' => true,'readonly'=>true,'id'=>'was21-inst_nama']) ?>
           
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
            <?= $form->field($model, 'no_was_21')->textInput(['maxlength' => true]) ?>
           
        </div>
      </div>
   </div>
           <div class="col-md-6">
     <div class="form-group">
        <!--<label class="control-label col-md-3">WAS-1</label>-->
        <label class="control-label col-md-4">Tanggal</label>
     
        <div class="col-md-7">
          
             <?=            $form->field($model, 'tgl_was_21')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                   
                    'ajaxConversion'=>false,
                    'displayFormat' => 'dd-MM-yyyy',
                    'options' => [
                         'id'=>'tgl_was_21',
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
          <?= $form->field($model, 'perihal')->textarea(['rows'=>5]) ?>
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
                      

                            <?= $form->field($model, 'kpd_was_21')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VPejabatPimpinan::find()->where("id_jabatan_pejabat IN (1,198,100)")->all(), 'id_jabatan_pejabat', 'jabatan'), ['prompt' => 'Pilih']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> <label class="control-label col-md-4">Dari</label>
                        <div class="col-md-8">
                       

                            <?= $form->field($model, 'ttd_was_21')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VPejabatPimpinan::find()->where("id_jabatan_pejabat IN (1,198,100)")->all(), 'id_jabatan_pejabat', 'jabatan'), ['prompt' => 'Pilih']) ?>
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
                    <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <!--<label class="col-md-2" style="margin-top:5px;">Analisa</label>-->
                        <span class="pull-left">
                            <button class="btn btn-primary" type="button" id="tambah_alasan_was21"><i class="fa fa-plus"></i> Tambah </button>
                        </span> <span class="pull-right">
                            <button class="removecheckbutton btn btn-primary" type="button" id="hapus_tanggapan_was21"><i class="fa fa-minus"></i> Hapus </button>
                        </span> </div>
                    <!--<label class="control-label col-md-2"></label>-->
                    <div class="box-header with-border">
                        <table id="table_alasan-was21" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Alasan Keberatan Terlapor</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_alasan-was21">
                                <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelAlasan as $dataAlasan) {
                                        ?>
                                        <tr id="analisa">
                                            <td><textarea rows="3" name="alasan[]" class="form-control" id="analisa_was21"><?php echo $dataAlasan['isi'] ?></textarea></td>
                                            <td><input type="checkbox" class="removecheck" value="1" name="remove"></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <!--<label class="col-md-2" style="margin-top:5px;">Analisa</label>-->
                        <span class="pull-left">
                            <button class="btn btn-primary" type="button" id="tambah_tanggapan_was21"><i class="fa fa-plus"></i> Tambah </button>
                        </span> <span class="pull-right">
                            <button class="removecheckbutton btn btn-primary" type="button" id="hapus_tanggapan_was21"><i class="fa fa-minus"></i> Hapus </button>
                        </span> </div>
                    <!--<label class="control-label col-md-2"></label>-->
                    <div class="box-header with-border">
                        <table id="table_tanggapan-was21" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggapan atas keberatan Terlapor</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_tanggapan-was21">
                                <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelTanggapan as $dataTanggapan) {
                                        ?>
                                        <tr id="analisa">
                                            <td><textarea rows="3" name="tanggapan[]" class="form-control" id="tanggapan_was21"><?php echo $dataTanggapan['isi'] ?></textarea></td>
                                            <td><input type="checkbox" class="removecheck" value="1" name="remove"></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                        <div class="box box-primary" style="overflow: hidden;">
                    <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <!--<label class="col-md-2" style="margin-top:5px;">Analisa</label>-->
                        <span class="pull-left">
                            <button class="btn btn-primary" type="button" id="tambah_kesimpulan_was21"><i class="fa fa-plus"></i> Tambah </button>
                        </span> <span class="pull-right">
                            <button class="removecheckbutton btn btn-primary" type="button" id="hapus_kesimpulan_was21"><i class="fa fa-minus"></i> Hapus </button>
                        </span> </div>
                    <!--<label class="control-label col-md-2"></label>-->
                    <div class="box-header with-border">
                        <table id="table_kesimpulan-was21" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kesimpulan Berdasarkan keberatan dan tanggapan atas keberatan Terlapor</th>
                                    <th width=10%>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_kesimpulan-was21">
                                <?php
                                if (!$model->isNewRecord) {
                                    foreach ($modelKesimpulan as $dataKesimpulan) {
                                        ?>
                                        <tr id="kesimpulan">
                                            <td><textarea rows="3" name="kesimpulan[]" class="form-control" id="kesimpulan_was21"><?php echo $dataKesimpulan['isi'] ?></textarea></td>
                                            <td><input type="checkbox" class="removecheck" value="1" name="remove"></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
      <div class="box box-primary" style="overflow: hidden;">  
           <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-4">PENDAPAT</label>
                        <div class="col-md-8">
    <?php 
    echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
   // 'inputContainer' => ['class'=>'col-sm-5'],
    'options' =>['class'=>'col-sm-8'],
    'attributes' => [
                'pendapat' => [
                  
                            'label'=>false, 
                            'type' => Form::INPUT_RADIO_LIST,
                            'items'=>[true=>'Setuju', false=>'Tidak setuju'], 
                            'options' => [
                                
                                'options' => [
                                    
                                ],
                            ],
                        
                   
                ],
            ]
]);
    
    
    ?> </div>
                    </div>
                </div> <div class="col-md-6"></div>
           </div>
          
          
           <div class="col-md-12">


                <label class="control-label col-md-2" style="margin-right: 20px;">Saran</label>
                <div class="col-md-9">
                    <?php
                    $options = [
                        'item' => function($index, $label, $name, $checked, $value) {

                            // check if the radio button is already selected
                            $checked = ($checked) ? 'checked' : '';

                            $return = '<label class="radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" ' . $checked . '>';
                            $return .= $label;
                            $return .= '</label>';

                            return $return;
                        }
                    ];
                   
                    $modelhasil = new \app\modules\pengawasan\models\SpRTingkatphd;
                    $query_hasil2 = $modelhasil->searchListSaran();
                    
                    $query_hasil = ArrayHelper::map($query_hasil2, 'tingkat_kd', 'hukdis');
                    ?>
                    <?=  $form->field($model, 'tingkat_kd')->dropDownList($query_hasil, ['prompt' => 'Pilih']) ?>
                </div>



            </div>
          
             <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-8">KEPUTUSAN JAKSA AGUNG R.I</label>
                        <div class="col-md-8">
    <?php 
    echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
   // 'inputContainer' => ['class'=>'col-sm-5'],
    'options' =>['class'=>'col-sm-8'],
    'attributes' => [
                'kputusan_ja' => [
                  
                            'label'=>false, 
                            'type' => Form::INPUT_RADIO_LIST,
                            'items'=>[true=>'Setuju', false=>'Tidak setuju'], 
                            'options' => [
                               
                                'options' => [
                                    
                                ],
                            ],
                        
                   
                ],
            ]
]);
    
    
    ?> </div>
                    </div>
                </div> <div class="col-md-6"></div>
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
                    <input type="hidden" value="<?php echo $model->ttd_peg_nik ?>" name="Was21[ttd_peg_nik]" class="form-control" id="was21-ttd_peg_nik">
                    <input type="hidden" value="<?php echo $model->ttd_id_jabatan ?>" name="Was21[ttd_id_jabatan]" class="form-control" id="was21-ttd_id_jabatan">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="margin-top:18px;" class="control-label col-md-3">Nama</label>
                            <div class="col-lg-9">
                                <div class="form-group field-was21-ttd_peg_nik">
                                    <div class="col-sm-12">

                                    </div>
                                    <!--<div class="col-sm-12"></div>
                                    <div class="col-sm-12">
                                        <div class="help-block"></div>
                                    </div>-->
                                </div>
                                <div class="form-group field-was21-ttd_peg_nama">
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
                                <div class="form-group field-was21-ttd_peg_nip">
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
                                <div class="form-group field-was21-ttd_peg_jabatan">
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
                                <div class="form-group field-was21-ttd_peg_inst_satker">
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
                                <div class="form-group field-was21-ttd_peg_nrp">
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

                                <table id="table_tembusan-was21" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tembusan</th>
                                            <th width=10%>Hapus</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tbody_tembusan-was21">
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
   <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'was21-submit']) ?>
  <?= Html::Button('Kembali', ['class' => 'btn btn-primary','data-dismiss'=>"modal"]) ?>

</div>

    <?php ActiveForm::end(); ?>

</div>
