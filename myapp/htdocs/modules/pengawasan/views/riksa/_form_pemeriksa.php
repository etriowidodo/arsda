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
<script>
    var url1 = '<?php echo Url::toRoute('was1/cetak'); ?>';

</script>
<?php $this->registerJs("

//Validasi file input by danar
$('#was1-file_disposisi_irmud').bind('change', function() {
			var batas =this.files[0].size;
			if (batas > 3145728){
            bootbox.dialog({
                message: 'Maaf Ukuran File Disposisi Irmud Lebih Dari 3 MB',
                buttons:{
                    ya : {
                        label: 'OK',
                        className: 'btn-primary',

                    }
                }
            });
			document.getElementById('was1-file_disposisi_irmud').value = '';
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
            $('.loader').css('display', 'block');
            $('#wait').css('display', 'block');
            var id=$('#was1-no_register').val();
            var option=$('#was1-id_level_was1').val();
            var tempat=$('#was1-tempat').val();
            var tglcetak=$('#was1-tgl_cetak').val();
            if(tglcetak==''){
              alert('Harap Masukan Tanggal Tandatangan');
              return false;
            }            
              
           $.ajax({
                    type:'GET',
                    url:'/pengawasan/was1/cetak?id='+id+'&option='+option+'&tempat='+tempat+'&tglcetak='+tglcetak,
                    success:function(data){
                    //$('#KejariToCabjari').html(data);
                    // $('#idkejari').html(data);
                        $('.loader').css('display', 'none');
                        $('#wait').css('display', 'none');
                    //window.location.href = '../../tmp/example_replaceTemplateVariableByHTML_1.docx';
                    }
                    });
        });

       $('#cetak').click(function(){
          $('#print').val('1');
        });

        $('#simpan').click(function(){
          $('#print').val('0');
        });

}); ", \yii\web\View::POS_END);
?>
<div class="terlapor-form">
<?php
    if (!$model->isNewRecord) { 
        $target='update';
        }else{
        $target='simpan';
        }
    $form = ActiveForm::begin([
                'id' => 'was1-form',
                // 'action' => '/pengawasan/was1/'.$target.'?id=2',
                // 'action' => array('/pengawasan/was1/'.$target.'?id=222&option=1'),
                // 'method' => 'POST',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'options'=>['enctype'=>'multipart/form-data'] ,
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
    ]);
?>
<div class="box box-primary" style="overflow:hidden;padding:10px 0px 15px 0px;">
<div class="col-md-12">
    <!--<div class="col-md-4">
        <div class="form-group">
            <label class="control-label col-md-4">Nomor. Surat</label>
            <div class="col-md-8">-->
                <!--<input class="form-control" type="text" maxlength="" name="no_surat" value="<?php echo $modelLapdu[0]['nomor_surat_lapdu']; ?>">-->
				<?//= $form->field($model, 'no_surat')->textInput(); ?>

    <!--        </div>
        </div>  
    </div>-->
   <!--  <div class="col-md-4">
        <div class="form-group">
            <label class="control-label col-md-4">Tanggal</label>
            <div class="col-md-8"> -->
                 <!-- <input class="form-control" type="text" maxlength="" name="no_surat" value="<?php echo $modelLapdu[0]['tanggal_surat_lapdu']; ?>"> -->
       <?php
        // echo $form->field($model, 'was1_tgl_surat')->widget(DateControl::className(), [
        //             'type' => DateControl::FORMAT_DATE,
        //             'ajaxConversion' => false,
        //             'displayFormat' => 'dd-MM-yyyy',
        //             'options' => [

        //                 'pluginOptions' => [
        //                     'startDate' => date("d-m-Y",strtotime($modelLapdu[0]['tanggal_surat_diterima'])),
        //                     // 'startDate' =>  $modelLapdu[0]['tanggal_surat_diterima'],
        //                     // 'startDate' => '-17y',
        //                     'autoclose' => true,
        //                 ]
        //             ],
        //         ]);
         ?>        
        <!--     </div>
        </div>
    </div>  -->


</div>


