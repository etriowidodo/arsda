<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\db\Query;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use app\modules\pengawasan\models\SkWas4aSearch;
use yii\widgets\Pjax;
use app\components\GlobalFuncComponent; 

use app\models\LookupItem;
/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4a */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="sk-was-4a-form">

  <?php
  $form = ActiveForm::begin([
              'options' => ['enctype' => 'multipart/form-data'],
              'id' => 'sk-was-4a-form',
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

  <section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <div class="box-header with-border">
            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="width: 140px;">No SK </label>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-sm-12">
                                     <?= $form->field($model, 'no_sk_was_4a')->textInput()->label(false); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal SK</label>
                        <div class="col-md-8">
                            <?=
                                $form->field($model, 'tgl_sk_was_4a',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'pluginOptions' => [
                                            //'startDate' => date('d-m-Y',strtotime($modelSpWas2['tanggal_sp_was2'])),
                                            'startDate' => date('d-m-Y'),
                                            'endDate' => 0,
                                            'autoclose' => true
                                        ]
                                    ]
                                ]);
                                ?>
                        </div>
                    </div>
                </div>
             
            </div>
            <div class="col-md-12" style="padding: 15px 0;">
             <?php if(!$model->isNewRecord){ ?>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="width: 140px;">Tanggal Diterima SK</label>
                        <div class="col-md-8">
                            <?=
                                $form->field($model, 'tgl_diterima_sk_was_4a',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'pluginOptions' => [
                                            //'startDate' => date('d-m-Y',strtotime($modelSpWas2['tanggal_sp_was2'])),
                                            'startDate' => date('d-m-Y'),
                                            'endDate' => 0,
                                            'autoclose' => true
                                        ]
                                    ]
                                ]);
                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tempat</label>
                        <div class="col-md-8">
                             <?= $form->field($model, 'di_tempat')->textInput(['maxlength'=>true])->label(false); ?>
                        </div>
                    </div>
                </div>
              <?php } ?>  
            </div> 

            <div class="col-md-12" style="padding: 0px 0;">    
               <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="width: 140px;">Tanggal LAPDU</label> 
                        <div class="col-md-8">
                                     <?= $form->field($model, 'tgl_lapdu',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'pluginOptions' => [
                                            //'startDate' => date('d-m-Y',strtotime($modelSpWas2['tanggal_sp_was2'])),
                                            'startDate' => date('d-m-Y'),
                                            'endDate' => 0,
                                            'autoclose' => true
                                        ]
                                    ]
                                ])->textInput(['readonly'=>'readonly','value'=>$dataLapdu->tanggal_surat_lapdu])->label(false); ?>
                        </div>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pasal Pelanggaran</label>
                        <div class="col-md-8">
                                  <?php if(!$model->isNewRecord){ ?>
                                    <?= $form->field($model, 'pasal')->textInput(['readonly'=>'readonly','value'=>$_GET['id3']])->label(false); ?>
                                 <?php }else{ ?>
                                    <?= $form->field($model, 'pasal')->textInput(['readonly'=>'readonly','value'=>$_GET['id2']])->label(false); ?>
                                 <?php }?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Daftar Pelapor</div>
                    <div class="panel-body">
                        <table class="table dataTable" id="" role="" aria-describedby="" style="padding-top: 20px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Sumber Laporan</th>
                                    <th style="text-align: center;">Nama Pelapor</th>
                                    <th style="text-align: center;" >Alamat</th>
                                    <th style="text-align: center;">Telp.</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                   $no_1=1; 
                                   //print_r($dataPelapor);
                                  // foreach ($dataPelapor as $value_pelapor) { ?>
                                        <tr role="row" class="pelapor">
                                            <td style="text-align:center;"><?= $no_1 ?>
                                                <input type="hidden" name="nama_pelapor[]" id="nama_pelapor" value="<?= $dataPelapor['nama_pelapor']; ?>">
                                                <input type="hidden" name="alamat_pelapor[]" id="alamat_pelapor" value="<?= $dataPelapor['alamat_pelapor']; ?>">
                                                <input type="hidden" name="email_pelapor[]" id="email_pelapor" value="<?= $dataPelapor['email_pelapor']; ?>">
                                                <input type="hidden" name="telp_pelapor[]" id="telp_pelapor" value="<?= $dataPelapor['telp_pelapor']; ?>">
                                                <input type="hidden" name="pekerjaan_pelapor[]" id="pekerjaan_pelapor" value="<?= $dataPelapor['pekerjaan_pelapor']; ?>">
                                                <input type="hidden" name="kewarganegaraan_pelapor[]" id="kewarganegaraan_pelapor" value="<?= $dataPelapor['kewarganegaraan_pelapor']; ?>">
                                                <input type="hidden" name="agama_pelapor[]" id="agama_pelapor" value="<?= $dataPelapor['agama_pelapor']; ?>">
                                                <input type="hidden" name="pendidikan_pelapor[]" id="pendidikan_pelapor" value="<?= $dataPelapor['pendidikan_pelapor']; ?>">
                                                <input type="hidden" name="nama_kota_pelapor[]" id="nama_kota_pelapor" value="<?= $dataPelapor['nama_kota_pelapor']; ?>">
                                                <input type="hidden" name="tanggal_lahir_pelapor[]" id="tanggal_lahir_pelapor" value="<?= $dataPelapor['tanggal_lahir_pelapor']; ?>">
                                                <input type="hidden" name="tempat_lahir_pelapor[]" id="tempat_lahir_pelapor" value="<?= $dataPelapor['tempat_lahir_pelapor']; ?>">
                                                <input type="hidden" name="sumber_lainnya[]" id="sumber_lainnya" value="<?= $dataPelapor['sumber_lainya']; ?>">
                                                <input type="hidden" name="id_sumber_laporan[]" id="id_sumber_laporan" value="<?= $dataPelapor['id_sumber_laporan']; ?>">
                                              </td>
                                            <td><?= $dataPelapor['nama_sumber_laporan']?></td>
                                            <td><?= $dataPelapor['nama_pelapor']?></td>
                                            <td><?= $dataPelapor['alamat_pelapor']?></td>
                                            <td><?= $dataPelapor['telp_pelapor']?>
                                            </td>  
                                        </tr>
                                <?php  $no_1++; ?> 
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Daftar Terlapor</div>
                    <div class="panel-body">
                        <table class="table dataTable" id="" role="" aria-describedby="" style="padding-top: 20px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;" >Nama Terlapor</th>
                                    <th style="text-align: center;" >NIP Terlapor</th>
                                    <th style="text-align: center;">Bentuk Pelanggaran</th>
                                    <th style="text-align: center;">Pasal Pelanggaran</th>
                                </tr>
                            </thead>
                            <tbody> 
                                         <?php
                                               $no_2=1; 
                                              // foreach ($dataTerlapor as $value_terlapor) { ?>
                                                    <tr role="row" class="terlapor">
                                                        <td style="text-align:center;"><?= $no_2 ?>
                                                            <input type="hidden" id="id_sp_was2" name="id_sp_was2" value="<?= $dataTerlapor['id_sp_was2'] ?>"> 
                                                            <input type="hidden" id="id_ba_was2" name="id_ba_was2" value="<?= $dataTerlapor['id_ba_was2'] ?>">
                                                            <input type="hidden" id="id_l_was2" name="id_l_was2" value="<?= $dataTerlapor['id_l_was2'] ?>">
                                                            <input type="hidden" id="id_was15" name="id_was15" value="<?= $dataTerlapor['id_was15'] ?>">
                                                            <?= $form->field($model, 'nip_pegawai_terlapor')->hiddenInput(['readonly'=>'readonly','value'=>$dataTerlapor['nip_terlapor']]); ?>
                                                            <?= $form->field($model, 'nama_pegawai_terlapor')->hiddenInput(['readonly'=>'readonly','value'=>$dataTerlapor['nama_terlapor']]); ?>
                                                            <?= $form->field($model, 'pangkat_pegawai_terlapor')->hiddenInput(['readonly'=>'readonly','value'=>$dataTerlapor['pangkat_terlapor']]); ?>
                                                            <?= $form->field($model, 'golongan_pegawai_terlapor')->hiddenInput(['readonly'=>'readonly','value'=>$dataTerlapor['golongan_terlapor']]); ?>
                                                            <?= $form->field($model, 'jabatan_pegawai_terlapor')->hiddenInput(['readonly'=>'readonly','value'=>$dataTerlapor['jabatan_terlapor']]); ?>
                                                        
                                                        </td>
                                                        <td><?= $dataTerlapor['nama_terlapor']?></td>
                                                        <td><?= $dataTerlapor['nip_terlapor']?></td>
                                                        <td><?= $dataTerlapor['keterangan_pelanggaran']?></td>
                                                        <td><?= $dataTerlapor['pasal']?></td>
                                                    </tr>
                                            <?php // $no_2++; } ?>  
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Daftar Pemeriksa</div>
                    <div class="panel-body">
                        <table class="table dataTable" id="" role="" aria-describedby="" style="padding-top: 20px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Pemeriksa</th>
                                    <th style="text-align: center;">NIP Pemeriksa</th>
                                    <th style="text-align: center;" >Pangkat Pemeriksa</th>
                                    <th style="text-align: center;" >Jabatan Pemeriksa</th>
                                    <th style="text-align: center;" >Golongan Pemeriksa</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php if(!$model->isNewRecord){ ?>    
                                     <?php
                                       $no_3=1; 
                                       foreach ($modelPemeriksa as $value_pemeriksa) { ?>
                                            <tr role="row" class="pemeriksa">
                                                <td style="text-align:center;"><?= $no_3 ?>
                                                    <input type="hidden" name="nip_pemeriksa[]" id="nip_pemeriksa" value="<?= $value_pemeriksa['nip_pemeriksa']; ?>">
                                                    <input type="hidden" name="nrp_pemeriksa[]" id="nrp_pemeriksa" value="<?= $value_pemeriksa['nrp_pemeriksa']; ?>">
                                                    <input type="hidden" name="nama_pemeriksa[]" id="nama_pemeriksa" value="<?= $value_pemeriksa['nama_pemeriksa']; ?>">
                                                    <input type="hidden" name="pangkat_pemeriksa[]" id="pangkat_pemeriksa" value="<?= $value_pemeriksa['pangkat_pemeriksa']; ?>">
                                                    <input type="hidden" name="jabatan_pemeriksa[]" id="jabatan_pemeriksa" value="<?= $value_pemeriksa['jabatan_pemeriksa']; ?>">
                                                    <input type="hidden" name="golongan_pemeriksa[]" id="golongan_pemeriksa" value="<?= $value_pemeriksa['golongan_pemeriksa']; ?>">
                                                </td>
                                                <td><?= $value_pemeriksa['nama_pemeriksa']?></td>
                                                <td><?= $value_pemeriksa['nip_pemeriksa']?></td>
                                                <td><?= $value_pemeriksa['pangkat_pemeriksa']?></td>
                                                <td><?= $value_pemeriksa['jabatan_pemeriksa']?></td>
                                                <td><?= $value_pemeriksa['golongan_pemeriksa']?></td>
                                            </tr>
                                    <?php  $no_3++; }?> 
                             <?php  }else{ ?>
                                    <?php
                                      $no_3=1; 
                                      // foreach ($dataPemeriksa as $value_pemeriksa) { ?>
                                            <tr role="row" class="pemeriksa">
                                                <td style="text-align:center;"><?= $no_3 ?>
                                                    <input type="hidden" name="nip_pemeriksa[]" id="nip_pemeriksa" value="<?= $dataPemeriksa['nip_pemeriksa']; ?>">
                                                    <input type="hidden" name="nrp_pemeriksa[]" id="nrp_pemeriksa" value="<?= $dataPemeriksa['nrp_pemeriksa']; ?>">
                                                    <input type="hidden" name="nama_pemeriksa[]" id="nama_pemeriksa" value="<?= $dataPemeriksa['nama_pemeriksa']; ?>">
                                                    <input type="hidden" name="pangkat_pemeriksa[]" id="pangkat_pemeriksa" value="<?= $dataPemeriksa['pangkat_pemeriksa']; ?>">
                                                    <input type="hidden" name="jabatan_pemeriksa[]" id="jabatan_pemeriksa" value="<?= $dataPemeriksa['jabatan_pemeriksa']; ?>">
                                                    <input type="hidden" name="golongan_pemeriksa[]" id="golongan_pemeriksa" value="<?= $dataPemeriksa['golongan_pemeriksa']; ?>">
                                                </td>
                                                <td><?= $dataPemeriksa['nama_pemeriksa']?></td>
                                                <td><?= $dataPemeriksa['nip_pemeriksa']?></td>
                                                <td><?= $dataPemeriksa['pangkat_pemeriksa']?></td>
                                                <td><?= $dataPemeriksa['jabatan_pemeriksa']?></td>
                                                <td><?= $dataPemeriksa['golongan_pemeriksa']?></td>
                                            </tr>
                                    <?php  $no_3++; }?> 
                            <?php  //}?> 
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Membaca</div>
                    <div class="panel-body">

                        <div class="form-group">
                         <div class="col-sm-12" ></div>
                            <?php 
                               $membaca="<ol type='1'>
                                          <li>laporan dari ".$dataPelapor['nama_pelapor']." tanggal ".\Yii::$app->globalfunc->ViewIndonesianFormat(date('Y-m-d',strtotime($dataTerlapor['tanggal_surat_lapdu'])))." tentang dugaan pelanggaran disiplin yang dilakukan
                                              terlapor atas nama ".$dataTerlapor['nama_terlapor']." NIP ".$dataTerlapor['nip_terlapor']." NRP ".$dataTerlapor['nrp_terlapor']." Pangkat ".$dataTerlapor['pangkat_terlapor']." 
                                              Jabatan ".ucwords(strtolower($dataTerlapor['jabatan_terlapor']))."</li>
                                          <li>Laporan Hasil Inspeksi Kasus yang dilakukan oleh Nama ".$dataPemeriksa['nama_pemeriksa']." NIP ".$dataPemeriksa['nip_pemeriksa']." NRP ".$dataPemeriksa['nrp_pemeriksa']."
                                              pangkat ".$dataPemeriksa['pangkat_pemeriksa']." Jabatan ".ucwords(strtolower($dataPemeriksa['jabatan_pemeriksa']))."</li>
                                        </ol>";   

                            ?>
                                <div>
                                    <?php if(!$model->isNewRecord){ ?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="membaca"> <?= $modelUraian[0]['isi_uraian']; ?></textarea>
                                    <?php }else{?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="membaca"> <?= $membaca ?></textarea>
                                    <?php } ?>
                                    <br>
                                </div>
                        </div>
                    </div>
                </div>
           </div> 

           <div class="col-md-12" style="padding-top: 15px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Menimbang</div>
                    <div class="panel-body">
                        <div class="form-group">
                         <div class="col-sm-12" ></div>
                            <?php 
                                $menimbang="<ol style='list-style-type: lower-alpha;'>
                                          <li>Bahwa menurut Laporan Hasil Inspeksi Kasus terlapor atas nama ".$dataTerlapor['nama_terlapor']." 
                                              telah melakukan perbuatan berupa ".$dataTerlapor['pelanggaran'].".</li>
                                          <li>Bahwa perbuatan tersebut merupakan pelanggaran terhadap ketentuan ".$dataTerlapor['pasal'].".</li>
                                          <li>Bahwa untuk menegakan disiplin, perlu menjatuhkan hukuman disiplin yang setimpal
                                              dengan pelanggaran disiplin yang dilakukannya.</li>
                                          <li>bahwa berdasarkan pertimbangan sebagaimana dimaksud dalam huruf a, b, dan c perlu Menetapkan
                                              Keputusan tentang Penjatuhan hukuman disiplin berupa Pembebasan dari Jabatan.</li>
                                        </ol>";   
                            ?>
                                <div>
                                    <?php if(!$model->isNewRecord){ ?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="membaca"> <?= $modelUraian[1]['isi_uraian']; ?></textarea>
                                    <?php }else{?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="menimbang"><?= $menimbang ?></textarea>
                                    <?php } ?>
                                    <br>
                                </div>
                        </div>
                    </div>
                </div>
           </div> 

           <div class="col-md-12" style="padding-top: 15px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Mengingat</div>
                    <div class="panel-body">
                        <div class="form-group">
                         <div class="col-sm-12" ></div>
                            <?php 
                                foreach ($dataPeraturan as $valuePeraturan) {
                                 $mengingat="<ol style='list-style-type: lower-alpha;'>
                                              <li>".$valuePeraturan['isi_peraturan']
                                                  ."</li>
                                          </ol>";
                                    } 

                                 $mengingat2="<ol style='list-style-type: lower-alpha;'>
                                              <li> </li>
                                          </ol>";         
                            ?>
                                <div>
                                    <?php if(!$model->isNewRecord){ ?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="membaca"> <?= $modelUraian[2]['isi_uraian']; ?></textarea>
                                    <?php }else{?>
                                       <?php if($valuePeraturan['isi_peraturan'] == ''){?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="mengingat"><?= $mengingat2 ?></textarea>
                                       <?php }else{ ?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="mengingat"><?= $mengingat ?></textarea>
                                       <?php } ?>
                                    <?php } ?>
                                    <br>
                                </div>
                        </div>
                    </div>
                </div>
           </div> 

           <div class="col-md-12" style="padding-top: 15px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Uraian Menetapkan</div>
                    <div class="panel-body">
                        <div class="form-group">
                         <div class="col-sm-12" ></div>
                            <?php 
                             $menetapkan="<table>
                                                <tr>
                                                    <td style='vertical-align:top'>KESATU</td>
                                                    <td style='vertical-align:top'>:</td>
                                                    <td colspan='2'>Menjatuhkan Hukuman Disiplin berupa PEMBEBASAN DARI JABATAN kepada :</td>
                                                </tr>
                                                <tr>
                                                    <td style='width:10%'></td>
                                                    <td style='width:2%'></td>
                                                    <td style='width:15%'>Nama</td>
                                                    <td style='width:73%'>: ".$dataTerlapor['nama_terlapor']."</td>
                                                </tr>
                                                <tr>
                                                    <td style='width:10%'></td>
                                                    <td style='width:2%'></td>
                                                    <td style='width:15%'>Pangkat</td>
                                                    <td style='width:73%'>: ".$dataTerlapor['pangkat_terlapor']."</td>
                                                </tr>
                                                <tr>
                                                    <td style='width:10%'></td>
                                                    <td style='width:2%'></td>
                                                    <td style='width:15%'>NIP / NRP</td>
                                                    <td style='width:73%'>: ".$dataTerlapor['nip_nrp']."</td>
                                                </tr>
                                                <tr>
                                                    <td style='width:10%'></td>
                                                    <td style='width:2%'></td>
                                                    <td style='width:15%'>Jabatan</td>
                                                    <td style='width:73%'>: ".ucwords(strtolower($dataTerlapor['jabatan_terlapor']))."</td>
                                                </tr>
                                                <tr>
                                                    <td style='width:10%'></td>
                                                    <td style='width:2%'></td>
                                                    <td style='width:15%'>Unit Kerja</td>
                                                    <td style='width:73%'>: ".ucwords(strtolower($dataTerlapor['instansi']))."</td>
                                                </tr>
                                                <tr>
                                                    <td style='width:10%'></td>
                                                    <td style='width:2%'></td>
                                                    <td colspan='2'>Karena yang bersangkutan pada tanggal ".\Yii::$app->globalfunc->ViewIndonesianFormat(date('Y-m-d',strtotime($dataTerlapor['tanggal_surat_lapdu'])))."
                                                                    telah melakukan perbuatan yang melanggar 
                                                                    ketentuan ".$dataTerlapor['pasal'].";</td>
                                                </tr>
                                                <tr>
                                                    <td style='vertical-align:top'>KEDUA</td>
                                                    <td style='vertical-align:top'>:</td>
                                                    <td colspan='2'>2 (dua) tahun sejak ditetapkan, kepada yang bersangkutan dapat diangkat kembali dalam jabatan ... 
                                                                    setelah mendapat persetujuan Jaksa Agung R.I.</td>
                                                </tr>
                                                <tr>
                                                    <td style='vertical-align:top'>KETIGA</td>
                                                    <td style='vertical-align:top'>:</td>
                                                    <td colspan='2'>Keputusan ini mulai berlaku pada tanggal ditetapkan.</td>
                                                </tr>
                                                <tr>
                                                    <td style='vertical-align:top'>KEEMPAT</td>
                                                    <td style='vertical-align:top'>:</td>
                                                    <td colspan='2'>Keputusan ini disampaikan kepada yang bersangkutan untuk dilaksanakan sebagaimana mestinya.</td>
                                                </tr>
                                             </table>";
                            ?>
                                <div>
                                    <?php if(!$model->isNewRecord){ ?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="membaca"> <?= $modelUraian[3]['isi_uraian']; ?></textarea>
                                    <?php }else{?>
                                        <textarea maxlength="50" name="uraian[]" class="ckeditor uraian" id="menetapkan"><?= $menetapkan ?></textarea>
                                    <?php } ?>
                                    <br>
                                </div>
                        </div>
                    </div>
                </div>
           </div> 

            <div class="col-md-12">
      <div class="panel panel-primary">
          <div class="panel-heading">Penandatangan</div>
              <div class="panel-body">
                 <div class="col-md-4">
                    <div class="form-group">
                        <!--<label class="control-label col-md-3">WAS-1</label>-->
                        
                        <label class="control-label col-md-3" style="width:22%">Nip</label>
                        <div class="col-md-10" style="width:75%">
                          <?php
                          //if(!$model->isNewRecord){
                          echo $form->field($model, 'nip_penandatangan',[
                                                  'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly']);
                        /* }else{
                          echo $form->field($model, 'nip_penandatangan_spwas1')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['nip_penandatangan_spwas1']]);
                        } */
                           ?>
                        </div>
                    </div>  
                </div>
                <!-- <div class="col-sm-1">
                    <button class="btn btn-primary" type="button" id="pilih_pegawai" data-toggle="modal" data-target="#peg_tandatangan">Pilih</button>
                </div> -->
                <div class="col-md-4">
                 <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                <div class="col-sm-10">
                     <?//= $form->field($model, 'was1_nama_penandatangan')->textInput(['readonly'=>'readonly']) ?>
                     <?php
                        //if(!$model->isNewRecord){
                        echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                      /* }else{
                        echo $form->field($model, 'nama_penandatangan_spwas1')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['nama_pemeriksa']]);
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
                        echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                        echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      ?>
                    

                </div>
                </div>
                </div>
          </div>
        </div>
    </div>


          
            <div class="col-md-12">
              <div class="col-md-12" style="padding:0px;">
                  <div class="panel panel-primary">
                      <div class="panel-heading">Tembusan</div>
                          <div class="panel-body">
                <div class="col-sm-12" style="margin-bottom: 15px">
                    <div class="col-sm-6">
                      <a class="btn btn-primary" id="hapus_tembusan"><span class="glyphicon glyphicon-trash"><i></i></span></a>
                      <a class="btn btn-primary"  id="addtembusan" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span> Tembusan</a>
                    </div>
                </div>
                <div class="for_tembusan">
                
                    <?php 
                 //   print_r($modelTembusanMaster);
                   // exit();
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
            </div>
           

            <?php if(!$model->isNewRecord){ ?>
            <div class="col-md-12" style="padding-top: 15px;">
                <label>Unggah Berkas Sk-Was-4a : 
                     <?php if (substr($model->upload_file,-3)!='pdf'){?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_sk_was_4a'].'&id2='.$model['id_sk_was_4a'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?> <?= $model['upload_file']?>
                    <?php } else{?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_sk_was_4a'].'&id2='.$model['id_sk_was_4a'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?= $model['upload_file']?>
                    <?php } ?>
                </label>
                <!-- <input type="file" name="upload_file" /> -->
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Upload File </span>
                <span class="fileupload-exists "> Ubah File</span>         <input type="file" name="upload_file" id="upload_file" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
            </div>
            <?php
             }
            ?>
        </div>
        <div align="center">
 <?php    
       if (!$model->isNewRecord){
        // if($result_expire=='1'){
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ;
          echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Batal', ['/pengawasan/sk-was-4a/index'], ['id' => 'KembaliSkWas4a', 'class' => 'btn btn-primary']);  
        //  }
       }else{
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ;
          echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Batal', ['/pengawasan/sk-was-4a/index'], ['id' => 'KembaliSkWas4a', 'class' => 'btn btn-primary']);
       }
    ?>   
    </div>
</section>

<?php ActiveForm::end(); ?>

<!-- begin penandatangan -->
<div class="modal fade" id="penandatangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Penandatangan</h4>
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
                                    <select name="jns_penandatangan" class="form-control">
                                      <option value="">Pilih</option>
                                      <option value="AN">AN</option>
                                      <option value="Plt">PLT</option>
                                      <option value="Plh">PLH</option>
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
                            $searchModelskwas4a = new SkWas4aSearch();
                            $dataProviderPenandatangan = $searchModelskwas4a->searchPenandatangan(Yii::$app->request->queryParams);
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
                                            return ['value' => $data['id_surat'],'class'=>'MPenandatangan_selection_one','json'=>$result];
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

    .content{
        margin-top: 10px;
    }
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
    .cke{margin:15px!important;}
    .field-skwas4apelapor-nama_pelapor , .field-skwas4apelapor-alamat_pelapor , .field-skwas4apelapor-email_pelapor
    , .field-skwas4apelapor-telp_pelapor, .field-skwas4apelapor-pekerjaan_pelapor, .field-skwas4apelapor-kewarganegaraan_pelapor
    , .field-skwas4apelapor-agama_pelapor, .field-skwas4apelapor-pendidikan_pelapor, .field-skwas4apelapor-nama_kota_pelapor
    , .field-skwas4apelapor-tanggal_lahir_pelapor, .field-skwas4apelapor-tempat_lahir_pelapor, .field-skwas4apelapor-sumber_lainnya
    , .field-skwas4apelapor-id_sumber_laporan ,.field-skwas4a-nip_pegawai_terlapor ,.field-skwas4a-nama_pegawai_terlapor
    ,.field-skwas4a-pangkat_pegawai_terlapor ,.field-skwas4a-golongan_pegawai_terlapor ,.field-skwas4a-jabatan_pegawai_terlapor
    ,.field-skwas4apemeriksa-nip_pemeriksa ,.field-skwas4apemeriksa-nrp_pemeriksa ,.field-skwas4apemeriksa-nama_pemeriksa
    ,.field-skwas4apemeriksa-pangkat_pemeriksa ,.field-skwas4apemeriksa-jabatan_pemeriksa ,.field-skwas4apemeriksa-golongan_pemeriksa{
        display: none;
    }
 
/* #skwas4a-tgl_sk_was_4a-disp{
    width: 405px;
 }*/   
