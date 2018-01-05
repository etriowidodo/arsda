<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\datecontrol\DateControl;
use kartik\widgets\TimePicker;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\web\View;
use app\modules\pengawasan\models\PemeriksaSpWas1;
use kartik\widgets\FileInput;
use app\modules\pengawasan\models\Was9Search;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;
/* @var $this yii\web\View */
/* @var $model app\models\Was9 */
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
    $('#jenis_saksi1').click(function(){
      $('#was9-nama_pegawai_terlapor').val('');
      $('#saksi').attr('data-target','#peg_terlapor');
    });
     $('#jenis_saksi2').click(function(){
      $('#was9-nama_pegawai_terlapor').val('');
        $('#saksi').attr('data-target','#was9_saksieksternal');
    });
    
    $('#tambah_saksi').click(function(){
      var nama=$('#saksieksternal-nama_saksi_eksternal').val();
      var tempat=$('#saksieksternal-tempat_lahir_saksi_eksternal').val();
      var tanggal=$('#saksieksternal-tanggal_lahir_saksi_eksternal').val();
      var negara=$('#saksieksternal-id_negara_saksi_eksternal').val();
      var pendidikan=$('#saksieksternal-pendidikan').val();
      var alamat=$('#saksieksternal-alamat_saksi_eksternal').val();
      var agama=$('#saksieksternal-id_agama_saksi_eksternal').val();
      var kota=$('#saksieksternal-nama_kota_saksi_eksternal').val();
      var pekerjaan=$('#saksieksternal-pekerjaan_saksi_eksternal').val();


    $('#was9-nama_pegawai_terlapor').val(nama);

    $('#nama_saksi_eksternal').val(nama);
    $('#tempat_lahir_saksi_eksternal').val(tempat);
    $('#tanggal_lahir_saksi_eksternal').val(tanggal);
    $('#wn_saksi_eksternal').val(negara);
    $('#agama_saksi_eksternal').val(agama);
    $('#pendidikan_saksi_eksternal').val(pendidikan);
    $('#alamat_saksi_eksternal').val(alamat);
    $('#kota_saksi_eksternal').val(kota);
    $('#pekerjaan_saksi_eksternal').val(pekerjaan);

   $('#was9_saksieksternal').modal('hide');
});

 // $(document).on('click','#btn-terlapor-kp',function(){
  $('#btn-terlapor-kp').click(function(){
    // $('#peg_terlapor').modal('hide');
   });