<div class="col-md-12" style="margin-top:10px">

    <div class="col-md-4">
        <div class="form-group">
            <!--<label class="control-label col-md-3">WAS-1</label>-->
            <label class="control-label col-md-4">Kepada</label>
            <div class="col-md-8">
                <?php 
                $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
                if($var[1]=='1'){
                    $nama_irmud="IRMUD Pegasum Dan Kepbang";
                }else  if($var[1]=='2'){
                    $nama_irmud="IRMUD Pidum Dan Datun";
                }else  if($var[1]=='3'){
                    $nama_irmud="IRMUD Intel Dan Pidsus";
                }
                $model->was1_kepada =  $nama_irmud;
                echo $form->field($model, 'was1_kepada')->textInput(['readonly'=>'readonly']); ?>
                <!-- <input id="was1-inst_satkerkd" class="form-control" type="hidden" maxlength="" name="Was1[inst_satkerkd]" value="<?php echo $model->inst_satkerkd; ?>"> -->

            </div>
        </div>  
    </div>

<!-- <div class="col-lg-10"> <span class="pull-left" style="margin-left:-55px;"> <a class="btn btn-primary" data-toggle="modal" data-target="#p_kejaksaan"><i class="fa fa-file-pdf-o"></i> ...</a> </span> </div> -->
<div class="col-md-4">
        <div class="form-group">
            <!--<label class="control-label col-md-3">WAS-1</label>-->
            <label class="control-label col-md-3">Dari</label>
            <div class="col-md-8">
                <?php
                if($var[2]=='1'){
                    $nama_riksa="Pemeriksa Pegasum";
                }else  if($var[2]=='2'){
                    $nama_riksa="Pemeriksa Kepbang";
                }else  if($var[2]=='3'){
                    $nama_riksa="Pemeriksa Pidum";
                }else  if($var[2]=='4'){
                    $nama_riksa="Pemeriksa Datun";
                }else  if($var[2]=='5'){
                    $nama_riksa="Pemeriksa Intel";
                }else  if($var[2]=='6'){
                    $nama_riksa="Pemeriksa Pidsus";
                }
                $model->was1_dari = $nama_riksa;
                echo $form->field($model, 'was1_dari')->textInput(['readonly'=>'readonly']); ?>

                <!-- <input id="was1-inst_satkerkd" class="form-control" type="hidden" maxlength="" name="Was1[inst_satkerkd]" value="<?php echo $model->inst_satkerkd; ?>"> -->

            </div>
        </div>  
    </div>
</div>
<!-- <div id="wait"  style="display:block;width:69px;height:89px;border:0px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='/image/demo_wait.gif' width="64" height="64" /><br>Loading..</div> -->
<!-- <div class="loader"></div> -->

<div class="col-md-12">
    <!-- <div class="col-md-12"> -->
        <div class="form-group">
            <label class="control-label col-md-2">Perihal</label>
        <div class="col-md-12">

                 <?php if (!$model->isNewRecord) { 
                 echo $form->field($model, 'was1_perihal')->textarea(['rows' => 3]);
                }else{ 
                 echo $form->field($model, 'was1_perihal')->textarea(['rows' => 3,'value'=>$modelLapdu[0]['perihal_lapdu']]);
                  } ?>
            <!-- </textarea> -->
        </div>
        <!-- </div> -->
    </div>

  <!--   <div class="col-md-4">
        <div class="form-group">
            <label class="control-label col-md-3">lampiran</label>
        <div class="col-md-9">
            <input class="form-control" type="text" maxlength="" name="was1_lampiran" value="<?php echo $modelLapdu[0]['perihal_lapdu']; ?>">
        </div>
        </div>
    </div> -->
<!-- <div class="loader"></div> -->
<div id="wait"  style="display:none;width:69px;height:89px;border:0px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='/image/demo_wait.gif' width="64" height="64" /><br>Loading..</div>
</div>
 <?php 
$model->id_level_was1='1';
 echo $form->field($model, 'id_level_was1')->hiddenInput()?>

  <?php 
$model->no_register=$modelLapdu[0]['no_register'];
 echo $form->field($model, 'no_register')->hiddenInput()?>