</style>

<script type="text/javascript">
 /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

$(document).on('click','#addtembusan',function() {
            $('.for_tembusan').append('<div class=\"col-sm-7\" style=\"margin-bottom: 15px;\"><div class=\"col-sm-1\" style=\"text-align: center\"><input type=\"checkbox\" value=\"0\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\" class=\"no_urut\" readonly></div><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" id=\"pejabat\" name=\"pejabat[]\"></div></div>');
                i = 0;
            $('.for_tembusan').find('.col-sm-7').each(function () {

                i++;
                $(this).addClass('tembusan'+i);
                $(this).find('.cekbok').val(i);
            });
        });

        $(document).on('click','#hapus_tembusan',function() {
             // $('#hapus_tembusan').click(function(){
                var cek = $('.cekbok:checked').length;
                 var checkValues = $('.cekbok:checked').map(function()
                    {
                        return $(this).val();
                    }).get();
                        for (var i = 0; i < cek; i++) {
                            $('.tembusan'+checkValues[i]).remove();
                        };
                                        
        });


        $(document).on('click','#tambah_penandatangan',function() {
          var data=JSON.parse($(".MPenandatangan_selection_one:checked").attr("json"));
          var jml=$(".MPenandatangan_selection_one:checked").length;
          if(jml=>1 && jml<2){
             $('#skwas4a-nip_penandatangan').val(data.nip);
             $('#skwas4a-nama_penandatangan').val(data.nama);
             $('#skwas4a-jabatan_penandatangan').val(data.nama_jabatan);
             $('#skwas4a-golongan_penandatangan').val(data.gol_kd);
             $('#skwas4a-pangkat_penandatangan').val(data.gol_pangkat2);
             $('#skwas4a-jbtn_penandatangan').val(data.jabtan_asli);
             $('#penandatangan').modal('hide');
          }
        });

       /*/////////PENANDATANGAN LOADING GRID//////////////*/
    $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
      $('#grid-penandatangan_surat').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penandatangan_surat').removeClass('loading');
    });

    $(document).on('click','.cari_ttd',function() { 
      $('#grid-penandatangan_surat').addClass('loading');
        $("#grid-penandatangan_surat").load("/pengawasan/sk-was-4a/getttd",function(responseText, statusText, xhr)
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

        //  $(document).on('hidden.bs.modal','#penandatangan', function (e) {
        //   $(this).find("input[type=checkbox], input[type=radio]")
        //        .prop("checked", "")
        //        .end();

        // });
</script>

    