function datePickerSetup () {
    //todays date
    var dateToday = new Date();
    var todayDate = dateToday.toLocaleDateString('en-GB'); //returns 05-12-2014
    var todayDateNumber = dateToday.getDate(); //returns 5 if 05-12-2014
    $('#datepicker-date-selected').text(todayDateNumber); 

    $('#was9-tanggal_pemeriksaan_was9').datepicker({
      inline: true,
      //minDate: new Date(),
	  minDate: new Date('".$spWas1['tanggal_mulai_sp_was1']."'),
	  maxDate: new Date('".$spWas1['tanggal_akhir_sp_was1']."'),
      firstDay: 1,
      dateFormat: 'dd-mm-yy',
      onSelect: function(date) {
          
        // work out selected date 
        var dateSelect = $(this).datepicker('getDate'); //used below
            
        var datexx = $.datepicker.formatDate('DD', dateSelect);
        
        var weekday = {Sunday:'Minggu',Monday:'Senin',Tuesday:'Selasa',Wednesday:'Rabu',Thursday:'Kamis',Friday:'Jumat',Saturday:'Sabtu'};
        
          var dayOfWeek = weekday[datexx]; //shows Monday
         $('#was9-hari_pemeriksaan_was9').val(dayOfWeek);

         
        }
    });
  }

  datePickerSetup();


}); ", \yii\web\View::POS_END);
?>
<div class="was9-form">
    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'id' => 'sp-was-2-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
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
    <div class="box-body" style="padding:15px;">
 <!-- <div class="box box-primary" style="overflow:hidden;padding:15px 0px 8px 0px;"> -->
    <?php
      if($result_expire=='0'){
    ?>
        <div class="alert alert-warning" style="margin:0 15px 15px 15px;">
            <strong>Peringatan!</strong> . Batas Tanggal Sp-Was-1 Sudah Kadaluarsa
        </div>
    <?php
      }
    ?>
    <br>
    <div class="col-md-6">
     <fieldset class="group-border" style="height: 195px;">
        <legend class="group-border">Nomor Surat</legend>
         <div class="col-md-12">
             <div class="form-group">
                <label class="control-label col-md-3">Nomor Surat</label>
                <div class="col-md-9">
                <?= $form->field($model, 'nomor_surat_was9')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
             <div class="form-group">
                <label class="control-label col-md-3">Perihal</label>
                <div class="col-md-9">
                <?= $form->field($model, 'perihal_was9')->textArea(['rows' => 2]) ?>
                </div>
            </div>
        </div>
     </fieldset>
    </div>

    <div class="col-md-6">
     <fieldset class="group-border">
        <legend class="group-border">Tanggal</legend>
        <div class="col-md-12">
             <div class="form-group">
                <label class="control-label col-md-3">Tanggal Surat</label>
                <div class="col-md-5">
                <?php
					echo $form->field($model, 'tanggal_was9',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
						'type' => DateControl::FORMAT_DATE,
						'ajaxConversion' => false,
						'displayFormat' => 'dd-MM-yyyy',
						'options' => [
							'pluginOptions' => [
								'autoclose' => true,
								'startDate' => date("d-m-Y",strtotime($spWas1['tanggal_mulai_sp_was1'])),
								'endDate' => date("d-m-Y",strtotime($spWas1['tanggal_akhir_sp_was1'])),
							
							]
						]
					]);
                ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
             <div class="form-group">
                <label class="control-label col-md-3">Lampiran</label>
                <div class="col-md-5">
               <?= $form->field($model, 'lampiran_was9')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
             <div class="form-group">
                <label class="control-label col-md-3">Sifat Surat</label>
                <div class="col-md-5">
			   <?= $form->field($model, 'sifat_was9')->dropDownList(['1' => 'Biasa', '2' => 'Segera','3' =>'Rahasia'], ['prompt' => '--Pilih--']) ?>
                </div>
            </div>
        </div>
     </fieldset>
     </div>
     <!-- saksi -->
     <div class="col-md-12" style="padding:0px;">
        <div class="panel panel-primary">
            <div class="panel-heading">Saksi <?php echo $_GET['jns']; ?></div>
                <div class="panel-body">
                  <input type="hidden" name="jenis_saksi" id="jenis_saksi" value="<?php echo $_GET['jns']; ?>">
                  <input type="hidden" name="id_saksi" id="id_saksi" value="<?php echo $_GET['id_saksi']; ?>">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">Kepada</label>
                          <div class="input-group col-md-8">
                              <input readonly="readonly" id="was9-nama_pegawai_terlapor" class="form-control" name="kepada" type="text" value="<?php echo $_GET['nm']?>" style="margin-left: 15px; padding-left: 12px; width: 304px;">
                              <input id="was9-nip_pegawai_terlapor" class="form-control" name="nip" type="hidden" value="<?php echo $_GET['id']?>"> 
                          </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6" style="margin-top:15px;">
                      <div class="form-group">
                          <label class="control-label col-md-3">Di</label>
                          <div class="col-md-8">
                          <?php echo $form->field($model, 'di_was9')->textInput()->label(false) ?>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6" style="margin-top:15px;">
                      <div class="form-group">
                      <label class="control-label col-md-4">Bertemu Dengan</label>
                          <div class="col-md-8">
                             <?php echo $form->field($model, 'nip_pemeriksa')->dropDownList(
                                          ArrayHelper::map(PemeriksaSpwas1::find()->where(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->all(), 'nip', 'nama_pemeriksa'),
                                          //ArrayHelper::map(PemeriksaSpwas2::find()->where(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->all(), 'nip_pemeriksa', 'nama_pemeriksa'),
                                           ['prompt' => 'Pilih Pemeriksa'],['width'=>'40%']
                                          )->label(false);     
                              ?>
                          </div>
                      </div>
                    </div>
                </div>
        </div>
      </div>

      <div class="col-md-12" style="padding:0px;">
        <div class="panel panel-primary">
            <div class="panel-heading">Jadwal Pemeriksaan</div>
                <div class="panel-body">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">Tanggal</label>
                          <div class="col-md-6" style="position: relative; z-index: 10;">
                           <?php
                            if($model->tanggal_pemeriksaan_was9!=''){
                              $model->tanggal_pemeriksaan_was9=date("d-m-Y", strtotime($model->tanggal_pemeriksaan_was9));
                            }
                            echo $form->field($model, 'tanggal_pemeriksaan_was9',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]]);
                            ?> 
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3">Hari</label>
                          <div class="col-md-6">
                           <?= $form->field($model, 'hari_pemeriksaan_was9')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3">Jam</label>
                          <div class="col-md-6">
                            <?php 
                              echo $form->field($model, 'jam_pemeriksaan_was9')->widget(TimePicker::classname(), [
                                  'pluginOptions'=>[
                                      'showSeconds' => false,
                                      'showMeridian' => false,
                                      'minuteStep' => 1,
                                      'secondStep' => 5,
                                  ],
                                ]);
                              ?>

                          </div>
                          <div class="col-md-3">
                              <?php echo $form->field($model, 'zona')->dropDownList(['WIB','WIT','WITA'])?>                             
                          </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">Tempat</label>
                          <div class="col-md-9">
                           <?= $form->field($model, 'tempat_pemeriksaan_was9')->textArea(['rows' =>5]) ?>
                          </div>
                      </div>
                    </div>
                </div>
        </div>
      </div>
      <?php
       $connection = \Yii::$app->db;
            $query = "select*from was.v_penandatangan where id_surat='was9' and unitkerja_kd='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."' and jabtan_asli=nama_jabatan";
            $nama_ttd = $connection->createCommand($query)->queryOne();
            
      ?>

   
