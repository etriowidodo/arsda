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
/* @var $this yii\web\View */
/* @var $model app\models\Was1 */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->registerJs("


//Validasi file input by danar
$('#was1-file_disposisi_jamwas').bind('change', function() {
			var batas =this.files[0].size;
			if (batas > 3145728){
            bootbox.dialog({
                message: 'Maaf Ukuran File Disposisi Jam Was Lebih Dari 3 MB',
                buttons:{
                    ya : {
                        label: 'OK',
                        className: 'btn-primary',

                    }
                }
            });
			document.getElementById('was1-file_disposisi_jamwas').value = '';
			}
        });
		//End Validasi by Danar
		
    $(document).ready(function(){
         
       if($(\"input[name='Was1[saran]']:checked\").val() != '1'){
       $('#hasil_saran').hide();
       }else{
       $('#hasil_saran').show();
       }
       
       $(\"input[name='Was1[saran]']\").change(function() {
        if (this.value == '1') {
         $('#hasil_saran').show();
         
        }else{
        $('#hasil_saran').hide();
        $('#was1-sebab_tdk_dilanjuti').val('');
        }
        });

          $('#was1-id_saran').change(function(){
            var x=$(this).val();
            if(x=='0'){
                $('#was1-was1_uraian').prop('readonly', true);
            }else{
                $('#was1-was1_uraian').prop('readonly', false);
            }
          });
      //     $('.cetakwas').click(function(){
         
      //  window.open('" . Url::to('pengawasan/was1/cetak', true) . "?id_register=' + $(\"#was1-id_register\").val() + '&id_was_1=' + $(\"#was1-id_was_1\").val());

      // });
  $('.ctk').click(function(){
    $('#wait').css('display', 'block');
          var id=$('#was1-no_register').val();
          var option=$('#was1-id_level_was1').val();
           $.ajax({
                    type:'GET',
                     url:'/pengawasan/was1/cetak2?id='+id+'&option='+option,
                    success:function(data){
                    //$('#KejariToCabjari').html(data);
                    // $('#idkejari').html(data);
                      $('#wait').css('display', 'none');
                    window.location.href = '../../tmp/example_replaceTemplateVariableByHTML_2.docx';
                    }
                    });
        });
$('#cetak').click(function(){

          $('#print_1').val('3');
        });

        $('#simpan').click(function(){
          $('#print_1').val('2');
        });
}); ", \yii\web\View::POS_END);
?>

<?php
    $form = ActiveForm::begin([
                'id' => 'was1-form',
                // 'action' => '/pengawasan/was1/create',
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
<div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;">
<div class="col-md-12">
    <div class="col-md-4">
        <div class="form-group">
            <!--<label class="control-label col-md-3">WAS-1</label>-->
            <label class="control-label col-md-4">No. Surat</label>
            <div class="col-md-8">
                <!--<input class="form-control" type="text" maxlength="" name="no_surat" value="<?php echo $modelLapdu[0]['nomor_surat_lapdu']; ?>">-->
			 <?= $form->field($model, 'no_surat')->textInput(); ?>
            </div>
        </div>  
    </div>
  <!--   <div class="col-md-4">
    </div> -->
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label col-md-3">Tanggal</label>
            <div class="col-md-8">
                 <!-- <input class="form-control" type="text" maxlength="" name="no_surat" value="<?php echo $modelLapdu[0]['tanggal_surat_lapdu']; ?>"> -->
       <?php
        echo $form->field($model, 'was1_tgl_surat')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'displayFormat' => 'dd-MM-yyyy',
                            'options' => [

                                'pluginOptions' => [
                                    'startDate' => date("d-m-Y",strtotime($modelLapdu[0]['tanggal_surat_diterima'])),
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



<div class="col-md-12" style="margin-top:10px">

    <div class="col-md-5">
        <div class="form-group">
            <!--<label class="control-label col-md-3">WAS-1</label>-->
            <label class="control-label col-md-3">Kepada</label>
            <div class="col-md-9">
                <?php 
                $model->was1_kepada = "JAKSA AGUNG MUDA PENGAWASAN";
                echo $form->field($model, 'was1_kepada')->textInput(['readonly'=>'readonly']); ?>
                <!-- <input id="was1-inst_satkerkd" class="form-control" type="hidden" maxlength="" name="Was1[inst_satkerkd]" value="<?php echo $model->inst_satkerkd; ?>"> -->

            </div>
        </div>  
    </div>

<!-- <div class="col-lg-10"> <span class="pull-left" style="margin-left:-55px;"> <a class="btn btn-primary" data-toggle="modal" data-target="#p_kejaksaan"><i class="glyphicon glyphicon-user"></i> ...</a> </span> </div> -->
<div class="col-md-3">
        <div class="form-group">
            <!--<label class="control-label col-md-3">WAS-1</label>-->
            <label class="control-label col-md-2">Dari</label>
            <div class="col-md-10">
                <?php 
                 $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
                if($var[0]=='1'){
                    $nama_inspektur="Inspektur I";
                }else  if($var[0]=='2'){
                    $nama_inspektur="Inspektur II";
                }else  if($var[0]=='3'){
                    $nama_inspektur="Inspektur II";
                }else  if($var[0]=='4'){
                    $nama_inspektur="Inspektur IV";
                }else  if($var[0]=='5'){
                    $nama_inspektur="Inspektur V";   
                }
                $model->was1_dari =  $nama_inspektur;
                echo $form->field($model, 'was1_dari')->textInput(['readonly'=>'readonly']); ?>

                <!-- <input id="was1-inst_satkerkd" class="form-control" type="hidden" maxlength="" name="Was1[inst_satkerkd]" value="<?php echo $model->inst_satkerkd; ?>"> -->

            </div>
        </div>  
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label col-md-3">Lampiran</label>
        <div class="col-md-9">
            <!-- <input class="form-control" type="text" maxlength="" name="lampiran" value="<?php echo $modelLapdu[0]['perihal_lapdu']; ?>"> -->
            <?php echo $form->field($model, 'was1_lampiran')->textInput();?>
        </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <!-- <div class="col-md-12"> -->
        <div class="form-group">
            <label class="control-label col-md-2">Perihal</label>
        <div class="col-md-12">
            <!-- <textarea name="perihal" row='3'> -->
               <!--  <?php //echo $modelLapdu[0]['perihal_lapdu']; 
                //echo $form->field($model, 'perihal')->textArea;
                ?> -->
                 <?php if (!$model->isNewRecord) { 
                // if($modelWas1[0]['id_level_was1']=='1'){
                //         $model->was1_perihal=$loadWas1['was1_perihal'];
                //    }
                 echo $form->field($model, 'was1_perihal')->textarea(['rows' => 3]);
                }else{ 
                  if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2'){
                        $model->was1_perihal=$loadWas1['was1_perihal'];
                   }else{
                        $model->was1_perihal=$modelLapdu[0]['perihal_lapdu'];
                    } 
                 echo $form->field($model, 'was1_perihal')->textarea(['rows' => 3]);
                  } ?>
            <!-- </textarea> -->
        </div>
        </div>
    <!-- </div> -->


    
</div>
<div id="wait"  style="display:none;width:69px;height:89px;border:0px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='/image/demo_wait.gif' width="64" height="64" /><br>Loading..</div>

<?php 
$model->id_level_was1='3';
 echo $form->field($model, 'id_level_was1')->hiddenInput()?>

<?php 
$model->no_register=$modelLapdu[0]['no_register'];
 echo $form->field($model, 'no_register')->hiddenInput()?>
<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
        <div class="col-md-12">
            <label for="narasi">Narasi Awal</label>
            <?php
            if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2'){
                  $model->was1_narasi_awal=$loadWas1['was1_narasi_awal'];
             }
            ?>
            <?php 
            echo $form->field($model, 'was1_narasi_awal')->textarea(['rows' => 3]) ?>
        </div>
        </div>
    <!-- </div> -->

</div>

<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
        <div class="col-md-12">
            <label for="permasaalahan">Permasalahan</label>
			
			<?php
            if(!$model->isNewRecord){
            ?>
             <?php
            if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2'){
                  $model->was1_permasalahan=$loadWas1['was1_permasalahan'];
             }
             
            ?>
			<?php
			
            }else{
            ?>

            <?php echo $form->field($model, 'was1_permasalahan')->textarea(['rows' => 3,'value'=>'Sehubungan dengan adanya laporan pengaduan dari '.$modelPelapor[0]['nama_pelapor'].' '
              .$modelLapdu[0]['ringkasan_lapdu'].' Bahwa '.$model_terlapor[0]['names']]);
          }
             ?>
        </div>
        </div>
    <!-- </div> -->

</div>

<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
        <div class="col-md-12">
            <label for="dugaan">Data</label>
			 <?php
            if(!$model->isNewRecord){
            ?>
            <?php
              if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2'){
                  $model->data=$loadWas1['data'];
             }
            ?>
			<?php
			}else{
            ?>
            <?php 
            echo $form->field($model, 'data')->textarea(['rows' => 3,'value'=>'Nama Terlapor '.$model_terlapor[0]['names'].' Nama Pelapor  '.$modelPelapor[0]['nama_pelapor'].' Ringkasan  '.$modelLapdu[0]['ringkasan_lapdu']]);
			}
			?>
			
        </div>
        </div>
    <!-- </div> -->

</div>

<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
        <div class="col-md-12">
            <label for="dugaan">Analisa</label>
            <?php
              if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2'){
                  $model->was1_analisa=$loadWas1['was1_analisa'];
             }
            ?>
            <?= $form->field($model, 'was1_analisa')->textarea(['class'=>'ckeditor','rows' => 3]) ?>
        </div>
        </div>
    <!-- </div> -->

