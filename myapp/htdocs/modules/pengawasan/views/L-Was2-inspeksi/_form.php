<?php

// use yii\helpers\Html;
// use yii\grid\GridView;
// use yii\widgets\ActiveForm;
// use kartik\datecontrol\DateControl;

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\db\Query;
use kartik\widgets\FileInput;
use app\modules\pengawasan\models\Was10InspeksiSearch;
use app\modules\pengawasan\models\LWas2InspeksiSearch;
use yii\widgets\Pjax;

use app\models\LookupItem;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'L.WAS-2 Laporan Hasil Inspeksi Kasus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

 <?php $form = ActiveForm::begin([
        // 'id' => 'Lwas2-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        
        'options' => [
                    'enctype' => 'multipart/form-data',
                ]
    ]); ?>
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading single-project-nav">
            <ul class="nav nav-tabs"> 
                <li class="active">
                    <a href="#permasalahan" data-toggle="tab">Permasalahan</a>
                </li>
                <li>
                    <a href="#data" data-toggle="tab">Data</a>
                </li>
                <li>
                    <a href="#analisa" data-toggle="tab">Analisa</a>
                </li>
                <li>
                    <a href="#kesimpulan" data-toggle="tab">Kesimpulan</a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
            <?php
                  if($model->isNewRecord){
                            $permasalahan="<ol>";
                            foreach ($modelLapdu as $rowlapdu) {
                                    $permasalahan .="
                                        <li>".$rowlapdu['ringkasan_lapdu'].".</li>
                                    ";
                            }
                            $permasalahan.="</ol>";

                            $pelapor="<ol>";
                            foreach ($modelPelapor as $rowpelapor) {
                                    $pelapor .="
                                        <li>Keterangan Pelapor ".$rowpelapor['nama_pelapor'].".</li>
                                    ";
                            }
                        //    $pelapor.="</ol>";

                            foreach ($modelInternal as $rowinternal) {
                                   $internal .="
                                        <li>Keterangan Saksi Internal ".$rowinternal['nama_saksi_internal'].",
                                            Pangkat(Gol) ".$rowinternal['pangkat_saksi_internal'].'('.$rowinternal['golongan_saksi_internal'].") ,
                                            NIP/NRP ".$rowinternal['nip'].($rowinternal['nrp']==''?'':'/'.$rowinternal['nrp'])." 
                                            jabatan ".$rowinternal['jabatansaksi_internal'].".</li>
                                    ";
                            }

                            foreach ($modelEksternal as $roweksternal) {
                                    $eksternal .="
                                        <li>Keterangan Saksi Internal ".$roweksternal['nama_saksi_eksternal'].", 
                                        Alamat ".$roweksternal['alamat_saksi_eksternal'].".</li>
                                    ";
                            }

                            foreach ($modelTerlapor as $rowterlapor) {
                                    $terlapor .="
                                        <li>Keterangan Terlapor ".$rowterlapor['nama_pegawai_terlapor'].", 
                                        Pangkat(Gol) ".$rowterlapor['pangkat_pegawai_terlapor'].'('.$rowterlapor['golongan_pegawai_terlapor'].") ,
                                        NIP/NRP ".$rowterlapor['nip'].($rowterlapor['nrp_pegawai_terlapor']==''?'':
                                        '/'.$rowterlapor['nrp_pegawai_terlapor'])." 
                                        jabatan ".$rowterlapor['jabatan_pegawai_terlapor'].".</li>
                                    ";
                            }
                            $pelapor.="</ol>";          

                            $terlapor3="<p>Berdasarkan data yang diperoleh, maka dapat disampaikan analisa sebagai berikut :</p> <ol>";
                            $terlapor4="<p>Berdasarkan hasil analisa dapat disimpulkan sebagai berikut :</p> <ol>";
                            
                        ?>
               <!-- <div class="col-md-12"> -->
                           
                <div class="tab-pane fade in active" id="permasalahan">
                    <?= $form->field($model, 'isi_permasalahan')->textArea(['rows' => '2','class' => 'ckeditor','value' => $permasalahan])->label(false) ?>
                    <!-- <textarea name="editor1" id="editor1"><?//=$permasalahan?> </textarea> -->
                </div>
                <!-- </div> -->
                <div class="tab-pane fade" id="data">
                    <?= $form->field($model, 'isi_data')->textArea(['rows' => '2','class' => 'ckeditor','value' => $pelapor.$internal.$eksternal.$terlapor])->label(false) ?>
                   <!--  <textarea name="editor2" id="editor2"><?//=$pelapor.$internal.$eksternal.$terlapor?></textarea> -->
                </div>
                <div class="tab-pane fade" id="analisa">
                    <?= $form->field($model, 'isi_analisa')->textArea(['rows' => '2','class' => 'ckeditor','value' => $terlapor3])->label(false) ?>
                  <!--   <textarea name="editor3" id="editor3"><?//=$terlapor3?></textarea> -->
                </div>
                <div class="tab-pane fade" id="kesimpulan">
                    <?= $form->field($model, 'isi_kesimpulan')->textArea(['rows' => '2','class' => 'ckeditor','value' => $terlapor4])->label(false) ?>
                    <!-- <textarea name="editor4" id="editor4"><?//=$terlapor4?></textarea> -->
                </div>
                        <?php
                            }else{
                        ?>
                 <div class="tab-pane fade in active" id="permasalahan">
                    <?= $form->field($model, 'isi_permasalahan')->textArea(['rows' => '2','class' => 'ckeditor','value' => $model['isi_permasalahan']])->label(false) ?>
                    <!-- <textarea name="editor1" id="editor1"><?//=$permasalahan?> </textarea> -->
                </div>
                <div class="tab-pane fade" id="data">
                    <?= $form->field($model, 'isi_data')->textArea(['rows' => '2','class' => 'ckeditor','value' => $model['isi_data']])->label(false) ?>
                   <!--  <textarea name="editor2" id="editor2"><?//=$pelapor.$internal.$eksternal.$terlapor?></textarea> -->
                </div>
                <div class="tab-pane fade" id="analisa">
                    <?= $form->field($model, 'isi_analisa')->textArea(['rows' => '2','class' => 'ckeditor','value' => $model['isi_analisa']])->label(false) ?>
                  <!--   <textarea name="editor3" id="editor3"><?//=$terlapor3?></textarea> -->
                </div>
                <div class="tab-pane fade" id="kesimpulan">
                    <?= $form->field($model, 'isi_kesimpulan')->textArea(['rows' => '2','class' => 'ckeditor','value' => $model['isi_kesimpulan']])->label(false) ?>
                    <!-- <textarea name="editor4" id="editor4"><?//=$terlapor4?></textarea> -->
                </div>       
                <?php } ?>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th rowspan="3" style="width: 1%;text-align: center;padding: 25px 10px;">No</th>
                <th rowspan="3" style="width: 20%;">Nama - Pangkat - NIP/NRP - Jabatan</th>
                <th colspan="3" style="text-align: center;">Pendapat</th>
            </tr>
        </thead>
        
        <?php if($model->isNewRecord){ ?>
        <tbody>
            <?php 
                $no=1;
                foreach ($modelTerlapor as $rowterlapor2) {
                ?>
                    <tr>
                            <td><?= $no ?></td>
                            <td><?= $rowterlapor2['nama_pegawai_terlapor'].'<br>'.$rowterlapor2['pangkat_pegawai_terlapor']
                                .'<br>'.$rowterlapor2['nip'].($rowterlapor2['nrp_pegawai_terlapor']==''?'':
                                '/'.$rowterlapor2['nrp_pegawai_terlapor']).'<br>'.$rowterlapor2['jabatan_pegawai_terlapor']?>
                            </td>
                            <td>
                                <label>Pendapat</label>
                                <select class="form-control saran" id="saran" name="saranP[]" >
                                    <option value="2">- Pilih Pendapat-</option>
                                    <option value="1">Terbukti</option>
                                    <option value="2">Tidak Terbukti</option>
                                </select>
                            </td>
                             <td>
                                <label>Bentuk Pelanggaran Disiplin</label>
                                 <textarea id="bentuk_pelanggaran" class="form-control bentuk_pelanggaran hidden" name="bentuk_pelanggaran[]" ></textarea>
                               
                            </td>
                            <td>
                                <label>Pasal</label> 
                                <select class="form-control pasal1 hidden" id="hukdis" name="hukdisP[]">
                                    <option value="">- Pilih Pasal -</option> 
                                    <?php  foreach ($modelHukdis as $rowHukdis2) {
                                            echo "<option value=".$rowHukdis2['kode_sk']." pasal=".$result.">".$rowHukdis2['pasal']."</option>";
                                            } ?> 
                                </select>
                            </td>
                    </tr>      
              <?   
                    $no++;
                      }             
                             
             ?>    
        </tbody>
      <?php }else{  ?>
      <tbody>
            <?php 
                $no=1;
               // print_r($modelTerlaporUpd);
                foreach ($modelTerlaporUpd as $rowterlaporupd) {
                    if($rowterlaporupd['pendapat_l_was_2'] == 1){
                        $pendapat="Terbukti";
                        $class=" ";
                    }else{
                        $pendapat="Tidak Terbukti";
                        $class="hidden";
                    }

                    $connection = \Yii::$app->db;
                    $query4="select a.*,b.*,b.pasal,a.category_sk||'-'||b.isi_sk as sk from was.ms_category_sk a 
                             inner join was.ms_sk b on a.kode_category=b.kode_category where b.kode_sk='".$rowterlaporupd['pendapat_pasal']."'
                             ";
                    $modelHukdisVal = $connection->createCommand($query4)->queryAll();          
                    //print_r($rowterlaporupd);
                ?>
                    <tr>
                            <td><?= $no ?></td>
                            <td><?= $rowterlaporupd['nama_terlapor'].'<br>'.$rowterlaporupd['pangkat_terlapor']
                                .'<br>'.$rowterlaporupd['nip'].($rowterlaporupd['nrp_terlapor']==''?'':
                                '/'.$rowterlaporupd['nrp_terlapor']).'<br>'.$rowterlaporupd['jabatan_terlapor']?>
                            </td>
                            <td>
                                <label>Pendapat</label>
                                <select class="form-control saran" id="saran" name="saranP[]" >
                                    <option value="<?= $rowterlaporupd['pendapat_l_was_2'] ?>"><?= $pendapat ?></option>
                                    <option value="1">Terbukti</option>
                                    <option value="2">Tidak Terbukti</option>
                                </select>
                            </td>
                             <td>
                                <label>Bentuk Pelanggaran Disiplin</label>
                                <textarea id="bentuk_pelanggaran" class="form-control bentuk_pelanggaran <?= $class ?>" name="bentuk_pelanggaran[]" ><?= $rowterlaporupd['bentuk_pelanggaran'] ?></textarea>
                                
                                     <?php /*if(count($modelHukdisVal) =='0'){
                                         $hukdis='';
                                                echo "<option value=''>-- Pilih Hukdis --</option>";
                                        }else{
                                        foreach ($modelHukdisVal as $rowHukdisval) { 
                                                echo "<option value='".$rowHukdisval['kode_sk']."'> ".$rowHukdisval['sk']."</option>";
                                                } ?>
                                       <!--  <option value="<?php //$rowHukdisval['kode_sk'] ?>"><?//= $hukdis ?></option> -->
                                    <?php } ?>
                                    <?php foreach ($modelHukdisUpd as $rowHukdisupd) {
                                            $result=json_encode($rowHukdisupd);
                                               echo "<option value=".$rowHukdisupd['kode_sk']." pasal=".$result.">".$rowHukdisupd['sk']."</option>";
                                            } */?> 


                                    <?php /* foreach ($modelHukdisVal as $rowHukdisval) { ?>
                                        <option value="<?php $rowHukdisval['kode_sk'] ?>"><?= $rowHukdisval['sk'] ?></option>
                                    <?php } ?>
                                    <?php foreach ($modelHukdisUpd as $rowHukdisupd) {
                                            $result=json_encode($rowHukdisupd);
                                               echo "<option value=".$rowHukdisupd['kode_sk']." pasal=".$result.">".$rowHukdisupd['sk']."</option>";
                                            } */ ?> 
                            </td>
                             <td class="cek_<?= $no ?>">
                                <label>Pasal</label> 
                                <select class="form-control pasalP <?= $class ?>" id="hukdis" name="hukdisP[]">
                                   <?php if(count($modelHukdisVal) =='0'){
                                         $hukdis='';
                                                echo "<option value=''>-- Pilih Pasal --</option>";
                                        }else{
                                        foreach ($modelHukdisVal as $rowHukdisval) { 
                                                echo "<option value='".$rowHukdisval['kode_sk']."'> ".$rowHukdisval['pasal']."</option>";
                                                } ?>
                                       <!--  <option value="<?php //$rowHukdisval['kode_sk'] ?>"><?//= $hukdis ?></option> -->
                                    <?php } ?>
                                    <?php foreach ($modelHukdisUpd as $rowHukdisupd) {
                                            $result=json_encode($rowHukdisupd);
                                               echo "<option value=".$rowHukdisupd['kode_sk']." pasal=".$result.">".$rowHukdisupd['pasal']."</option>";
                                            } ?> 
                                   <?php/* if(!$model->isNewRecord){ 
                                             echo "<option> ".$rowHukdisval['pasal']."</option>";
                                    } */?>

                          <!--   <td>
                                <label>Pasal</label> 
                                <select class="form-control pasal1" id="pasalP" name="pasalP[]"> -->
                                    <?php /*if(count($modelHukdisVal) =='0'){
                                         $hukdis='';
                                                echo "<option value=''>-- Pilih Pasal --</option>";
                                        }else{
                                        foreach ($modelHukdisVal as $rowHukdisval) { 
                                                echo "<option> ".$rowHukdisval['pasal']."</option>";
                                                } ?>
                                       <!--  <option value="<?php //$rowHukdisval['kode_sk'] ?>"><?//= $hukdis ?></option> -->
                                    <?php } ?>
                                    <?php foreach ($modelHukdisUpd as $rowHukdisupd) {
                                               echo "<option>".$rowHukdisupd['pasal']."</option>";
                                            }*/ ?> 


                                    <?php /* foreach ($modelHukdisVal as $rowHukdisval) { ?>
                                        <option ><?= $rowHukdisval['pasal'] ?></option>
                                    <?php } ?>
                                    <?php foreach ($modelHukdisUpd as $rowHukdisupd) {
                                               echo "<option >".$rowHukdisupd['pasal']."</option>";
                                            } */ ?> 
                                </select>
                            </td>
                    </tr>      
              <?php $no++;
                      }             
               ?>    
        </tbody>
        <?php } ?>
    </table>
    <div class="clearfix">
    </div>

    <?php
        $pertimbangan  ="<ol><li>Hal-Hal yang memberatkan</li>";
        $pertimbangan .="<br>"; 
        $pertimbangan2 ="<li>Hal-Hal yang meringankan</li></ol>";
    ?>

    <br/>

    <div class="panel panel-primary">
        <div class="panel-heading">Pertimbangan</div>
            <div class="panel-body">
                <div class="row" style="padding-top: 20px;">
                    <div class="col-md-12">
                     <?php if($model->isNewRecord){ ?>    
                         <?= $form->field($model, 'isi_pertimbangan')->textArea(['rows' => '2','class' => 'ckeditor' , 'value' => $pertimbangan.$pertimbangan2])->label(false) ?>
                     <?php }else{ ?>    
                         <?= $form->field($model, 'isi_pertimbangan')->textArea(['rows' => '2','class' => 'ckeditor' , 'value' => $model['isi_pertimbangan']])->label(false) ?>
                    <?php }?>
                    </div>
                </div>
            </div>
        </div>
    

    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th rowspan="3" style="width: 1%;text-align: center;padding: 25px 10px;">No</th>
                <th rowspan="3" style="width: 20%;">Nama - Pangkat - NIP/NRP - Jabatan</th>
                <th colspan="3" style="text-align: center;">Saran</th>
            </tr>
            <!-- <tr>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Terbukti/Tidak Terbukti</th>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Bentuk Pelanggaran Disiplin</th>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Pasal</th>
            </tr> -->
        </thead>
        
        <?php if($model->isNewRecord){ ?>
        <tbody>
            <?php 
                $no=1;
                foreach ($modelTerlapor as $rowterlapor) {
                ?>
                    <tr>
                            <td><?= $no ?></td>
                            <td><?= $rowterlapor['nama_pegawai_terlapor'].'<br>'.$rowterlapor['pangkat_pegawai_terlapor']
                                .'<br>'.$rowterlapor['nip_pegawai_terlapor'].($rowterlapor['nrp_pegawai_terlapor']==''?'':
                                '/'.$rowterlapor['nrp_pegawai_terlapor']).'<br>'.$rowterlapor['jabatan_pegawai_terlapor']?>
                                <input type="hidden" id="nip" name="nip[]" value="<?= $rowterlapor['nip_pegawai_terlapor'] ?>">
                                <input type="hidden" id="nrp" name="nrp[]" value="<?= $rowterlapor['nrp_pegawai_terlapor'] ?>">
                                <input type="hidden" id="nama" name="nama[]" value="<?= $rowterlapor['nama_pegawai_terlapor'] ?>">
                                <input type="hidden" id="pangkat" name="pangkat[]" value="<?= $rowterlapor['pangkat_pegawai_terlapor'] ?>">
                                <input type="hidden" id="golongan" name="golongan[]" value="<?= $rowterlapor['golongan_pegawai_terlapor'] ?>">
                                <input type="hidden" id="jabatan" name="jabatan[]" value="<?= $rowterlapor['jabatan_pegawai_terlapor'] ?>">
                                <input type="hidden" id="satker" name="satker[]" value="<?= $rowterlapor['satker_pegawai_terlapor'] ?>">
                            </td>
                            <td>
                                <label>Saran</label>
                                <select class="form-control saran" id="saran" name="saran[]" >
                                    <option value="2">- Pilih Saran-</option>
                                    <option value="1">Terbukti</option>
                                    <option value="2">Tidak Terbukti</option>
                                </select>
                            </td>
                             <td>
                                <label>Hukuman Disiplin</label>
                                <select class="form-control hukdis hidden" id="hukdis" name="hukdis[]" rel="cek_<?= $no ?>">
                                    <option value="">- Pilih Hukuman Disiplin-</option>
                                    <?php foreach ($modelHukdis as $rowHukdis) {
                                            $result=json_encode($rowHukdis);
                                               echo "<option value=".$rowHukdis['kode_sk']." pasal=".$result.">".$rowHukdis['sk']."</option>";
                                            } ?> 
                                </select>
                            </td>
                            <td class="cek_<?= $no ?>">
                                <label>Pasal</label> 
                               <!--  <div class="pasal1">
                                        
                                </div> -->
                                <!-- <input type="text" id="pasal" name="pasal[]" class="form-control pasal hidden"> -->
                                  <select class="form-control pasal1 hidden" id="pasal" name="pasal[]">
                                    <option value=""></option> 
                                    <?php  foreach ($modelHukdis as $rowHukdis) {
                                            echo "<option>".$rowHukdis['pasal']."</option>";
                                            } ?> 
                                </select>
                            </td>
                    </tr>      
              <?   
                    $no++;
                      }                      
             ?>    
        </tbody>
    <?php } else {?>
    
    <tbody>
            <?php 
                $no=1;
                foreach ($modelTerlaporUpd as $rowterlaporupd) {
                    //print_r($rowterlaporupd);
                if($rowterlaporupd['saran_l_was_2'] == 1){
                        $saran="Terbukti";
                        $class=" ";
                    }else{
                        $saran="Tidak Terbukti";
                        $class="hidden";
                    }

                    $connection = \Yii::$app->db;
                    $query4="select a.*,b.*,b.pasal,a.category_sk||'-'||b.isi_sk as sk from was.ms_category_sk a 
                             inner join was.ms_sk b on a.kode_category=b.kode_category where b.kode_sk='".$rowterlaporupd['saran_pasal']."'
                             ";
                    $modelHukdisValS = $connection->createCommand($query4)->queryAll();          
                  //  print_r($query4);
                ?>
                    <tr>
                            <td><?= $no ?></td>
                            <td><?= $rowterlaporupd['nama_terlapor'].'<br>'.$rowterlaporupd['pangkat_terlapor']
                                .'<br>'.$rowterlaporupd['nip_terlapor'].($rowterlaporupd['nrp_terlapor']==''?'':
                                '/'.$rowterlaporupd['nrp_terlapor']).'<br>'.$rowterlaporupd['jabatan_terlapor']?>
                                <input type="hidden" id="nip" name="nip[]" value="<?= $rowterlaporupd['nip_terlapor'] ?>">
                                <input type="hidden" id="nrp" name="nrp[]" value="<?= $rowterlaporupd['nrp_terlapor'] ?>">
                                <input type="hidden" id="nama" name="nama[]" value="<?= $rowterlaporupd['nama_terlapor'] ?>">
                                <input type="hidden" id="pangkat" name="pangkat[]" value="<?= $rowterlaporupd['pangkat_terlapor'] ?>">
                                <input type="hidden" id="golongan" name="golongan[]" value="<?= $rowterlaporupd['golongan_terlapor'] ?>">
                                <input type="hidden" id="jabatan" name="jabatan[]" value="<?= $rowterlaporupd['jabatan_terlapor'] ?>">
                                <input type="hidden" id="satker" name="satker[]" value="<?= $rowterlaporupd['satker_terlapor'] ?>">
                            </td>
                            <td>
                                <label>Saran</label>
                                <select class="form-control saran" id="saran" name="saran[]" >
                                    <option value="<?= $rowterlaporupd['saran_l_was_2'] ?>"><?= $saran ?></option>
                                    <option value="1">Terbukti</option>
                                    <option value="2">Tidak Terbukti</option>
                                </select>
                            </td>
                             <td>
                                <label>Hukuman Disiplin</label>
                                <select class="form-control hukdis <?= $class ?>" id="hukdis" name="hukdis[]" rel="cek_<?= $no ?>">
                                    <?php if(count($modelHukdisValS) =='0'){
                                         $hukdis='';
                                                echo "<option value='".$rowHukdisval['kode_sk']."'>-- Pilih Hukdis --</option>";
                                        }else{
                                        foreach ($modelHukdisValS as $rowHukdisval) { 
                                                echo "<option value='".$rowHukdisval['kode_sk']."'> ".$rowHukdisval['sk']."</option>";
                                                } ?>
                                       <!--  <option value="<?php //$rowHukdisval['kode_sk'] ?>"><?//= $hukdis ?></option> -->
                                    <?php } ?>
                                    <?php foreach ($modelHukdisUpd as $rowHukdisupd) {
                                            $result=json_encode($rowHukdisupd);
                                               echo "<option value=".$rowHukdisupd['kode_sk']." pasal=".$result.">".$rowHukdisupd['sk']."</option>";
                                            } ?> 
                                </select>
                            </td>
                            <td class="cek_<?= $no ?>">
                                <label>Pasal</label> 
                                <select class="form-control pasal1 <?= $class ?>" id="pasal" name="pasal[]">
                                   <?php if(!$model->isNewRecord){ 
                                             echo "<option> ".$rowHukdisval['pasal']."</option>";
                                    } ?>
                                    <?php /*if(count($modelHukdisValS) =='0'){
                                         $hukdis='';
                                                echo "<option value=''>-- Pilih Pasal --</option>";
                                        }else{
                                        foreach ($modelHukdisValS as $rowHukdisval) { 
                                                echo "<option> ".$rowHukdisval['pasal']."</option>";
                                                }*/ ?>
                                       <!--  <option value="<?php //$rowHukdisval['kode_sk'] ?>"><?//= $hukdis ?></option> -->
                                    <?php //} ?>
                                    <?php /*foreach ($modelHukdisUpd as $rowHukdisupd) {
                                               echo "<option >".$rowHukdisupd['pasal']."</option>";
                                            }*/ ?>
                                 </select>
                            </td>
                    </tr>    
              <?   
                    $no++;
                      }                      
             ?>    
        </tbody>    
       <?php } ?>  
    </table>
    <div class="clearfix">
    </div>

    <div class="col-md-12" style="margin-top: 30px;">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Tanggal </label>
                <div class="col-md-8">          
                     <?=
                        $form->field($model, 'tanggal_l_was_2',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'endDate' => 0,
                                    'autoclose' => true
                                ]
                            ]
                        ])->label(false);
                        ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                 <label class="control-label col-md-4">Tempat</label>
                 <div class="col-md-8">
                    <?= $form->field($model, 'tempat_l_was_2')->textArea(['rows' => '2'])->label(false) ?>
                 </div>
            </div>
        </div>
    </div>

   <?php if(!$model->isNewRecord) { ?>
        <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas L.Was2 Inspeksi :
                    <?php if (substr($model->file_l_was_2,-3)!='pdf'){?>
                        <?= ($model['file_l_was_2']!='' ? '<a href="viewpdf?id='.$model['id_l_was2'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['file_l_was_2']!='' ? '<a href="viewpdf?id='.$model['id_l_was2'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                    <?php } ?>
                </label>
                <!-- <input type="file" name="file_l_was_2" /> -->
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="file_l_was_2" id="file_l_was_2" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
            </div>
        <?php
        }
        ?>
<!-- </div> -->
<!-- Penandatanganan -->
<div class="col-md-12">
      <div class="col-md-12" style="padding:0px;">
          <div class="panel panel-primary">
              <div class="panel-heading">Penandatangan</div>
                  <div class="panel-body">
                    <div class="col-sm-12" style="margin-bottom: 15px">
                        <div class="col-sm-6">
                          <a class="btn btn-primary" id="hapus_penandatangan"><span class="glyphicon glyphicon-trash"><i></i></span></a>
                          <a class="btn btn-primary"  id="add_penandatangan" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span> Penandatangan</a>
                        </div>
                    </div>
                    <div class="for_tembusan">
                          <?php 
                            if(!$model->isNewRecord){
                              
                                $no=1;
                                foreach ($modelPenandatangan as $key) {
                            ?>
                            <div class="col-md-9 <?php echo"tembusan".$key['nip_penandatangan']; ?>" style="margin-bottom: 15px" id="<?= $key['nip_penandatangan']?>">
                                <div class="col-sm-1" style="text-align:center">
                                   <input type="checkbox" value="<?= $key['nip_penandatangan']?>" id="cekbok" class="cekbok">
                                </div>
                                <div class="col-sm-2" style="text-align:center">
                                    <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no ?>" size="1" readonly style="text-align:center;">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="nama_ttd" name="nama_ttd[]" value="<?php echo $key['nama_penandatangan']; ?>">
                                    <input type="hidden" class="form-control" id="nip_ttd" name="nip_ttd[]"  value="<?php echo $key['nip_penandatangan']; ?>">
                                    <input type="hidden" class="form-control" id="nrp_ttd" name="nrp_ttd[]"  value="<?php echo $key['nrp_penandatangan']; ?>">
                                    <input type="hidden" class="form-control" id="jabatan_ttd" name="jabatan_ttd[]"  value="<?php echo $key['jabatan_penandatangan']; ?>">
                                    <input type="hidden" class="form-control" id="golongan_ttd" name="golongan_ttd[]"  value="<?php echo $key['golongan_penandatangan']; ?>">
                                    <input type="hidden" class="form-control" id="pangkat_ttd" name="pangkat_ttd[]"  value="<?php echo $key['pangkat_penandatangan']; ?>">
                                    <input type="hidden" class="form-control" id="id_sp_was2_ttd" name="id_sp_was2_ttd[]"  value="<?php echo $key['id_sp_was2']; ?>">
                              
                                </div>
                            </div>
                            <?php 
                            $no++;
                                    }
                                }
                                  ?>
                    </div>
          </div>
        </div>
      </div>
    </div>
<div>
    <br><br>
</div>



<div class="box-footer" style="margin:0px;padding:0px;background:none;">
      <?php
      if (!$model->isNewRecord) {
       // echo " ".Html::a('<i class ="fa fa-save"></i> Update', ['/pengawasan/l-was2-inspeksi/update', 'id' => $model->id_l_was2], ['id' => 'updateLwas2', 'class' => 'btn btn-primary']);
        echo  Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Update' : '<i class="fa fa-save"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);
       echo " ".Html::a('<i class ="fa fa-print"></i> Cetak', ['/pengawasan/l-was2-inspeksi/cetak', 'id' => $model->id_l_was2], ['id' => 'hapusLwas2', 'class' => 'btn btn-primary']);
      }else{ ?>
      <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
      <?php } ?>  
    </div>
<?php ActiveForm::end(); ?>
</div>


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
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchLwas2 = new LWas2InspeksiSearch();
                            $dataProviderPenandatangan = $searchLwas2->searchPenandatangan(Yii::$app->request->queryParams);
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
                                        'attribute'=>'nip_pemeriksa',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pemeriksa',
                                    ],

                                    ['label'=>'Jabatan Alias',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_pemeriksa',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['nip_pemeriksa'],'class'=>'selection_one','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]); ?>
                           <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="tambah_penandatangan">Tambah</button>
                </div>
            </div>
        </div>