<!-- untuk penandatangan itu ada defaulnya pas create jadi kita biarkan soalnya  belum jelas-->
      <div class="col-md-12" style="padding:0px;">
        <div class="panel panel-primary">
            <div class="panel-heading">Penandatangan</div>
                <div class="panel-body">
                   <div class="col-md-4">
                      <div class="form-group">
                          <!--<label class="control-label col-md-3">WAS-1</label>-->
                          <label class="control-label col-md-2" style="width:22%">Nip</label>
                          <div class="col-md-10" style="width:75%">
                            <?php
                            if(!$model->isNewRecord){
                            echo $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly']);
                          }else{
                            echo $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly']);
                          }
                             ?>
                          </div>
                      </div>  
                  </div>
                  <div class="col-md-4">
                       <div class="form-group">
                          <label class="control-label col-md-2">Nama</label>
                      <div class="col-sm-10">
                           <?//= $form->field($model, 'was1_nama_penandatangan')->textInput(['readonly'=>'readonly']) ?>
                           <?php
                              if(!$model->isNewRecord){
                              echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                            }else{
                              echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                            }
                            ?>
                      </div>
                      </div>
                  </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label col-md-2">Jabatan</label>
                    <div class="col-sm-10">
                      <?php
                      /*sebenarnya ini ada default pas awal tpi kang putut blm kasih tau defaulnya apa*/
                            if(!$model->isNewRecord){
                            echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                          }else{
                            echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                          }
                          ?>
                    </div>
                </div>
            </div>
          </div>
         </div>
      </div>

      
      <div class="col-md-12" style="padding:0px;">
          <div class="panel panel-primary">
              <div class="panel-heading">Tembusan</div>
                  <div class="panel-body">
                    <div class="form-group" style="margin:10px;">
                        <a class="btn btn-primary" id="hapus_tembusan"><span class="glyphicon glyphicon-trash"><i></i></span></a>
                        <a class="btn btn-primary"  id="addtembusan" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span> Tembusan</a><br>  
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
                            <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no ?>" size="1" readonly style="text-align:center;">
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
                                  <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no_2 ?>" size="1" readonly style="text-align:center;">
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
            </div>  
          </div>
      </div>