<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
        <div class="col-md-12">
            <label for="narasi">Narasi Awal Surat</label>
            <?= $form->field($model, 'was1_narasi_awal')->textarea(['rows' => 3]) ?>
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
            <?php echo $form->field($model, 'was1_permasalahan')->textarea(['rows' => 3]);
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
            <?php echo $form->field($model, 'data')->textarea(['rows' => 3]);
            }else{
            ?>

            <?php echo $form->field($model, 'data')->textarea(['rows' => 3,'value'=>'Nama Terlapor '.$model_terlapor[0]['names'].' Nama Pelapor  '.$modelPelapor[0]['nama_pelapor'].' Ringkasan  '.$modelLapdu[0]['ringkasan_lapdu']]);
          }
             ?>
            <?//= $form->field($model, 'data')->textarea(['rows' => 3]) ?>
        </div>
        </div>
    <!-- </div> -->

</div>

<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
        <div class="col-md-12">
            <label for="dugaan">Analisa</label>
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
        <?= $form->field($model, 'was1_kesimpulan')->textarea(['rows' => 3]) ?>
    </div>
    </div>
<!-- </div> -->

</div> 

<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
           
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
                         echo $form->field($model, 'id_saran')->dropDownList($list); ?>
                        </div>
                    </div>
        </div>
        <div class="col-md-12">
                 <div class="form-group">
                 <label class="control-label col-md-2">Uraian</label>
                    <div class="col-md-10">
                         <?= $form->field($model, 'was1_uraian')->textarea(['rows' => 3,'readonly'=>'readonly']) ?>
                    </div>
                 </div>
        </div>
             </fieldset>
    <!-- </div> -->

</div>


