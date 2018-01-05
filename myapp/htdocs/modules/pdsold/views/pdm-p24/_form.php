<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use app\components\GlobalFuncComponent;
use yii\helpers\Url;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP24 */
/* @var $form yii\widgets\ActiveForm */
//jaka | 21 Juni 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(
  "$('#p24-form').on('afterValidate', function (event, messages) {
     
    if(typeof $('.has-error').first().offset() !== 'undefined') {
      var scroll     = $('.has-error').first().closest(':visible').offset().top;
      var minscroll  = (86.6/100)*scroll;
        $('html, body').animate({
            scrollTop: ($('.has-error').first().closest(':visible').offset().top)-minscroll
        }, 1500);
        var lenghInput = $('.has-error div input[type=text]').length;
        var lenghSearch = $('.has-error div input[type=search]').length;
         $('.has-error div input').first().focus();  
        if(lenghInput==0)
        {
          var minscrollText = (39/100)*($(document).height()-$(window).height());
          $('html, body').animate({
            scrollTop: ($(document).height()-$(window).height())-minscrollText
        }, 1500);
           $('.has-error div textarea').first().focus();
        }
        
      }
  });
  
  
  "
  );
//END <-- CMS_PIDUM001 -->
?>


<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">
<div class="box box-primary">
    <div class="box-header"></div>
    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'p24-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 1,
                'showLabels' => false

            ]
        ]);
		
		
    ?>
	
    <div class="box-body">
        <div class="form-group hide" style="margin-left:10px">
            <label class="control-label col-md-2">Wilayah Kerja</label>

            <div class="col-md-4">
                <input class="form-control" value="<?php echo \Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
            </div>
        </div>		
		 
        <div class="form-group" style="margin-left:10px">
            <label class="control-label col-md-2" style="">Tanggal Berita Acara</label>
			<?php $TglMulai = date('d-m-Y', strtotime($modelBerkas->tgl_pengiriman)) ?>
		
            <div class="col-md-2" id='tgl_ba'>
                <?= $form->field($model, 'tgl_ba')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => ['placeholder' => 'DD-MM-YYYY','style'=>'width:75%'],//jaka rubah format tanggal
                        'pluginOptions' => [
                            'autoclose' => true,
							//'startDate' => $TglMulai,
							//'endDate' => '+30d',
							'endDate'=>date('d-m-Y'),
                        ]
                    ]
                ]); ?>
				
            </div>
        </div>
		
<!--     
        <div class="panel box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Referensi </h3>
            </div>
            <div class="form-group" style="margin-left:10px">
                <label for="nomor" class="control-label col-md-2">Nomor</label>

                <div class="col-md-4"><input type="text" class="form-control" value="<?= $modelSpdp->no_surat ?>"
                                             readonly="true">
                </div>
            </div>

            <div class="form-group" style="margin-left:10px">
                <label for="tanggal" class="control-label col-md-2">Tanggal</label>

                <div class="col-md-4"><input type="text" class="form-control"
                                             value=""
                                             readonly="true"></div>
            </div>
        </div>
