<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\WasDisposisiInspektur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was-disposisi-inspektur-form">

    <?php $form = ActiveForm::begin([
                // 'id' => 'inspektur',
                // 'type' => ActiveForm::TYPE_HORIZONTAL,
                // 'enableAjaxValidation' => false,
                // 'fieldConfig' => [
                //     'autoPlaceholder' => false
                // ],
                'options'=>['enctype'=>'multipart/form-data'] ,
                // 'formConfig' => [
                //     'deviceSize' => ActiveForm::SIZE_SMALL,
                //     'showLabels' => true
                // ]
    ]); ?>

    <div class="box box-primary" style="padding: 15px 0px;">
        <div class="col-md-12" style="margin-bottom: 15px;">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">No Surat</label>
                    <div class="col-sm-8 kejaksaan">
                           <input id="lapdu-nomor_surat_lapdu" class="form-control" type="text" maxlength="50" readonly="readonly" value="<?= $modelLapdu['nomor_surat_lapdu']?>" name="nomor_surat_lapdu">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                    <label class="control-label col-sm-6" style="padding: 0px">Tanggal Surat</label>
                <div class="form-group">
                    <div class="col-sm-6 kejaksaan">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="text" id="dt1" class="form-control" name="tanggal_surat_lapdu" value="<?= $modelLapdu['tanggal_surat_lapdu']?>" readonly>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-5">Media Pelaporan</label>
                    <div class="col-sm-7 kejaksaan">
                        <select disabled="disabled" name="id_media_pelaporan" class="form-control" id="lapdu-id_media_pelaporan">
                            <option value="">Pilih Sumber</option>
                            <option value="4" <?= ($modelLapdu['id_media_pelaporan']=='4'?'selected':'')?>>Web Kejaksaan RI</option>
                            <option value="1" <?= ($modelLapdu['id_media_pelaporan']=='1'?'selected':'')?>>Via Pos</option>
                            <option value="2" <?= ($modelLapdu['id_media_pelaporan']=='2'?'selected':'')?>>Datang Langsung</option>
                            <option value="3" <?= ($modelLapdu['id_media_pelaporan']=='3'?'selected':'')?>>Media Massa</option>
                            <option value="5" <?= ($modelLapdu['id_media_pelaporan']=='5'?'selected':'')?>>Email</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">Di Tunjukkan Kepada</label>
                    <div class="col-sm-8 kejaksaan">
                            <input id="lapdu-kepada_lapdu" class="form-control" type="text" maxlength="50" readonly="readonly" value="<?= $modelLapdu['kepada_lapdu']?>" name="kepada_lapdu">
                    </div>
                </div>
            </div>
            <div class="col-md-8" style="padding-left: 4px;">
                <div class="form-group">
                    <label class="control-label col-sm-3">Di Tembuskan Ke</label>
                    <div class="col-sm-6 kejaksaan">
                      <input id="lapdu-tembusan_lapdu" class="form-control" type="text" maxlength="50" readonly="readonly" value="<?= $modelLapdu['tembusan_lapdu']?>" name="tembusan_lapdu">
                    </div>
                </div>
            </div>
                <?php   ?>
        </div>

        <div class="col-md-12" style="margin-bottom: 15px;">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">No Register</label>
                    <div class="col-sm-8 kejaksaan">
                     <input id="lapdu-no_register" class="form-control" type="text" maxlength="25" readonly="readonly" value="<?= $modelLapdu['no_register']?>" name="no_register">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-6" style="padding-left: 1px;">Tanggal Surat Diterima</label>
                    <div class="col-sm-6 kejaksaan">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                       <input type="text" id="dt2" class="form-control" name="tanggal_surat_diterima" value="<?= date('d-m-Y',strtotime($modelLapdu['tanggal_surat_diterima']))?>" readonly>
                    </div>
                    </div>
                </div>
            </div>
           
    <div class="clearfix"></div>
     <div class="box box-primary" style="margin-top: 15px;">

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
                    // if (!$model->isNewRecord) {
                        $no=1;
                        foreach ($pelapor as $data) {
                            echo "<tr data-nik='".$data['id_pelapor']."' id='trpelapor".$data['id_pelapor']."'>";
                            echo "<td>" . $no . "<input type='hidden' name='nik[]' id='nik' value='" . $data['id_pelapor'] . "' /></td>";
                           if($data['id_sumber_laporan']==11){
                            echo "<td> LSM " . ucwords($data['sumberlain']) . "<input type='hidden' name='txt_sumber[]' value='" . $data['id_sumber_laporan'] . "' /></td>";
                                }else{
                                 echo "<td>" . ucwords($data['nama_sumber_laporan']) . "<input type='hidden' name='txt_sumber[]' value='" . $data['id_sumber_laporan'] . "' /></td>";
                                }
                            echo "<td>" . ucwords($data['nama_pelapor']) . "<input type='hidden' name='nama[]' value='" . $data['nama_pelapor'] . "' /></td>";
                            echo "<td>" . $data['alamat_pelapor'] . "<input type='hidden' name='alamat[]' value='" . $data['alamat_pelapor'] . "' /><input type='hidden' name='pekerjaan[]' value='" . $data['pekerjaan_pelapor']. "' /></td>";
                            echo "<td>" . $data['telp_pelapor'] . "<input type='hidden' name='no_telepon[]' value='" . $data['telp_pelapor']. "' /><input type='hidden' name='sumberlainya[]' value='" . $data['sumber_lainnya'] . "' />
                            <input type='hidden' name='tempat_lahir[]' value='" . $data['tempat_lahir_pelapor'] . "' /><input type='hidden' name='tgl_lahir[]' value='" . $data['tanggal_lahir_pelapor'] . "' /><input type='hidden' name='warga[]' value='" . $data['kewarganegaraan_pelapor'] . "' />
                            <input type='hidden' name='agama[]' value='" . $data['agama_pelapor'] . "' /><input type='hidden' name='pendidikan[]' value='" . $data['pendidikan_pelapor'] . "' /><input type='hidden' name='kota[]' value='" . $data['nama_kota_pelapor'] . "' />
                            </td>";
                            echo "</tr>";
                        $no++;
                        }
                    // }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

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
                    <th width="4%" rowspan="2" style="vertical-align:middle">No</th>
                    <th width="20%" rowspan="2" style="vertical-align:middle">Nama Terlapor</th>
                    <th rowspan="2" style="vertical-align:middle">Jabatan</th>
                    <th rowspan="2" style="vertical-align:middle">Satuan Kerja</th>
                    <th align="center" colspan="2" style="text-align: center" >Pelanggaran</th>
                    <th width="10%" align="center" colspan="3" style="text-align: center">Inspektur Muda</th>
                    <!-- <th width="15%" align="center" colspan="3">IRMUD</th> -->
                </tr>
                <tr>
                    <th style="vertical-align: middle;text-align: center;background-color:rgba(178, 214, 250, 1);color: #0f5e86;">Wilayah</th>
                    <th style="vertical-align: middle;text-align: center;background-color:rgba(178, 214, 250, 1);color: #0f5e86;">Waktu</th>
                    <th width="7%" rowspan="2" style="vertical-align: middle;text-align: center;background-color:rgba(178, 214, 250, 1);color: #0f5e86;">Pegasum <br>& <br> Kepbang</th>
                    <th width="6%" rowspan="2" style="vertical-align: middle;text-align: center;background-color:rgba(178, 214, 250, 1);color: #0f5e86;">Pidum <br>& <br> Datun</th>
                    <th width="5%" rowspan="2" style="vertical-align: middle;text-align: center;background-color:rgba(178, 214, 250, 1);color: #0f5e86;">Intel <br>& <br>Pidsus </th>
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
                        echo '<td>'.ucwords($data['nama_terlapor_awal']).'<input type="hidden" name="namaTerlapor[]" value="' . $data['nama_terlapor_awal'] . '"></td>';
                        echo '<td>'.ucwords($data['jabatan_terlapor_awal']).'<input type="hidden" name="jabatanTerlapor[]" value="' . $data['jabatan_terlapor_awal'] . '"><input type="hidden" name="tgl[]" value="'.$data['tgl_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.ucwords($data['satker_terlapor_awal']).'<input type="hidden" name="satkerTerlapor[]" value="' . $data['satker_terlapor_awal'] . '"><input type="hidden" name="bln[]"  value="'.$data['bln_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.$nama_wilayah.'<input type="hidden" name="wilayahTerlapor[]" value="' . $data['id_wilayah'] . '"><input type="hidden" name="thn[]" value="'.$data['thn_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.$data['tgl_pelanggaran_terlapor_awal'].' '.$BulanIndo[date($data['bln_pelanggaran_terlapor_awal'])].' '.$data['thn_pelanggaran_terlapor_awal'].'
                        <input type="hidden" name="waktuTerlapor[]" value="' . $data['tgl_pelanggaran_terlapor_awal'].'-'.$data['bln_pelanggaran_terlapor_awal'].'-'.$data['thn_pelanggaran_terlapor_awal'] . '"><input type="hidden" name="pelanggaranTerlapor[]" value="'.$data['pelanggaran_terlapor_awal'].'">
                        <input type="hidden" name="bidang[]" value="'.$data['id_bidang_kejati'].'"><input type="hidden" name="unit[]" value="'.$data['id_unit_kejari'].'"><input type="hidden" name="cabjari[]" value="'.$data['id_unit_kejari'].'">
                        </td>';
                      if($data['id_inspektur']==$_SESSION['inspektur']){
                          echo'<td align="center" class="for_cek1"><input type="hidden" name="cek_1[]" class="cek_1" value="'.$data['irmud1'].'"><input class="td_pegasum" type="checkbox" name="pegasum[]" value="" '.($data['irmud1'] =='1'?"checked":"").'></td>';
                          echo'<td align="center" class="for_cek2"><input type="hidden" name="cek_1[]" class="cek_2" value="'.$data['irmud2'].'"><input class="td_pidum" type="checkbox" name="pidum[]" value="" '.($data['irmud2'] =='2'?"checked":"").'></td>';
                          echo'<td align="center" class="for_cek3"><input type="hidden" name="cek_1[]" class="cek_3" value="'.$data['irmud3'].'"><input class="td_intel" type="checkbox" name="intel[]" value="" '.($data['irmud3'] =='3'?"checked":"").'></td>';  
                      }else{
                          echo'<td align="center" class="for_cek1"></td>';
                          echo'<td align="center" class="for_cek2"></td>';
                          echo'<td align="center" class="for_cek3"></td>';
                      }
                      
                        echo '</tr>';
                    $no++;
                    }
                ?>

            </tbody>
        </table>
        </div>