<div class="col-md-12">

     <!-- <div class="col-md-10"> -->
       <!--  <div class="form-group"> -->
            <!-- <label class="control-label col-md-2"></label> -->
             <fieldset class="group-border">
                <legend class="group-border">Penandatangan</legend>

                <div class="col-md-12" style="padding: 0px">
                  <div class="col-md-4" style="padding: 0px">
                  <div class="form-group">
                     <label class="control-label col-md-2">Tempat</label>
                  <div class="col-md-10" style="margin-left: -2px">
                          <?php
                          echo $form->field($model, 'tempat')->textInput(['value'=>'Jakarta']);
                           ?>        
                    </div>
                  </div>
                  </div>

                  <div class="col-md-8">
                  <div class="form-group">
                     <label class="control-label col-md-1">Tanggal</label>
                  <div class="col-md-3">

                  <?php
                          // $model->tgl_cetak=date('d-M-Y');
                          echo $form->field($model, 'tgl_cetak')->widget(DateControl::className(), [
                                      // 'value' => date('d-M-Y'),
                                      'type' => DateControl::FORMAT_DATE,
                                      'ajaxConversion' => false,
                                      'displayFormat' => 'dd-MM-yyyy',
                                      // 'value'=>date('d-M-Y'),
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
                    <!--<label class="control-label col-md-1" style="margin-left: -2px">Status</label>
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
                           
                    </div>-->
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                     
                  </div>
                  </div>
                         <!-- <div class="form-group">
                     <label class="control-label col-md-2"></label>
                  <div class="col-md-6">
                    </div>
                  </div> -->
                </div>

                <!-- <div class="col-sm-3">
                    <div class="form-group">
                <label class="control-label col-md-2">sas</label>
                     
                    </div>
                </div> -->
                 <div class="col-md-3">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-2">Nip</label>
                        <div class="col-md-10">
                          <?php
                         /*  if(!$model->isNewRecord){
                          echo $form->field($model, 'nip')->textInput(['readonly'=>'readonly']);
                        }else{
                          echo $form->field($model, 'nip')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['nip']]);
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
                    <label class="control-label col-md-2">Nama</label>
                <div class="col-sm-10">
                     <?//= $form->field($model, 'was1_nama_penandatangan')->textInput(['readonly'=>'readonly']) ?>
                     <?php
                     /*    if(!$model->isNewRecord){
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
                    <label class="control-label col-md-2">Jabatan</label>
                <div class="col-sm-10">
                  <?php
                        /* if(!$model->isNewRecord){
                        echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                      }else{
                        echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['jabatan']]);
                      } */
					   echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                      ?>
                      <?php
                       /*  if(!$model->isNewRecord){
                        echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      }else{
                        echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['golongan']]);
                      } */
					  echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      ?>
                  
<?php
                      
					  echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      ?>
                     <?php
                        /* if(!$model->isNewRecord){
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
        <!-- </div> -->
    <!-- </div> -->

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
            <?= ($model->was1_file!='' ? '<a href="viewpdf?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?>
          </div>
        </div>
    </div>
</div>
</div>

</div> -->

<?php if (!$model->isNewRecord) { 

?> 
<script type="text/javascript">
 $(document).ready(function(){
         
	   if($("#was1-tgl_disposisi_irmud-disp").val() !="")
	   {
	   $("#pilih_bidang_1").addClass("disabled");   
	   }
	   });
	   </script>
<?php 
$var=str_split($_SESSION['is_inspektur_irmud_riksa']);
if($var[1]=='1'){
$x='PEGASUM DAN KEPBANG';
}elseif($var[1]=='2'){
$x='PIDUM DAN DATUN';
}elseif($var[1]=='3'){
$x='INTEL DAN PIDSUS';
}
?>
<div class="col-md-12">
     <fieldset class="group-border">
                <legend class="group-border">Disposisi Inspektur Muda <?= $x ?></legend>
<div class="col-sm-8">
    <div class="form-group">
        <div class="col-md-12 kejaksaan">
        <label class="control-label col-md-3" style="padding: 0px">Isi Disposisi Inspektur Muda</label>
             <?php 
             echo $form->field($model, 'isi_disposisi_irmud')->textarea(['rows' => 5]) ?>
            

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
        <div style="width: 59%">
            <?php
                if($modelWas1[0]['id_level_was1']=='1'){
                  $tglAkhir='0';
                 }else if($modelWas1[0]['id_level_was1']=='2'){
                  $tglAkhir='Tanggal akhir adalah tidak lebih dari disposisi id level 2';
                 }else if($modelWas1[0]['id_level_was1']=='2'){
                  $tglAkhir='Tanggal akhir adalah tidak lebih dari disposisi id level 2';
                }
                echo $form->field($model, 'tgl_disposisi_irmud')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'displayFormat' => 'dd-MM-yyyy',
                            'options' => [

                                'pluginOptions' => [
                                    // 'startDate' => date("d-m-Y",strtotime($modelLapdu[0]['tanggal_surat_diterima'])),
                                    'startDate' =>  date("d-m-Y",strtotime($modelLapdu[0]['tgl_irmud'])),
                                    // 'startDate' => '-17y',
                                    'autoclose' => true,
                                ]
                            ],
                        ]);
            ?>       
        </div>
             <label class="control-label col-md-10" style="padding: 0px">Unggah File Disposisi Irmud :</label>
			  <div class="col-md-1 kejaksaan">
                      <div class="form-group" >
                        <?= ($model->file_disposisi_irmud !='' ? '<a href="viewpdf?id='.$model['no_register'].'&option='.$model['id_level_was1'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?>
                      </div>
        </div>
             <?php
            echo $form->field($model, 'file_disposisi_irmud')->widget(FileInput::classname(), [
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
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;"> 
<div class="box-footer" style="margin:0px;padding:0px;background:none;">
    <?//= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
    <?//= Html::Button('Kembali', ['class' => 'tombolbatal btn btn-primary','value'=>$was_register]) ?>
    <?//= Html::Button('Cetak', ['class' => 'cetakwas btn btn-primary']) ?>
    <!-- <a class="btn btn-primary ctk" href="#">Cetak</a> -->
    <input name="simpan" type="submit" value="Simpan" class="btn btn-primary" id="simpan"/>
    <input type="hidden" name="print" value="0" id="print"/>
    <input name="action" type="submit" value="Cetak" class="btn btn-primary" id="cetak"/>
    <?php if (!$model->isNewRecord) { ?> 
  
      <?php //echo $form->field($model, 'id_was_1')->hiddenInput(['name'=>'id']) ?>
    <?php } ?>
    <a class="btn btn-primary" href="/pengawasan/was1/index1?id=<?= $_SESSION['was_register']?>">Kembali</a>
</div>


<?php ActiveForm::end(); ?>
<div>
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

<style>
.loader {
  margin: 0 auto;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 69px;
  height: 69px;
  display: none;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>