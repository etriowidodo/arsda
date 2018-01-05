
<?php

use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
// use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\grid\GridView;
use kartik\widgets\Select2;
// use kartik\daterange\DateRangePicker;
// use app\modules\pengawasan\models\Wilayah;
// use app\modules\pengawasan\models\Inspektur;
use app\modules\pengawasan\models\SumberPengaduan;
// use app\modules\pengawasan\models\Dokumen;
use app\modules\pengawasan\models\SumberPelapor;
use app\modules\pengawasan\models\Kejagungbidang;
use app\modules\pengawasan\models\Kejagungunit;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use yii\helpers\Url

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php

    $form = ActiveForm::begin([
                'id' => 'irmud',
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

<!-- <input type="text" id="dt1" class="form-control">
<input type="text" id="dt2" class="form-control"> -->


    <div class="box box-primary" style="padding: 15px 0px;">
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">No Surat</label>
                    <div class="col-sm-8 kejaksaan">
                            <?= $form->field($model, 'nomor_surat_lapdu')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-6">Tanggal Surat</label>
                    <div class="col-sm-6 kejaksaan">
                       <?
                       if($model['tanggal_surat_lapdu']!=''){
                        $tgl_lapdu=date("d-m-Y", strtotime($model['tanggal_surat_lapdu']));
                       }
                        ?>
                        <input type="text" id="dt1" class="form-control" name="Lapdu[tanggal_surat_lapdu]" value="<?= $tgl_lapdu ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-5">Media Pelaporan</label>
                    <div class="col-sm-7 kejaksaan">
                        <?=
                        $form->field($model, 'id_media_pelaporan')->dropDownList(
                                ArrayHelper::map(SumberPengaduan::find()->all(), 'id_sumber_pengaduan', 'nm_sumber_pengaduan'), ['prompt' => 'Pilih Sumber','disabled'=>'disabled'],['width'=>'40%']
                        )
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">Di Tunjukkan Kepada</label>
                    <div class="col-sm-8 kejaksaan">
                            <?= $form->field($model, 'kepada_lapdu')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-sm-3">Di Tembuskan Ke</label>
                    <div class="col-sm-9 kejaksaan">
                       <?= $form->field($model, 'tembusan_lapdu')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">No Register</label>
                    <div class="col-sm-8 kejaksaan">
                      <?php
                        // if (!$model->isNewRecord) {
                       echo $form->field($model, 'no_register')->textInput(['maxlength' => true,'readonly'=>'readonly']);
                        // }else{
                        //   echo $form->field($model, 'no_register')->textInput(['maxlength' => true]);
                        // } 
                      ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-6">Tanggal Surat Diterima</label>
                    <div class="col-sm-6 kejaksaan">
                       <?
                       if($model['tanggal_surat_diterima']!=''){
                        $tgl_diterima=date("d-m-Y", strtotime($model['tanggal_surat_diterima']));
                       }
                            ?>
                       <input type="text" id="dt2" class="form-control" name="Lapdu[tanggal_surat_diterima]" value="<?= $tgl_diterima?>" readonly>
                    </div>
                </div>
            </div>
        </div>

<!-- begin Pelapor -->
    <div class="box box-primary">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-sm-6">
                Daftar Pelapor
            </div>
        </div>
        <div class="box-header with-border">
            <table id="table_pelapor" class="table table-bordered tbl_pelapor">
                <thead>
                    <tr>
                        <th width="4%">No</th>
                        <th width="35%">Sumber Laporan</th>
                        <th>Nama Pelapor</th>
                        <th>Alamat</th>
                        <th>No telp</th>
                    </tr>
                </thead>
                <tbody id="tbody_pelapor">
                    <?php
                        $no=1;
                        foreach ($pelapor as $data) {
                            echo "<tr data-nik='".$data['id_pelapor']."' id='trpelapor".$data['id_pelapor']."'>";
                            echo "<td>" . $no . "<input type='hidden' name='nik[]' id='nik' value='" . $data['id_pelapor'] . "' /></td>";

                            if($data['id_sumber_laporan']==11){
                                echo "<td> LSM " . ucwords($data['sumberlain']) . "<input type='hidden' name='txt_sumber[]' value='" . $data['id_sumber_laporan'] . "' /></td>";
							}else{
								 echo "<td>" . ucwords($data['nama_sumber_laporan']) . "<input type='hidden' name='txt_sumber[]' value='" . $data['id_sumber_laporan'] . "' /></td>";
							}
                            echo "<td>" . $data['nama_pelapor'] . "<input type='hidden' name='nama[]' value='" . $data['nama_pelapor'] . "' /></td>";
                            echo "<td>" . $data['alamat_pelapor'] . "<input type='hidden' name='alamat[]' value='" . $data['alamat_pelapor'] . "' /><input type='hidden' name='pekerjaan[]' value='" . $data['pekerjaan_pelapor']. "' /></td>";
                            echo "<td>" . $data['telp_pelapor'] . "<input type='hidden' name='no_telepon[]' value='" . $data['telp_pelapor']. "' /><input type='hidden' name='sumberlainya[]' value='" . $data['sumber_lainnya'] . "' />
                            <input type='hidden' name='tempat_lahir[]' value='" . $data['tempat_lahir_pelapor'] . "' /><input type='hidden' name='tgl_lahir[]' value='" . $data['tanggal_lahir_pelapor'] . "' /><input type='hidden' name='warga[]' value='" . $data['kewarganegaraan_pelapor'] . "' />
                            <input type='hidden' name='agama[]' value='" . $data['agama_pelapor'] . "' /><input type='hidden' name='pendidikan[]' value='" . $data['pendidikan_pelapor'] . "' /><input type='hidden' name='kota[]' value='" . $data['nama_kota_pelapor'] . "' />
                            </td>";
                            echo "</tr>";
                        $no++;
                        }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

<!-- begin Terlapor -->
    <div class="box box-primary">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-sm-6">
                Daftar Terlapor
            </div>
        </div>

        <div class="box-header with-border">
        <table id="table_jpu" class="table table-bordered tbl_terlapor">
            <thead>
                <tr>
                    <th width="4%" rowspan="2" >No</th>
                    <th width="20%" rowspan="2">Nama Terlapor</th>
                    <th rowspan="2">Jabatan</th>
                    <th rowspan="2">Satuan Kerja</th>
                    <th width="23%" align="center" colspan="2" >Pelanggaran</th>
                    <th align="center" colspan="2">Pemeriksa</th>
                </tr>
                <tr>
                    <th>Wilayah</th>
                    <th>Waktu</th>
                <!--ini header judul  -->
                <?php  
					$USER=str_split($_SESSION['is_inspektur_irmud_riksa']);
					if($USER[1]=='1'){
                        $judul1='Pegasum';
                        $judul2='Kepbang';
                    }else if($USER[1]=='2'){
                        $judul1='Pidum';
                        $judul2='Datun';   
                    }else if($USER[1]=='3'){
                        $judul1='Intel';
                        $judul2='Pidsus';   
                    }
                ?>
                <!--ini header judul  -->
                    <th width="7%"><?=$judul1 ?></th>
                    <th width="6%"><?=$judul2 ?></th>
                </tr>
                

            </thead>
            <tbody id="tbody_terlapor">
                <?php
				$BulanIndo = array("","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                    $no=1;
                    foreach ($terlapor as $data) {
                        if($data['id_tingkat_kejadian']=='0'){
                            $nama_wilayah=$data['level2'];
                        }else if($data['id_tingkat_kejadian']=='1'){
                            $nama_wilayah=$data['level1'];
                        }else if($data['id_tingkat_kejadian']=='2'){
                            $nama_wilayah=$data['level2'];
                        }else if($data['id_tingkat_kejadian']=='3'){
                            $nama_wilayah=$data['level3'];
                        }
                        echo '<tr id="trterlapor' . $data['no_urut'] . '">';
                        echo '<td>'.$no.'<input type="hidden" name="no_urut[]" value="' . $data['no_urut'] . '">';
                        echo '<td>'.$data['nama_terlapor_awal'].'<input type="hidden" name="namaTerlapor[]" value="' . $data['nama_terlapor_awal'] . '"></td>';
                        echo '<td>'.$data['jabatan_terlapor_awal'].'<input type="hidden" name="jabatanTerlapor[]" value="' . $data['jabatan_terlapor_awal'] . '"><input type="hidden" name="tgl[]" value="'.$data['tgl_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.$data['satker_terlapor_awal'].'<input type="hidden" name="satkerTerlapor[]" value="' . $data['satker_terlapor_awal'] . '"><input type="hidden" name="bln[]"  value="'.$data['bln_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.$nama_wilayah.'<input type="hidden" name="wilayahTerlapor[]" value="' . $data['id_wilayah'] . '"><input type="hidden" name="thn[]" value="'.$data['thn_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.$data['tgl_pelanggaran_terlapor_awal'].' '.$BulanIndo[date($data['bln_pelanggaran_terlapor_awal'])].' '.$data['thn_pelanggaran_terlapor_awal'].'
                        <input type="hidden" name="waktuTerlapor[]" value="' . $data['tgl_pelanggaran_terlapor_awal'].'-'.$data['bln_pelanggaran_terlapor_awal'].'-'.$data['thn_pelanggaran_terlapor_awal'] . '"><input type="hidden" name="pelanggaranTerlapor[]" value="'.$data['pelanggaran_terlapor_awal'].'">
                        <input type="hidden" name="bidang[]" value="'.$data['id_bidang_kejati'].'"><input type="hidden" name="unit[]" value="'.$data['id_unit_kejari'].'"><input type="hidden" name="cabjari[]" value="'.$data['id_unit_kejari'].'">
                        </td>';
                        echo'<td align="center" class="for_cek1"><input type="hidden" name="cek_1[]" class="cek_1" value="'.($data['pemeriksa1']=='1'?'1':'0').'"><input class="td_pegasum" type="checkbox" name="urut_terlapor[]" '.($data['pemeriksa1']=='1'?"checked":'').'></td>';
                        echo'<td align="center" class="for_cek2"><input type="hidden" name="cek_1[]" class="cek_2" value="'.($data['pemeriksa2']=='2'?'2':'0').'"><input class="td_kepbang" type="checkbox" name="urut_terlapor[]" '.($data['pemeriksa2']=='2'?"checked":'').'></td>';
                        echo '</tr>';
                    $no++;
                    }
                // }
                ?>
            </tbody>
        </table>
        </div>
        </div>

        <!-- baegin perihal -->
        <div class="box box-primary">
            <div class="col-md-12">
                <div class="col-sm-6">
                    <label class="control-label col-md-4" style="padding:0px">Perihal</label>
                    <div class="form-group">
                        <div class="col-md-12 kejaksaan">
                    <?= $form->field($model, 'perihal_lapdu')->textarea(['rows' => 2, 'id'=>'perihal_lapdu','readonly'=>'readonly']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label class="control-label col-md-6" style="padding:0px">Ringkasan/Isi Laporan</label>
                    <div class="form-group">
                        <div class="col-md-12 kejaksaan">
                    <?= $form->field($model, 'ringkasan_lapdu')->textarea(['rows' => 2, 'id'=>'ringkasan_lapdu','readonly'=>'readonly']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding: 15px 0px;">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-md-6">File Inspektur : 
                        <!-- <div class="col-md-8 kejaksaan" style="right:45px;"> -->
						<?php if (substr($modelDisposisi_ins['file_inspektur'],-3)!='pdf'){?>
                        <?= ($modelDisposisi_ins['file_inspektur']!='' ? '<a href="viewpdf1?id='.$modelDisposisi_ins['no_register'].'&id_tingkat='.$_GET['id_tingkat'].'&id_kejati='.$_GET['id_kejati'].'&id_kejari='.$_GET['id_kejari'].'&id_cabjari='.$_GET['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?> <?php echo $modelDisposisi_ins['file_inspektur'];?>
						<?php } else{?>
						   <?= ($modelDisposisi_ins['file_inspektur']!='' ? '<a href="viewpdf1?id='.$modelDisposisi_ins['no_register'].'&id_tingkat='.$_GET['id_tingkat'].'&id_kejati='.$_GET['id_kejati'].'&id_kejari='.$_GET['id_kejari'].'&id_cabjari='.$_GET['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php echo $modelDisposisi_ins['file_inspektur']; } ?> 
                        </label>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Only Irmud -->
        <fieldset class="group-border">
            <legend class="group-border">Disposisi IRMUD <!--?php echo $_SESSION['inspektur']?--></legend>
        <div class="col-md-12">
            <div class="col-sm-8">
                    <label class="control-label col-md-2" style="padding:0px">Isi Disposisi</label>
                <div class="form-group">
                    <div class="col-sm-12 kejaksaan">
                    <?php
                        if($modelDisposisi->isNewRecord){ ?>
                            <textarea id="isi_disposisi_irmud" class="form-control" name="isi_disposisi" rows="4"></textarea>
                        <?php }else{ ?>
                            <textarea id="isi_disposisi_irmud" class="form-control" name="isi_disposisi" rows="4"><?php echo $modelDisposisi['isi_disposisi'] ?></textarea>
                        <?php }
                    ?>
                    </div>
                </div>
            </div>
			
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label col-md-5">Tanggal Disposisi</label>
            <div class="col-md-8 kejaksaan">
            <?php
                if($modelDisposisi->isNewRecord){?>
                <div class='input-group date' id='datetimepicker5'>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    <input type="text" id="dt3" class="form-control" name="tanggal_dis_inspektur">
                </div>
                <?php }else{ ?>
                 <div class='input-group date' id='datetimepicker5'>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    <input type="text" id="dt3" class="form-control" name="tanggal_dis_inspektur" value="<?= ($modelDisposisi['tanggal_disposisi']==''? '':date('d-m-Y',strtotime($modelDisposisi['tanggal_disposisi'])));  ?>">
                </div>
                <?php }?>
            </div>
		
            <div class="col-md-10 kejaksaan">	
             <label class="control-label col-md-12" style="padding:0px">Unggah File Disposisi IRMUD : 
                <?php if (substr($terlapor[0]['file_irmud'],-3)!='pdf'){?>
                  <?= ($terlapor[0]['file_irmud']!='' ? '<a href="viewpdf?id='.$modelDisposisi['no_register'].'&id_tingkat='.$_GET['id_tingkat'].'&id_kejati='.$_GET['id_kejati'].'&id_kejari='.$_GET['id_kejari'].'&id_cabjari='.$_GET['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                <?php } else{?>
                  <?= ($terlapor[0]['file_irmud']!='' ? '<a href="viewpdf?id='.$modelDisposisi['no_register'].'&id_tingkat='.$_GET['id_tingkat'].'&id_kejati='.$_GET['id_kejati'].'&id_kejari='.$_GET['id_kejari'].'&id_cabjari='.$_GET['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                  <?php } ?>
             </label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Upload File </span>
                <span class="fileupload-exists "> Ubah File</span>         <input type="file" name="file_irmud" id="file_irmud" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
            </div>
       	    <!-- <div class="col-md-1 kejaksaan">
                      <div class="form-group" >
					   
                      </div>
            </div> -->
            </div>

            </div>
        </div>
        </fieldset>

    <div class="col-md-12">
        <div class="form-group">
            <div class="box-footer">
                <?php 
                     if( $terlapor[0]['tanggal_disposisi'] == ''){
                        echo Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']); 
                    }       
                 ?>   
                                
                <?php //echo Html::Button('Kembali', ['class' => 'tombolbatalindex btn btn-primary']); ?>
                <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
            </div>
        </div>
    </div> 
    
    <?php ActiveForm::end(); ?>
</section>

<style type="text/css">

.table > thead > tr > th{
    vertical-align: middle!important;
}

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
table, td, th {
    border: 1px solid black;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th {
    text-align: center;
    background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);
}
.ck_bok {
  text-align: center;
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
//Validasi File 3MB (3048576)by Danar
	   $('#file_irmud').bind('change', function() {
        var ext = $('#file_irmud').val().split('.').pop().toLowerCase();
        var batas=this.files[0].size;
        if($.inArray(ext, ['png','jpg','jpeg','pdf']) == -1) {
                    bootbox.dialog({
                        message: "Extension File harus png, jpg, jpeg, dan Pdf",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-primary",

                            }
                        }
                });
                $('#file_irmud').val('');
        }

        if(batas>=2097152) {
                    bootbox.dialog({
                        message: "Maksimal Size File 2 MB",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-primary",

                            }
                        }
                });
                $('#file_irmud').val('');
        }
   
        });
       $('#dt3').datepicker({
        dateFormat: "dd-mm-yy",
         maxDate: 0,
         minDate: "<?php echo date('d-m-Y',strtotime($modelDisposisi_ins['tanggal_disposisi'])) ?>",
    }); 

/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

    
 window.onload = function () {


     $(document).on('click', '.td_pegasum', function () {
           var x=$(this).prop('checked');
           // var z=$(this).closest("td");
              if(x==true){
                $(this).closest(".for_cek1").find('.cek_1').attr('value','1');

             }else{
                $(this).closest(".for_cek1").find('.cek_1').attr('value','0');
             }
          });
      $(document).on('click', '.td_kepbang', function () {
           var x=$(this).prop('checked');
           // var z=$(this).closest("td");
              if(x==true){
                $(this).closest(".for_cek2").find('.cek_2').attr('value','2');

             }else{
                $(this).closest(".for_cek2").find('.cek_2').attr('value','0');
             }
          });
}


</script>