</div>
        
        
        <!-- baegin perihal -->
        <div class="box box-primary">
        <div class="col-md-12">
            <div class="col-sm-6">
                    <label class="control-label col-md-4" style="padding:12px">Perihal</label>
                <div class="form-group">
                    <div class="col-md-12 kejaksaan">
                   
                    <textarea id="perihal_lapdu" class="form-control"  name="perihal_lapdu" rows="3" readonly="readonly"><?php echo $modelLapdu['perihal_lapdu']?></textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                    <label class="control-label col-md-6" style="padding:12px">Ringkasan/Isi Laporan</label>
                <div class="form-group">
                    <div class="col-md-12 kejaksaan">
                        <textarea id="ringkasan_lapdu" class="form-control" rows="3" name="ringkasan_lapdu" readonly="readonly"><?php echo $modelLapdu['ringkasan_lapdu']?></textarea>
                    </div>
                </div>
            </div>
        </div>

         <div class="col-md-12" style="padding: 15px 0px;">
            <div class="col-sm-8">
                <div class="form-group">
                    <!-- <label class="control-label col-md-3">Upload File</label> -->
                    <div class="col-md-5 kejaksaan">
                        <label class="control-label col-md-6">File Lapdu: </label>  
                    </div>
                    <div class="col-md-3 kejaksaan" style="right:26%;">
                    
                      <div class="form-group">                      
                         <?php if (substr($modelLapdu['file_lapdu'],-3)!='pdf'){?>
                        <?= ($modelLapdu->file_lapdu!='' ? '<a href="viewpdf1?id='.$modelLapdu['no_register'].'&id_tingkat='.$modelLapdu['id_tingkat'].'&id_kejati='.$modelLapdu['id_kejati'].'&id_kejari='.$modelLapdu['id_kejari'].'&id_cabjari='.$modelLapdu['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?> <?php echo $model['file_inspektur']; ?>
                        <?php } else{?>
                        <?= ($modelLapdu->file_lapdu!='' ? '<a href="viewpdf1?id='.$modelLapdu['no_register'].'&id_tingkat='.$modelLapdu['id_tingkat'].'&id_kejati='.$modelLapdu['id_kejati'].'&id_kejari='.$modelLapdu['id_kejari'].'&id_cabjari='.$modelLapdu['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php  echo $model['file_inspektur']; } ?>
                      </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

         <?php
        $connection = \Yii::$app->db;
        $sql="select*from was.was_disposisi_inspektur where no_register='".$modelLapdu['no_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_inspektur='".$_SESSION['inspektur']."'";
        // echo $sql;
        $disposisi=$connection->createCommand($sql)->queryAll();

        ?>

   
    <fieldset class="group-border">
        <legend class="group-border">Disposisi Inspektur <?php echo $_SESSION['inspektur']?></legend>
        <div class="col-md-12">
            <div class="col-sm-9">
                    <!-- <label class="control-label col-md-2" style="padding:0px">Isi Disposisi</label> -->
                <div class="form-group">
                    <div class="col-sm-12 kejaksaan">
                         <?= $form->field($model, 'isi_disposisi')->textarea(['rows' => 6]) ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <!-- <label class="control-label col-md-5">Tanggal Disposisi</label> -->
                    <div class="col-md-12 kejaksaan">
                         <?= $form->field($model, 'tanggal_disposisi',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        // 'endDate' =>0,
                                        'startDate' => date("d-m-Y", strtotime($modelLapdu['tgl_disposisi'])),
                                        // 'startDate' => '30-10-2017',
                                    ]
                                ]
                ]) ?>
                            
                    </div>
                    <div class="col-md-12 kejaksaan">   
                         <label class="control-label col-md-12" style="padding:0px"> Unggah File Disposisi Inspektur: 
                                    <?php if (substr($model['file_inspektur'],-3)!='pdf'){?>
                                    <?= ($model['file_inspektur']!='' ? '<a href="viewpdf?id='.$_GET['id'].'&id_tingkat='.$_GET['id_tingkat'].'&id_kejati='.$_GET['id_kejati'].'&id_kejari='.$_GET['id_kejari'].'&id_cabjari='.$_GET['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                                    <?php } else{?>
                                    <?= ($model['file_inspektur']!='' ? '<a href="viewpdf?id='.$_GET['id'].'&id_tingkat='.$_GET['id_tingkat'].'&id_kejati='.$_GET['id_kejati'].'&id_kejari='.$_GET['id_kejari'].'&id_cabjari='.$_GET['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                                    <?php } ?>
                         </label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Upload File </span>
                            <span class="fileupload-exists "> Ubah File</span>         <input type="file" name="file_inspektur" id="file_inspektur" /></span>
                            <span class="fileupload-preview"></span>
                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                        </div> 
                    </div>
                     
                </div>

            </div>
        </div>
</fieldset>

   
            </div>

    <div class="form-group" style="text-align: center;">
    <?php 
     if($disposisi[0]['tanggal_disposisi']==''){
        echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"> </i> Simpan' : '<i class="fa fa-save"> </i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    }
        ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>

    <?php ActiveForm::end(); ?>

</div>

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
    padding:0 5px; /* To give a bit of padding on the left and right */
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


window.onload = function () {

     $(document).on('click', 'td.for_cek1', function () {
           var x=$(this).find('.td_pegasum').prop('checked');
              if(x==true){
                $(this).find('.cek_1').val('1');

        }else{
                $(this).find('.cek_1').val('0');
        }
          });

     $(document).on('click', 'td.for_cek2', function () {
           var x=$(this).find('.td_pidum').prop('checked');
              if(x==true){
                $(this).find('.cek_2').val('2');

        }else{
                $(this).find('.cek_2').val('0');
        }
          });

     $(document).on('click', 'td.for_cek3', function () {
           var x=$(this).find('.td_intel').prop('checked');
              if(x==true){
                $(this).find('.cek_3').val('3');

        }else{
                $(this).find('.cek_3').val('0');
        }
          });
};
</script>

