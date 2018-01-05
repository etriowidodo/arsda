<style>
/*#m_pelapor 
{
    margin-top: 70px !important;
} */
</style>
<?php

use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use app\modules\pengawasan\models\SumberPengaduan;
use app\modules\pengawasan\models\SumberPelapor;
use app\modules\pengawasan\models\Kejagungbidang;
use app\modules\pengawasan\models\Kejagungunit;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use yii\web\View;
use yii\helpers\Url;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use app\modules\pengawasan\models\SumberLaporan;



/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
include_once('_bidang_.php');
include_once('_kejati.php');
include_once('_kejari.php');
include_once('_cabjari.php');
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php

    $form = ActiveForm::begin([
                'id' => 'dugaan-pelanggaran-form',
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

    <div class="box box-primary" style="padding: 15px 0px;">
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">No Surat</label>
                    <div class="col-sm-8 kejaksaan">
                            <?= $form->field($model, 'nomor_surat_lapdu')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label col-sm-3">Tanggal Surat</label>
                    <div class="col-sm-6 kejaksaan">
                      <?php if($model->isNewRecord){?>
                      <input type="hidden" class="form-control" name="surat_tanggal" value="00-00-0000" id="surat_tanggal">
                      <?php }else{ ?>
                      <input type="hidden" class="form-control" name="surat_tanggal" value="<?= $model->tanggal_surat_lapdu ?>" id="surat_tanggal">

                      <?php 
                      $tanggal=explode("-", $model->tanggal_surat_lapdu);

                    } 

                      ?>
                      <input type="hidden" name="tmp" value="" id="test" rel="00-00-0000">
                      <!-- <input type="text" class="form-control" name="tahun" value=""> -->
                      <div class="col-sm-2" style="padding: 1px;width: 100px;">
                        <select class="form-control" name="tanggal_surat" id="tanggal_surat">
                            <?php
                            $arrlength1 = count($tgl);
                                for ($i=0; $i <$arrlength1 ; $i++) { 
                                echo "<option value=".$i." ".($tanggal[0]==$i? 'selected':"").">".$tgl[$i]."</option>";
                                }
                            ?>
                        </select>
                      </div> 
                        
                      <div class="col-sm-2" style="padding: 1px;width: 120px;">
                          <select class="form-control" name="bulan_surat" id="bulan_surat">
                              <?php
                              $arrlength = count($bln);
                                  for ($i=0; $i <$arrlength ; $i++) { 
                                  echo "<option value=".$i." ".($tanggal[1]==$i? 'selected':"").">".$bln[$i]."</option>";
                                  }
                              ?>
                          </select>
                      </div>

                      <div class="col-sm-2" style="padding: 1px;width: 95px;">
                         <?php 
                          $currentYear = date('Y');
                              $tahun = array();
                                          for ($i = $currentYear; $i >= $currentYear-15 ; $i--) { 
                                              $tahun[$i] = $i;
                                          }
                                         ?>
                          <select class="form-control" name="tahun_surat" id="tahun_surat">
                            <option value='' selected>Tahun</option>
                              <?php

                                  for ($i=$currentYear-15; $i <=$currentYear ; $i++) { 
                                  echo "<option value=".$tahun[$i]." ".($tanggal[2]==$i? 'selected':"").">".$tahun[$i]."</option>";
                                  }
                              ?>
                          </select>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">Ditujukan Kepada</label>
                    <div class="col-sm-8 kejaksaan">
                            <?= $form->field($model, 'kepada_lapdu')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-6">Ditembuskan Ke</label>
                    <div class="col-sm-6 kejaksaan">
                       <?php
                       echo  $form->field($model, 'tembusan_lapdu')->textInput(['maxlength' => true])
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-5">Media Pelaporan <i style="color:#FF0000">*</i></label>
                    <div class="col-sm-7 kejaksaan">
                        <?=
                        $form->field($model, 'id_media_pelaporan')->dropDownList(
                                ArrayHelper::map(SumberPengaduan::find()->orderBy('id_sumber_pengaduan ASC')->all(), 'id_sumber_pengaduan', 'nm_sumber_pengaduan'), ['prompt' => ''],['width'=>'40%']
                        )
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-4">No Register <i style="color:#FF0000">*</i></label>
                    <div class="col-sm-8 kejaksaan">
                      <?php
                        if (!$model->isNewRecord) {
                         echo $form->field($model, 'no_register')->textInput(['maxlength' => true,'readonly'=>'readonly']);
                        }else{
                          echo $form->field($model, 'no_register')->textInput(['maxlength' => true]);
                        } 
                      ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-6">Tanggal Surat Diterima<font style="color:red;"> * </font></label>
                    <div class="col-sm-6 kejaksaan">
                      <div class='input-group date' id='datetimepicker5'>
                       <?php
                       if($model['tanggal_surat_diterima']!=''){
                        $tgl_diterima=date("d-m-Y", strtotime($model['tanggal_surat_diterima']));
                       }
                            ?>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                       <input type="text" id="dt2" class="form-control" name="Lapdu[tanggal_surat_diterima]" value="<?= $tgl_diterima?>">
                       
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <!--<label class="control-label col-sm-5" >Lampiran</label>-->
                    <div class="col-sm-7 kejaksaan">
                       <?php
                          //echo $form->field($model, 'lampiran')->hiddenInput(['maxlength' => true]);
                            ?>
                    </div>
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
            <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="btn_hapus_pelapor"><span style="cursor:pointer"><i class="glyphicon glyphicon-trash">  </i> Hapus</span></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="btn_ubah_pelapor"><span style="cursor:pointer"><i class="glyphicon glyphicon-pencil">  </i> Ubah</span></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="btn_pelapor"><span style="cursor:pointer"><i class="glyphicon glyphicon-plus">  </i> Pelapor</span></a>
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
                        <th width="4%"><input class="" type="checkbox" name="hapus_all_tr" id="hapus_all_pl"></th>
                        <!-- <th width="8%">&nbsp;</th> -->
                    </tr>
                </thead>
                <tbody id="tbody_pelapor">
                  <?php if (!$model->isNewRecord) { 
                    $no=1;
                        foreach ($pelapor as $data) {
                  ?>
                  <tr>
                  <td><?= $no ?></td>
                  <td class='td_sumberlaporan'><?php
                        if($data['id_sumber_laporan']==13){
                          echo $data['sumber_lainnya'];
                        }else if($data['id_sumber_laporan']==11){
                          echo 'LSM '.$data['sumber_lainnya'];
                        }else{
                          echo $data['nama_sumber_laporan'];
                        }
                   ?>
                  </td>
                  <td class='td_namapelapor'><?=$data['nama_pelapor'] ?></td>
                  <td class='td_alamat'><?=$data['alamat_pelapor'] ?></td>
                  <td class='td_no_telepon'><?=$data['telp_pelapor']?></td>
                  <td class='ck_bok' width='4%'>
                    <?php $result=json_encode($data); ?>
                    <input class='td_pl' type='checkbox' name='ck_pl_ubah' json=''
                    rel='<?=$data['id_sumber_laporan'].'#'.$data['sumber_lainnya'].'#'.$data['nama_pelapor'].'#'.$data['tempat_lahir_pelapor'].'#'.$data['tanggal_lahir_pelapor'].'#'.$data['agama_pelapor'].'#'.$data['pendidikan_pelapor'].'#'.$data['nama_kota_pelapor'].'#'.$data['alamat_pelapor'].'#'.$data['telp_pelapor'].'#'.$data['kewarganegaraan_pelapor'].'#'.$data['email_pelapor'].'#'.$data['pekerjaan_pelapor'].'#'.$data['sumber_lainnya'].'#'.$data['namewn']?>' >
                    <input type='hidden' class="nik" name='nik[]' id='nik' value='<?=$data['id_pelapor'] ?>' >
                    <input type='hidden' class="txt_sumber" name='txt_sumber[]' value='<?=$data['id_sumber_laporan'] ?>' >
                    <input type='hidden' class="nama" name='nama[]' value='<?=$data['nama_pelapor'] ?>' >
                    <input type='hidden' class="email" name='email[]' value='<?=$data['email_pelapor'] ?>' >
                    <input type='hidden' class="alamat" name='alamat[]' value='<?=$data['alamat_pelapor'] ?>' >
                    <input type='hidden' class="pekerjaan" name='pekerjaan[]' value='<?=$data['pekerjaan_pelapor']?>' >
                    <input type='hidden' class="no_telepon" name='no_telepon[]' value='<?=$data['telp_pelapor']?>' >
                    <input type='hidden' class="sumberlainya" name='sumberlainya[]' value='<?=$data['sumber_lainnya'] ?>' >
                    <input type='hidden' class="tempat_lahir" name='tempat_lahir[]' value='<?=$data['tempat_lahir_pelapor'] ?>' >
                    <input type='hidden' class="tgl_lahir" name='tgl_lahir[]' value='<?=$data['tanggal_lahir_pelapor'] ?>' >
                    <input type='hidden' class="warga" name='warga[]' value='<?=$data['kewarganegaraan_pelapor'] ?>' >
                    <input type='hidden' class="agama" name='agama[]' value='<?=$data['agama_pelapor'] ?>' >
                    <input type='hidden' class="pendidikan" name='pendidikan[]' value='<?=$data['pendidikan_pelapor'] ?>' >
                    <input type='hidden' class="kota" name='kota[]' value='<?=$data['nama_kota_pelapor'] ?>' >
                  </td>
                  </tr>
                  <?php
                    $no++;
                        }
                    }
                    ?>

                    <?php
                   
                    ?>

                </tbody>
            </table>
        </div>
 </div>
 <?php
 
?>
<!-- begin Terlapor -->
 <div class="box box-primary">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-sm-6">
                Daftar Terlapor
            </div>
            <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="hapus_terlapor"><span style="cursor:pointer"><i class="glyphicon glyphicon-trash">  </i> Hapus</span></a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_terlapor"><span style="cursor:pointer"><i class="glyphicon glyphicon-pencil">  </i> Ubah</span></a>&nbsp;
             <a class="btn btn-primary btn-sm pull-right" id="btn_terlapor"><span style="cursor:pointer"><i class="glyphicon glyphicon-plus">  </i> Terlapor</span></a>
            </div>

        </div>
       
        <div class="box-header with-border">
           <!--  <div class="box-header with-border" style="border-color: #c7c7c7;">
                   
            </div> -->
        <table id="table_jpu" class="table table-bordered tbl_terlapor">
            <thead>
                <tr>
                    <th width="4%" rowspan="2" style="vertical-align:middle">No</th>
                    <th width="20%" rowspan="2" style="vertical-align:middle">Nama Terlapor</th>
                    <th rowspan="2" style="vertical-align:middle">Jabatan</th>
                    <th rowspan="2" style="vertical-align:middle">Satuan Kerja</th>
                    <th align="center" colspan="2" >Pelanggaran</th>
                    <th align="center" colspan="5" >Inspektur</th>
                    <th width="4%" rowspan="2"><input class="" type="checkbox" name="hapus_all_pl" id="hapus_all_tr"></th>

                </tr>
                <tr>
                    <th>Wilayah</th>
                    <th>Waktu</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp1"> I</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp2"> II</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp3"> III</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp4"> IV</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp5"> V</th>
                      
                    <?php 
                    if (!$model->isNewRecord) {
                    ?>
                    <!-- <th><input class="" type="radio" name="all_insp" id="all_insp1"> I</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp2"> II</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp3"> III</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp4"> IV</th>
                    <th><input class="" type="radio" name="all_insp" id="all_insp5"> V</th> -->
                    <?php } ?>
                </tr>
            </thead>
            <tbody id="tbody_terlapor">
                <?php
                $BulanIndo = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                if (!$model->isNewRecord) {
                    $no=1;
                    foreach ($terlapor as $data) {
                        // $query = new Query;
                        // $query->select('*')
                        //         ->from('was.v_riwayat_jabatan')
                        //         ->where("id= :id", [':id' => $data->id_h_jabatan]);

                        // $pegawai = $query->one();
                        if($data['id_tingkat_kejadian']=='0'){
                            $nama_wilayah='Kejaksaan Agung RI';
                        }else if($data['id_tingkat_kejadian']=='1'){
                            $nama_wilayah=$data['level1'];
                        }else if($data['id_tingkat_kejadian']=='2'){
                            $nama_wilayah=$data['level2'];
                        }else if($data['id_tingkat_kejadian']=='3'){
                            $nama_wilayah=$data['level3'];
                        }
                        $tmp_wilayah=($data['id_tingkat_kejadian']==0?'0':$data['id_tingkat_kejadian']);
                        $tmp_bidang=($data['id_tingkat_kejadian']=='0'?$data['id_level1_kejadian']:$data['id_kejati_kejadian']);
                        $tmp_unit=($data['id_tingkat_kejadian']=='0'?$data['id_level2_kejadian']:$data['id_kejari_kejadian']);

                        $gabung=$data['nama_terlapor_awal'].'#'.$data['jabatan_terlapor_awal'].'#'.$data['satker_terlapor_awal'].'#'.$nama_wilayah.'#'.$data['tgl_pelanggaran_terlapor_awal'].'#'.$data['bln_pelanggaran_terlapor_awal'].'#'.$data['thn_pelanggaran_terlapor_awal'].'#'.$data['pelanggaran_terlapor_awal'].'#'.$tmp_bidang.'#'.$tmp_unit.'#'.$data['id_cabjari_kejadian'].'#'.$data['id_inspektur'].'#'.$data['level1'].'#'.$data['level2'].'#'.$data['level3'].'#'.$data['id_tingkat_kejadian'];
            //date('d-F-Y',strtotime('2-March-2011'));
                        echo '<tr id="trterlapor' . $data['no_urut'] . '" class="terlapor_tmp">';
                        echo '<td>'.$no.'</td>';
                        echo '<td class="nm">'.ucwords($data['nama_terlapor_awal']).'</td>';
                        echo '<td class="jb">'.ucwords($data['jabatan_terlapor_awal']).'</td>';
                        echo '<td class="sat">'.ucwords($data['satker_terlapor_awal']).'</td>';
                        echo '<td class="wil">'.$nama_wilayah.'</td>';
                        echo '<td class="wak">' .$data['tgl_pelanggaran_terlapor_awal'].' '.$BulanIndo[date($data['bln_pelanggaran_terlapor_awal'])].' '.$data['thn_pelanggaran_terlapor_awal'].'
                        </td>';
                        echo '<td class="ck_bok1"><input type="radio" name="radio' . $no . '" class="insp1" rel="trterlapor' . $data['no_urut'] . '" value="1" '.($data['id_inspektur']=='1' ? 'checked' :'').'></td>';
                        echo '<td class="ck_bok2"><input type="radio" name="radio' . $no . '" class="insp2" rel="trterlapor' . $data['no_urut'] . '" value="2" '.($data['id_inspektur']=='2' ? 'checked' :'').'></td>';
                        echo '<td class="ck_bok3"><input type="radio" name="radio' . $no . '" class="insp3" rel="trterlapor' . $data['no_urut'] . '" value="3" '.($data['id_inspektur']=='3' ? 'checked' :'').'></td>';
                        echo '<td class="ck_bok4"><input type="radio" name="radio' . $no . '" class="insp4" rel="trterlapor' . $data['no_urut'] . '" value="4" '.($data['id_inspektur']=='4' ? 'checked' :'').'></td>';
                        echo '<td class="ck_bok5"><input type="radio" name="radio' . $no . '" class="insp5" rel="trterlapor' . $data['no_urut'] . '" value="5" '.($data['id_inspektur']=='5' ? 'checked' :'').'></td>';
                        echo '<td class="ck_bok" width="4%" style="text-align:center;">
                          <input class="td_tr" type="checkbox" name="ck_tr" rel="'.$gabung.'">
                          <input type="hidden" class="namaTerlapor" name="namaTerlapor[]" value="' . $data['nama_terlapor_awal'] . '">
                          <input type="hidden" class="jabatanTerlapor" name="jabatanTerlapor[]" value="' . $data['jabatan_terlapor_awal'] . '">
                          <input type="hidden" class="tgl" name="tgl[]" value="'.$data['tgl_pelanggaran_terlapor_awal'].'">
                          <input type="hidden" class="satkerTerlapor" name="satkerTerlapor[]" value="' . $data['satker_terlapor_awal'] . '">
                          <input type="hidden" class="bln" name="bln[]"  value="'.$data['bln_pelanggaran_terlapor_awal'].'">
                          <input type="hidden" class="wilayahTerlapor" name="wilayahTerlapor[]" value="' . $tmp_wilayah . '">
                          <input type="hidden" class="thn" name="thn[]" value="'.$data['thn_pelanggaran_terlapor_awal'].'">
                          <input type="hidden" class="waktuTerlapor" name="waktuTerlapor[]" value="' . $data['tgl_pelanggaran_terlapor_awal'].'-'.$data['bln_pelanggaran_terlapor_awal'].'-'.$data['thn_pelanggaran_terlapor_awal'] . '">
                          <input type="hidden" class="pelanggaranTerlapor" name="pelanggaranTerlapor[]" value="'.$data['pelanggaran_terlapor_awal'].'">
                          <input type="hidden" class="td_bidang" name="bidang[]" value="'.($data['id_tingkat_kejadian']=='0'?$data['id_level1_kejadian']:$data['id_kejati_kejadian']).'">
                          <input type="hidden" class="unit" name="unit[]" value="'.($data['id_tingkat_kejadian']=='0'?$data['id_level2_kejadian']:$data['id_kejari_kejadian']).'">
                          <input type="hidden" class="td_cabjari" name="cabjari[]" value="'.$data['id_cabjari_kejadian'].'">
                          <input type="hidden" class="inspektur" name="inspektur[]" value="'.$data['id_inspektur'].'">
                        </td>';
                        '</tr>';
                    $no++;
                    }
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
                    <label class="control-label col-md-4" style="padding:0px">Perihal <i style="color:#FF0000">*</i></label>
                <div class="form-group">
                    <div class="col-md-12 kejaksaan">
                <?php //= $form->field($model, 'perihal_lapdu')->textarea(['rows' => 2, 'id'=>'perihal_lapdu']) ?>
				<?= $form->field($model, 'perihal_lapdu')->textarea() ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                    <label class="control-label col-md-4" style="padding:0px">Ringkasan/Isi Laporan <i style="color:#FF0000">*</i></label>
                <div class="form-group">
                    <div class="col-md-12 kejaksaan">
                <?php //= $form->field($model, 'ringkasan_lapdu')->textarea(['rows' => 2, 'id'=>'ringkasan_lapdu']) ?>                 
				<?= $form->field($model, 'ringkasan_lapdu')->textarea() ?>
				  </div>
                </div>
            </div>
        </div>

         <div class="col-md-12">
                    <label class="control-label col-md-4" style="width:15%;">Unggah File Lapdu:</label>
					<div class="col-md-1 kejaksaan">
                      <div class="form-group">
					  <?php if (substr($model['file_lapdu'],-3)!='pdf'){?>
                        <?= ($model->file_lapdu!='' ? '<a href="viewpdf?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
						<i class="fa fa-file-image-o"></i></span></a>' :'') ?>
						<?php } else{?>
						<?= ($model->file_lapdu!='' ? '<a href="viewpdf?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
						<i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php } ?>
                      </div>
                    </div>
                    
            </div>
			<div class="col-md-3 kejaksaan" style="margin-left:3%;">
                      <div class="form-group" >
                         <?php
                          echo $form->field($model, 'file_lapdu')->widget(FileInput::classname(), [
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
                        ]);


                           
                        ?>

                    </div>
                    
                </div>
            <!-- </div> -->
			</div>
			
			<!--khusus JAM WAS -->
<?php if (!$model->isNewRecord) {			
?>
<fieldset class="group-border">
        <legend class="group-border">Disposisi Jam Was</legend>
  <div class="col-md-12">
              <div class="col-sm-8">
                      <label class="control-label col-md-2" style="padding:0px">Isi Disposisi</label>
                  <div class="form-group">
                      <div class="col-sm-12 kejaksaan">
                      <?= $form->field($model, 'keterangan')->textarea(['rows' => 4, 'id'=>'keterangan']); ?>

                      </div>
                  </div>
              </div>

<div class="col-sm-4">
    <!-- <div class="form-group"> -->
        <div class="col-md-7 kejaksaan">
        <label class="control-label col-md-9" style="padding:0px;right:18px">Tanggal Disposisi</label>
        <div class="form-group" >
            <?php
                echo $form->field($model, 'tgl_disposisi',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'displayFormat' => 'dd-MM-yyyy',
                            'options' => [

                                'pluginOptions' => [
                                    'startDate' =>  date("d-m-Y", strtotime($model->tanggal_surat_diterima)),
                                    // 'startDate' => '-17y',
                                    'autoclose' => true,
                                ]
                            ],
                        ]);
            ?>     
      </div>
		</div>
		<!-- <div class="col-md-12 kejaksaan">	 -->
       
       <div class="col-md-12 kejaksaan">
             <label class="control-label col-md-10" style="padding:0px">Unggah File Disposisi Jam Was:</label>
                      <div class="form-group" >
						
					  
					   <?php if (substr($model['file_disposisi'],-3)!='pdf'){?>
                         <?= ($model->file_disposisi!='' ? '<a href="viewpdf1?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
						<i class="fa fa-file-image-o"></i></span></a>' :'') ?>
						<?php } else{?>
						 <?= ($model->file_disposisi!='' ? '<a href="viewpdf1?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
						<i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php } ?>
						
                       
                      </div>
               <div class="col-md-12 kejaksaan" style="padding:0px">
                <div class="form-group" >
					<div class="col-md-12">
          <?php
              echo $form->field($model, 'file_disposisi')->widget(FileInput::classname(), [
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
                        ]);
                         
                        ?>
					</div>
				</div>
            </div>
              </div>
        <!-- </div> -->
       	 

  </div>
</div>
</fieldset>
<?php
}
?>			
			
        

 <div class="col-md-12">
    <div class="form-group">
    <div class="box-footer">
        <?php //= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
        <?php //echo Html::Button('Kembali', ['class' => 'tombolbatalindex btn btn-primary']); ?>
		
		<input name="action" type="submit" value="Simpan" class="btn btn-primary" id="simpan"/>        
		<input type="hidden" name="print" value="0" id="print"/>
    <?php if(!$model->isNewRecord){
      ?>
		    <input name="action" type="submit" value="Cetak" class="btn btn-primary" id="cetak"/>
      <?php
      }
      ?>
    <!-- <a class="btn btn-primary" href="<?= Url::to(['lapdu/cetak?id=' . $model->no_register]) ?>">Cetak</a> -->
        <!-- <input action="action" type="button" value="Kembalicc" class="btn btn-primary" onclick="goSimpan();" /> -->
        <input action="action" type="button" value="Batal" class="btn btn-primary" onclick="history.go(-1);" />
        
    </div>
    </div>
</div> 
    <?php ActiveForm::end(); ?>
    </div>
</section>

<!-- =======================================================MODAL TAMBAH PELAPOR ========================================================-->
    <div class="modal fade" id="m_pelapor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Tambah Pelapor</h4>
              </div>
              <div class="modal-body">
                <div class="box box-primary" style="padding: 15px 0px;">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Sumber <i style="color:#FF0000">*</i></label>
                                    <div class="col-md-8 kejaksaan">
                                        <input id="asal" type="hidden" maxlength="32"  value="" readonly="readonly">
                                       <?php
                                        echo $form->field($modelPelapor, 'id_sumber_laporan')->dropDownList(
                                                 ArrayHelper::map(SumberLaporan::find()->orderBy(['(id_sumber_laporan::int)' => SORT_ASC])->all(), 'id_sumber_laporan', 'nama_sumber_laporan'), ['prompt' => ''],['width'=>'40%']
                                                
                                       );   
                                     ?>
                                        <input type="hidden" name="cek" value="" id="cek">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 sumberlain">
                                <div class="form-group">
                                    <label class="control-label col-md-4" id="lbl_sumber">Sumber Lainya</label>
                                    <div class="col-md-8 kejaksaan">
                                       <?= $form->field($modelPelapor, 'sumber_lainnya')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nama</label>
                                    <div class="col-md-8 kejaksaan">
                                        <?= $form->field($modelPelapor, 'nama_pelapor')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Pekerjaan</label>
                                    <div class="col-md-8 kejaksaan">
                                        <?= $form->field($modelPelapor, 'pekerjaan_pelapor')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">No Telepon</label>
                                    <div class="col-md-8 kejaksaan">  <!-- #bowo 19 agustus 2016 no tlf hanya angka saja-->
                               <?php echo $form->field($modelPelapor, 'telp_pelapor')->input('text',
                                                ['oninput'  =>'var number =  /^[0-9 +]+$/;
                                                        if(this.value.length>24)
                                                        {
                                                          this.value = this.value.substr(0,24);
                                                        }
                                                        if(this.value<0)
                                                        {
                                                           this.value =null
                                                        }
                                                        var str   = "";
                                                        var slice = "";
                                                        var b   = 0;
                                                        for(var a =1;a<=this.value.length;a++)
                                                        {
                                                            slice = this.value.substr(b,1);
                                                            if(slice.match(number))
                                                            {
                                                                str+=slice;
                                                            }
                                                            
                                                            b++
                                                        }
                                                        this.value=str;
                                                        ']) ?>
                              
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Email</label>
                                    <div class="col-md-8 kejaksaan">
                                        <?= $form->field($modelPelapor, 'email_pelapor')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Alamat</label>
                                    <div class="col-md-10" style="margin-left:-4px;">
                                      <?= $form->field($modelPelapor, 'alamat_pelapor')->textarea() ?>
                                    </div>
                                </div>
                            </div>     
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tempat Lahir</label>
                                    <div class="col-md-8 kejaksaan">
                                    <?= $form->field($modelPelapor, 'tempat_lahir_pelapor')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Lahir</label>
                                    <div class="col-md-8 kejaksaan">
                                    <?php

                                    echo $form->field($modelPelapor, 'tanggal_lahir_pelapor',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'displayFormat' => 'dd-MM-yyyy',
                                            'options' => [

                                                'pluginOptions' => [
                                                    //'startDate' =>  date("d-m-Y", strtotime($modelPelapor->tanggal_lahir_pelapor)),
                                                    'startDate' =>  0,
                                                    'endDate' => '-17y',
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Warganegara</label>
                                    <div class="col-md-8 kejaksaan" >
                                    <input id='cari_Wn' class='form-control' type='text' maxlength='32' readonly='readonly' style="margin-left: 15px;">
                                    <?php
                                    function search_wn($strorage,$id=null)
                                                {
                                                    foreach($strorage AS $index=>$value )
                                                    {
                                                        if($id!=null)
                                                        {
                                                            if($id==$index)
                                                            {
                                                                return $value;
                                                                
                                                            }
                                                        }                                       
                                                        
                                                    }
                                                }
                                                $i_wn = $modelPelapor->kewarganegaraan_pelapor;  
                                                // $pop warganegara                                                                                     
                                                echo $form->field($modelPelapor, 'kewarganegaraan_pelapor')->textInput(['type'=>'hidden','value'=>search_wn($warganegara,$i_wn),'readonly'=>'readonly','placeholder'=>'','data-id'=>$i_wn]); 
                                            
                                    ?>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Agama</label>
                                    <div class="col-md-8 kejaksaan">
                                    <?php
                                    echo $form->field($modelPelapor, 'agama_pelapor')->dropDownList(
                                                 ArrayHelper::map(MsAgama::find()->all(), 'id_agama', 'nama'), ['prompt' => ''],['width'=>'40%']
                                                //  print_r($x);
                                       );   
                                     ?>
                                    </div>
                                </div>
                            </div> 
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Pendidikan</label>
                                    <div class="col-md-8 kejaksaan">
                                     <?php
                                    echo $form->field($modelPelapor, 'pendidikan_pelapor')->dropDownList(
                                                 ArrayHelper::map(MsPendidikan::find()->all(), 'id_pendidikan', 'nama'), ['prompt' => ''],['width'=>'40%']
                                                //  print_r($x);
                                       );   
                                     ?>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Kota</label>
                                    <div class="col-md-8 kejaksaan">
                                    <?= $form->field($modelPelapor, 'nama_kota_pelapor')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            </div> 
                        </div>

                </div>
              <hr style="border-color: #c7c7c7;margin: 10px 0;">
              <div class="box-footer">
                  <button class="btn btn-primary" type="button" id="btn-tambah-pelapor">Simpan</button>
                  <button class="btn btn-primary"  data-dismiss="modal" type="button">Batal</button>
              </div>
              </div>
          </div>
      </div>
    </div>
<?php
$script = <<< JS
 $('#cari_Wn').click(function(){
    
        $('#m_kewarganegaraan').html('');
        $('#m_kewarganegaraan').load('/pengawasan/lapdu/wn');
        $('#m_kewarganegaraan').modal('show');
    });
  
  $(document).ready(function(){
    $('#tgl_pelanggaran').change(function () {
              var date_start=$("#dt2").val().split('-');/*diambil dari tanggal surat lapdu*/
           });

    });

    

JS;
$this->registerJs($script);
?>
<?php
// Modal::begin([
//     'id' => 'm_pelapor',
//     'header' => 'Tambah Pelapor',
//     'options' => [
//         'data-url' => '',
//     ],
// ]);
?> 

<?
// =
// $this->render('_modalPelapor', [
//     'model' => $model,
//     'modelPelapor' => $modelPelapor,
// 	  'warganegara'       => $warganegara,
// 	//'pelapor' => $pelapor,
// ])
?>

<?php
// Modal::end();
?>
<!-- =========================================================END MODAL TAMBAH PELAPOR =====================================================-->

<!-- =========================================================MODAL TAMBAH TERLAPOR========================================================== -->

 <div class="modal fade" id="myModalTerlapor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Tambah Terlapor</h4>

            </div>
             <div class="container"></div>
    <div class="modal-body">
<?php
    $form = ActiveForm::begin([
                'id' => 'lapdu-modalterapor',
                // 'type' => ActiveForm::TYPE_HORIZONTAL,
                // 'enableAjaxValidation' => false,
                // 'fieldConfig' => [
                //     'autoPlaceholder' => false
                // ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
    ]);
    ?>

   <div class="box box-primary" style="padding: 15px 0px;">
       <!-- <div class="col-md-12"> -->
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="Nama" class="control-label col-md-4" style="margin-left:-15px;">Nama</label>
                        <?= $form->field($modelTerlapor, 'nama_terlapor_awal')->textInput(['maxlength' => true]) ?>
                         <input type="hidden" name="asalTerlapor" value="" id="asalTerlapor">
                </div>
            </div>

            <div class="col-sm-4">
                       <div class="form-group">
                     <label for="jabatan" class="control-label col-md-4" style="margin-left:-15px;">Jabatan</label>
                         <?= $form->field($modelTerlapor, 'jabatan_terlapor_awal')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                     <label for="satker" class="control-label col-md-6" style="margin-left:-15px;">Satker <i style="color:#FF0000">*</i></label>
                         <?= $form->field($modelTerlapor, 'satker_terlapor_awal')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        <!-- </div> -->

        <div class="col-md-12">
            <!-- <div class="col-sm-12"> -->
                <div class="form-group">
                    <label for="Nama" class="control-label col-md-12" style="margin-left:-15px;">Pelanggaran <i style="color:#FF0000">*</i></label>
                    <?= $form->field($modelTerlapor, 'pelanggaran_terlapor_awal')->textarea(['rows' => 3]) ?>
                </div>
            <!-- </div> -->

        </div>

        <!-- <div class="col-md-12"> -->
            <div class="col-sm-6" style="font-size:13px">
             <fieldset class="group-border">
                            <legend class="group-border">Waktu Pelanggaran</legend>
                <div class="col-sm-2" style="padding: 1px;width: 100px;">
                <select class="form-control" name="tanggal" id="tgl_pelanggaran">
                      <!-- <option value='' selected>Tanggal</option> -->
                    <?php
                    $arrlength1 = count($tgl);
                        for ($i=0; $i <$arrlength1 ; $i++) { 
                        echo "<option value=".$i.">".$tgl[$i]."</option>";
                        }
                    // echo $form->field($modelTerlapor, 'tgl_pelanggaran_terlapor_awal')->widget(Select2::classname(), [
                    //         'data' => $tgl,
                    //         'options' => ['placeholder' => 'Tanggal','id' =>'tgl_pelanggaran'],
                    //         'pluginOptions' => [
                    //             'allowClear' => true
                    //         ],
                    //     ]);
                        
                    ?>
                </select>
                
            </div> 

            <div class="col-sm-2" style="padding: 1px;width: 110px;">
               
                <select class="form-control" name="bulan" id="bln_pelanggaran">
                  <!-- <option value='' selected>Bulan</option> -->
                    <?php
                    $arrlength = count($bln);
                        for ($i=0; $i <$arrlength ; $i++) { 
                        echo "<option value=".$i.">".$bln[$i]."</option>";
                        }
                // echo $form->field($modelTerlapor, 'bln_pelanggaran_terlapor_awal')->widget(Select2::classname(), [
                //             'data' => $bln,
                //             'options' => ['placeholder' => 'Bulan','id' =>'bln_pelanggaran'],
                //             'pluginOptions' => [
                //                 'allowClear' => true,
                //                 'width' => '100%'
                //             ],
                //         ]);
                    ?>
                </select>

               
            </div> 
            <div class="col-sm-2" style="padding: 1px;width: 90px;">
               <?php 
                $currentYear = date('Y');
                    $tahun = array();
                                for ($i = $currentYear; $i >= $currentYear-15 ; $i--) { 
                                    $tahun[$i] = $i;
                                }
                               ?>
                <select class="form-control" name="tahun" id="thn_pelanggaran">
                  <option value='' selected>Tahun</option>
                    <?php

                        for ($i=$currentYear-15; $i <=$currentYear ; $i++) { 
                        echo "<option value=".$tahun[$i].">".$tahun[$i]."</option>";
                        }
                    ?>
                </select>
            </div><i style="color:#FF0000">*</i>
            </fieldset> 
            </div> 

            <!-- <div class="col-sm-6" style="border-radius: 25px; border: 2px solid #73a8de; padding: 20px; width: 350px; height: 100px; margin-right:12px; margin-left:12px;"> -->
            <div class="col-sm-6">
               <fieldset class="group-border">
                            <legend class="group-border">Wilayah Pelanggaran <i style="color:#FF0000">*</i></legend>
                <!-- <div style="margin-bottom:12px;margin-top:1px;">Lokasi Pelanggaran<font style="color:red;"> ( * ) </font></div> -->
                <div class="radio-inline">
                  <label><input type="radio" name="optradio" class="opt_wilayah" id="opt_wilayah0" value="0" rel="Kejaksaan Agung">Kejagung RI</label>
                </div>
                <div class="radio-inline">
                  <label><input type="radio" name="optradio" class="opt_wilayah" id="opt_wilayah1" value="1" rel="Kejati">Kejati</label>
                </div>
                <div class="radio-inline">
                  <label><input type="radio" name="optradio" class="opt_wilayah" id="opt_wilayah2" value="2" rel="Kejari">Kejari</label>
                </div>
                <div class="radio-inline">
                  <label><input type="radio" name="optradio" class="opt_wilayah" id="opt_wilayah3" value="3" rel="Cabjari">Cabjari</label>
                </div>
                </fieldset>

            </div>
            <!-- </div> -->
        <!-- </div> -->
        <input id="idbidang" class="form-control idbidang" type="hidden" maxlength="32">
        <input id="idunit" class="form-control idunit" type="hidden" maxlength="32">
        <input id="idcabjari" class="form-control idcabjari" type="hidden" maxlength="32">
        <input id='idinspektur' class='form-control idinspektur' type='hidden' value="" maxlength='32'>




    <div class="col-sm-12" style="padding: 15px 20px; margin-top: 15px;"  id="lokasi_pelanggaran">
      <input type="hidden" value="" id="idbidang">
      
      <div id="detail_kejagung">
      <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Pilih Bidang</label>
                        <div class="col-md-7 kejaksaan">
                            <input id="bidang" class="form-control bidang" type="text" maxlength="32"  value="" readonly="readonly">
                        </div>
                        <div class="col-md-1 kejaksaan">
                            
                        </div>
                        <div class="col-md-2">
                           <button class="btn btn-primary" type="button" id="pilih_bidang_1" data-toggle="modal" data-target="#modalBidang" data-backdrop="static" data-keyboard="false">Pilih</button>
                        </div>
                    </div>
            </div>
            <div class="col-md-12" style="margin-top: 15px;">
                    <div class="form-group">
                        <label class="control-label col-md-2">Unit Kerja</label>
                        <div class="col-md-7 kejaksaan">
                            <input id="unit_kerja" class="form-control unit_kerja" type="text" maxlength="32"  value="" readonly="readonly">
                        </div>
                        <div class="col-md-1 kejaksaan">
                            
                        </div>
                    </div>
                    <div class="col-md-1 kejaksaan">
                            
                    </div>
            </div>
          </div>

          <div id="detail_kejati">
            <div class='col-md-12'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Tinggi</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='nmkejati' class='form-control bidang' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                        </div>
                        <div class='col-md-2'>
                           <button class='btn btn-primary' type='button' id='pilih_bidang_2' data-toggle='modal' data-target='#modalKejati' data-backdrop="static" data-keyboard="false">Pilih</button>
                        </div>
                    </div>
                    <div class='col-md-1 kejaksaan'>
                    </div>
            </div>
          </div>
          <div id="detail_kejari">
            <div class='col-md-12'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Tinggi</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='nmkejati' class='form-control bidang' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                        </div>
                        <div class='col-md-2'>
                           <button class='btn btn-primary' type='button' id='pilih_bidang_3' data-toggle='modal' data-target='#modalKejari' data-backdrop="static" data-keyboard="false">Pilih</button>
                        </div>
                    </div>
            </div>
            <div class='col-md-12' style='margin-top: 15px;'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Negeri</label>
                        <div class='col-md-5 kejaksaan'>
                            <input id='nmkejari' class='form-control unit_kerja' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                        </div>
                    </div>
            </div>
          </div>
          <div id="detail_cabjari">
            <div class='col-md-12'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Tinggi</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='nmkejati' class='form-control bidang' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                        </div>
                        <div class='col-md-2'>
                           <button class='btn btn-primary' type='button' id='pilih_bidang_3' data-toggle='modal' data-target='#modalCabjari' data-backdrop="static" data-keyboard="false">Pilih</button>
                        </div>
                    </div>
            </div>
            <div class='col-md-12' style='margin-top: 15px;'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Negeri</label>
                        <div class='col-md-5 kejaksaan'>
                            <input id='nmkejari' class='form-control unit_kerja' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                        </div>
                    </div>
            </div>
            <div class='col-md-12' style='margin-top: 15px;'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Cabjari</label>
                        <div class='col-md-5 kejaksaan'>
                            <input id='cabjari' class='form-control cabjari' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                        </div>
                    </div>
            </div>
          </div>

    </div>
    </div>
   
 <?php ActiveForm::end(); ?>
</div>

            
            <div class="modal-footer"> 
			<?php //= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'btn_tambah_Telapor']) ?>
			
             <button class="btn btn-primary" type="button" id="btn_tambah_Telapor">Simpan</button>
             <a href="#" data-dismiss="modal" class="btn btn-primary">Batal</a>

            </div>
        </div>
        </div>
</div>

<!-- ====================================================END OF MODAL TERLAPOR======================================================== -->
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

#myModalTerlapor{
  overflow-y:hidden!important;   
}
#myModalTerlapor .modal-header{
  margin: 0px!important;
}
#myModalTerlapor .modal-dialog{
  overflow-y:inherit!important; 
}
#myModalTerlapor .modal-body{
  max-height: calc(100vh - 210px);
  overflow-y:auto!important;  
  padding: 0px!important;
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
.ck_bok,.ck_bok1,.ck_bok2,.ck_bok3,.ck_bok4,.ck_bok5 {
  text-align: center;
}
}
</style>
<!-- =========================================================MODAL BIDANG================================================================= -->

<?php
// Modal::begin([
//     'id' => 'MyModalPopUp',
//     'header' => 'Pilih Bidang',
//     'options' => [
//         'data-url' => '',
//     ],
//         'size' => 'modal-md',

// ]);
?> 

<?
// =
// $this->render('_bidang', [
//     'model' => $model,
//     'modelTerlapor' => $modelTerlapor,
//     'dataProvider' => $dataProvider,

// ])
?>

<?php
//Modal::end();
?>

<?php
// Modal::begin([
//     'id' => 'MyModalPopUp2',
//     'header' => 'Pilih Kejaksaan Tinggi',
//     'options' => [
//         'data-url' => '',
//     ],
//         'size' => 'modal-md',

// ]);
?> 

<?
//=
// $this->render('_kejati', [
//     'model' => $model,
//     'modelTerlapor' => $modelTerlapor,
//     'dataProviderKejati' => $dataProviderKejati,
// ]);
?>

<?php
 // Modal::end();
?>


<?php
// Modal::begin([
//     'id' => 'MyModalPopUp3',
//     'header' => 'Pilih Kejaksaan Negeri',
//     'options' => [
//         'data-url' => '',
//     ],
//         'size' => 'modal-md',

// ]);
?> 

<?
// =
// $this->render('_kejari', [
//     'model' => $model,
//     'modelTerlapor' => $modelTerlapor,
//     'dataProviderKejari' => $dataProviderKejari,
// ])
?>

<?php
 // Modal::end();
?>

<?php
// Modal::begin([
//     'id' => 'MyModalPopUp4',
//     'header' => 'Pilih Cabang Kejaksaan Negeri',
//     'options' => [
//         'data-url' => '',
//     ],
//         'size' => 'modal-md',

// ]);
?> 

<?
//=
// $this->render('_cabjari', [
//     'model' => $model,
//     'modelTerlapor' => $modelTerlapor,
//     'dataProviderCabjari' => $dataProviderCabjari,
// ])
?>

<?php
 //Modal::end();
?>
<!-- =============================================================end modal bidang================================================================= -->
<?php
Modal::begin([
    'id'     => 'm_kewarganegaraan',
    'header' => '<h7>Pilih Kewarganegaraan</h7>',
]);
Modal::end();
?>
<!-- =========================================================END MODAL BIDANG================================================================= -->
<style type="text/css">
    tr.hover {
  background-color: #FFFFCC;
}

tr.click-row {
  background-color: #81bcf8;
}
</style>

<script type="text/javascript"> 

    $(".dropdown-menu li a").click(function(){
      var selText = $(this).text();
      $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
    });

    function removeRow(id)
    {
        $("#tembusan-"+id).remove();
    }
        
    function removeRowUpdate(id)
    {
        var id_2= id.split("-");
        var nilai = $("#delete_tembusan").val()+"#"+id_2[1];
       
        $("#delete_tembusan").val(nilai);
        $("#"+id).remove();
    }
    
    window.onload = function () {
        // set button disabled
        $("#btn_ubah_pelapor").addClass("disabled");
        $("#btn_hapus_pelapor").addClass("disabled");
        $("#ubah_terlapor").addClass("disabled");
        $("#hapus_terlapor").addClass("disabled");
         $("#detail_kejagung").hide();
         $("#detail_kejati").hide();
         $("#detail_kejari").hide();
         $("#detail_cabjari").hide();
         

        $(document).on('click','#btn_pelapor',function(){
            // $("#modalpelapor")[0].reset();
            // $('#modalpelapor').closest('form').find("input[type=text], textarea, select").val("");
            $('#asal').val('tambah');
            // $("#m_pelapor").modal('show');
            $('#m_pelapor').modal({backdrop: 'static', keyboard: false})
        });

        $(document).on('hidden.bs.modal','#m_pelapor', function (e) {
          $(this)
            .find("input,textarea,select")
               .val('')
               .end();
            // .find("input[type=checkbox], input[type=radio]")
            //    .prop("checked", "")
            //    .end();

        });


         $(document).on('click','.td_kejati',function(){
           var x=$('.td_kejati:checked').length;
            if(x > 1){
              $(this).prop('checked',false);
            }
          });

         $(document).on('click','#add_kejati',function(){
        //   var id_kejati=$('.td_kejati:checked').attr('rel');
        //   var nama_kejati=$('.td_kejati:checked').attr('nmkejati');
		      // var id_inspektur=$('.td_kejati:checked').attr('idinspektur');
        //   if(id_kejati==null){
        //     alert('Harap Pilih Kejati');
        //     return false;
        //   }

        //   $('#idbidang').val(id_kejati);/*Warning pada saat memilih kejagung id_bidang ini adalah id bidang kejagung tpi pada saat milih kejati id bidang ini adalah id_kejati*/
        //   $('#nmkejati').val(nama_kejati);
		      // $('#idinspektur').val(id_inspektur);
        //   $('#idunit').val('');
        //   $("#MyModalPopUp2").modal('hide');
          
        });

         



		$(document).on('click', '#pilih_bidang_1', function () {
		//$('.dataTables_wrapper').remove();
	//	alert('aaaa');
		$('#tbl_bidang_wrapper').remove();
		$("#terlapor-id_bidang_kejati").val('');
		
		});

        $(document).on('click', 'input.td_tr', function () {
              var x=$(".td_tr:checked").length;
              if(x>0){
             $("#ubah_terlapor").removeClass("disabled");
             $("#hapus_terlapor").removeClass("disabled");  
            }else{
              $("#ubah_terlapor").addClass("disabled");
              $("#hapus_terlapor").addClass("disabled");      
              }
          // alert('ddddd');
          });
            
        $(document).on('change','.td_pl',function() {
            var c = this.checked ? '#f00' : '#09f';
            var x =$('.td_pl:checked').length;
            ConditionOfButtonTr(x);
        });


        function ConditionOfButtonTr(n){
                if(n == 1){
                   $('#btn_ubah_pelapor, #btn_hapus_pelapor').removeClass('disabled');
                } else if(n > 1){
                   $('#btn_hapus_pelapor').removeClass('disabled');
                   $('#btn_ubah_pelapor').addClass('disabled');
                } else{
                   $('#btn_ubah_pelapor, #btn_hapus_pelapor').addClass('disabled');
                }
        }

           $(document).on('change','#tgl_pelanggaran,#bln_pelanggaran,#thn_pelanggaran',function () {
            $("#bln_pelanggaran").css("background-color","#ffffff");
              var date_start=$("#test").attr('rel').split('-');/*diambil dari tanggal surat lapdu*/
              var tanggal=$('#tgl_pelanggaran').val();
              var bulan=$('#bln_pelanggaran').val();
              var tahun=$('#thn_pelanggaran').val();
              var waktu_surat=$('#dt2').val().split("-");
              var f = waktu_surat[2]+'-'+waktu_surat[1]+'-'+waktu_surat[0];
              // alert(f);


               if (tanggal != "0" && bulan != "0" && tahun !="") {
                  var waktu_pelanggaran=tahun+'-'+bulan+'-'+tanggal;
               }else  if(tanggal == "0" && bulan != "0" && tahun !="") {
                  var waktu_pelanggaran=tahun+'-'+bulan+'-'+'01';
               }else if(tanggal == "0" && bulan == "0" && tahun !="") {
                  var waktu_pelanggaran=tahun+'-'+'01'+'-'+'01';
               }
              
                 if (date_start[2] != "0000" && date_start[1] != "00" && date_start[0] !="00") {
                  var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                  var firstDate = new Date(date_start[2]+'-'+date_start[1]+'-'+date_start[0]);
                  var secondDate = new Date(waktu_pelanggaran);
                  var diffDays = Math.round(Math.round(( firstDate.getTime() - secondDate.getTime()) / (oneDay)));
                  // $("#x_Date_Difference").val(diffDays);
                  // alert(diffDays);
                }else if(date_start[2] != "0000" && date_start[1] != "00" && date_start[0] =="00"){
                  date_start[0]="01";/*jika kondisi kosong ganti degan 01*/
                  var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                  var firstDate = new Date(date_start[2]+'-'+date_start[1]+'-'+date_start[0]);
                  var secondDate = new Date(waktu_pelanggaran);
                  var diffDays = Math.round(Math.round(( firstDate.getTime() - secondDate.getTime()) / (oneDay)));
                  // alert(diffDays);

                }else if(date_start[2] != "0000" && date_start[1] == "00" && date_start[0] =="00"){
                  date_start[0]="01";/*jika kondisi tanggal kosong ganti degan 01*/
                  date_start[1]="01";/*jika kondisi bulan kosong ganti degan 01*/
                  var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                  var firstDate = new Date(date_start[2]+'-'+date_start[1]+'-'+date_start[0]);
                  var secondDate = new Date(waktu_pelanggaran);
                  var diffDays = Math.round(Math.round(( firstDate.getTime() - secondDate.getTime()) / (oneDay)));
                  // alert(diffDays);

                }else if(date_start[2] == "0000" && date_start[1] == "00" && date_start[0] =="00"){
                  var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                  var firstDate = new Date(f);
                  var secondDate = new Date(waktu_pelanggaran);
                  var diffDays = Math.round(Math.round(( firstDate.getTime() - secondDate.getTime()) / (oneDay)));
                  // alert(diffDays);
                }
                if(diffDays<0){
                  var warna="info";
                  notify_wkatu_pelanggaran(warna);
                  $("#thn_pelanggaran option[value='']").prop("selected", "selected");
                  // $("#tahun_surat option[value='']").prop("selected", "selected");
                }
              // alert(date_start[0]);
              // alert(date_start[1]);
              // alert(date_start[2]);
              
           });

   
          // var tanggal1='01-09-2016';
          $(document).on('change', '#tanggal_surat,#bulan_surat,#tahun_surat', function () {
            var tanggal_surat=$("#tanggal_surat option:selected").text();
            var bulan_surat=$("#bulan_surat").val();
            var tahun_surat=$("#tahun_surat").val();
           $("#bulan_surat").css("background-color","#ffffff");

            if(tanggal_surat=='Tanggal' || tanggal_surat=='0'){
              tanggal_surat='00';
            }
            if(bulan_surat=='Bulan' || bulan_surat=='0'){
              bulan_surat='00';
            }
            if(bulan_surat>1 && bulan_surat<10){
              bulan_surat='0'+bulan_surat;
            }
            if(tahun_surat=='' || tahun_surat=='0'){
              tahun_surat='0000';
            }

            $("#surat_tanggal").val(tanggal_surat+'-'+bulan_surat+'-'+tahun_surat);
            $("#test").attr('rel',tanggal_surat+'-'+bulan_surat+'-'+tahun_surat);

          
            var start = new Date(tahun_surat+'-'+bulan_surat+'-'+tanggal_surat),
            end   = new Date(),
            diff  = new Date(end - start),
            days  = diff/1000/60/60/24;

            // alert(days);
            // alert(end);
            // alert(diff);
            // alert(start);
            if(days<0 || start > end){
              var warna='info';
                notify_tanggal(warna);
               $("#tahun_surat").val('');
               $("#tahun_surat option[value='']").prop("selected", "selected");
            }
                   
          });
          
            $(document).on('focus','#dt2',function(){

               var tanggal=$("#test").attr('rel').split('-');
              if(tanggal[0]!='00' && tanggal[1]=='00' && tanggal[2]=='0000'){
                    //var warna='info';
					bootbox.alert("Tanggal Surat Tidak Valid");
                      //notify_hapus(warna);
$("#bulan_surat").css("background-color","#dd4b39");
					$("#bulan_surat").focus();
					
					
                    $("#dt2").datepicker("destroy");
                return false;
              }else if(tanggal[0]!='00' && tanggal[1]=='00' && tanggal[2]!='0000'){
               bootbox.alert("Tanggal Surat Tidak Valid");
			   $("#bulan_surat").css("background-color","#dd4b39");
			   $("#bulan_surat").focus();
			   //$("#bulan_surat").css("background-color","#ffffff");
                     /*  var warna='info';
                      notify_hapus(warna); */

                  
                    $("#dt2").datepicker("destroy");
                return false;
              }else if(tanggal[0]!='00' && tanggal[1]!='00' && tanggal[2]=='0000'){
              bootbox.alert("Tanggal Surat Tidak Valid");
			  $("#bulan_surat").css("background-color","#dd4b39");
			  $("#bulan_surat").focus();
			  //$("#bulan_surat").css("background-color","#ffffff");
                     /*  var warna='info';
                      notify_hapus(warna); */

                  
                    $("#dt2").datepicker("destroy");
                return false;
              }
               $("#dt2").datepicker("destroy");
               // var tanggal='01-09-2016'.split('-');
               var tanggal1;
              if(tanggal[0]=='00' && tanggal[1]=='00' && tanggal[2]=='0000'){
                   tanggal1=null;
               }else  if(tanggal[0]!='00' && tanggal[1]!='00' && tanggal[2]!='0000'){
                   tanggal1=tanggal[0]+'-'+tanggal[1]+'-'+tanggal[2];
               }else  if(tanggal[0]=='00' && tanggal[1]!='00' && tanggal[2]!='0000'){
                   tanggal1='01-'+tanggal[1]+'-'+tanggal[2];
               }else  if(tanggal[0]=='00' && tanggal[1]=='00' && tanggal[2]!='0000'){
                    tanggal1='01-'+'01-'+tanggal[2];
               }else{
                tanggal1=null;
               }
                
           $('#dt2').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: "dd-mm-yy",
                 maxDate: 0,
                 minDate:  tanggal1,
            });
             
          }); 
        

        

        $(document).on('click', 'a#btn_hapus_pelapor', function () {
            //$(this).parent().parent().remove();
            //return false;
            // var nik_pelapor = $(this).parents('tr').find('#nik_pelapor').val();
            var cek = $(".td_pl:checked").length;
            if(cek<=0){
                var warna='info';
                notify_hapus(warna);
             return false
             }
            var checkValues = $('.td_pl:checked').map(function()
            {
                return $(this).attr('rel');
            }).get();

            bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-primary",
                                callback: function(){   
                                $('.td_pl:checked').closest('tr').remove();                              
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-primary",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        });

        $(document).on('click', 'a#hapus_terlapor', function () {
        var cek = $(".td_tr:checked").length;
            if(cek<=0){
                var warna='info';
                notify_hapus(warna);
             return false
             }
        var checkValues = $('.td_tr:checked').map(function()
            {
                return $(this).attr('rel');
            }).get();
            
         // alert(checkValues[0]);
            bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-primary",
                                callback: function(){   
                                // $("#trterlapor"+nip_terlapor).remove();                             
                                for (var i = 0; i < 2; i++) {
                                        // Things[i]
                                $("#"+checkValues[i]).remove();                                
                                    };
                                // $("#"+nip_terlapor).remove();                             
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-primary",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
            
            
        });

        
        $("#cbWilayah").change(function(){
        var idWilayah = $(this).val();
        $.ajax({
                                        type:'POST',
                                        url:'/pengawasan/dugaan-pelanggaran/getwilayah',
                                        data:'id='+idWilayah,
                                        success:function(data){
                                        $('#div-wilayah-keterangan').show();
                                        $('#wilayah_keterangan').text(data);
                                        }
                                        });
        });

       
        $("#btn-tambah-pelapor").click(function () {
			
          var asal=$("#asal").val();
          var sumber = $("#pelapor-id_sumber_laporan").val();
          // var sumberlainya = $("#pelapor-sumber_lainnya").val();
          var nama = $("#pelapor-nama_pelapor").val();
          var tempat_lahir = $("#pelapor-tempat_lahir_pelapor").val();
          var tgl_lahir = $("#pelapor-tanggal_lahir_pelapor").val();
          var agama = $("#pelapor-agama_pelapor").val();
          var pendidikan = $("#pelapor-pendidikan_pelapor").val();
          var kota = $("#pelapor-nama_kota_pelapor").val();
          var alamat = $("#pelapor-alamat_pelapor").val();
          var no_telepon = $("#pelapor-telp_pelapor").val();
          var cari_Wn = $("#cari_Wn").val();

            if(typeof($('#pelapor-kewarganegaraan_pelapor').attr('data-id')) === 'undefined')
              {
                 warga = '';  
              }
              else
              {
                warga = $('#pelapor-kewarganegaraan_pelapor').attr('data-id');  
          
              }
            
            if(sumber=='13'){
            var sumberText=$("#pelapor-sumber_lainnya").val();
            var nmsumber=sumberText;/*unutuk tampilan d table*/
            }else if(sumber=='11'){
            var nmsumber='LSM '+$("#pelapor-sumber_lainnya").val();/*unutuk tampilan d table*/
            var sumberText=$("#pelapor-sumber_lainnya").val();
            }else{ 
            var sumberText = '';
            var nmsumber=$("#pelapor-id_sumber_laporan  option:selected").text();/*unutuk tampilan d table*/
            }

            var pekerjaan = $("#pelapor-pekerjaan_pelapor").val();
            var email = $("#pelapor-email_pelapor").val();

            if(email!=''){
                if (isValidEmailAddress(email)) {
            }else {
             alert('Invalid Email Address');
               return false;
            }
            }

          if(asal=='ubah'){/*jika button yang di klik adalah ubah maka ubah nilai nya*/
            /*rubah value*/
            $('.td_pl:checked').attr('rel',sumber+'#'+sumberText+'#'+nama+'#'+tempat_lahir+'#'+tgl_lahir+'#'+agama+'#'+pendidikan+'#'+kota+'#'+alamat+'#'+no_telepon+'#'+warga+'#'+email+'#'+pekerjaan+'#'+nmsumber+'#'+cari_Wn);
            $('.td_pl:checked').closest('td').find('.txt_sumber').val(sumber);
            $('.td_pl:checked').closest('td').find('.nama').val(nama);
            $('.td_pl:checked').closest('td').find('.email').val(email);
            $('.td_pl:checked').closest('td').find('.alamat').val(alamat);
            $('.td_pl:checked').closest('td').find('.pekerjaan').val(pekerjaan);
            $('.td_pl:checked').closest('td').find('.no_telepon').val(no_telepon);
            $('.td_pl:checked').closest('td').find('.sumberlainya').val(sumberText);
            $('.td_pl:checked').closest('td').find('.tempat_lahir').val(tempat_lahir);
            $('.td_pl:checked').closest('td').find('.tgl_lahir').val(tgl_lahir);
            $('.td_pl:checked').closest('td').find('.warga').val(warga);
            $('.td_pl:checked').closest('td').find('.agama').val(agama);
            $('.td_pl:checked').closest('td').find('.pendidikan').val(pendidikan);
            $('.td_pl:checked').closest('td').find('.kota').val(kota);
            /*rubah tampilan table*/
            $('.td_pl:checked').closest('tr').find('.td_sumberlaporan').html(nmsumber);
            $('.td_pl:checked').closest('tr').find('.td_namapelapor').html(nama);
            $('.td_pl:checked').closest('tr').find('.td_alamat').html(alamat);
            $('.td_pl:checked').closest('tr').find('.td_no_telepon').html(no_telepon);


          }else{ /*jika button yang di klik adalah tambah maka append*/
            var html = "<tr  id='trpelapor'>";
            html += "<td class='no'></td>";
            html += "<td class='td_sumberlaporan'>"+nmsumber+"</td>";
            html += "<td class='td_namapelapor'>"+nama+"</td>";
            html += "<td class='td_alamat'>"+alamat+"</td>";
            html += "<td class='td_no_telepon'>"+no_telepon+"</td>";
            html += "<td class='ck_bok' width='3%'>"+
                    "<input class='td_pl' type='checkbox' name='ck_pl_ubah' rel='"+sumber+'#'+sumberText+'#'+nama+'#'+tempat_lahir+'#'+tgl_lahir+'#'+agama+'#'+pendidikan+'#'+kota+'#'+alamat+'#'+no_telepon+'#'+warga+'#'+email+'#'+pekerjaan+'#'+nmsumber+'#'+cari_Wn+"'>"+
                    // "<input type='text' class='nik' name='nik[]' id='nik' value='' >"+
                    "<input type='hidden' class='txt_sumber' name='txt_sumber[]' value='"+sumber+"' >"+
                    "<input type='hidden' class='nama' name='nama[]' value='"+nama+"' >"+
                    "<input type='hidden' class='email' name='email[]' value='"+email+"' >"+
                    "<input type='hidden' class='alamat' name='alamat[]' value='"+alamat+"' >"+
                    "<input type='hidden' class='pekerjaan' name='pekerjaan[]' value='"+pekerjaan+"' >"+
                    "<input type='hidden' class='no_telepon' name='no_telepon[]' value='"+no_telepon+"' >"+
                    "<input type='hidden' class='sumberlainya' name='sumberlainya[]' value='"+sumberText+"' >"+
                    "<input type='hidden' class='tempat_lahir' name='tempat_lahir[]' value='"+tempat_lahir+"' >"+
                    "<input type='hidden' class='tgl_lahir' name='tgl_lahir[]' value='"+tgl_lahir+"' >"+
                    "<input type='hidden' class='warga' name='warga[]' value='"+warga+"' >"+
                    "<input type='hidden' class='agama' name='agama[]' value='"+agama+"' >"+
                    "<input type='hidden' class='pendidikan' name='pendidikan[]' value='"+pendidikan+"' >"+
                    "<input type='hidden' class='kota' name='kota[]' value='"+kota+"' >"+
                    "</td>";
            // html += "<td>";
            // html += "<a class='btn btn-primary btn_hapus_pelapor' id='btn_hapus_pelapor' rel='trpelapor"+nik+"'>Hapus</a></td>";
            html += "</tr>";
            $("#tbody_pelapor").append(html);
          }
            
            $("#m_pelapor").modal('hide');
            
        });
        
        function notify(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Merubah data harus memilih satu data,Harap pilih satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }

        function notify_tanggal(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Input Tanggal Tidak Boleh Lebih Dari Hari Ini!'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }

       function notify_wkatu_pelanggaran(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Input Tanggal Tidak Boleh Lebih Dari Tanggal Surat atau tanggal diterima!'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }

        function notify_hapus(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Menghapus data harus memilih salah data,Harap pilih salah satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }
		
// $(document).ready(function(){

  // $('#ubah_terlapor').click(function(){
    $(document).on('click', 'a#ubah_terlapor', function () {

        var x=$("input[name=ck_tr]:checked").length;
             if(x>=2 || x<=0){
                var warna='info';
                notify(warna);
             return false
             }

             var pecah=$("input[name=ck_tr]:checked").attr('rel').split('#');
            // $("#lapdu-modalterapor")[0].reset();
            cek1=$("input[name=ck_tr]:checked").val();
            enama_terlapor=pecah[0];
            ejabatan_terlapor=pecah[0];
            esatker_terlapor=pecah[0];
            eid_wilayah=pecah[0];
            epelanggaran=pecah[0];
            etgl=pecah[0];
            ebln=pecah[0];
            ethn=pecah[0];
            ebidang=pecah[0];
            eunit_kejari=pecah[0];
            ecabjari=pecah[0];
            eidbidang=pecah[0];
            eidunit=pecah[0];
            eidcabjari=pecah[0];
			      eidinspektur=pecah[0];
			
			//$("#tgl_pelanggaran").select2('val',etgl);
         //alert(eidbidang);
         
        if(pecah[15]=='0'){
            $('#opt_wilayah0').prop('checked',true);
            $("#detail_kejagung").show(); 
            $("#detail_kejati").hide(); 
            $("#detail_kejari").hide(); 
            $("#detail_cabjari").hide();
        }if(pecah[15]=='1'){
            $('#opt_wilayah1').prop('checked',true);
            $("#detail_kejati").show();  $("#detail_kejagung").hide(); $("#detail_kejari").hide(); $("#detail_cabjari").hide();
        }if(pecah[15]=='2'){
            $('#opt_wilayah2').prop('checked',true);
            $("#detail_kejari").show();  $("#detail_kejati").hide();  $("#detail_kejagung").hide(); $("#detail_cabjari").hide();
            // $("#detail_kejati").attr('disabled','disabled');$("#detail_kejagung").attr('disabled','disabled');$("#detail_cabjari").attr('disabled','disabled');
        }if(pecah[15]=='3'){
            $('#opt_wilayah3').prop('checked',true);
            $("#detail_cabjari").show(); $("#detail_kejari").hide();  $("#detail_kejati").hide();  $("#detail_kejagung").hide();
        }
        $('#asalTerlapor').val('2');
        $('.bidang').val(pecah[12]);//untuk nama nya saja
        $('.unit_kerja').val(pecah[13]);//untuk nama nya saja
        $('.cabjari').val(pecah[14]);//untuk nama nya saja
        $('#terlapor-nama_terlapor_awal').val(pecah[0]);
        $('#terlapor-jabatan_terlapor_awal').val(pecah[1]);
        $('#terlapor-satker_terlapor_awal').val(pecah[2]);
        $('#terlapor-pelanggaran_terlapor_awal').val(pecah[7]);
        $('.idbidang').val(pecah[8]);
        $('.idunit').val(pecah[9]);
        $('.idcabjari').val(pecah[10]);
		    $('.idinspektur').val(pecah[11]);
        $("#tgl_pelanggaran option[value='"+pecah[4]+"']").prop("selected", "selected");
        $("#bln_pelanggaran option[value='"+pecah[5]+"']").prop("selected", "selected");
        $("#thn_pelanggaran option[value='"+pecah[6]+"']").prop("selected", "selected");
		// $("#tgl_pelanggaran").select2('val',etgl);
		// $("#bln_pelanggaran").select2('val',ebln);
		// $("#thn_pelanggaran").select2('val',ethn);
        $("#myModalTerlapor").modal('show');
    });
   
     $(document).on('click', '#btn_terlapor', function () {
      $('#asalTerlapor').val('1');
      $('#myModalTerlapor').modal({backdrop: 'static', keyboard: false})
    //  $('#lokasi_pelanggaran').hide();
      // $('#modalKejari').hide();
      // $('#modalKejati').hide();
      // $('#modalCabjari').hide();

      // $('#myModalTerlapor').modal(show:'false');
      });

     $(document).on('click', '.insp1', function () {
        $(this).closest('tr').find('.inspektur').val('1');
      });

     $(document).on('click', '.insp2', function () {
        $(this).closest('tr').find('.inspektur').val('2');
      });

     $(document).on('click', '.insp3', function () {
        $(this).closest('tr').find('.inspektur').val('3');
      });

     $(document).on('click', '.insp4', function () {
        $(this).closest('tr').find('.inspektur').val('4');
      });

     $(document).on('click', '.insp5', function () {
        $(this).closest('tr').find('.inspektur').val('5');
      });

    $(document).on('click', '#all_insp1', function () {
      $('.insp1').prop('checked',true);
      $('.inspektur').val('1');
      });     
    
    $(document).on('click', '#all_insp2', function () {
      $('.insp2').prop('checked',true);
      $('.inspektur').val('2');
      });     
    
    $(document).on('click', '#all_insp3', function () {
      $('.insp3').prop('checked',true);
      $('.inspektur').val('3');
      });     
    

    $(document).on('click', '#all_insp4', function () {
      $('.insp4').prop('checked',true);
      $('.inspektur').val('4');
      });     
    
    $(document).on('click', '#all_insp5', function () {
      $('.insp5').prop('checked',true);
      $('.inspektur').val('5');
      });     
    
    // $(document).on('click', '.ck_bok1', function () {
    //      var x=$(this).find('.insp1').val();
    //      var rel=$(this).find('.insp1').attr('rel');
    //      // alert(rel);
    //      $('#'+rel).find('.cek_insp').val(x);
    //   });

    //   $(document).on('click', '.ck_bok2', function () {
    //      var x=$(this).find('.insp2').val();
    //      var rel=$(this).find('.insp2').attr('rel');
    //      // alert(x);
    //      $('#'+rel).find('.cek_insp').val(x);
    //   });

    //   $(document).on('click', '.ck_bok3', function () {
    //      var x=$(this).find('.insp3').val();
    //      var rel=$(this).find('.insp3').attr('rel');
    //      // alert(x);
    //      $('#'+rel).find('.cek_insp').val(x);
    //   });

    // $(document).on('click', '.ck_bok4', function () {
    //      var x=$(this).find('.insp4').val();
    //      var rel=$(this).find('.insp4').attr('rel');
    //      // alert(x);
    //      $('#'+rel).find('.cek_insp').val(x);
    //   });

    //   $(document).on('click', '.ck_bok5', function () {
    //      var x=$(this).find('.insp5').val();
    //      var rel=$(this).find('.insp5').attr('rel');
    //      // alert(x);
    //      $('#'+rel).find('.cek_insp').val(x);
    //   });

   

        $(document).on('click', 'a#btn_ubah_pelapor', function () {
    
             $('#asal').val('ubah');
             var cek    =$(".td_pl:checked").attr('rel');
             var pecah  =cek.split('#');

  
            
            $("#pelapor-id_sumber_laporan").val(pecah[0]);
            if(pecah[0]=='11' || pecah[0]=='13'){
              $(".sumberlain").css("display","block")
            }else{
              $(".sumberlain").css("display","none")

            }
            $("#pelapor-sumber_lainnya").val(pecah[1]);
            $("#pelapor-nama_pelapor").val(pecah[2]);
            $("#pelapor-tempat_lahir_pelapor").val(pecah[3]);
            $("#pelapor-tanggal_lahir_pelapor").val(pecah[4]);
            $("#pelapor-tanggal_lahir_pelapor-disp").val(pecah[4]);
            $("#pelapor-agama_pelapor").val(pecah[5]);
            $("#pelapor-pendidikan_pelapor").val(pecah[6]);
            $("#pelapor-nama_kota_pelapor").val(pecah[7]);
            $("#pelapor-alamat_pelapor").val(pecah[8]);
            $("#pelapor-telp_pelapor").val(pecah[9]);
            // $("#pelapor-sumber_lainnya").val(pecah[10]);
            $("#pelapor-kewarganegaraan_pelapor").val(pecah[10]);
            $("#pelapor-email_pelapor").val(pecah[11]);
            $("#pelapor-pekerjaan_pelapor").val(pecah[12]);
            $("#cari_Wn").val(pecah[14]);
            $("#m_pelapor").modal('show');
            // $('#m_pelapor').modal({backdrop: 'static', keyboard: false});
            
        });
    

// });  
    };

   
    /*ini adalah fungsi untuk menambahkan daftar orang terlapor*/
    function GoTerlapor( nama, jabatan, satker, wilayah, wilayah_text, waktu,waktuTampil, pelanggaran, tgl, bln, thn, id_baris,cek,bidang,unit,cabjari,bidangtext,unittext,cabjaritext,idinspektur,new_td){
        if(cek!=''){
           $("#trterlapor"+cek).remove(); 
        }
        $('#tbody_terlapor').append(
                    '<tr id="trterlapor'+id_baris+'">' +
                        '<td class="no_u">'+
                        '<input type="hidden" name="no_urut[]" value="'+id_baris+'">' +
                        '<input type="hidden" name="namaTerlapor[]"value="'+nama+'">' +
                        '<input type="hidden" name="jabatanTerlapor[]" readonly="true" value="'+jabatan+'">' +
                        '<input type="hidden" name="tgl[]" value="'+tgl+'">' +
                        '<input type="hidden" name="satkerTerlapor[]" value="'+satker+'">' +
                        '<input type="hidden" name="bln[]" value="'+bln+'">' +
                        '<input type="hidden" name="wilayahTerlapor[]" value="'+wilayah+'">' +
                        '<input type="hidden" name="thn[]" value="'+thn+'">' +
                        '<input type="hidden" name="waktuTerlapor[]" value="'+waktu+'">' +
                        '<input type="hidden" name="pelanggaranTerlapor[]" readonly="true" value="'+pelanggaran+'">' +
                        '<input type="hidden" name="bidang[]" value="'+bidang+'">' +
                        '<input type="hidden" name="unit[]" value="'+unit+'">' +
                        '<input type="hidden" name="cabjari[]" value="'+cabjari+'">' +
                        '<input class="cek_insp" name="inspektur[]" value="'+idinspektur+'" type="hidden">' +
                        '</td>' +
                        '<td>'+nama+'</td>' +
                        '<td>'+jabatan+'</td>'+
                        '<td>'+satker+'</td>'+
                        '<td>'+wilayah_text+'</td>'+
                        '<td>'+waktuTampil+'</td>'+
                        
                        new_td+
                        '<td class="ck_bok" width="4%"><input class="td_tr" type="checkbox" name="ck_tr_ubah" rel="trterlapor'+id_baris+'" value="'+id_baris+'"enama_terlapor="'+nama+'"ejabatan_terlapor="'+jabatan+'"esatker_terlapor="'+satker+'"eid_wilayah="'+wilayah+'"epelanggaran="'+pelanggaran+'"etgl="'+tgl+'"ebln="'+bln+'"ethn="'+thn+'" ebidang="'+bidangtext+'" eunit_kejari="'+unittext+'" ecabjari="'+cabjaritext+'" eidbidang="'+bidang+'"  eidunit="'+unit+'" eidcabjari="'+cabjari+'" eidinspektur="'+idinspektur+'"></td>'+





                        // '<td><input type="hidden" name="pelanggaranTerlapor[]" readonly="true" value="'+pelanggaran+'"><a class="btn btn-primary btn_delete_terlapor" id="btn_delete_terlapor" rel="trterlapor'+id_baris+'">Hapus</a></td>'+
                    '</tr>'
        );
    
    i = 0;
    $('#table_jpu').find('.no_u').each(function () {
        i++;
        // $(this).html(i+'.');
    });
    // $("#btn_terlapor").attr('rel',i);

    $('#myModalTerlapor').modal('hide');
    }
    function isValidEmailAddress(emailAddress) {
   var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        if (filter.test(emailAddress)) {
            return true;
        }
        else {
            return false;
        }
    };

    /*ini adalah jquery untuk mebedakan wilayah pelanggaran*/
    $(document).ready(function(){
    // $('#opt_wilayah0').attr('checked','checked');
       
    $('.opt_wilayah').click(function(){
    //  alert('aaa');
        var kode_pelanggaran=$(this).val();
      $.ajax({
            type:'POST',
            url:'/pengawasan/lapdu/lokasipelanggaran',
            data:'id='+kode_pelanggaran,
            success:function(data){
            $('#lokasi_pelanggaran').html(data);
            }
            });
       });


    $('#btn_terlapor').click(function(){
    //     $("#cek1").val('');
        $("#lapdu-modalterapor")[0].reset();
    });

        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
   

//*dn
    $('#btn_tambah_Telapor').click(function(){
       // bootbox.alert({
       //                          message: "Format tanggal surat Tidak Valid!",
       //                          size: 'small'
       //                      });

      var z=$('input[name=optradio]:checked').val();
    if($(".idbidang").val()==''){
	  bootbox.alert('Wilayah Pelanggaran Harus Di lengkapi');
    }else if($("#terlapor-pelanggaran_terlapor_awal").val()==''){
		bootbox.alert('Pelanggaran Harus Diisi');
		$('#terlapor-pelanggaran_terlapor_awal').focus();
    }else if($("#thn_pelanggaran").val()=='' && $("#tgl_pelanggaran").val()!='0' ){
		 alert('Tahun Waktu Pelanggaran Tidak boleh kosong');
$("#bln_pelanggaran").css("background-color","#dd4b39");
    }
	/* else if($("#terlapor-nama_terlapor_awal").val()==''){
      alert('Nama Terlapor Harus Diisi ');
    } */else if(z=='undefined'|| z=='' || z==null){
      bootbox.alert('Wilayah Harus Diisi ');
      return false;
    }else if($("#thn_pelanggaran").val()=='' && $("#tgl_pelanggaran").val()=='0' && $("#bln_pelanggaran").val()=='0'){
      bootbox.alert('Format Tanggal Pelanggaran tidak Valid');
	  $("#bln_pelanggaran").css("background-color","#dd4b39");

	   return false;

    }else if($("#thn_pelanggaran").val()!='' && $("#tgl_pelanggaran").val()!='0' && $("#bln_pelanggaran").val()=='0'){

      bootbox.alert('Format Tanggal Pelanggaran tidak Valid');
	  $("#bln_pelanggaran").css("background-color","#dd4b39");
	   return false;


    }else{
    var opt_wilayah= $('input[name=optradio]:checked').val();
    // var id_baris=$('#btn_terlapor').attr('rel');
    var nama_terlapor=$('#terlapor-nama_terlapor_awal').val();
    var jabatan= $('#terlapor-jabatan_terlapor_awal').val();
    var satker= $('#terlapor-satker_terlapor_awal').val();
	  var unit_kerja=$('#unit_kerja').val();
    var pelanggaran= $('#terlapor-pelanggaran_terlapor_awal').val();
    // var opt_wilayah= $('input[name=optradio]:checked').val();
    var bidang=$('#idbidang').val();
    var unit=$('#idunit').val();
    var cabjari=$('#idcabjari').val();
    var idinspektur=$('#idinspektur').val();
	  var tmp_insp=$('#inspektur').val();
    // var new_record="<?php  echo count($terlapor) ?>";

    if(idinspektur=='1'){
      var x1='checked';
    }else  if(idinspektur=='2'){
      var x2='checked';
    }else  if(idinspektur=='3'){
      var x3='checked';
    }else  if(idinspektur=='4'){
      var x4='checked';
    }else  if(idinspektur=='5'){
      var x5='checked';
    }

	
	if(satker==''){
		alert('Satker Harus Diisi');
	  $('#terlapor-satker_terlapor_awal').focus();
	  return false	
    }
	

    // if(new_record>0){((a < b) ? 2 : 3)
    var new_td='<td class="ck_bok1"><input type="radio" name="radio" class="insp1" value="1" '+((idinspektur=='1')?"checked":"")+'></td>'+
                '<td class="ck_bok2"><input type="radio" name="radio" class="insp2" value="2" '+((idinspektur=='2')?"checked":"")+'></td>'+
                '<td class="ck_bok3"><input type="radio" name="radio" class="insp3" value="3" '+((idinspektur=='3')?"checked":"")+'></td>'+
                '<td class="ck_bok4"><input type="radio" name="radio" class="insp4" value="4" '+((idinspektur=='4')?"checked":"")+'></td>'+
                '<td class="ck_bok5"><input type="radio" name="radio" class="insp5" value="5" '+((idinspektur=='5')?"checked":"")+'></td>';
    // // var new_td="<td></td><td></td><td></td><td></td><td></td>";
    // }else{
    //  var new_td='';
    // }

// alert(new_record);
    if(opt_wilayah=='0'){
    		var bidangtext=$('#bidang').val();
    		var unittext=$('#unit_kerja').val();
        var cabjaritext='';
        var wilayah_text=unittext;      
    }else if(opt_wilayah=='1'){
        var bidangtext=$('#nmkejati').val();
        var unittext='';
        var cabjaritext='';
		    var wilayah_text=bidangtext;
    }else if(opt_wilayah=='2'){
        var bidangtext=$('#nmkejati').val();
        var unittext=$('#nmkejari').val();
        var cabjaritext='';
		    var wilayah_text=unittext;
    }else if(opt_wilayah=='3'){
        var bidangtext=$('#nmkejati').val();
        var unittext=$('#nmkejari').val();
        var cabjaritext=$('#cabjari').val();
		    var wilayah_text=cabjaritext;
    }
    var cek=$("#cek1").val();

    /* var waktu=$('#terlapor-tgl_pelanggaran_terlapor_awal').val()+'-'+$('#terlapor-bln_pelanggaran_terlapor_awal').val()+'-'+$('#terlapor-thn_pelanggaran_terlapor_awal option:selected').val(); */
	
	var blnx = $("#bln_pelanggaran").val();
	if (blnx=='' || blnx=='0'){
		var nilaix = '';
	}else{
		var BulanIndo = ['','Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];   
		var nilaix = BulanIndo[blnx];
	}
	//alert(blnx);
  if($("#tgl_pelanggaran").val()=='0'){
  var tgl='';
  }else{
  var tgl=$("#tgl_pelanggaran").val();
  }
	var waktuTampil=tgl+' '+ nilaix+' '+$("#thn_pelanggaran").val();
	var waktu=$("#tgl_pelanggaran").val()+'-'+$("#bln_pelanggaran").val()+'-'+$("#thn_pelanggaran").val();
  
    var bln=$("#bln_pelanggaran").val();
    var thn=$("#thn_pelanggaran").val();
    var gabung=nama_terlapor+'#'+jabatan+'#'+satker+'#'+wilayah_text+'#'+tgl+'#'+bln+'#'+thn+'#'+pelanggaran+'#'+bidang+'#'+unit+'#'+cabjari+'#'+idinspektur+'#'+bidangtext+'#'+unittext+'#'+cabjaritext+'#'+opt_wilayah;
    
    var asalTerlapor=$('#asalTerlapor').val();
    if(asalTerlapor=='1'){
       $('#tbody_terlapor').append(
                        '<tr class="terlapor_tmp">' +   
                        '<td class="no"></td>' +   
                        '<td class="nm">'+nama_terlapor+'</td>' +   
                        '<td class="jb">'+jabatan+'</td>' +   
                        '<td class="sat">'+satker+'</td>' +   
                        '<td class="wil">'+wilayah_text+'</td>' +   
                        '<td class="wak">'+waktuTampil+'</td>' + new_td +  
                        '<td style="text-align:center;"><input class="td_tr" type="checkbox" name="ck_tr" rel="'+gabung+'">' + 
                        '<input type="hidden" class="namaTerlapor" name="namaTerlapor[]"value="'+nama_terlapor+'">' +
                        '<input type="hidden" class="jabatanTerlapor" name="jabatanTerlapor[]" readonly="true" value="'+jabatan+'">' +
                        '<input type="hidden" class="tgl" name="tgl[]" value="'+tgl+'">' +
                        '<input type="hidden" class="satkerTerlapor" name="satkerTerlapor[]" value="'+satker+'">' +
                        '<input type="hidden" class="bln" name="bln[]" value="'+bln+'">' +
                        '<input type="hidden" class="wilayahTerlapor" name="wilayahTerlapor[]" value="'+opt_wilayah+'">' +
                        '<input type="hidden" class="thn" name="thn[]" value="'+thn+'">' +
                        '<input type="hidden" class="waktuTerlapor" name="waktuTerlapor[]" value="'+waktu+'">' +
                        '<input type="hidden" class="pelanggaranTerlapor" name="pelanggaranTerlapor[]" readonly="true" value="'+pelanggaran+'">' +
                        '<input type="hidden" class="td_bidang" name="bidang[]" value="'+bidang+'">' +
                        '<input type="hidden" class="unit" name="unit[]" value="'+unit+'">' +
                        '<input type="hidden" class="td_cabjari" name="cabjari[]" value="'+cabjari+'">' +
                        '<input type="hidden" class="inspektur" name="inspektur[]" class="cek_insp"  value="'+idinspektur+'"></td>' +  
                        '</tr>'); 
            i = 0;
            $('.terlapor_tmp').each(function () {

                i++;
                $(this).find('.insp1').attr('name','radio'+i);
                $(this).find('.insp2').attr('name','radio'+i);
                $(this).find('.insp3').attr('name','radio'+i);
                $(this).find('.insp4').attr('name','radio'+i);
                $(this).find('.insp5').attr('name','radio'+i);
            });
            
        $("#myModalTerlapor").modal('hide'); 
    }else if(asalTerlapor=='2'){
      // untuk tampilan table
      $('.td_tr:checked').closest('tr').find('.nm').html(nama_terlapor);
      $('.td_tr:checked').closest('tr').find('.jb').html(jabatan);
      $('.td_tr:checked').closest('tr').find('.sat').html(satker);
      $('.td_tr:checked').closest('tr').find('.wil').html(wilayah_text);
      $('.td_tr:checked').closest('tr').find('.wak').html(waktuTampil);

      // untuk msukan ke database
      $('.td_tr:checked').attr('rel',gabung);
      $('.td_tr:checked').closest('td').find('.namaTerlapor').attr('value',nama_terlapor);
      $('.td_tr:checked').closest('td').find('.jabatanTerlapor').attr('value',jabatan);
      $('.td_tr:checked').closest('td').find('.tgl').attr('value',tgl);
      $('.td_tr:checked').closest('td').find('.satkerTerlapor').attr('value',satker);
      $('.td_tr:checked').closest('td').find('.bln').attr('value',bln);
      $('.td_tr:checked').closest('td').find('.wilayahTerlapor').attr('value',opt_wilayah);
      $('.td_tr:checked').closest('td').find('.thn').attr('value',thn);
      $('.td_tr:checked').closest('td').find('.waktuTerlapor').attr('value',waktu);
      $('.td_tr:checked').closest('td').find('.pelanggaranTerlapor').attr('value',pelanggaran);
      $('.td_tr:checked').closest('td').find('.td_bidang').attr('value',bidang);
      $('.td_tr:checked').closest('td').find('.unit').attr('value',unit);
      $('.td_tr:checked').closest('td').find('.td_cabjari').attr('value',cabjari);
      $('.td_tr:checked').closest('td').find('.inspektur').attr('value',idinspektur);
    } 

       // GoTerlapor(nama_pelapor,jabatan,satker,opt_wilayah,wilayah_text,waktu,waktuTampil,pelanggaran,tgl,bln,thn,id_baris,cek,bidang,unit,cabjari,bidangtext,unittext,cabjaritext,idinspektur,new_td);
   }
    });

  $(document).on('hidden.bs.modal','#modalBidang,#modalKejati,#modalKejari,#modalCabjari', function (e) {
      $(this)
        .find("input,textarea,select")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

  });

/*validasi*/
$("#lapdu-no_register").keyup(function(){
   var str_variable = $(this).val();
var res = str_variable.replace(",", "");
$(this).val(res);
});

$("#lapdu-no_register").keydown(function(){
   var str_variable = $(this).val();
var res = str_variable.replace(",", "");
$(this).val(res);
});

$('.sumberlain').hide();

//*dn 
$("#pelapor-id_sumber_laporan").change(function(){
if($(this).val()=='13'){
 $('.sumberlain').show();
 $('#lbl_sumber').text('Sumber Lainya');
}else if($(this).val()=='11'){
 $('.sumberlain').show();
 $('#lbl_sumber').text('Nama LSM');
}else{
  $('.sumberlain').hide();
}
			  $('#pelapor-nama_pelapor').focus();


}

);


$("#hapus_all_pl").click(function () {
    //$('.th').attr('<input id="selectall" type="checkbox" >', this.checked);
    $('.td_pl:checkbox').not(this).prop('checked', this.checked);
    //alert("You have selected all boxes");
    });
$("#hapus_all_tr").click(function () {
    //$('.th').attr('<input id="selectall" type="checkbox" >', this.checked);
   $('.td_tr:checkbox').not(this).prop('checked', this.checked);
    //alert("You have selected all boxes");
    });



$("#terlapor-id_bidang_kejati").change(function(){
$('.dataTables_wrapper').addClass();
  var id=$(this).val();
  $.ajax({
            type:'POST',
            url:'/pengawasan/lapdu/kejagung',
            data:'id='+id,
            success:function(data){
            $('#KejagungToBidang').html(data);
            
            // alert(data);
            }
            });
  // alert('sdfs');
});

$("#idkejati").change(function(){
  var id=$(this).val();
  $.ajax({
            type:'POST',
            url:'/pengawasan/lapdu/kejari',
            data:'id='+id,
            success:function(data){
            $('#KejatiToKejari').html(data);
            
            }
            });
});
$("#idkejati_").change(function(){
  var id=$(this).val();
  $.ajax({
            type:'POST',
            url:'/pengawasan/lapdu/cabjari',
            data:'id='+id,
            success:function(data){
            // $('#KejariToCabjari').html(data);
            $('#idkejari').html(data);
            
            }
            });
});
$("#idkejari").change(function(){
  var id=$(this).val();
  var idkejati=$('#idkejati_').val();
  $.ajax({
            type:'POST',
            url:'/pengawasan/lapdu/cabjaridetail',
            data:'id='+id+'&idkejati='+idkejati,
            success:function(data){
            $('#KejariToCabjari').html(data);
            // $('#idkejari').html(data);
            
            }
            });

});

        var in_arr=['aaa','bbb','ccc','ddd','eee','fff','ggg','hhh','iii','jjj','kkk','lll','mmm','nnn','ooo','ppp','qqq','rrr','sss','ttt','uuu','vvv','www','xxx','yyy','zzz'];
$("#pelapor-nama_pelapor").keyup(function(){
        var x=$(this).val().toLowerCase();
        if(jQuery.inArray( x, in_arr )!='-1'){
        // $("input").css("background-color", "pink");
        alert('Nama Yang Dimasukan Tidak Benar');
        // notify(warna);
        $(this).val('');
        }
    });
$("#terlapor-nama_terlapor_awal").keyup(function(){
        var x=$(this).val().toLowerCase();
        // var in_arr=['aaa','bbb','ccc','ddd','eee','fff','ggg','hhh','iii','jjj','kkk','lll','mmm','nnn','ooo','ppp','qqq','rrr','sss','ttt','uuu','vvv','www','xxx','yyy','zzz'];
        if(jQuery.inArray( x, in_arr )!='-1'){
        // $("input").css("background-color", "pink");
        alert('Nama Yang Dimasukan Tidak Benar');
        // notify(warna);
        $(this).val('');
        }
    });

        $("#cetak").click(function(){
          // var cek_media=$('#lapdu-id_media_pelaporan').val();

          $("#print").val('1');
        });
//*dn
        $("#simpan").click(function(){
         
			
			var jmlpelapor=$('#tbody_pelapor tr').length;
			if (jmlpelapor<1){				
			alert('Form Pelapor Tidak Boleh Kosong');	
			$("#btn_pelapor").click();
			
			return false
			}
	
			var jmlterlapor=$('#tbody_terlapor tr').length;
			if (jmlterlapor<1){				
			alert('Form Terlapor Tidak Boleh Kosong');	
			$("#btn_terlapor").click();
			$('#terlapor-nama_terlapor_awal').focus();
			return false
	
			}
			
          $("#print").val('0');
        });

      

      $('.tbl_pelapor tr').on('click', function() {
         
          // $(this).toggleClass('click-row');
          // // $(this).toggleClass('click-row');
        
          // var y=$(this).attr('class');
          // if(y==''){
          //  $(this).find('.td_pl').prop('checked',false);
          //   $("#btn_hapus_pelapor").addClass("disabled");
          //   $("#btn_ubah_pelapor").addClass("disabled");
          // }else{
          // $(this).find('.td_pl').prop('checked',true);
          //   $("#btn_hapus_pelapor").removeClass("disabled");
          //   $("#btn_ubah_pelapor").removeClass("disabled");
          // }
           // alert(y);
      });

		//Validasi File 3MB by Danar
	   $('#lapdu-file_lapdu').bind('change', function() {
			var batas =this.files[0].size;
			if (batas > 3145728){
            bootbox.dialog({
                message: "Maaf Ukuran File Lapdu Lebih Dari 3 MB",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
			document.getElementById("lapdu-file_lapdu").value = "";
			}
        });
		$('#lapdu-file_disposisi').bind('change', function() {
			var batas =this.files[0].size;
			if (batas > 3145728){
            bootbox.dialog({
                message: "Maaf Ukuran File Disposisi Jam Was Lebih Dari 3 MB",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
			document.getElementById("lapdu-file_disposisi").value = "";
			}
        });
		//End Validasi by Danar

      $('.tbl_terlapor tr').on('click', function() {
         
          $(this).toggleClass('click-row');
        
          // $(this).toggleClass('click-row');
        
          var z=$(this).attr('class');
          if(z==''){
           $(this).find('.td_tr').prop('checked',false);
            $("#hapus_terlapor").addClass("disabled");
            $("#ubah_terlapor").addClass("disabled");
          }else{
          $(this).find('.td_tr').prop('checked',true);
            $("#hapus_terlapor").removeClass("disabled");
            $("#ubah_terlapor").removeClass("disabled");
          }
          // $(this).find(".td_tr")
           // alert(z);
      });

  
    
  });
     


</script>