</div>
<script>
    CKEDITOR.replace( 'editor1' );
    CKEDITOR.replace( 'editor2' );
    CKEDITOR.replace( 'editor3' );
    CKEDITOR.replace( 'editor4' );
</script>
<script type="text/javascript">  

$(document).ready(function(){
  /*remove localstorage*/
    localStorage.removeItem("nip_tandatangan");
        var arrnip = $('.cekbok').map(function()
                              {
                                  return $(this).val();
                              }).get();
    localStorage.setItem("nip_tandatangan", JSON.stringify(arrnip));

});

window.onload=function(){

    $(document).on('change','.hukdis',function(){
        var vals = this.value; 
      //  $('#undang_internal').modal({backdrop: 'static', keyboard: false});
       // var check=JSON.parse($('.MselectionSI_one:checked').attr('json'));
        var cek =  $(this).attr('rel');
      //  alert(check.id_saksi_internal);

        $.ajax({
            type:'POST',
            url:'/pengawasan/l-was2-inspeksi/getsaran',
            data:'id='+vals,
            success:function(data){
              $('.'+cek).html(data);
            }
               // alert(a);
        });
             //  $(this).closest('tr').find('.cek').html('<select> <option> --test-- </option> </select>');
      
    });

    $(document).on('change','.hukdisP',function(){
        var vals = this.value; 
        var cek =  $(this).attr('rel');
      //  alert(check.id_saksi_internal);

        $.ajax({
            type:'POST',
            url:'/pengawasan/l-was2-inspeksi/getsaran',
            data:'id='+vals,
            success:function(data){
              $('.'+cek).html(data);
            }
               // alert(a);
        });
             //  $(this).closest('tr').find('.cek').html('<select> <option> --test-- </option> </select>');
      
    });

     $(document).on('change','.saran',function(){
        var idsaran = $(this).val();
        
        if(idsaran==1){
            $(this).closest('tr').find('.hukdis').removeClass("hidden");
            $(this).closest('tr').find('.pasal1').removeClass("hidden");
            $(this).closest('tr').find('.pasalP').removeClass("hidden");
            $(this).closest('tr').find('.bentuk_pelanggaran').removeClass("hidden");
            // $(".hukdis").removeClass("hidden");
            // $(".pasal").removeClass("hidden");
        }else{
            $(this).closest('tr').find('.hukdis').addClass("hidden");
            $(this).closest('tr').find('.pasal1').addClass("hidden");
            $(this).closest('tr').find('.pasalP').addClass("hidden");
            $(this).closest('tr').find('.bentuk_pelanggaran').addClass("hidden");
           // $(this).closest('tr').find('.cek_3').addClass("hidden");
            // $(".hukdis").addClass("hidden");
            // $(".pasal").addClass("hidden");
        }

        });

        $(document).on('click','#add_penandatangan',function(){
             // var check=JSON.parse($('.Mselection_one:checked').attr('json'));
             // $('#surat_was10_ins_tu').val(check.id_surat_was10);
             // $('#nomor').val(check.no_surat);
             // $('#id_pegawai_terlapor').val(check.id_pegawai_terlapor);
             $('#penandatangan').modal({backdrop: 'static', keyboard: false});
        }); 

        $(document).on('click','#tambah_penandatangan',function(){
            var asal=$('#asal').val();
            var cek = JSON.parse(localStorage.getItem("nip_tandatangan"));

            var jml=$('.selection_one:checked').length;
            var checkValues = $('.selection_one:checked').map(function()
                        {
                        return $(this).attr("json");
                        }).get();
            var arrnip = $('.selection_one:checked').map(function()
                        {
                        return $(this).val();
                        }).get();
         
         for (var i = 0; i < jml; i++) {
            var trans=JSON.parse(checkValues[i]);
           // alert(jQuery.inArray(trans.nip_pemeriksa,cek));
            if(jQuery.inArray(trans.nip_pemeriksa,cek)==-1){/*jika kondisi Nip tidak sama maka tambahkan data*/
           
                $('.for_tembusan').append('<div class=\"col-sm-9 tembusan'+trans['nip_pemeriksa']+'\" style=\"margin-bottom: 15px;\"><div class=\"col-sm-1\" style=\"text-align: center\"><input type=\"checkbox\" value=\"'+trans['nip_pemeriksa']+'\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\"  size=\"1\" readonly></div><div class=\"col-sm-6\" style=\"text-align: center\"><input type=\"text\" class=\"form-control\" id=\"nama_ttd\" name=\"nama_ttd[]\" value=\"'+trans['nama_pemeriksa']+'\"><input type=\"hidden\" class=\"form-control\" id=\"nip_ttd\" name=\"nip_ttd[]\"  value=\"'+trans['nip_pemeriksa']+'\"><input type=\"hidden\" class=\"form-control\" id=\"nrp_ttd\" name=\"nrp_ttd[]\"  value=\"'+trans['nrp_pemeriksa']+'\"><input type=\"hidden\" class=\"form-control\" id=\"jabatan_ttd\" name=\"jabatan_ttd[]\"  value=\"'+trans['jabatan_pemeriksa']+'\"><input type=\"hidden\" class=\"form-control\" id=\"golongan_ttd\" name=\"golongan_ttd[]\"  value=\"'+trans['golongan_pemeriksa']+'\"><input type=\"hidden\" class=\"form-control\" id=\"pangkat_ttd\" name=\"pangkat_ttd[]\"  value=\"'+trans['pangkat_pemeriksa']+'\"><input type=\"hidden\" class=\"form-control\" id=\"id_sp_was2_ttd\" name=\"id_sp_was2_ttd[]\"  value=\"'+trans['id_sp_was2']+'\"></div></div>'
                  );
                }
            }

            i = 0;
            $('.for_tembusan').find('.col-sm-7').each(function () {

                i++;
                $(this).addClass('tembusan'+i);
                $(this).find('.cekbok').val(i);
            });
            
            $('#penandatangan').modal('hide');
            var arrnip = $('.selection_one').map(function()
                                {
                                    return $(this).val();
                                }).get();
            localStorage.setItem("nip_tandatangan", JSON.stringify(arrnip));
        }); 

        $(document).on('click','#hapus_penandatangan',function() {
                 // $('#hapus_tembusan').click(function(){
                    var cek = $('.cekbok:checked').length;
                     var checkValues = $('.cekbok:checked').map(function()
                        {
                            return $(this).val();
                        }).get();
                            for (var i = 0; i < cek; i++) {
                                $('.tembusan'+checkValues[i]).remove();
                            };

                     localStorage.removeItem("nip_tandatangan"); 
                       var nip1 = $('.cekbok').map(function()
                                {
                                    return $(this).val();
                                }).get();

                     localStorage.setItem("nip_tandatangan", JSON.stringify(nip1));                
                                            
            });

 }    
</script>
<style type="text/css">
    .panel-default > .panel-heading {
        background-color: #2a8cbd;
        color: #0f5e86;
        text-transform: uppercase;
        font-weight: 500;
    }
    .nav-tabs > li.active > a:after {
        position: absolute;
        content: " ";
        background: #2a8cbd;
        width: 12px;
        height: 12px;
        border-radius: 3px 0 0 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        box-shadow: none;
        bottom: -40%;
        right: 50%;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        color: black;
        cursor: pointer;
        border: 1px solid transparent;
        border-radius: 0px;
        background-image: #fff;
    }
    .nav-tabs {
        border-bottom: 0px;
    }
    .nav-tabs>li>a{
        border-radius: 0px;
        color: #fff;
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
#permasalahan .col-md-10{width: 100%}
#data .col-md-10{width: 100%}
#analisa .col-md-10{width: 100%}
#kesimpulan .col-md-10{width: 100%}
.field-lwas2inspeksi-isi_pertimbangan .col-md-10{width: 100%}

</style>

<script type="text/javascript">
  /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

</script>