</div>

<div class="col-md-12">
 <!-- <div class="col-md-10"> -->
    <div class="form-group">
    <div class="col-md-12">
        <label for="kesimpulan">Kesimpulan</label>
        <?php
              if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2'){
                  $model->was1_kesimpulan=$loadWas1['was1_kesimpulan'];
                }
            ?>
        <?php 
        echo $form->field($model, 'was1_kesimpulan')->textarea(['rows' => 3]) ?>
    </div>
    </div>
<!-- </div> -->

</div> 

<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
            <!-- <label class="control-label col-md-2"></label> -->
        <div class="col-md-12">
            <fieldset class="group-border">
                <legend class="group-border">saran</legend>
                   <div class="col-md-12">
                            <div class="form-group">
                         <label class="control-label col-md-2">Saran</label>
                                <div class="col-md-7">
                                <?php
                                 $list = [0 => 'Pilih Saran',
                                 1 => 'Tidak Ditindak Lanjunti', 
                                 2 => 'Perlu ditindaklanjuti dengan meneruskan laporan pengaduan tersebut kepada bidang teknis terkait',
                                 3 => 'Perlu ditindaklanjuti dengan melakukan Klarifikasi oleh atasan langsung',
                                 4=>'Perlu ditindaklanjuti dengan melakukan lnspeksi Kasus oleh atasan langsung ',
                                 5=>'Perlu ditindaklanjuti dengan melakukan Klarifikasi oleh tim pemeriksa Kejaksaan Agung',
                                 6=>'Perlu ditindaklanjuti dengan melakukan lnspeksi Kasus oleh tim pemeriksa Kejaksaan Agung'];
                                 if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2'){
                                      $model->id_saran=$loadWas1['id_saran'];
                                 }
                                 echo $form->field($model, 'id_saran')->dropDownList($list); ?>
                                </div>
                            </div>
                    </div>
                      <div class="col-md-12">
                         <div class="form-group">
                         <label class="control-label col-md-2">uraian</label>
                            <div class="col-md-10">
                              <?php 
                              if($modelWas1[0]['id_level_was1']=='1' OR $modelWas1[0]['id_level_was1']=='2'){
                                      $model->was1_uraian=$loadWas1['was1_uraian'];
                                 }
                              ?>
                                 <?= $form->field($model, 'was1_uraian')->textarea(['rows' => 3,'readonly'=>'readonly']) ?>
                            </div>
                         </div>
                </div>
             </fieldset>
        </div>
        </div>
    <!-- </div> -->