<?php if(!$model->isNewRecord){ ?>
          <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas WAS-9 : 
                     <?php if (substr($model['was9_file'],-3)!='pdf'){?>
                     <?= ($model->was9_file!='' ? '<a href="viewpdf?id='.$model['id_saksi'].'&no='.$model['nomor_surat_was9'].'&id_register='.$model['no_register'].'&id_tingkat='.$model['id_tingkat'].'&id_kejati='.$model['id_kejati'].'&id_kejari='.$model['id_kejari'].'&id_cabjari='.$model['id_cabjari'].'" ><span style="cursor:pointer;font-size:28px;">
                    <i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                     <?= ($model->was9_file!='' ? '<a href="viewpdf?id='.$model['id_saksi'].'&no='.$model['nomor_surat_was9'].'&id_register='.$model['no_register'].'&id_tingkat='.$model['id_tingkat'].'&id_kejati='.$model['id_kejati'].'&id_kejari='.$model['id_kejari'].'&id_cabjari='.$model['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
                    <i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php } ?>
                </label>
                <!-- <input type="file" name="was9_file" /> -->
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="was9_file" id="was9_file" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
          </div>
 <?php 
    }
 ?>  
     

    <!-- </div> -->
</div>

      <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="margin:10px;padding:10px;background:none;">
      <?php
// echo $result_expire;
      if ($model->isNewRecord){
         if($result_expire=='1'){
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ;
          }
       }else{
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ;
       }
       ?>
       <?php
       // echo Html::a('<i class="fa fa-print"></i> Cetak', ['/pengawasan/was9/cetak', 'id' => $model->id_surat_was9], ['class' => 'btn btn-primary']) ;
       echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Batal ', ['/pengawasan/was9/index'], ['id' => 'KembaliSpWas1', 'class' => 'btn btn-primary']) ;
     ?>
       <?php if($_GET['jns']=='Internal'){ ?>
       <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was9/cetak?no_register='.$model->no_register.'&id='. $model['id_surat_was9'].'&id_tingkat='. $model['id_tingkat'].'&id_kejati='. $model['id_kejati'].'&id_kejari='. $model['id_kejari'].'&id_cabjari='. $model['id_cabjari']])?>"><i class="fa fa-print"> </i> Cetak</a>       
       <?php }else {?>
       <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was9/cetak2?no_register='.$model->no_register.'&id='. $model['id_surat_was9'].'&id_tingkat='. $model['id_tingkat'].'&id_kejati='. $model['id_kejati'].'&id_kejari='. $model['id_kejari'].'&id_cabjari='. $model['id_cabjari']])?>"><i class="fa fa-print"> </i> Cetak</a>       
       <?php }?>
      
    </div>
</div>
    <?php ActiveForm::end(); ?>
</div>

<div class="modal fade" id="penandatangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Terlapor</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormPenandatangan', 
                                      'options'=>['name'=>'searchFormPenandatangan'],
                                      'fieldConfig' => [
                                                  'options' => [
                                                      'tag' => false,
                                                      ],
                                                  ],
                                  ]); ?>
                          <div class="col-md-12">
                             <div class="form-group">
                                <label class="control-label col-md-2">Cari</label>
                                  <!-- <div class="col-md-2 kejaksaan">
                                    <select name='jns_penandatangan' class="form-control">
                                        <option value=''>pilih</option>
                                        <option value='AN'>AN</option>
                                        <option value='Plt'>PLT</option>
                                        <option value='Plh'>PLH</option>
                                      </select>
                                  </div> -->
                                  <div class="col-md-6 kejaksaan">
                                    <div class="form-group input-group">
                                             
                                      <input type="text" name="cari_penandatangan" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan_surat" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas9 = new Was9Search();
                            $dataProviderPenandatangan = $searchModelWas9->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w0" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatangan,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    // ['label'=>'No Surat',
                                    //     'headerOptions'=>['style'=>'text-align:center;'],
                                    //     'attribute'=>'id_surat',
                                    // ],

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'Jabatan Alias',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_jabatan',
                                    ],

                                    ['label'=>'Jabatan Sebenarnya',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabtan_asli',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_surat'],'class'=>'selection_one','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]); ?>
                           <?php Pjax::end(); ?>
                        </div>
                        <div class="modal-loading-new"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="tambah_penandatangan">Tambah</button>
                </div>
            </div>
        </div>
</div>






<style type="text/css">

#grid-penandatangan_surat.loading {overflow: hidden;}
#grid-penandatangan_surat.loading .modal-loading-new {display: block;}

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

#pemeriksa .modal-dialog  {width:1000px;}

/*upload file css*/
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
window.onload=function(){
$(document).on('click','#tambah_penandatangan',function() {
    var data=JSON.parse($(".selection_one:checked").attr("json"));
       $('#was9-nip_penandatangan').val(data.nip);
       $('#was9-nama_penandatangan').val(data.nama);
       $('#was9-jabatan_penandatangan').val(data.nama_jabatan);
       $('#was9-jbtn_penandatangan').val(data.jabtan_asli);
       $('#was9-pangkat_penandatangan').val(data.gol_pangkat2);
       $('#was9-golongan_penandatangan').val(data.gol_kd);
       $('#penandatangan').modal('hide');
                                
    });

/*/////////PENANDATANGAN LOADING GRID//////////////*/
    $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
      $('#grid-penandatangan_surat').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penandatangan_surat').removeClass('loading');
    });

    $(document).on('click','.cari_ttd',function() { 
      $('#grid-penandatangan_surat').addClass('loading');
        $("#grid-penandatangan_surat").load("/pengawasan/was9/getttd",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penandatangan_surat').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

    $(document).on('hidden.bs.modal','#penandatangan', function (e) {
      $(this)
        .find("input[name=cari_penandatangan]")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

    });
}
</script>