<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use kartik\widgets\Select2;
use yii\db\Query;
use yii\db\Command;

/* @var $this yii\web\View */
/* @var $model app\models\Was2 */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $this->registerJs("
    $(document).ready(function(){
         
    $('#addtembusan').click(function(){
        // alert('ss');
        $('.for_tembusan').append('<div class=\"col-sm-7\" style=\"margin-bottom: 15px;\"><div class=\"col-sm-1\"><input type=\"checkbox\" value=\"0\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\" class=\"no_urut\" readonly></div><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" id=\"pejabat\" name=\"pejabat[]\"></div></div>');
        i = 0;
    $('.for_tembusan').find('.col-sm-7').each(function () {

        i++;
        $(this).addClass('tembusan'+i);
        $(this).find('.cekbok').val(i);
    });
// alert(i);
    });
    $('#hapus_tembusan').click(function(){
        var cek = $('.cekbok:checked').length;
         var checkValues = $('.cekbok:checked').map(function()
            {
                return $(this).val();
            }).get();
                for (var i = 0; i < cek; i++) {
                    $('.tembusan'+checkValues[i]).remove();
                };
                                
    });

    $('#cetak').click(function(){
          $('#print').val('1');
        });

        $('#simpan').click(function(){
          $('#print').val('0');
        });

}); ", \yii\web\View::POS_END);
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'was2-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ],
                    'options' => [
                        'enctype' => 'multipart/form-data',
                    ]
        ]);
        ?>
        <div class="box box-primary">

            <?php
            // $was_register = 0;
            // $searchModel = new \app\modules\pengawasan\models\Was1Search();
            // if ($model->isNewRecord) {
            //     $session = Yii::$app->session;
            //     $was_register = $session->get('was_register');
            // } else {
            //     $was_register = $model->no_register;
            // }
            // $no_register = $searchModel->searchRegister($was_register);

            // $model->no_register = $no_register->no_register;
            // $model->no_register = $no_register->no_register;

            // $data_satker = $searchModel->searchSatker($was_register);
            // $model->inst_satkerkd = $data_satker['inst_satkerkd'];
            // $model->inst_nama = $data_satker['inst_nama'];
            ?>
            <?= Html::hiddenInput('delete_tembusan', null, ['id' => 'delete_tembusan']); ?>
            <?= $form->field($model, 'id_was2')->hiddenInput(['maxlength' => true]) ?>
            <?php //echo $_SERVER['REMOTE_ADDR'] ?>
            <?php //echo $form->field($model, 'inst_satkerkd')->hiddenInput(['maxlength' => true]) ?>
            
            <input type="hidden" value="<?php echo $model->no_register ?>" name="Was2[no_register]" class="form-control" id="was2-no_register">
            <div class="col-md-12">
                <div class="col-md-7">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">#WAS-2</label> -->
                        <label class="control-label col-md-4">No. Surat</label>
                        <div class="col-md-8">

                            <?= $form->field($model, 'was2_no_surat')->textInput() ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="text-align:left;">Tanggal</label>
                        <div class="col-md-4">
                    <?php
                      $connection = \Yii::$app->db;
                      $sql_level2 = "select was1_tgl_surat from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3'  ";
                      $result_sql_level2 = $connection->createCommand($sql_level2)->queryOne();
                      $batas=$result_sql_level2['was1_tgl_surat'];
          //          }

                         echo $form->field($model, 'was2_tanggal')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    
                                    'pluginOptions' => [
                                    'startDate' => date("d-m-Y",strtotime($batas)),
                                    // 'startDate' =>  $modelLapdu[0]['tanggal_surat_diterima'],
                                    // 'startDate' => '-17y',
                                    'autoclose' => true,
                                    ]
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>


            
            
              

            <div class="col-md-12">
             <div class="col-md-7">
              <div class="form-group">
                        <label class="control-label col-md-4">Ditujukan Kepada</label>
                        <div class="col-md-8">
                           <!--  <select id="was2-id_kepada_was2" class="form-control" name="Was2[id_kepada_was2]">
                                <option value="2">JAKSA AGUNG MUDA TINDAK PIDANA UMUM </option>
                                <option value="19">JAKSA AGUNG MUDA TINDAK PIDANA KHUSUS </option>
                                <option value="59">JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA </option>
                                <option value="72">JAKSA AGUNG MUDA INTELIJEN </option>
                                <option value="100">JAKSA AGUNG MUDA PEMBINAAN </option>
                                <option value="147">KEPALA PUSAT PENELITIAN DAN PENGEMBANGAN </option>
                            </select> -->
                             <select id="was2-id_kepada_was2" class="form-control" name="Was2[id_kepada_was2]" style="margin-bottom:15px">
                                <?php
                                $connection = \Yii::$app->db;   
                                
                                $wil = "select * from was.v_pejabat_pimpinan where unitkerja_kd in ('1.1','1.2','1.3','1.4','1.5','1.8') order by id_jabatan_pejabat";
                                $wilayah = $connection->createCommand($wil)->queryAll();
                                
                                foreach ($wilayah as $key) {
                                  echo "<option value='".$key['id_jabatan_pejabat']."' ".($model->id_kepada_was2 == $key['id_jabatan_pejabat'] ? 'selected':'' ).">".$key['jabatan']."</option>";
                                }
                                ?>
                            </select>
                        </div>
              </div>
             </div>   

                <!-- <div class="col-md-7">
                    <div class="form-group">
                        <label class="control-label col-md-4">Ditujukan Kepada</label>
                        <div class="col-md-8">
                            <?php
                               // $kpd_was2 = array(); 
                            ?>
                            <?//= $form->field($model, 'id_kepada_was2')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VPejabatPimpinan::find()->where("unitkerja_kd in ('1.1','1.2','1.3','1.4','1.5','1.8')")->all(), 'id_jabatan_pejabat', 'jabatan') ) ?>

                        </div>
                    </div>
                </div> -->
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Dari</label>
                        <div class="col-md-8">
                            <?php