</div>

<div class="col-md-12">
     <fieldset class="group-border">
                <legend class="group-border">Penanda Tangan</legend>
                <div class="col-md-12" style="padding: 0px">
                  <div class="col-md-5" style="padding: 0px">
                  <div class="form-group">
                     <!--<label class="control-label col-md-2">Status</label>-->
                  <div class="col-md-3" style="margin-left: -2px">
                          <?php
                           /* $status=['-','AN','PLH','PLT'];
                          echo  $form->field($model, 'status_penandatangan')->widget(Select2::classname(), [
                            'data' => $status,
                            'options' => ['placeholder' => $status[0]],
                            'pluginOptions' => [
                                'allowClear' => true,

                            ],
                        ]);  */

                          echo $form->field($model, 'tgl_cetak')->hiddenInput();
                          echo $form->field($model, 'tempat')->hiddenInput();
                           ?>        
                    </div>
                  </div>
                  </div>

                </div>
                
                 <div class="col-md-3">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-2">Nip</label>
                        <div class="col-md-10">
                            <?php
							echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly']);
                         /*  if(!$model->isNewRecord){
                          echo $form->field($model, 'nip')->textInput(['readonly'=>'readonly']);
                        }else{
                          echo $form->field($model, 'nip')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['nip']]);
                        } */
                           ?>
                        </div>
                    </div>  
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-primary" type="button" id="pilih_bidang_1" data-toggle="modal" data-target="#peg_tandatangan">Pilih</button>
                </div>
                <div class="col-md-4">
                 <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                <div class="col-sm-10">
                    <?php
					echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                       /*  if(!$model->isNewRecord){
                        echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                      }else{
                        echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['nama_pemeriksa']]);
                      } */
                      ?>
                </div>
                </div>
                </div>
                <div class="col-md-4">
                 <div class="form-group">
                    <label class="control-label col-md-2">Jabatan</label>
                <div class="col-sm-10">
                     <?php
					 echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                        /* if(!$model->isNewRecord){
                        echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                      }else{
                        echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['jabatan']]);
                      } */
                      ?>
                      <?php
					   echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                       /*  if(!$model->isNewRecord){
                        echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      }else{
                        echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['golongan']]);
                      } */
                      ?>
                  
				  <?php
					   echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      ?>

                     <?php
					 echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                       /*  if(!$model->isNewRecord){
                        echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      }else{
                        echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['pangkat']]);
                      } */
                      ?>
                </div>
                </div>
                </div>
             </fieldset>