-->

        <div class="panel box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><!--Danar Wido 22/06/2016 P24_04 -->
                    Jaksa P-16 Nomor : <?php echo $modelP16->no_surat ; ?> | Tanggal : <?php echo date('d-m-Y', strtotime($modelP16->tgl_dikeluarkan)) ;?>
                </h3>
				<!-- End Danar Wido 22/06/2016 P24_04 -->
            </div>
           
		   <div class="box-header with-border">


                <table id="table_jpu" class="table table-bordered table-striped">
                    <thead>
                        <tr><!--jaka CMSPIDUM | edit tampilan grid-->
                            <th style="text-align:center;">#</th>
                            <th>Nama<br>NIP</th>
                            <th>Pangkat<br>Jabatan</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_jpu">
                        <?php //if (!$model->isNewRecord): ?>
                            <?php foreach ($modelJpu as $key => $value): ?>
                                <tr id="trjpu<?= $value['id_jpp'] ?>">

                                    <td style="width:60px;text-align:center"><?= $key+1 ?></td>
                                    <td style="width:400px;"><?= $value->nama ?><br><?= $value->nip ?></td>
                                    <td><?= $value->pangkat ?><br><?= $value->jabatan ?></td>
                                    <!--
                                    <td style="width:60px;"><input type="text" name="no_urut[]" class="form-control" readonly="true" value="<?= ($value['no_urut'] == null) ? $key+1:$value['no_urut'] ?>"></td>
                                    <td style="width:170px;"><input type="text" name="nip_jpu[]" class="form-control" readonly="true" value="<?= $value['peg_nip_baru'] ?>"><?= $value->nama ?></td>
                                    <td style="width:180px"><input type="text" name="nama_jpu[]" class="form-control" readonly="true" value="<?= $value->nama ?>"></td>
                                    <td><input type="text" name="gol_jpu[]" class="form-control" readonly="true" value="<?= $value->pangkat ?>"></td>
                                    <td style="width:500px;"><input type="text" name="jabatan_jpu[]" class="form-control" readonly="true" value="<?= $value->jabatan ?>"></td>
                                    end CMSPIDUM-->
                                </tr>
                            <?php endforeach; ?>
                        <?php //endif; ?>
                    </tbody>
                </table>
            </div>
		   
        </div>
 <!--      
        <div class="panel box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Pertimbangan</h3>
            </div>
            <?php
            if ($modelTersangka != null) {
                foreach ($modelTersangka as $key => $value) {
                    // echo "<tr><td>".$value['nama']."</td></tr>";
                    ?>
                    <div class="form-group" style="margin-left:10px">
                        <label for="id_p17" class="control-label col-md-2">Nama Tersangka <?php echo $key+1?></label>

                        <div class="col-md-4"><input type="text" class="form-control" value="<?= $value['nama'] ?>"
                                                     readonly="true"></div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
-->        

        <div class="panel box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Hasil Penelitian</h3>
            </div>
			<div class="form-group" style="margin-left:20px">
            <div class="form-group">
                <label for="ket_saksi" class="control-label col-md-2">Keterangan Saksi</label>

                <div class="col-md-6"><?= $form->field($model, 'ket_saksi')->textarea() ?></div>
            </div>

            <div class="form-group">
                <label for="ket_ahli" class="control-label col-md-2">Keterangan Ahli</label>

                <div class="col-md-6"><?= $form->field($model, 'ket_ahli')->textarea() ?></div>
            </div>

            <div class="form-group">
                <label for="alat_bukti" class="control-label col-md-2">Alat Bukti Surat</label>

                <div class="col-md-6"><?= $form->field($model, 'alat_bukti')->textarea() ?></div>
            </div>

            <div class="form-group">
                <label for="benda_sitaan" class="control-label col-md-2">Petunjuk/Benda Sitaan</label><!--jaka edit jadi Petunjuk/Benda Sitaan-->

                <div class="col-md-6"><?= $form->field($model, 'benda_sitaan')->textarea() ?></div>
            </div>

            <div class="form-group">
                <label for="ket_tersangka" class="control-label col-md-2">Keterangan Tersangka</label>

                <div class="col-md-6"><?= $form->field($model, 'ket_tersangka')->textarea() ?></div>
            </div>

            <div class="form-group">
                <label for="fakta_hukum" class="control-label col-md-2">Fakta Hukum</label>

                <div class="col-md-6"><?= $form->field($model, 'fakta_hukum')->textarea() ?></div>
            </div>

            <div class="form-group">
                <label for="yuridis" class="control-label col-md-2">Pembahasan Yuridis</label><!-- jaka edit jadi Pembahasan Yuridis-->

                <div class="col-md-6"><?= $form->field($model, 'yuridis')->textarea() ?></div>
            </div>

            <div class="form-group">
                <label for="kesimpulan" class="control-label col-md-2">Kesimpulan</label>

                <div class="col-md-6"><?= $form->field($model, 'kesimpulan')->textarea() ?></div>
            </div>

            <div class="form-group" > 
                <label for="pendpat" class="control-label col-md-2" style="width:15%;">Pendapat</label>
                <?php if($model->isNewRecord){
                    $id_pendapat   = explode(",", $modelCeklis1->id_pendapat_jaksa);
                    $id_pendapat1   = $id_pendapat[0];
                ?>
                    <div class="col-md-6" style="width:70%;">
                        <?php
                            $pendapat1 = "Berkas perkara telah memenuhi persyaratan untuk dilimpahkan ke Pengadilan"; // lengkap
                            $pendapat2 = "Masih perlu melengkapi berkas perkara dengan melakukan pemeriksaan tambahan";
                            //$pendapat3 = "Belum ada pendapat"; //optimal	
                        ?>
                        <?php if ($id_pendapat1 == 1){?>
                            <div class="radio">
                                <label><input type="radio" checked="checked" name="PdmP24[id_pendapat]" value="1"><?= $pendapat1?></label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" name="PdmP24[id_pendapat]" value="2"><?= $pendapat2?></label>
                            </div>
                        <?php } else {?>

                            <div class="radio">
                                <label><input type="radio" name="PdmP24[id_pendapat]" value="1"><?= $pendapat1?></label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" checked="checked" name="PdmP24[id_pendapat]" value="2"><?= $pendapat2?></label>
                            </div>
                        <?php }?>   
                    </div>
                    <?php }else{ ?>
                <div class="col-md-6" style="width:70%;">
                    <?php
                        $pendapat1 = "Berkas perkara telah memenuhi persyaratan untuk dilimpahkan ke Pengadilan"; // lengkap
                        $pendapat2 = "Masih perlu melengkapi berkas perkara dengan melakukan pemeriksaan tambahan";
                        //$pendapat3 = "Belum ada pendapat"; //optimal	
                    ?>	
                    <?=	
                        $form->field($model, 'id_pendapat')->radioList(
                            [1 => $pendapat1, 2 => $pendapat2],
                            ['style' => 'border:0px solid #e4e4e4;padding: 0px 0px 8px 17px;']
                        )		
                    ?>
                    <?= $form->field($model, 'pendapat')->input('hidden') ?>
                </div>
                <?php }?>
                <div class="col-md-1" style="margin-left: -30px;margin-top: -5px;">
                </div>
                
                <br/>
            </div>
			
			<div class="panel box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Tersangka
                </h3>
            </div>
           
		   <div class="box-header with-border">


                <table id="table_grid_tersangka" class="table table-bordered table-striped">
                    <thead>
                            <th style="text-align:center;width:60px;">#</th>
                            <th>Nama</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_grid_tersangka">
                         <?php $i=1; foreach ($modelGridTersangka as $key => $value): ?>
                                <tr>
									<td><?=$i?></td>
									<td><?=$value->nama?></td>
									<td><?=$value->tmpt_lahir.",&nbsp;".date('d-m-Y',strtotime($value->tgl_lahir))?></td>
									<td><?php if($value->id_jkl=='1'){echo 'Laki-laki';}else if($value->id_jkl=='2'){ echo 'Perempuan';}else{echo'';}?></td>
									<td><?=$value->umur." Tahun"?></td>
                                </tr>
                            <?php $i++; endforeach; ?>
                        <?php //endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
			</div>
        </div>
       
        <div class="panel box box-warning">
			<div class="box-header with-border">
            
				<label for="saran" class="control-label col-md-2"></label>

				<div class="col-md-6"><?= $form->field($model, 'saran_disetujui')->radioList(['1' => 'Setuju Pendapat', '0' => 'Tidak Setuju Pendapat'],['inline'=>true])->label(false) ?></div>
			</div>
			
			<div class="box-header with-border">		
				<?php if(strlen($modelSpdp->wilayah_kerja) >= 5){ ?>
				
					<label for="saran" class="control-label col-md-2">Saran Kasi Pidum</label>

					<div class="col-md-6"><?= $form->field($model, 'saran')->textarea() ?></div>
				
				<?php } ?>
				
				<?php if(strlen($modelSpdp->wilayah_kerja) == 2 && $modelSpdp->wilayah_kerja != '00'){ ?>
				
					<label for="saran" class="control-label col-md-2">Saran Aspidum</label>

					<div class="col-md-6"><?= $form->field($model, 'saran')->textarea() ?></div>
				
				<?php } ?>
				
				<?php if($modelSpdp->wilayah_kerja == '00'){ ?>
				
					<label for="saran" class="control-label col-md-2">Saran Direktur</label>

					<div class="col-md-6"><?= $form->field($model, 'saran')->textarea() ?></div>
			
				<?php } ?>
			</div>
			
			<div class="box-header with-border">
            
				<label for="saran" class="control-label col-md-2"></label>

				<div class="col-md-6"><?= $form->field($model, 'petunjuk_disetujui')->radioList(['1' => 'Setuju Saran', '0' => 'Tidak Setuju Saran'],['inline'=>true])->label(false) ?></div>
			</div>
            
            
			
            <div class="box-header with-border">
            
            <?php if(strlen($modelSpdp->wilayah_kerja) >= 5){ ?>
            
                <label for="petunjuk" class="control-label col-md-2">Petunjuk Kejari</label>

                <div class="col-md-6"><?= $form->field($model, 'petunjuk')->textarea() ?></div>
            
			<?php } ?>
			
			<?php if(strlen($modelSpdp->wilayah_kerja) == 2 && $modelSpdp->wilayah_kerja != '00'){ ?>
            
                <label for="petunjuk" class="control-label col-md-2">Petunjuk Kejati</label>

                <div class="col-md-6"><?= $form->field($model, 'petunjuk')->textarea() ?></div>
            
			<?php } ?>
			
			<?php if($modelSpdp->wilayah_kerja == '00'){ ?>
			
                <label for="petunjuk" class="control-label col-md-2">Petunjuk JAMPIDUM</label>

                <div class="col-md-6"><?= $form->field($model, 'petunjuk')->textarea() ?></div>
            
			<?php } ?>
			
			 <div class="class-md-12 pull-right" style="width:400px;">
		
                <div class="col-md-6"style="margin-left:50px;">
				               Penanda Tangan
                    <?php
					
					 echo "<select name='idttd' class='form-control' style='width:235px;'>
					 <option>Pilih Penanda Tangan</option>"; 
	
		  foreach ($modelJpu as $key => $value)
          {
            if($model->id_penandatangan != null and ($model->id_penandatangan==$value->nip))
                {
            
			     echo  "<option  value='".$value->nip."' selected>".$value->nama."</option>";
               }
               else
               {
                 echo  "<option  value='".$value->nip."'>".$value->nama."</option>";
               }
		  }   
 echo "</select><br>";
                    ?>
                </div>
            </div>
        </div>
            
            <div class="box box-primary"  style="border-color: #f39c12;padding: 13px;overflow: hidden;">
            <div class="row">
                <div class="col-md-12" style="margin-top: 15px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Upload File</label>
                            <div class="col-md-4">  
                            <?php
                                $preview = "";
                                if($model->file_upload!=""){
//                                    $preview = ["<a href='".$model->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
//                                                 ];
                                    echo '<object width="160px" id="print" height="160px" data="'.$model->file_upload.'"></object>';
                                }
                                echo FileInput::widget([
                                    'name' => 'attachment_3',
                                    'id'   =>  'filePicker',
                                    'pluginOptions' => [
                                        'showPreview' => true,
                                        'showCaption' => true,
                                        'showRemove' => true,
                                        'showUpload' => false,
                                        'initialPreview' =>  $preview
                                    ],
                                ]);
                            ?>


                            <?= $form->field($model, 'file_upload')->hiddenInput()?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      

    </div>
		 
		<div class="box-footer" style="text-align: center;">
                    <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
                    <?php if ($model->isNewRecord) {?>
                        <a class="btn btn-warning" href="<?= Url::to(['pdm-p24/cetakdraft?id_pengantar='.$id_pengantar]) ?>">Cetak Draf</a>
                    <?php  } else {?>
                        <!--<a class="btn btn-warning" href="<?= $model->file_upload?>" target="_blank">Cetak</a>-->     
                        <!--<a class="btn btn-warning" href="<?// Url::to(['pdm-p24/cetak?id_p24=' . $model->id_p24.'&id_berkas='.$_GET['id_berkas']]) ?>">Cetak</a>-->     
                    <?php  }?>
		</div>
	
	<hr style="border-color: #c7c7c7; margin:10 px 0;">

	</div>


<?php ActiveForm::end();  ?>
<div>
</section>

<?php
$script = <<< JS
		
        var handleFileSelect = function(evt) {
            var files = evt.target.files;
            var file = files[0];

            if (files && file) {
                var reader = new FileReader();
                // console.log(file);
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var mime = "data:"+file.type+";base64,";
                    console.log(mime);
                    document.getElementById("pdmp24-file_upload").value = mime+btoa(binaryString);
                    // window.open(mime+btoa(binaryString));
                };
                reader.readAsBinaryString(file);
            }
        };

        if (window.File && window.FileReader && window.FileList && window.Blob) {
            document.getElementById('filePicker').addEventListener('change', handleFileSelect, false);
        } else {
            alert('The File APIs are not fully supported in this browser.');
        }
        

                        // date            = '$modelCeklis';
                        // var someDate    = new Date(date);
                        // var endDate     = new Date();
                        // //someDate.setDate(someDate.getDate()+7);
                        // someDate.setDate(someDate.getDate());
                        // endDate.setDate(endDate.getDate());
                        // var dateFormated        = someDate.toISOString().substr(0,10);
                        // var enddateFormated     = endDate.toISOString().substr(0,10);
                        // var resultDate          = dateFormated.split('-');
                        // var endresultDate       = enddateFormated.split('-');
                        // finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
                        // date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
                        // var input               = $('#tgl_ba').html();
                        // var datecontrol         = $('#pdmp24-tgl_ba-disp').attr('data-krajee-datecontrol');
                        // $('#tgl_ba').html(input);
                        // var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
                        // var datecontrol_001 = {'idSave':'pdmp24-tgl_ba','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
                        //   $('#pdmp24-tgl_ba-disp').kvDatepicker(kvDatepicker_001);
                        //   $('#pdmp24-tgl_ba-disp').datecontrol(datecontrol_001);
                        //   $('.field-pdmp24-tgl_ba-disp').removeClass('.has-error');
					
            $("input[name='PdmP24[pendapat]").change(function(){
                // var val = $(this).val();
                // if (val.indexOf('Berkas') > -1) {
                //     console.log('Lengkap');
                //     $('#hasil_berkas').val(1);
                // }else if(val.indexOf('pemeriksaan tambahan') > -1) {
                //     console.log('Tidak Lengkap');
                //     $('#hasil_berkas').val(2);
                // }else{
                //     console.log('Optimal');
                //     $('#hasil_berkas').val(3);
                // }
            }); 
$('input[name="PdmP24[id_pendapat]"').on('click',function(){
    $('#pdmp24-pendapat').val(($(this).val()==1)?'$pendapat1':'$pendapat2');
})
JS;
$this->registerJs($script);
?>
	