//  $query_sebab2 = app\models\LookupItem::find()->select('kd_lookup_item,nm_lookup_item')->where("kd_lookup_group = '07'")->all();
// $query_sebab=ArrayHelper::map($query_sebab2,'kd_lookup_item','nm_lookup_item');
//                             $ttd_was2 = array("1" => "JAM WAS", "2" => "WAS", "3" => "PEMERIKSA");
                            $var_array=['asadad','asasdasd','asdadasd']
                            ?>
                            <?//= $form->field($model, 'id_dari_was2')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VPejabatPimpinan::find()->where("bidang ='PENGAWASAN'")->all(), 'id_jabatan_pejabat', 'jabatan'), ['prompt' => 'Pilih']) ?>
                            <?= $form->field($model, 'id_dari_was2')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VPejabatPimpinan::find()->where("unitkerja_kd in ('1.6')")->all(), 'id_jabatan_pejabat', 'jabatan')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-7">
                    <div class="form-group">
                        <label class="control-label col-md-4" >Perihal</label>
                        <div class="col-md-8">
						<?php if (!$model->isNewRecord) { 
                             echo $form->field($model, 'was2_perihal')->textArea(['row' => 3]) ;
						}else{
							 echo $form->field($model, 'was2_perihal')->textArea(['value'=>$modelLapdu[0]['perihal_lapdu']]);
						}?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Lampiran</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'was2_lampiran')->textInput() ?>
                           
                        </div> <!-- <label class="control-label col-md-4" style="text-align:left;margin-left:-16px;">Berkas</label> -->
                    </div>
                </div>

            </div>

            <div class="col-md-12">

                <fieldset class="group-border">
                    <legend class="group-border">Penandatangan</legend>
					
					<!-- <div class="col-md-10">
                  <div class="form-group">
					 <label class="control-label col-md-1" style="margin-left: -2px">Status</label>
                  <div class="col-md-2" style="margin-left: 0px">
                          <?php
                         /*  $status=['-','AN','PLH','PLT'];
                          echo  $form->field($model, 'status_penandatangan')->widget(Select2::classname(), [
                            'data' => $status,
                            'options' => ['placeholder' => $status[0]],
                            'pluginOptions' => [
                                'allowClear' => true,

                            ],
                        ]);  */
                           ?>       
                           
                    </div>
					</div></div>-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <!--<label class="control-label col-md-3">WAS-1</label>-->
                                    <label class="control-label col-md-2" style="width: 27%">Nip</label>
                                    <div class="col-md-10" style="width: 70%">
                                      <?php
                                      /* if(!$model->isNewRecord){
                                          echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly']);
                                        }else{
                                        echo $form->field($model, 'nip_penandatangan')->textInput(['readyonly'=>'readyonly','value'=>$modelPenandatangan[0]['nip_penandatangan']]);
                                        } */
										echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly']);
                                       ?>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary" type="button" id="pilih_bidang_1" data-toggle="modal" data-target="#peg_tandatangan">Pilih</button>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!--<label class="control-label col-md-3">WAS-1</label>-->
                                    <label class="control-label col-md-2">Nama</label>
                                    <div class="col-md-10">
                                      <?php
                                        /* if(!$model->isNewRecord){
                                            echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                                          }else{
                                            echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['nama_pemeriksa']]);
                                          } */
										   echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                                       ?>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!--<label class="control-label col-md-3">WAS-1</label>-->
                                    <label class="control-label col-md-3">Jabatan</label>
                                    <div class="col-md-9">
                                      <?php
                                       /* if(!$model->isNewRecord){
                                            echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                                          }else{
                                            echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['jabatan']]);
                                          } */
										  echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                                          ?>
                                          <?php
                                          /*   if(!$model->isNewRecord){
                                            echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                          }else{
                                            echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['golongan']]);
                                          } */
										  echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                          ?>
                                      <?php
                                           /*  if(!$model->isNewRecord){
                                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                          }else{
                                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['pangkat']]);
                                          } */
										  echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                       ?>

                                         <?php
                                           /*  if(!$model->isNewRecord){
                                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                          }else{
                                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['pangkat']]);
                                          } */
										  echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                       ?>
                                    </div>
                                </div>  
                            </div>
                </fieldset>
            </div>



            <div class="col-md-12 kejaksaan">   
             <label class="control-label col-md-3" style="padding:0px">Unggah File Disposisi Jam Was :</label>
             
             <div class="col-md-1 kejaksaan">
                      <div class="form-group" >
                       <?php if (substr($model['was2_file'],-3)!='pdf'){?>
                         <?= ($model->was2_file!='' ? '<a href="viewpdf?id='.$model['id_was2'].'&id_register='.$model['no_register'].'&id_tingkat='.$model['id_tingkat'].'&id_kejati='.$model['id_kejati'].'&id_kejari='.$model['id_kejari'].'&id_cabjari='.$model['id_cabjari'].'" ><span style="cursor:pointer;font-size:28px;">
                        <i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                        <?php } else{?>
                         <?= ($model->was2_file!='' ? '<a href="viewpdf?id='.$model['id_was2'].'&id_register='.$model['no_register'].'&id_tingkat='.$model['id_tingkat'].'&id_kejati='.$model['id_kejati'].'&id_kejari='.$model['id_kejari'].'&id_cabjari='.$model['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
                        <i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php } ?>
                      </div>
             </div>





<?

                       /*   echo $form->field($model, 'was2_file')->widget(FileInput::classname(), [
                            'options' => ['accept'=>'application/pdf'],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showUpload' => false,
                                'showRemove' => false,
                'showClose' => false,
                                'showCaption'=> false,
                                'allowedFileExtension' => ['pdf','jpeg','jpg','png'],
                                'maxFileSize'=> 3027,
                                'browseLabel'=>'Pilih File',
                            ]
                        ]);*/
                        ?>
            </div>
            <div class="col-md-12 kejaksaan">
             <div class="col-md-12 kejaksaan" style="padding:0px">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                    <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="was2_file" id="was2_file" /></span>
                    <span class="fileupload-preview"></span>
                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                </div>  
            </div> 
            </div>  
        </div>
            

            <div class="col-md-12">
                <fieldset class="group-border">
                    <legend class="group-border">Tembusan</legend>
                    <!-- <div class="col-md-12" style="margin-bottom:10px;"> -->
                    <div class="col-sm-12" style="margin-bottom: 15px">
                        <div class="col-sm-6">
                    <a class="btn btn-primary" id="hapus_tembusan"><span class="glyphicon glyphicon-trash"><i></i></span></a>
                    <a class="btn btn-primary"  id="addtembusan" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span> Tembusan</a>
                        </div>
                    </div>
                    <div class="for_tembusan">
                       <?php 
        if(!$model->isNewRecord){
          
            $no=1;
            foreach ($modelTembusan as $key) {
        ?>
        <div class="col-md-7 <?php echo"tembusan".$key['id_tembusan_was']; ?>" style="margin-bottom: 15px" id="<?= $key['id_tembusan_was']?>">
            <div class="col-sm-1" style="text-align:center">
               <input type="checkbox" value="<?= $key['id_tembusan_was']?>" id="cekbok" class="cekbok">
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no ?>" size="1" readonly>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="pejabat" name="pejabat[]" value="<?php echo $key['tembusan']?>">
            </div>
        </div>
        <?php 
        $no++;
                }
            }else{ 

                $no_2=1;
                foreach ($modelTembusanMaster as $valueTembusanAwal) {   
              ?>

              <div class="col-md-7 <?php echo"tembusan".$valueTembusanAwal['id_tembusan']; ?>" style="margin-bottom: 15px" id="<?= $valueTembusanAwal['id_tembusan']?>">
                  <div class="col-sm-1" style="text-align:center">
                     <input type="checkbox" value="<?= $valueTembusanAwal['id_tembusan']?>" id="cekbok" class="cekbok">
                  </div>
                  <div class="col-sm-2">
                      <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no_2 ?>" size="1" readonly>
                  </div>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="pejabat" name="pejabat[]" value="<?php echo $valueTembusanAwal['nama_tembusan']?>">
                  </div>
              </div>
              <?php
               $no_2++;
                  }
                }
              ?>


                </div>
                </fieldset>
            </div>
            

            <?//= $form->field($model, 'satuan_lampiran')->hiddenInput() ?>
            <?//= $form->field($model, 'id_terlapor')->hiddenInput() ?>
            <?//= $form->field($model, 'created_ip')->hiddenInput(['maxlength' => true]) ?>

        </div>
        
        <hr style="border-color: #c7c7c7;margin: 10px 0;">  
        <div class="box-footer" style="margin:0px;padding:0px;background:none;">

            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
        <input type="hidden" name="print" value="0" id="print"/>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was2/cetak?no_register='.$model->no_register.'&id_was2='. $model['id_was2'].'&id_tingkat='. $model['id_tingkat'].'&id_kejati='. $model['id_kejati'].'&id_kejari='. $model['id_kejari'].'&id_cabjari='. $model['id_cabjari']])?>">Cetak</a>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
        </div>
<?php ActiveForm::end(); ?>
    </div> 
</section>



<style type="text/css">
fieldset.group-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend.group-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}

.clearfix{*zoom:1;}.clearfix:before,.clearfix:after{display:table;content:"";line-height:0;}
.clearfix:after{clear:both;}
.hide-text{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0;}
.input-block-level{display:block;width:100%;min-height:30px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
.btn-file{overflow:hidden;position:relative;vertical-align:middle;}.btn-file>input{position:absolute;top:0;right:0;margin:0;opacity:0;filter:alpha(opacity=0);transform:translate(-300px, 0) scale(4);font-size:23px;direction:ltr;cursor:pointer;}
.fileupload{margin-bottom:9px;}.fileupload .uneditable-input{display:inline-block;margin-bottom:0px;vertical-align:middle;cursor:text;}
.fileupload .thumbnail{overflow:hidden;display:inline-block;margin-bottom:5px;vertical-align:middle;text-align:center;}.fileupload .thumbnail>img{display:inline-block;vertical-align:middle;max-height:100%;}
.fileupload .btn{vertical-align:middle;}
.fileupload-exists .fileupload-new,.fileupload-new .fileupload-exists{display:none;}
.fileupload-inline .fileupload-controls{display:inline;}
.fileupload-new .input-append .btn-file{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0;}
.thumbnail-borderless .thumbnail{border:none;padding:0;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;}
.fileupload-new.thumbnail-borderless .thumbnail{border:1px solid #ddd;}
.control-group.warning .fileupload .uneditable-input{color:#a47e3c;border-color:#a47e3c;}
.control-group.warning .fileupload .fileupload-preview{color:#a47e3c;}
.control-group.warning .fileupload .thumbnail{border-color:#a47e3c;}
.control-group.error .fileupload .uneditable-input{color:#b94a48;border-color:#b94a48;}
.control-group.error .fileupload .fileupload-preview{color:#b94a48;}
.control-group.error .fileupload .thumbnail{border-color:#b94a48;}
.control-group.success .fileupload .uneditable-input{color:#468847;border-color:#468847;}
.control-group.success .fileupload .fileupload-preview{color:#468847;}
.control-group.success .fileupload .thumbnail{border-color:#468847;}

</style>
<script type="text/javascript">
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

</script>
<?php
Modal::begin([
    'id' => 'peg_tandatangan',
    'size' => 'modal-lg',
    'header' => 'Pilih Pegawai',
]);

echo $this->render('@app/modules/pengawasan/views/global/_dataPegawai', ['param' => 'was2']);

Modal::end();
?>
<?php
Modal::begin([
    'id' => 'tembusan',
    'size' => 'modal-lg',
    'header' => 'Pilih Tembusan',
]);
echo $this->render('@app/modules/pengawasan/views/global/_tembusan', ['param' => 'was2']);
Modal::end();
?>
