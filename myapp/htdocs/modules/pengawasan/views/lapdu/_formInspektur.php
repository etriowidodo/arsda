
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
                'id' => 'inspektur',
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
                       <?php
                       // print_r($model);
                       // =
                       if($model['tanggal_surat_lapdu']!=''){
                        $tgl_lapdu=date("d-m-Y", strtotime($model['tanggal_surat_lapdu']));
                       }
                           // echo $form->field($model, 'tanggal_surat_lapdu')->widget(DateControl::className(), [
                           //      'type' => DateControl::FORMAT_DATE,
                           //      'ajaxConversion' => false,
                           //      'displayFormat' => 'dd-MM-yyyy',
                           //      'options' => [

                           //          'pluginOptions' => [

                           //              'autoclose' => true,
                           //          ]
                           //      ],
                           //  ]);

                            ?>
                        <input type="text" id="dt1" class="form-control" name="Lapdu[tanggal_surat_lapdu]" value="<?= $tgl_lapdu ?>" readonly>
                    </div>
                </div>
            </div>
                <?php   ?>
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
                       <?
                       echo  $form->field($model, 'tembusan_lapdu')->textInput(['maxlength' => true,'readonly'=>'readonly'])
                        ?>
                    </div>
                </div>
            </div>
                <?php   ?>
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
                       // echo date("d-m-Y", strtotime($model['tanggal_surat_lapdu']));
                       // echo $form->field($model, 'tanggal_surat_diterima')->widget(DateControl::className(), [
                       //          'type' => DateControl::FORMAT_DATE,
                       //          'ajaxConversion' => false,
                       //          'displayFormat' => 'dd-MM-yyyy',
                       //          'options' => [

                       //              'pluginOptions' => [
                       //                  'autoclose' => true,
                       //                  // 'startDate'=>  date("d-m-Y", strtotime($model['tanggal_surat_lapdu'])),
                       //                  // 'startDate'=>  '10-08-2016',
                       //              ]
                       //          ],
                       //      ]);

                            ?>
                       <input type="text" id="dt2" class="form-control" name="Lapdu[tanggal_surat_diterima]" value="<?= $tgl_diterima?>" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-sm-5">Lampiran</label>
                    <div class="col-sm-7 kejaksaan">
                       <?php
                          echo $form->field($model, 'lampiran')->textInput(['maxlength' => true,'readonly'=>'readonly']);
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
        </div>
        <div class="box-header with-border">
           <!--  <div class="box-header with-border" style="border-color: #c7c7c7;">
                   
            </div> -->

            <table id="table_pelapor" class="table table-bordered tbl_pelapor">
                <thead>
                    <tr>
                        <th width="4%">No</th>
                        <th width="35%">Sumber Laporan</th>
                        <th>Nama Pelapor</th>
                        <th>Alamat</th>
                        <th>No telp</th>
                        <!-- <th width="4%"></th> -->
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
                            echo "<td>" . $data['nama_pelapor'] . "<input type='hidden' name='nama[]' value='" . $data['nama_pelapor'] . "' /></td>";
                            echo "<td>" . $data['alamat_pelapor'] . "<input type='hidden' name='alamat[]' value='" . $data['alamat_pelapor'] . "' /><input type='hidden' name='pekerjaan[]' value='" . $data['pekerjaan_pelapor']. "' /></td>";
                            echo "<td>" . $data['telp_pelapor'] . "<input type='hidden' name='no_telepon[]' value='" . $data['telp_pelapor']. "' /><input type='hidden' name='sumberlainya[]' value='" . $data['sumber_lainnya'] . "' />
                            <input type='hidden' name='tempat_lahir[]' value='" . $data['tempat_lahir_pelapor'] . "' /><input type='hidden' name='tgl_lahir[]' value='" . $data['tanggal_lahir_pelapor'] . "' /><input type='hidden' name='warga[]' value='" . $data['kewarganegaraan_pelapor'] . "' />
                            <input type='hidden' name='agama[]' value='" . $data['agama_pelapor'] . "' /><input type='hidden' name='pendidikan[]' value='" . $data['pendidikan_pelapor'] . "' /><input type='hidden' name='kota[]' value='" . $data['nama_kota_pelapor'] . "' />
                            </td>";
                             //  echo "<td class='ck_bok' width='4%'><input class='td_pl' type='checkbox' name='ck_pl_ubah' rel='trpelapor".$data['id_pelapor']."' value='".$data['id_pelapor']."'enama='".$data['nama_pelapor']."'ealamat='".$data['alamat_pelapor']."'eno_telepon='".$data['telp_pelapor']."' esumber='".$data['id_sumber_laporan']."' esumberlainya='".$data['sumber_lainnya']."' epekerjaan='".$data['pekerjaan_pelapor']."' eemail='".$data['email_pelapor']."'
                             // etempat_lahir='".$data['tempat_lahir_pelapor']."' etgl_lahir='".date('d-m-Y', strtotime($data['tanggal_lahir_pelapor']))."' ewarga='".$data['kewarganegaraan_pelapor']."' eagama='".$data['agama_pelapor']."'
                             // ependidikan='".$data['pendidikan_pelapor']."'ekota='".$data['nama_kota_pelapor']."'></td>";
                            // echo "<td><a class='btn btn-primary btn_hapus_pelapor' id='btn_hapus_pelapor' rel='trpelapor".$data->id_pelapor."'>Hapus</a></td>";
                            echo "</tr>";
                        $no++;
                        }
                    // }
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
           <!--  <div class="box-header with-border" style="border-color: #c7c7c7;">
                   
            </div> -->
        <table id="table_jpu" class="table table-bordered tbl_terlapor">
            <thead>
                <tr>
                    <th width="4%" rowspan="2">No</th>
                    <th width="20%" rowspan="2">Nama Terlapor</th>
                    <th rowspan="2">Jabatan</th>
                    <th rowspan="2">Satuan Kerja</th>
                    <th width="10%" align="center" colspan="2" >Pelanggaran</th>
                    <!-- <th width="15%" align="center" colspan="3">IRMUD</th> -->
                    <th width="7%" rowspan="2">Pegasum & Kepbang</th>
                    <th width="6%" rowspan="2">Pidum & Datun</th>
                    <th width="5%" rowspan="2">Intel & Pidsus</th>
                </tr>
                <tr>
                    <th>Wilayah</th>
                    <th>Waktu</th>
                </tr>
                

            </thead>
            <tbody id="tbody_terlapor">
                <?php
                // if (!$model->isNewRecord) {
                //     $no=1;
                    foreach ($terlapor as $data) {
                        // $query = new Query;
                        // $query->select('*')
                        //         ->from('was.v_riwayat_jabatan')
                        //         ->where("id= :id", [':id' => $data->id_h_jabatan]);

                        // $pegawai = $query->one();
                        if($data['id_wilayah']=='0'){
                            $nama_wilayah="Kejaksaan Agung RI";
                        }else if($data['id_wilayah']=='1'){
                            $nama_wilayah="Kejati";
                        }else if($data['id_wilayah']=='2'){
                            $nama_wilayah="Kejari";
                        }else if($data['id_wilayah']=='3'){
                            $nama_wilayah="Cabjari";
                        }

                        echo '<tr id="trterlapor' . $data['id_terlapor_awal'] . '">';
                        echo '<td>'.$no.'<input type="hidden" name="no_urut[]" value="' . $data['id_terlapor_awal'] . '">';
                        echo '<td>'.$data['nama_terlapor_awal'].'<input type="hidden" name="namaTerlapor[]" value="' . $data['nama_terlapor_awal'] . '"></td>';
                        echo '<td>'.$data['jabatan_terlapor_awal'].'<input type="hidden" name="jabatanTerlapor[]" value="' . $data['jabatan_terlapor_awal'] . '"><input type="hidden" name="tgl[]" value="'.$data['tgl_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.$data['satker_terlapor_awal'].'<input type="hidden" name="satkerTerlapor[]" value="' . $data['satker_terlapor_awal'] . '"><input type="hidden" name="bln[]"  value="'.$data['bln_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.$nama_wilayah.'<input type="hidden" name="wilayahTerlapor[]" value="' . $data['id_wilayah'] . '"><input type="hidden" name="thn[]" value="'.$data['thn_pelanggaran_terlapor_awal'].'"></td>';
                        echo '<td>'.$data['tgl_pelanggaran_terlapor_awal'].'-'.$data['bln_pelanggaran_terlapor_awal'].'-'.$data['thn_pelanggaran_terlapor_awal'].'
                        <input type="hidden" name="waktuTerlapor[]" value="' . $data['tgl_pelanggaran_terlapor_awal'].'-'.$data['bln_pelanggaran_terlapor_awal'].'-'.$data['thn_pelanggaran_terlapor_awal'] . '"><input type="hidden" name="pelanggaranTerlapor[]" value="'.$data['pelanggaran_terlapor_awal'].'">
                        <input type="hidden" name="bidang[]" value="'.$data['id_bidang_kejati'].'"><input type="hidden" name="unit[]" value="'.$data['id_unit_kejari'].'"><input type="hidden" name="cabjari[]" value="'.$data['id_unit_kejari'].'">
                        </td>';
                        // echo '<input type="hidden" class="form-control" name="nipTerlapor[]" id="nip_terlapor" readonly="true" value="' . $pegawai['peg_nip_baru'] . '">';
                        // echo '<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="' . $data->id_h_jabatan . '">';
                        // echo '<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="' . $pegawai['peg_nik'] . '">';
                        /*
                        echo '<td><input type="text" class="form-control" name="nipTerlapor[]" id="nip_terlapor" readonly="true" value="' . $pegawai['peg_nip_baru'] . '">';
                        echo '<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="' . $data->id_h_jabatan . '">';
                        echo '<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="' . $pegawai['peg_nik'] . '">';
                        echo '</td>';
                        
                        echo '<td class="ck_bok" width="4%"><input class="td_tr" type="checkbox" name="ck_tr_ubah" rel="trterlapor' . $data['id_terlapor_awal'] . '" value="'. $data['id_terlapor_awal'] .'" enama_terlapor="'.$data['nama_terlapor_awal'].'"ejabatan_terlapor="'.$data['jabatan_terlapor_awal'].'"esatker_terlapor="'.$data['satker_terlapor_awal'].'"eid_wilayah="'.$data['id_wilayah'].'"epelanggaran="'.$data['pelanggaran_terlapor_awal'].'"etgl="'.$data['tgl_pelanggaran_terlapor_awal'].'"ebln="'.$data['bln_pelanggaran_terlapor_awal'].'"ethn="'.$data['thn_pelanggaran_terlapor_awal'].'"
                        ebidang="'.$data['bidang_kejati'].'" eunit_kejari="'.$data['unit_kejari'].'"ecabjari="'.$data['cabjari'].'"></td>';*/
                        // echo '<td><input type="hidden" name="pelanggaranTerlapor[]" readonly="true" value="'.$data['pelanggaran_terlapor_awal'].'"><a class="btn btn-primary btn_delete_terlapor" id="btn_delete_terlapor" rel="trterlapor' . $data['id_terlapor_awal'] . '">Hapus</a></td>';
                      echo'<td align="center"><input class="td_pegasum" type="checkbox" name="pegasum[]" value="'.$data['id_terlapor_awal'].'" '.($data['cek1']=='1'?"checked":'').'></td>';
                      echo'<td align="center"><input class="td_pidum" type="checkbox" name="pidum[]" value="'.$data['id_terlapor_awal'].'" '.($data['cek2']=='1'?"checked":'').'></td>';
                      echo'<td align="center"><input class="td_intel" type="checkbox" name="intel[]" value="'.$data['id_terlapor_awal'].'" '.($data['cek3']=='1'?"checked":'').'></td>';
                        echo '</tr>';
                    $no++;
                    }
                //     // print_r($terlapor);
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
                    <label class="control-label col-md-4">Perihal</label>
                <div class="form-group">
                    <div class="col-md-12 kejaksaan">
                <?= $form->field($model, 'perihal_lapdu')->textarea(['rows' => 2, 'id'=>'perihal_lapdu','readonly'=>'readonly']) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                    <label class="control-label col-md-4">Ringkasan/Isi Laporan</label>
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
                    <!-- <label class="control-label col-md-3">Upload File</label> -->
                    <div class="col-md-8 kejaksaan" style="right:45px;">
                         <?php //=
                //           echo $form->field($model, 'file_lapdu')->widget(FileInput::classname(), [
                //             'options' => ['accept'=>'application/pdf'],
                //             'pluginOptions' => [
                //                 'showPreview' => true,
                //                 'showUpload' => false,
                //                 'showRemove' => false,
                // 'showClose' => false,
                //                 'showCaption'=> false,
                //                 'allowedFileExtension' => ['pdf','jpeg','jpg','png'],
                //                 'maxFileSize'=> 3027,
                //                 'browseLabel'=>'Pilih File',
                //             ]
                //         ]);
                        ?>

                    </div>
                    <div class="col-md-1 kejaksaan" style="right:250px;">
                      <div class="form-group">
                        <?= ($model->file_lapdu!='' ? '<a href="viewpdf?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="glyphicon glyphicon-file"></i></span></a>' :'') ?>
                      </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Only Inspektur -->
        <div class="box box-primary" style="padding: 15px 0px;">
        <div class="col-md-12">
            <div class="col-sm-12">
                    <label class="control-label col-md-2">Keterangan</label>
                <div class="form-group">
                    <div class="col-md-12 kejaksaan">
                <?= $form->field($model, 'keterangan')->textarea(['rows' => 2, 'id'=>'keterangan']); ?>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-sm-12">
          <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal</label>
                    <div class="col-md-8 kejaksaan">
                <?= $form->field($model, 'tgl_disposisi')->textInput(['maxlength' => true]); ?>
                    </div>
                </div>
            </div>
        <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label col-md-4">File Disposisi</label>
                    <div class="col-md-8 kejaksaan">
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
            <div class="col-md-1 kejaksaan" style="right:100px;">
                      <div class="form-group">
                        <?= ($model->file_disposisi!='' ? '<a href="viewpdf?id='.$model['no_register'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="glyphicon glyphicon-file"></i></span></a>' :'') ?>
                      </div>
                    </div>
        </div>

        </div>

 <div class="col-md-12">
    <div class="form-group">
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <?php //echo Html::Button('Kembali', ['class' => 'tombolbatalindex btn btn-primary']); ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
        
    </div>
    </div>
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
}
</style>
<!-- =========================================================MODAL BIDANG================================================================= -->