</div>

<!-- <div class="col-md-12" style="padding: 15px 0px;">
<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label col-md-3">Upload File</label>
        <div class="col-md-8 kejaksaan">
             <?//=
            // echo $form->field($model, 'was1_file')->widget(FileInput::classname(), [
            //     'options'=>['accept'=>'application/*'],
            //     'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpeg','jpg','png'],
            //                       'showUpload' => false
            // ],
            // ]);

            ?>

        </div>
        <div class="col-md-1 kejaksaan">
          <div class="form-group">
            <?= ($model->was1_file!='' ? '<a href="viewpdf?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="glyphicon glyphicon-file"></i></span></a>' :'') ?>
          </div>
        </div>
    </div>
</div>
</div>

</div> -->

<?php if (!$model->isNewRecord) { ?> 
<script type="text/javascript">
			$(document).ready(function(){
         
	   if($("#was1-tgl_disposisi_jamwas-disp").val() !="")
	   {
	   $("#pilih_bidang_1").addClass("disabled");   
	   }
	   });
	   </script>
<div class="col-md-12">
     <fieldset class="group-border">
                <legend class="group-border">Disposisi Jam Was</legend>
<div class="col-sm-8">
    <div class="form-group">
        <div class="col-md-12 kejaksaan">
        <label class="control-label col-md-2" style="padding: 0px">Isi</label>
             <?php 
             echo $form->field($model, 'isi_disposisi_jamwas')->textarea(['rows' => 5]) ?>
            

        </div>
        <!-- <div class="col-md-1 kejaksaan">
          <div class="form-group">
            <?//= ($model->was1_file!='' ? '<a href="viewpdf?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="glyphicon glyphicon-file"></i></span></a>' :'') ?>
          </div>
        </div> -->
    </div>
</div>
<div class="col-sm-4">
    <div class="form-group">
        <div class="col-md-12 kejaksaan">
        <label class="control-label col-md-2" style="padding: 0px">Tanggal</label>
            <?php
             // if($modelWas1[0]['id_level_was1']=='3'){
             //        if($loadWas1['tgl_disposisi_irmud']==''){
             //            $starTgl=$model->was1_tgl_surat;
             //        }else{
             //            $starTgl=$loadWas1['tgl_disposisi_irmud'];
             //        }
             //    }
                echo $form->field($model, 'tgl_disposisi_jamwas')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'displayFormat' => 'dd-MM-yyyy',
                            'options' => [

                                'pluginOptions' => [
                                    // 'startDate' => date("d-m-Y",strtotime($modelLapdu[0]['tanggal_surat_diterima'])),
                                    'startDate' =>  date("d-m-Y",strtotime($model->was1_tgl_surat)),
                                    // 'startDate' => '-17y',
                                    'autoclose' => true,
                                ]
                            ],
                        ]);
            ?>       
             <label class="control-label col-md-10" style="padding:0px">Unggah File Disposisi Jam Was :</label>
			 <div class="col-md-1 kejaksaan">
                      <div class="form-group" >
                        <?= ($model->file_disposisi_jamwas !='' ? '<a href="viewpdf?id='.$model['no_register'].'&option='.$model['id_level_was1'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?>
                      </div>
        </div>
             <?php
            echo $form->field($model, 'file_disposisi_jamwas')->widget(FileInput::classname(), [
                'options'=>['accept'=>'application/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpeg','jpg','png'],
                                  'showPreview' => true,
                                'showUpload' => false,
                                'showRemove' => false,
                'showClose' => false,
                                'showCaption'=> false,
                                'allowedFileExtension' => ['pdf','jpeg','jpg','png'],
                                'maxFileSize'=> 3027,
                                'browseLabel'=>'Pilih File',
            ],
            ]);

            ?>

        </div>
        
    </div>
</div>
</fieldset>
</div>


<?php } ?>
<hr style="border-color: #c7c7c7;margin: 10px 0;"> 
<div class="box-footer" style="margin:0px;padding:0px;background:none;">
    <?//= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
  <!-- <a class="btn btn-primary ctk" href="#">Cetak</a> -->
  <input name="simpan" type="submit" value="Simpan" class="btn btn-primary" id="simpan"/>
  <input type="hidden" name="print_1" value="2" id="print_1"/> 
  <input name="action" type="submit" value="Cetak" class="btn btn-primary" id="cetak"/>
  <?php if (!$model->isNewRecord) { ?> 
  
    <?//= Html::Button('Cetak', ['class' => 'cetakwas btn btn-primary']) ?>
      <?php// echo $form->field($model, 'id_was1')->hiddenInput(['name'=>'id']) ?>
    <?php } ?>
    <a class="btn btn-primary ctk" href="/pengawasan/was1/index1?id=<?= $_SESSION['was_register']?>">Kembali</a>
</div>


<?php ActiveForm::end(); ?>
<?php
Modal::begin([
    'id' => 'peg_tandatangan',
    'size' => 'modal-lg',
    'header' => 'Pilih Pegawai',
]);

echo $this->render('@app/modules/pengawasan/views/global/_dataPegawai', ['param' => 'was1']);

Modal::end();
?>

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
</style>