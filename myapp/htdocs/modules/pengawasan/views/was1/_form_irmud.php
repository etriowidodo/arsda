<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use app\modules\pengawasan\models\Was1Search;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use kartik\widgets\Select2;
use yii\db\Query;
use yii\db\Command;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Was1 */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->registerJs("

//Validasi file input by danar
$('#was1-file_disposisi_inspektur').bind('change', function() {
			var batas =this.files[0].size;
			if (batas > 3145728){
            bootbox.dialog({
                message: 'Maaf Ukuran File Disposisi Inspektur Lebih Dari 3 MB',
                buttons:{
                    ya : {
                        label: 'OK',
                        className: 'btn-primary',

                    }
                }
            });
			document.getElementById('was1-file_disposisi_inspektur').value = '';
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
      <?php
        $connection = \Yii::$app->db;
        $max_level = "
                      SELECT coalesce(max(id_level_was1),'0') as id,was1_tgl_disposisi FROM was.was1 
                      where no_register='".$_SESSION['was_register']."' and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."' and id_level_was1='1'
                      group by id_level_was1,was1_tgl_disposisi";
        $result_max_level = $connection->createCommand($max_level)->queryOne();
  
         if($result_max_level['id']!='' and $result_max_level['was1_tgl_disposisi']==''){  
        ?>  
           <script type="text/javascript">
            alert('Langkah Sebelumnya Belum Di Disposisi');
            location.href='/pengawasan/was1/create?id=0';
            </script>
         <?php } ?>   
  
<!-- Kondisi No surat n tanggal muncul ketika update -->
<?php  if(!$model->isNewRecord){ ?> 
    <div class="col-md-4">
        <div class="form-group">
            <!--<label class="control-label col-md-3">WAS-1</label>-->
            <label class="control-label col-md-4">No. Surat</label>
            <div class="col-md-8">    
      				 <?php 
               echo $form->field($model, 'no_surat')->textInput(); ?>
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
                  $connection = \Yii::$app->db;
                      $max_level = "select max(id_level_was1) as id_level_was1 from was.was1 where no_register='".$_SESSION['was_register']."' and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
                      $result_max_level = $connection->createCommand($max_level)->queryOne();

                    if($result_max_level['id_level_was1']==1){
                      $connection = \Yii::$app->db;
                      $sql_level1 = "select was1_tgl_surat,was1_tgl_disposisi from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='1'";
                      $result_sql_level1 = $connection->createCommand($sql_level1)->queryOne();
                      $batas      =$result_sql_level1['was1_tgl_surat'];
                      $batas_dispo=$result_sql_level1['was1_tgl_disposisi'];
                     // $batas1     =$result_sql_level1['was1_tgl_surat'];
                    
                    }else if($result_max_level['id_level_was1']==0 or $result_max_level['id_level_was1']==''){
                      $connection = \Yii::$app->db;
                      $sql = "select distinct tanggal_disposisi from was.was_disposisi_irmud where no_register='".$_SESSION['was_register']."'";
                      $result = $connection->createCommand($sql)->queryOne();
                      $batas=$result['tanggal_disposisi'];
                     // $batas_dispo=$result['was1_tgl_disposisi'];
                     // $batas2=$result['was1_tgl_surat'];
                    }else if($result_max_level['id_level_was1']==2){
                      $connection = \Yii::$app->db;
                      $sql_level3 = "select was1_tgl_surat,was1_tgl_disposisi from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='2' and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
                      $result_sql_level3 = $connection->createCommand($sql_level3)->queryOne();
                      $batas=$result_sql_level3['was1_tgl_surat'];
                      $batas_dispo=$result_sql_level3['was1_tgl_disposisi'];
                      //$batas3=$result_sql_level3['was1_tgl_surat'];
                    }else if($result_max_level['id_level_was1']==3 ){
                      $connection = \Yii::$app->db;
                      $sql_level2 = "select was1_tgl_surat from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3'  and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
                      $result_sql_level2 = $connection->createCommand($sql_level2)->queryOne();
                      $batas=$result_sql_level2['was1_tgl_surat'];
                    }
                    echo $form->field($model, 'was1_tgl_surat',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'displayFormat' => 'dd-MM-yyyy',
                        'options' => [

                            'pluginOptions' => [
                                'startDate' => date("d-m-Y",strtotime($batas)),//date("d-m-Y",strtotime($modelLapdu[0]['tanggal_surat_diterima'])),
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
<?php  } ?> 
<div class="clearfix"></div>
    <div class="col-md-4" style="margin-top:10px;">
        <div class="form-group">
            <!--<label class="control-label col-md-3">WAS-1</label> <br><?php// echo"1".$batas1."/".$_SESSION['is_inspektur_irmud_riksa']."/".$_SESSION['was_register']; ?>  <br><?php// echo"2".$batas2."/".$batas3; ?>-->
            <label class="control-label col-md-4">Kepada  </label>
            <div class="col-md-8">
                <?php 
                $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
                if($var[0]=='1'){
                    $nama_inspektur="Inspektur I";
                }else  if($var[0]=='2'){
                    $nama_inspektur="Inspektur II";
                }else  if($var[0]=='3'){
                    $nama_inspektur="Inspektur III";
                }else  if($var[0]=='4'){
                    $nama_inspektur="Inspektur IV";
                }else  if($var[0]=='5'){
                    $nama_inspektur="Inspektur V";   
                }
                $model->was1_kepada =  $nama_inspektur;
                echo $form->field($model, 'was1_kepada')->textInput(['readonly'=>'readonly']); ?>
                <!-- <input id="was1-inst_satkerkd" class="form-control" type="hidden" maxlength="" name="Was1[inst_satkerkd]" value="<?php //echo $model->inst_satkerkd; ?>"> -->

            </div>
        </div>  
    </div>

    <div class="col-md-4" style="margin-top:10px;">
        <div class="form-group">
            <!--<label class="control-label col-md-3">WAS-1</label>-->
            <label class="control-label col-md-3">Dari</label>
            <div class="col-md-9">
                
               <?php
                $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
                if($var[1]=='1'){
                    $nama_irmud="Irmud Pegasum Dan Kepbang";
                }else  if($var[1]=='2'){
                    $nama_irmud="Irmud Pidum Dan Datun";
                }else  if($var[1]=='1'){
                    $nama_irmud="Irmud Intel Dan Pidsus";
                }
                $model->was1_dari =  $nama_irmud;
                echo $form->field($model, 'was1_dari')->textInput(['readonly'=>'readonly']); ?>

                <!-- <input id="was1-inst_satkerkd" class="form-control" type="hidden" maxlength="" name="Was1[inst_satkerkd]" value="<?php // echo $model->inst_satkerkd; ?>"> -->

            </div>
        </div>  
    </div>

    <div class="col-md-3" style="margin-top:10px;">
        <div class="form-group">
            <label class="control-label col-md-3">Lampiran</label>
            <div class="col-md-9">
                <!-- <input class="form-control" type="text" maxlength="" name="lampiran" value="<?php echo $modelLapdu[0]['perihal_lapdu']; ?>"> -->
                <?php echo $form->field($model, 'was1_lampiran')->textInput();?>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-2">Perihal</label>
          <div class="col-md-12">
              <!-- <textarea name="perihal" row='3'> -->
                 <!--  <?php //echo $modelLapdu[0]['perihal_lapdu']; 
                  //echo $form->field($model, 'perihal')->textArea;
                  ?> -->
                   <?php if (!$model->isNewRecord) { 
                    // if($modelWas1[0]['id_level_was1']=='1'){
                    //       $model->was1_perihal=$loadWas1['was1_perihal'];
                    //  }
                   echo $form->field($model, 'was1_perihal')->textarea(['rows' => 3]);
                  }else{ 
                    if($modelWas1['id_level_was1']=='1'){
                          $model->was1_perihal=$loadWas1['was1_perihal'];
                     }else{
                          $model->was1_perihal=$modelLapdu[0]['perihal_lapdu'];
                      }
                   echo $form->field($model, 'was1_perihal')->textarea(['rows' => 3]);
                    } ?>
              <!-- </textarea> -->
          </div>
        </div>
    </div>

 <div id="wait"  style="display:none;width:69px;height:89px;border:0px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='/image/demo_wait.gif' width="64" height="64" /><br>Loading..</div>

<?php 
$model->id_level_was1='2';
 echo $form->field($model, 'id_level_was1')->hiddenInput()?>

  <?php 
     // $model->no_register=$modelLapdu[0]['no_register'];
     // echo $form->field($model, 'no_register')->hiddenInput();

     // $model->id_tingkat=$modelLapdu[0]['id_tingkat'];
     // echo $form->field($model, 'id_tingkat')->hiddenInput();

     // $model->id_kejati=$modelLapdu[0]['id_kejati'];
     // echo $form->field($model, 'id_kejati')->hiddenInput();
      
     // $model->id_kejari=$modelLapdu[0]['id_kejari'];
     // echo $form->field($model, 'id_kejari')->hiddenInput();

     // $model->id_cabjari=$modelLapdu[0]['id_cabjari'];
     // echo $form->field($model, 'id_cabjari')->hiddenInput();
 ?>
<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
        <div class="form-group">
          <div class="col-md-12">
              <label for="narasi">Narasi Awal <?php //echo $modelWas1['id_level_was1']; ?></label>
               <?php if (!$model->isNewRecord) { 
                   echo $form->field($model, 'was1_narasi_awal')->textarea(['rows' => 3]);
                  }else{ 
                    if($modelWas1['id_level_was1']=='1'){
                          $model->was1_narasi_awal=$loadWas1['was1_narasi_awal'];
                     }else{
                        //  $model->was1_narasi_awal=$modelLapdu[0]['was1_narasi_awal'];
                      }
                   echo $form->field($model, 'was1_narasi_awal')->textarea(['rows' => 3]);
                    } ?>
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

              <?php echo $form->field($model, 'was1_permasalahan')->textarea(['rows' => 3,'value'=>'Sehubungan dengan adanya laporan pengaduan dari '.
                $model_terlapor[0]['names'].$modelLapdu[0]['ringkasan_lapdu']]);
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
                     $data1="<ul>
                                  <li>Identitas Pegawai (yang dilaporkan);<br/>".$dataTerlapor['nama']."</li>
                                  <li>Identitas Pelapor;<br/>".$dataPelapor['nama']."</li>
                                  <li>Dugaan pelanggaran disiplin yang dilaporkan;<br/>".$modelLapdu[0]['ringkasan_lapdu']."</li>
                                  <li>Penelitian surat dan atau laporan (buril);</li>
                              </ul>";   

                  ?>  
                	<?php
                    if(!$model->isNewRecord){
                  ?>
                    			<script type="text/javascript">
                        			$(document).ready(function(){  
                          	   if($("#was1-tgl_disposisi_inspektur-disp").val() !="")
                          	   {
                          	     $("#pilih_bidang_1").addClass("disabled");   
                          	   }
                        	   });
                    	   </script>
                    <?php
                        if($modelWas1['id_level_was1']=='1'){
                            $model->data=$loadWas1['data'];
                       }
                         echo $form->field($model, 'data')->textarea(['class'=>'ckeditor','rows' => 3,'value'=>$model['data']]);
                     ?>
                <?php
            			}else{
                ?>
                <?php 
                       echo $form->field($model, 'data')->textarea(['class'=>'ckeditor','rows' => 3,'value'=>$data1]);  
                   // echo $form->field($model, 'data')->textarea(['rows' => 3,'value'=>'Nama Terlapor '.$model_terlapor[0]['names'].' Nama Pelapor  '.$modelPelapor[0]['nama_pelapor'].' Ringkasan  '.$modelLapdu[0]['ringkasan_lapdu']]);
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
              <?php if (!$model->isNewRecord) { 
                   echo $form->field($model, 'was1_analisa')->textarea(['class'=>'ckeditor','rows' => 3]);
                  }else{ 
                    if($modelWas1['id_level_was1']=='1'){
                          $model->was1_analisa=$loadWas1['was1_analisa'];
                     }else{
                      //    $model->was1_analisa=$modelLapdu[0]['was1_analisa'];
                      }
                   echo $form->field($model, 'was1_analisa')->textarea(['class'=>'ckeditor','rows' => 3]) ;
                    } ?>

          </div>
        </div>
    <!-- </div> -->
</div>

<div class="col-md-12">
 <!-- <div class="col-md-10"> -->
    <div class="form-group">
      <div class="col-md-12">
          <label for="kesimpulan">Kesimpulan</label>
          <?php if (!$model->isNewRecord) { 
                   echo $form->field($model, 'was1_kesimpulan')->textarea(['class'=>'ckeditor','rows' => 3]);
                  }else{ 
                    if($modelWas1['id_level_was1']=='1'){
                          $model->was1_kesimpulan=$loadWas1['was1_kesimpulan'];
                     }else{
                    //      $model->was1_kesimpulan=$modelLapdu[0]['was1_kesimpulan'];
                      }
                   echo $form->field($model, 'was1_kesimpulan')->textarea(['class'=>'ckeditor','rows' => 3]);
                    } ?>
      </div>
    </div>
<!-- </div> -->
</div> 

  <div class="col-md-12">
       <!-- <div class="col-md-10"> -->
          <div class="form-group">
              <!-- <label class="control-label col-md-2"></label> -->
              <div class="col-md-12">
                      <label class="group-border">Saran</label>
                  <fieldset class="group-border">
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
                                         if($modelWas1['id_level_was1']=='1'){
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
                                    <?php if (!$model->isNewRecord) { 
                                       echo $form->field($model, 'was1_uraian')->textarea(['rows' => 3,'readonly'=>'readonly']);
                                      }else{ 
                                        if($modelWas1['id_level_was1']=='1'){
                                              $model->was1_uraian=$loadWas1['was1_uraian'];
                                         }else{
                                           //   $model->was1_uraian=$modelLapdu[0]['was1_uraian'];
                                          }
                                       echo $form->field($model, 'was1_uraian')->textarea(['rows' => 3,'readonly'=>'readonly']);
                                        } ?>

                                  </div>
                               </div>
                            </div>
                   </fieldset>
              </div>
          </div>
      <!-- </div> -->
  </div>

<?php
    $connection = \Yii::$app->db;
    $query1 = "select b.unitkerja_kd from was.penandatangan b where nip='".$_SESSION['nik_user']."'";
    $query = $connection->createCommand($query1)->queryOne();

    $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    if($var[0]=='1' or $var[0]=='2'){
           // echo substr($query['unitkerja_kd'],0,7);
           $x=substr($query['unitkerja_kd'],0,7);
           $cek_irmud="substring(b.unitkerja_kd,1,7)='".$x."'";
    }else{
           // echo substr($query['unitkerja_kd'],0,8);
           $x=substr($query['unitkerja_kd'],0,8);
           $cek_irmud="substring(b.unitkerja_kd,1,8)='".$x."'";
    }
    
    $sql = "select a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan,b.unitkerja_kd,b.kode_level,c.id_jabatan
    from was.penandatangan_surat a
    inner join was.penandatangan b on a.unitkerja_kd=b.unitkerja_kd
    left join was.was_jabatan c on c.id_jabatan=a.id_jabatan
    where b.kode_level='44' and id_surat='was1' and ".$cek_irmud."";
    $result = $connection->createCommand($sql)->queryOne();
?>

<div class="col-md-12">
     <!-- <div class="col-md-10"> -->
       <!--  <div class="form-group"> -->
            <!-- <label class="control-label col-md-2"></label> -->
      <label class="group-border">Penanda Tangan</label>
        <fieldset class="group-border">
                <div class="col-md-12" style="padding: 0px">
                    <div class="col-md-4" style="padding: 0px">
                      <div class="form-group">
                         <label class="control-label col-md-2"></label>
                        <div class="col-md-10" style="margin-left: -2px">
                              <?php
                            //  echo $form->field($model, 'tempat')->textInput(['value'=>'Jakarta']);
                               ?>        
                        </div>
                      </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                           <label class="control-label col-md-1"></label>
                            <div class="col-md-3">
                            <?php
                             echo $form->field($model, 'tgl_cetak')->hiddenInput();
                              echo $form->field($model, 'tempat')->hiddenInput();
                               ?> 

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                      </div>
                    </div>
                </div>


                 <div class="col-md-4">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        <label class="control-label col-md-2">Nip</label>
                        <div class="col-md-10">
                          <?php
                           if(!$model->isNewRecord){
                          echo $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_irmud', "data-toggle"=>"modal", "data-target"=>"#peg_tandatangan"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly']);
                        }else{
                        echo $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_irmud', "data-toggle"=>"modal", "data-target"=>"#peg_tandatangan"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly','value'=>$query['nip']]);
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
                            //echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['nama_pemeriksa']]);
                            echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly','value'=>$query['nama_penandatangan']]);
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
                            if(!$model->isNewRecord){
                              echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                            }else{
                              // echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['jabatan']]);
                              echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly','value'=>$query['jabatan_penandatangan']]);
                            } 
                            ?>
                            <?php
                             if(!$model->isNewRecord){
                              echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            }else{
                              // echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['golongan']]);
                              echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$query['golongan']]);
                            } 
                            ?>

                           <?php
                            if(!$model->isNewRecord){
                              echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            }else{
                              // echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['pangkat']]);
                              echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$query['pangkat']]);
                            } 
                            ?>

                            <?php
                            if(!$model->isNewRecord){
                              echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            }else{
                             echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly','value'=>$query['jabatan']]);
                            } 
                            ?>
                            <?php
                            if(!$model->isNewRecord){
                              echo $form->field($model, 'id_jabatan')->hiddenInput(['readonly'=>'readonly']);
                            }else{
                             echo $form->field($model, 'id_jabatan')->hiddenInput(['readonly'=>'readonly','value'=>$query['id_jabatan']]);
                            } 
                            ?>
                      </div>
                  </div>
                </div>
             </fieldset>
</div>

<?php if (!$model->isNewRecord) { ?> 

  <div class="col-md-12">
     <label class="group-border">Disposisi Inspektur</label>
       <fieldset class="group-border">
        <div class="col-sm-8">
              <div class="form-group">
                  <div class="col-md-12 kejaksaan">
                  <label class="control-label col-md-2" style="padding: 0px">Isi Disposisi</label>
                       <?php 
                       echo $form->field($model, 'was1_isi_disposisi')->textarea(['rows' => 5]) ?>
                      

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
                <label class="control-label col-md-4" style="padding: 0px">Tanggal Disposisi </label>
                    <?php
                     /* $connection = \Yii::$app->db;
                      $query1 = "select id_level_was1 from ";
                      $query = $connection->createCommand($query1)->queryOne();*/
                        if($result_max_level['id_level_was1']=='2'  or $result_max_level['id_level_was1']=='1'){
                            // if($loadWas1['tgl_disposisi_irmud']==''){
                            //     $starTgl=$model->was1_tgl_surat;
                            // }else{
                            //     $starTgl=$loadWas1['tgl_disposisi_irmud'];
                            // }
                                $starTgl=date("d-m-Y",strtotime($batas));
                        }else{
                                $starTgl=date("d-m-Y",strtotime($model->was1_tgl_surat));

                        }
                      
                        echo $form->field($model, 'was1_tgl_disposisi',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'displayFormat' => 'dd-MM-yyyy',
                                    'options' => [

                                        'pluginOptions' => [
                                            // 'startDate' => date("d-m-Y",strtotime($modelLapdu[0]['tanggal_surat_diterima'])),
                                            'startDate' =>   date("d-m-Y",strtotime($starTgl)),
                                            // 'startDate' => '-17y',
                                            'autoclose' => true,
                                        ]
                                    ],
                                ]);
                    ?>       
                     <label class="control-label col-md-10" style="padding:0px"> Unggah File Disposisi Inspektur :

                      <?php if (substr($model['was1_file_disposisi'],-3)!='pdf'){?>
                      <?= ($model['was1_file_disposisi']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&option='.$_GET['option'].'&id_tingkat='.$model['id_tingkat'].'&id_kejati='.$model['id_kejati'].'&id_kejari='.$model['id_kejari'].'&id_cabjari='.$model['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                      <?php } else{?>
                      <?= ($model['was1_file_disposisi']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&option='.$_GET['option'].'&id_tingkat='.$model['id_tingkat'].'&id_kejati='.$model['id_kejati'].'&id_kejari='.$model['id_kejari'].'&id_cabjari='.$model['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                      <?php } ?>

                     </label>

                     <div class="fileupload fileupload-new" data-provides="fileupload">
                        <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                        <span class="fileupload-exists "> Ubah File</span>         <input type="file" name="file_was1" id="file_was1" /></span>
                        <span class="fileupload-preview"></span>
                        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                    </div>
        			<!--  <div class="col-md-1 kejaksaan">
                              <div class="form-group" > -->
                                <?//= ($model->file_disposisi_inspektur !='' ? '<a href="viewpdf?id='.$model['no_register'].'&option='.$model['id_level_was1'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?>
                         <!--      </div>
                </div>
        		 -->
                     <?php
                   

                    ?>

                </div>
                
            </div>
      </div>
    </fieldset>
  </div>
<?php } ?>

<hr style="border-color: #c7c7c7;margin: 10px 0;"> 
    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
        <?//= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <!-- <a class="btn btn-primary ctk" href="#">Cetak</a> -->
        <input name="simpan" type="submit" value="Simpan" class="btn btn-primary" id="simpan"/>
        <input type="hidden" name="print_1" value="2" id="print_1"/>
        <a class="btn btn-primary ctk" href="/pengawasan/was1/index">Batal</a>
      <input name="action" type="submit" value="Cetak" class="btn btn-primary" id="cetak"/>
        <?php if (!$model->isNewRecord) { ?> 
        <?//= Html::Button('Cetak', ['class' => 'cetakwas btn btn-primary']) ?>
          <?php //echo $form->field($model, 'id_was1')->hiddenInput(['name'=>'id']) ?>
        <?php } ?>
        <!--a class="btn btn-primary" href="/pengawasan/was1/index1?id=<?//= $_SESSION['was_register']?>">Kembali</a>-->
        <!-- <a class="btn btn-primary" href="/pengawasan/was1/index">Kembali</a> -->
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<!-- modal PENANDATANGAN -->
<div class="modal fade" id="peg_tandatangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Penandatangan</h4>
                </div>
                <?php 
                 // $gab = $_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2'].'.'.$_SESSION['was_id_level3'];
                  //echo $gab;
                //print_r($_SESSION);//echo strlen('1.6.10.2'); ?>
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
                          <div class="col-md-12" style="margin-bottom:10px;">
                             <div class="form-group">
                                <label class="control-label col-md-2">Cari</label>
                                  <div class="col-md-8 kejaksaan">
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
                            $searchModelWas1 = new Was1Search();
                            $dataProviderPenandatangan = $searchModelWas1->searchPenandatanganIrmud(Yii::$app->request->queryParams);
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
                                            return ['value' => $data['id_surat'],'class'=>'selection_one_tandatangan','json'=>$result];
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

/*Penandatangan-id-grid*/
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

/*upload file*/
/* leave this part out */
/*body{text-align:center; padding-top:30px;}*/
/* leave this part out */

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
/*end upload file*/
</style>

<script type="text/javascript">
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

/*penandatangan*/
$(document).on('click','#tambah_penandatangan',function() {
     var data=JSON.parse($(".selection_one_tandatangan:checked").attr("json"));
  //alert(data.ni);
       $('#was1-nip_penandatangan').val(data.nip);
       $('#was1-nama_penandatangan').val(data.nama);
       $('#was1-jabatan_penandatangan').val(data.nama_jabatan);
       $('#peg_tandatangan').modal('hide');
                                
    });
/*hapus checklist n input text cari grid penandatangan*/
$(document).on('hidden.bs.modal','#peg_tandatangan', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});

  /*////////////reload grid Pemeeriksa surat/////////////////*/
     $(document).on('click','.cari_irmud',function() { 
      $('#grid-penandatangan_surat').addClass('loading');
        $("#grid-penandatangan_surat").load("/pengawasan/was1/getirmud",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penandatangan_surat').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

      $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
        $('#grid-penandatangan_surat').addClass('loading');
      }).on('pjax:success', function(){
        $('#grid-penandatangan_surat').removeClass('loading');
      }); 
</script>