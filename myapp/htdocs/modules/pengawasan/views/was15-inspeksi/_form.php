<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\modules\pengawasan\models\Was15Search;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\db\Query;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dipa-master-form">

<?php $form = ActiveForm::begin([
                'id' => 'was15form',
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
                    'onsubmit'=>'return validateForm()',
                ]

]); ?>
    <div class="box box-primary">
        <div class="box-body" style="padding:15px;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Kepada</label>
                        <div class="col-md-9">
                            <?php
                                echo $form->field($model, 'kepada_was15')->textInput()->label(false);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Dari</label>
                        <div class="col-md-9">
                            <?php
                                echo $form->field($model, 'dari_was15',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Pilih', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#penandatangan","data-backdrop"=>"static", "data-keyboard"=>false]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly'])->label(false);
                            ?>
                            </div>
                        </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal</label>
                        <div class="col-md-6">
                             <?php
                                $connection = \Yii::$app->db;
                                $sql="select*from was.was_14d where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                    and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
                                $was14d=$connection->createCommand($sql)->queryOne();
                             ?>
                             <?php
                                echo $form->field($model, 'tgl_was15',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'startDate' =>  date("d-m-Y",strtotime($was14d['tgl_was14d'])),
                                        'endDate' => '0day',
                                    ]
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nomor Surat</label>
                        <div class="col-md-9">
                            <?php
                                echo $form->field($model, 'no_was15')->textInput()->label(false);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Lampiran</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'lampiran_was15')->textInput()->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">sifat</label>
                        <div class="col-md-4">
                         <?php
                             $model->sifat_was15='3';
                             ?>
                            <?= $form->field($model, 'sifat_was15')->dropDownList(['1' => 'Biasa', '2' => 'Segera','3' =>'Rahasia'])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Perihal</label>
                        <div class="col-md-9">
                            <?php
                            if(count($modelTerlapor)>=3){
                                $nm_terlapor=$modelTerlapor[0]['nama_terlapor']. 'Dkk';
                            }else if(count($modelTerlapor)==2){
                                $nm_terlapor=$modelTerlapor[0]['nama_terlapor'].' Dan '.$modelTerlapor[1]['nama_terlapor'];
                            }else if(count($modelTerlapor)==1){
                                $nm_terlapor=$modelTerlapor[0]['nama_terlapor'];
                            }
                            ?>
                            <?= $form->field($model, 'perihal_was15')->textArea(['row'=>3,'value'=>"Pertimbangan terhadap hukuman disiplin yang akan dijatuhkan kepada Terlapor ".$nm_terlapor])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Daftar Terlapor</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                   <th width="4%" style="text-align:center;">No</th>
                                      <th style="text-align:center;">NIP/NRP</th>
                                      <th width="20%" style="text-align:center;">Nama</th>
                                      <th style="text-align:center;">Jabatan</th>
                                      <th style="text-align:center;">Satker</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                <?php
                                $noTerlpor=1;
                                    foreach ($modelTerlapor as $keyTerlapor) {
                                ?>
                                <tr>
                                    <td><?=$noTerlpor?></td>
                                    <td><?=$keyTerlapor['nip_terlapor'].($keyTerlapor['nrp_terlapor']!=''?'/'.$keyTerlapor['nrp_terlapor']:'')?></td>
                                    <td><?=$keyTerlapor['nama_terlapor']?></td>
                                    <td><?=$keyTerlapor['jabatan_terlapor']?></td>
                                    <td><?=$keyTerlapor['satker_terlapor']?></td>
                                </tr>
                                <?php
                                $noTerlpor++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Daftar Pelapor</div>
                    <div class="panel-body">
                        <!-- <table class="table table-bordered">
                            <thead>
                                <tr>
                                   <th width="4%" style="text-align:center;">No</th>
                                      <th style="text-align:center;">Sumber Laporan</th>
                                      <th width="20%" style="text-align:center;">Nama Pelapor</th>
                                      <th style="text-align:center;">Alamat</th>
                                      <th style="text-align:center;">Telepon</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                              
                            </tbody>
                        </table> -->
                        <?= $form->field($model, 'isi_pelapor_was15')->textArea(['row' => 3,'class'=>'ckeditor'])->label(false)?>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                            <li class="active">
                                <a href="#permasalahan" data-toggle="tab" id="">Permasalahan</a>
                            </li>
                            <li>
                                <a href="#dataanalisa" data-toggle="tab" id="">Data Dan Analisa</a>
                            </li>
                            <li>
                                <a href="#kesimpulan" data-toggle="tab" id="">Kesimpulan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="permasalahan">
                                 <?= $form->field($model, 'isi_permasalahan_was15')->textArea(['row' => 3,'class'=>'ckeditor'])->label(false)?>
                                <!-- <div class="help-block with-errors" id="error_custom2"></div> -->
                            </div>
                            <div class="tab-pane fade" id="dataanalisa">
                                <?= $form->field($model, 'data_analisa_was15')->textArea(['row' => 3,'class'=>'ckeditor'])->label(false)?>
                                <!-- <div class="help-block with-errors" id="error_custom2"></div> -->
                            </div>
                            <div class="tab-pane fade" id="kesimpulan">
                                <?= $form->field($model, 'kesimpulan_was15')->textArea(['row' => 3,'class'=>'ckeditor'])->label(false)?>
                                <!-- <div class="help-block with-errors" id="error_custom2"></div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Pertimbangan</div>
                    <div class="panel-body">
                        <div class="panel with-nav-tabs panel-default">
                            <div class="panel-heading single-project-nav">
                                <ul class="nav nav-tabs"> 
                                    <li class="active">
                                        <a href="#memberatkan" data-toggle="tab" id="">Hal - Hal Yang Memberatkan</a>
                                    </li>
                                    <li>
                                        <a href="#meringankan" data-toggle="tab" id="">Hal - Hal Yang Meringankan</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="memberatkan">
                                        <?= $form->field($model, 'pertimbangan_berat_was15')->textArea(['row' => 3,'class'=>'ckeditor'])->label(false)?>
                                        <!-- <div class="help-block with-errors" id="error_custom2"></div> -->
                                    </div>
                                    <div class="tab-pane fade" id="meringankan">
                                        <?= $form->field($model, 'pertimbangan_ringan_was15')->textArea(['row' => 3,'class'=>'ckeditor'])->label(false)?>
                                        <!-- <div class="help-block with-errors" id="error_custom2"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Rencana Penjatuhan Hukuman Disiplin</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center">No.</th>
                                    <th rowspan="2" style="text-align: center">Nama - Pangkat - NIP/NRP - Jabatan</th>
                                    <th colspan="3" style="text-align: center">Saran</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center">Tim Pemeriksa</th>
                                    <th style="text-align: center">Inspektur <?php $var=str_split($_SESSION['is_inspektur_irmud_riksa']); echo $var[0];?></th>
                                    <th style="text-align: center">Jaksa Agung Muda Pengawasan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($model->isNewRecord){
                            $no=1;
                                foreach ($modelTerlapor as $key) {
                            ?>
                            <tr>
                            <td><?=$no?></td>
                                <td><?= 'Nama : '.$key['nama_terlapor'].'<br>Pangkat(Gol) : '.$key['pangkat_terlapor'].'('.$key['golongan_terlapor'].')<br>NIP/NRP : '.$key['nip_terlapor'].'/'.$key['nrp_terlapor'].'<br>Jabatan : '.$key['jabatan_terlapor']?>
                                    <input type="hidden" name="nip_terlapor[<?=$no?>]" class="form-control" id="nip_terapor" value="<?=$key['nip_terlapor']?>">
                                    <input type="hidden" name="nama_terlapor[<?=$no?>]" class="form-control" id="nama_terlapor" value="<?=$key['nama_terlapor']?>">
                                    <input type="hidden" name="nrp_terlapor[<?=$no?>]" class="form-control" id="nrp_terlapor" value="<?=$key['nrp_terlapor']?>">
                                    <input type="hidden" name="pangkat_terlapor[<?=$no?>]" class="form-control" id="pangkat_terlapor" value="<?=$key['pangkat_terlapor']?>">
                                    <input type="hidden" name="golongan_terlapor[<?=$no?>]" class="form-control" id="golongan_terlapor" value="<?=$key['golongan_terlapor']?>">
                                    <input type="hidden" name="jabatan_terlapor[<?=$no?>]" class="form-control" id="jabatan_terlapor" value="<?=$key['jabatan_terlapor']?>">
                                    <input type="hidden" name="satker_terlapor[<?=$no?>]" class="form-control" id="satker_terlapor" value="<?=$key['satker_terlapor']?>">
                                </td>
                                <td>
                                    <input type="hidden" name="saran_dari[<?=$no?>][0]" class="form-control" id="saran_dari" value="Pemeriksa">
                                    <select name="saran_rencana[<?=$no?>][0]" class="form-control saran_rencana" rel="saran_hukuman_pemeriksa<?=$no?>">
                                        <option value="0">- Pilih Saran -</option>
                                        <option value="1">- Ringan -</option>
                                        <option value="2">- Sedang -</option>
                                        <option value="3">- Berat -</option>
                                    </select><br/>
                                    <select name="saran_hukuman[<?=$no?>][0]" class="form-control saran_hukuman" id="saran_hukuman_pemeriksa<?=$no?>" rel="pasal_pemeriksa<?=$no?>" rellink="sk_pemeriksa<?=$no?>">
                                        <option>- Pilih -</option>
                                    </select>
                                    <div class="form-group" style="padding: 20px;">
                                        <label>Pasal</label>
                                        <input name="pasal[<?=$no?>][0]" type="text" class="form-control psl" id="pasal_pemeriksa<?=$no?>" readonly="readonly">
                                        <input name="sk[<?=$no?>][0]" type="hidden" class="form-control" id="sk_pemeriksa<?=$no?>" readonly="readonly">
                                    </div>
                                </td>
                                 <td>
                                 <input type="hidden" name="saran_dari[<?=$no?>][1]" class="form-control" id="saran_dari" value="Inspektur">
                                    <select name="saran_rencana[<?=$no?>][1]" class="form-control saran_rencana" rel="saran_hukuman_inspektur<?=$no?>">
                                        <option value="0">- Pilih Saran -</option>
                                        <option value="1">- Ringan -</option>
                                        <option value="2">- Sedang -</option>
                                        <option value="3">- Berat -</option>
                                    </select><br/>
                                    <select name="saran_hukuman[<?=$no?>][1]" class="form-control saran_hukuman" id="saran_hukuman_inspektur<?=$no?>" rel="pasal_inspektur<?=$no?>" rellink="sk_inspektur<?=$no?>">
                                        <option>- Pilih -</option>
                                    </select>
                                    <div class="form-group" style="padding: 20px;">
                                        <label>Pasal</label>
                                        <input name="pasal[<?=$no?>][1]" type="text" class="form-control psl" id="pasal_inspektur<?=$no?>" readonly="readonly">
                                        <input name="sk[<?=$no?>][1]" type="hidden" class="form-control" id="sk_inspektur<?=$no?>" readonly="readonly">
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" name="saran_dari[<?=$no?>][2]" class="form-control" id="saran_dari" value="Jamwas">   
                                    <select name="saran_rencana[<?=$no?>][2]" class="form-control saran_rencana" rel="saran_hukuman_jamwas<?=$no?>">
                                        <option value="0">- Pilih Saran -</option>
                                        <option value="1">- Ringan -</option>
                                        <option value="2">- Sedang -</option>
                                        <option value="3">- Berat -</option>
                                    </select><br/>
                                    <select name="saran_hukuman[<?=$no?>][2]" class="form-control saran_hukuman" id="saran_hukuman_jamwas<?=$no?>" rel="pasal_jamwas<?=$no?>" rellink="sk_jamwas<?=$no?>">
                                        <option>- Pilih -</option>
                                    </select>
                                    <div class="form-group" style="padding: 20px;">
                                        <label>Pasal</label>
                                        <input name="pasal[<?=$no?>][2]" type="text" class="form-control psl" id="pasal_jamwas<?=$no?>" readonly="readonly">
                                        <input name="sk[<?=$no?>][2]" type="hidden" class="form-control" id="sk_jamwas<?=$no?>" readonly="readonly">
                                    </div>
                                </td>
                            </tr>
                            <?php
                                $no++;
                                }
                            }else{
                                $no=1;
                                 foreach ($modelTerlapor as $key) {
                            ?>
                            <tr>
                            <td><?=$no?></td>
                                <td><?= 'Nama : '.$key['nama_terlapor'].'<br>Pangkat(Gol) : '.$key['pangkat_terlapor'].'('.$key['golongan_terlapor'].')<br>NIP/NRP : '.$key['nip_terlapor'].'/'.$key['nrp_terlapor'].'<br>Jabatan : '.$key['jabatan_terlapor']?>
                                    <input type="hidden" name="nip_terlapor[<?=$no?>]" class="form-control" id="nip_terapor" value="<?=$key['nip_terlapor']?>">
                                    <input type="hidden" name="nama_terlapor[<?=$no?>]" class="form-control" id="nama_terlapor" value="<?=$key['nama_terlapor']?>">
                                    <input type="hidden" name="nrp_terlapor[<?=$no?>]" class="form-control" id="nrp_terlapor" value="<?=$key['nrp_terlapor']?>">
                                    <input type="hidden" name="pangkat_terlapor[<?=$no?>]" class="form-control" id="pangkat_terlapor" value="<?=$key['pangkat_terlapor']?>">
                                    <input type="hidden" name="golongan_terlapor[<?=$no?>]" class="form-control" id="golongan_terlapor" value="<?=$key['golongan_terlapor']?>">
                                    <input type="hidden" name="jabatan_terlapor[<?=$no?>]" class="form-control" id="jabatan_terlapor" value="<?=$key['jabatan_terlapor']?>">
                                    <input type="hidden" name="satker_terlapor[<?=$no?>]" class="form-control" id="satker_terlapor" value="<?=$key['satker_terlapor']?>">
                                </td>
                                <td>
                                <?php
                                /*QUERY mengambil kategori hukuman*/
                                      $connection = \Yii::$app->db;
                                      $query1 = "select*from was.was_15_rencana
                                        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."' and saran_dari='Pemeriksa' and nip_terlapor='".$key['nip_terlapor']."'";
                                      $resultPemeriksa = $connection->createCommand($query1)->queryOne();

                                      $connection = \Yii::$app->db;
                                      $query2 = "select*from was.was_15_rencana
                                        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."' and saran_dari='Inspektur' and nip_terlapor='".$key['nip_terlapor']."'";
                                      $resultInspektur = $connection->createCommand($query2)->queryOne();

                                      $connection = \Yii::$app->db;
                                      $query3 = "select*from was.was_15_rencana
                                        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."' and saran_dari='Jamwas' and nip_terlapor='".$key['nip_terlapor']."'";
                                      $resultJamwas = $connection->createCommand($query3)->queryOne();


                                      /*QUERY SK*/
                                      $connection = \Yii::$app->db;
                                      $querySk1 = "select*from was.ms_sk
                                        where kode_category='".$resultJamwas['kategori_hukuman']."'";
                                      $resultSkPemeriksa = $connection->createCommand($querySk1)->queryAll();

                                      $connection = \Yii::$app->db;
                                      $querySk2 = "select*from was.ms_sk
                                        where kode_category='".$resultJamwas['kategori_hukuman']."'";
                                      $resultSkInspektur = $connection->createCommand($querySk2)->queryAll();

                                      $connection = \Yii::$app->db;
                                      $querySk3 = "select*from was.ms_sk
                                        where kode_category='".$resultJamwas['kategori_hukuman']."'";
                                      $resultSkJamwas = $connection->createCommand($querySk3)->queryAll();

                                ?>
                                    <input type="hidden" name="saran_dari[<?=$no?>][0]" class="form-control" id="saran_dari" value="Pemeriksa">
                                    <select name="saran_rencana[<?=$no?>][0]" class="form-control saran_rencana" rel="saran_hukuman_pemeriksa<?=$no?>">
                                        <option value="0">- Pilih Saran -</option>
                                        <option value="1"  <?=($resultPemeriksa['kategori_hukuman']=='1'?'selected':'') ?>>- Ringan -</option>
                                        <option value="2" <?=($resultPemeriksa['kategori_hukuman']=='2'?'selected':'') ?>>- Sedang -</option>
                                        <option value="3" <?=($resultPemeriksa['kategori_hukuman']=='3'?'selected':'') ?>>- Berat -</option>
                                    </select><br/>
                                    <select name="saran_hukuman[<?=$no?>][0]" class="form-control saran_hukuman" id="saran_hukuman_pemeriksa<?=$no?>" rel="pasal_pemeriksa<?=$no?>" rellink="sk_pemeriksa<?=$no?>">
                                        <option>- Pilih -</option>
                                        <?php
                                            foreach ($resultSkPemeriksa as $keyPemeriksa) {
                                                echo "<option value='".$keyPemeriksa['isi_sk']."' ".($resultPemeriksa['jenis_hukuman']==$keyPemeriksa['isi_sk']?'selected':'').">".$keyPemeriksa['isi_sk']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <div class="form-group" style="padding: 20px;">
                                        <label>Pasal</label>
                                        <input name="pasal[<?=$no?>][0]" type="text" value="<?=$resultPemeriksa['pasal']?>" class="form-control psl" id="pasal_pemeriksa<?=$no?>" readonly="readonly">
                                        <input name="sk[<?=$no?>][0]" type="hidden" value="<?=$resultPemeriksa['sk']?>" class="form-control" id="sk_pemeriksa<?=$no?>" readonly="readonly">
                                    </div>
                                </td>
                                 <td>
                                 <input type="hidden" name="saran_dari[<?=$no?>][1]" class="form-control" id="saran_dari" value="Inspektur">
                                    <select name="saran_rencana[<?=$no?>][1]" class="form-control saran_rencana" rel="saran_hukuman_inspektur<?=$no?>">
                                        <option value="0">- Pilih Saran -</option>
                                        <option value="1" <?=($resultInspektur['kategori_hukuman']=='1'?'selected':'') ?>>- Ringan -</option>
                                        <option value="2" <?=($resultInspektur['kategori_hukuman']=='2'?'selected':'') ?>>- Sedang -</option>
                                        <option value="3" <?=($resultInspektur['kategori_hukuman']=='3'?'selected':'') ?>>- Berat -</option>
                                    </select><br/>
                                    <select name="saran_hukuman[<?=$no?>][1]" class="form-control saran_hukuman" id="saran_hukuman_inspektur<?=$no?>" rel="pasal_inspektur<?=$no?>" rellink="sk_inspektur<?=$no?>">
                                        <option>- Pilih -</option>
                                        <?php
                                            foreach ($resultSkInspektur as $keyInspektur) {
                                                echo "<option value='".$keyInspektur['isi_sk']."' ".($resultInspektur['jenis_hukuman']==$keyInspektur['isi_sk']?'selected':'').">".$keyInspektur['isi_sk']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <div class="form-group" style="padding: 20px;">
                                        <label>Pasal</label>
                                        <input name="pasal[<?=$no?>][1]" type="text" value="<?=$resultInspektur['pasal']?>" class="form-control psl" id="pasal_inspektur<?=$no?>" readonly="readonly">
                                        <input name="sk[<?=$no?>][1]" type="hidden" value="<?=$resultInspektur['sk']?>" class="form-control" id="sk_inspektur<?=$no?>" readonly="readonly">
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" name="saran_dari[<?=$no?>][2]" class="form-control" id="saran_dari" value="Jamwas">   
                                    <select name="saran_rencana[<?=$no?>][2]" class="form-control saran_rencana" rel="saran_hukuman_jamwas<?=$no?>">
                                        <option value="0">- Pilih Saran -</option>
                                        <option value="1" <?=($resultJamwas['kategori_hukuman']=='1'?'selected':'') ?>>- Ringan -</option>
                                        <option value="2" <?=($resultJamwas['kategori_hukuman']=='2'?'selected':'') ?>>- Sedang -</option>
                                        <option value="3" <?=($resultJamwas['kategori_hukuman']=='3'?'selected':'') ?>>- Berat -</option>
                                    </select><br/>
                                    <select name="saran_hukuman[<?=$no?>][2]" class="form-control saran_hukuman" id="saran_hukuman_jamwas<?=$no?>" rel="pasal_jamwas<?=$no?>" rellink="sk_jamwas<?=$no?>">
                                        <option>- Pilih -</option>
                                        <?php
                                            foreach ($resultSkJamwas as $keyJamwas) {
                                                echo "<option value='".$keyJamwas['isi_sk']."' ".($resultJamwas['jenis_hukuman']==$keyJamwas['isi_sk']?'selected':'').">".$keyJamwas['isi_sk']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <div class="form-group" style="padding: 20px;">
                                        <label>Pasal</label>
                                        <input name="pasal[<?=$no?>][2]" type="text" value="<?=$resultInspektur['pasal']?>" class="form-control psl" id="pasal_jamwas<?=$no?>" readonly="readonly">
                                        <input name="sk[<?=$no?>][2]" type="hidden" value="<?=$resultInspektur['sk']?>" class="form-control" id="sk_jamwas<?=$no?>" readonly="readonly">
                                    </div>
                                </td>
                            </tr>

                            <?php
                             $no++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

           
            <div class="col-md-12">
                <div class="panel panel-primary">
                 <div class="panel-heading">Saran Jamwas</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <?= $form->field($model, 'saran_jamwas')->textArea(['class'=>'ckeditor'])->label(false)?>
                        </div>
                        <div class="col-md-6">
                                <label class="control-label col-md-4">Tanggal Saran</label>
                                <div class="col-md-8">
                                    <?=  $form->field($model, 'tanggal_saran_jamwas',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                       // 'startDate' => date('d-m-Y',strtotime($modelWas10['was10_tanggal'])),
                                    ]
                                ],
                            ])->label(false);?>

                                </div>
                        </div>
                    </div>
                </div>
            </div> 
            <?php 
            if(!$model->isNewRecord){
            ?>
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Keputusan Jaksa Agung Republik Indonesia</div>
                    <div class="panel-body">
                     <?= $form->field($model, 'keputusan_was15')->textArea(['row' => 3,'class'=>'ckeditor'])->label(false)?>
                     <!--WARNING......... interface tidak sesuai dengan perja, sedangkan database menyesuaikan dengan perja -->

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center">No.</th>
                                    <th style="text-align: center;width: 250px;">Nama - Pangkat - NIP/NRP - Jabatan</th>
                                    <th style="text-align: center;width: 450px;">Keputusan</th>
                                    <th style="text-align: center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                              
                            $no_ja=1;
                                foreach ($modelTerlapor as $row_data) {
                                    
                              /*jika kondisi saran dari ja ada maka tampilkan jika tidak ada maka ambil dari jamwas*/
                              $connection = \Yii::$app->db;
                              $cek_row = "select*from was.was_15_rencana
                                where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."' and saran_dari='Jaksa Agung' and nip_terlapor='".$row_data['nip_terlapor']."'";
                              $cek = $connection->createCommand($cek_row)->queryOne();
                              // $cek=1;
                            $query6 = "select*from was.was_15_rencana
                                where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."' and saran_dari='Jamwas' and nip_terlapor='".$row_data['nip_terlapor']."'";
                              $resultKetrangan = $connection->createCommand($query6)->queryOne();

                              if(!$cek)
                            {

                              $query3 = "select*from was.was_15_rencana
                                where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."' and saran_dari='Jamwas' and nip_terlapor='".$row_data['nip_terlapor']."'";
                              $resultJa = $connection->createCommand($query3)->queryOne();
                            }else{
                              $query4 = "select*from was.was_15_rencana
                                where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."' and saran_dari='Jaksa Agung' and nip_terlapor='".$row_data['nip_terlapor']."'";
                              $resultJa = $connection->createCommand($query4)->queryOne();
                            }

                            

                              $connection = \Yii::$app->db;
                              $querySk4 = "select*from was.ms_sk
                                where kode_category='".$resultJa['kategori_hukuman']."'";
                              $resultSkJa = $connection->createCommand($querySk4)->queryAll();
                             
                            ?>
                                <tr>
                                    <td style="text-align: center"><?=$no_ja?></td>
                                    <td><?= 'Nama : '.$row_data['nama_terlapor'].'<br>Pangkat(Gol) : '.$row_data['pangkat_terlapor'].'('.$row_data['golongan_terlapor'].')<br>NIP/NRP : '.$row_data['nip_terlapor'].'/'.$row_data['nrp_terlapor'].'<br>Jabatan : '.$row_data['jabatan_terlapor']?>
                                        <input type="hidden" name="nip_terlapor_ja[]" class="form-control" id="nip_terapor" value="<?=$row_data['nip_terlapor']?>">
                                        <input type="hidden" name="nama_terlapor_ja[]" class="form-control" id="nama_terlapor" value="<?=$row_data['nama_terlapor']?>">
                                        <input type="hidden" name="nrp_terlapor_ja[]" class="form-control" id="nrp_terlapor" value="<?=$row_data['nrp_terlapor']?>">
                                        <input type="hidden" name="pangkat_terlapor_ja[]" class="form-control" id="pangkat_terlapor" value="<?=$row_data['pangkat_terlapor']?>">
                                        <input type="hidden" name="golongan_terlapor_ja[]" class="form-control" id="golongan_terlapor" value="<?=$row_data['golongan_terlapor']?>">
                                        <input type="hidden" name="jabatan_terlapor_ja[]" class="form-control" id="jabatan_terlapor" value="<?=$row_data['jabatan_terlapor']?>">
                                        <input type="hidden" name="satker_terlapor_ja[]" class="form-control" id="satker_terlapor" value="<?=$row_data['satker_terlapor']?>">
                                    </td>
                                    <td>
                                    <!-- begin ini jika minta di aktifkan defaultnya-->
                                        <select class="form-control saran_ja" name="saran_ja[]" rel="hukuman_ja<?=$no_ja?>">
                                            <option value="0">- Pilih Saran -</option>
                                            <option value="1" <?=($resultJa['kategori_hukuman']=='1'?'selected':'') ?>>- Ringan -</option>
                                            <option value="2" <?=($resultJa['kategori_hukuman']=='2'?'selected':'') ?>>- Sedang -</option>
                                            <option value="3" <?=($resultJa['kategori_hukuman']=='3'?'selected':'') ?>>- Berat -</option>
                                        </select><br/>
                                        <select class="form-control hukuman_ja" name="hukuman_ja[]" id="hukuman_ja<?=$no_ja?>" rel="pasal_ja<?=$no_ja?>" rellink="sk_ja<?=$no_ja?>" rellink2="keterangan_ja<?=$no_ja?>" keterangan="<?=$resultKetrangan['sk']?>">
                                            <option>- Pilih -</option>
                                            <?php
                                            foreach ($resultSkJa as $row_skJa) {

                                                echo "<option value='".$row_skJa['isi_sk']."'  ".($resultJa['sk']==$row_skJa['kode_sk']?'selected':'').">".$row_skJa['isi_sk']."</option>";

                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" name="pasal_ja[]" class="form-control" id="pasal_ja<?=$no_ja?>" value="<?=$resultJa['pasal']?>">
                                        <input type="hidden" name="sk_ja[]" class="form-control" id="sk_ja<?=$no_ja?>" value="<?=$resultJa['sk']?>">

                                        <!-- end default -->

                                    </td>
                                    <td style="text-align: center;" id="keterangan_ja<?=$no_ja?>"><?=($resultJa['sk']==$resultKetrangan['sk']?'Setuju Saran JAMWAS':'Tidak Setuju Saran JAMWAS')?></td>
                                </tr>
                            <?php
                                $no_ja++;
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <!-- <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <div class="col-md-8">
                            <div class="panel with-nav-tabs panel-default">
                                <div class="panel-heading single-project-nav">
                                    <ul class="nav nav-tabs"> 
                                        <li class="active">
                                            <a href="#saran" data-toggle="tab" id="">Saran Jaksa Agung</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="saran">
                                            <textarea class="ckeditor" id="" name="" ></textarea>
                                            <div class="help-block with-errors" id="error_custom2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                                <label class="control-label col-md-8">Tgl Saran Jaksa Agung</label>
                                <div class="col-md-9">
                                    <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                                </div>
                        </div>
                    </div>
                </div>
            </div> -->

          <!--   <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Penandatangan</div>
                    <div class="panel-body">
                        <div class="col-md-12 row">
                            <div class="form-group">
                                <label class="control-label col-md-3">NIP</label>
                                <div class="col-md-9">
                                    <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                                </div>
                            </div>
                        </div><br/>
                        <div class="col-md-12 row"  style="padding-top: 15px;">
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama</label>
                                <div class="col-md-9">
                                    <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                                </div>
                            </div>
                        </div><br/>
                        <div class="col-md-12 row" style="padding-top: 15px;">
                            <div class="form-group">
                                <label class="control-label col-md-3">Jabatan</label>
                                <div class="col-md-9">
                                    <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 -->
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Penandatangan</div>
                        <div class="panel-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Nip</label>
                                    <div class="col-md-10">
                                      <?php
                        //                 echo $form->field($model, 'nip_penandatangan',['addon' => ['append' => ['content'=>Html::button('Browse', ['class'=>'btn btn-primary','id'=>'pilih_pegawai','data-toggle'=>'modal','data-target'=>'#penandatangan']), 
                        // 'asButton' => true]]])->textInput(['readonly'=>'readonly'])->label(false);
                                      echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                       ?>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!--<label class="control-label col-md-3">WAS-1</label>-->
                                    <label class="control-label col-md-2">Nama</label>
                                    <div class="col-md-10">
                                      <?php
                                          echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                       ?>
                                    </div>
                                </div>  
                            </div>
                            <!-- sebenarnya ada penandatangan default tpi daskrimti belum tau defaultnya apa -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!--<label class="control-label col-md-3">WAS-1</label>-->
                                    <label class="control-label col-md-3">Jabatan</label>
                                    <div class="col-md-9">
                                      <?php
                                          echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                          ?>
                                      <?php
                                       echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly'])->label(false);
                                          ?>

                                         <?php
                                           echo $form->field($model, 'pangkat_penandatangan')->hiddenInput()->label(false);
                                       ?>
                                       <?php
                                            echo $form->field($model, 'jbtn_penandatangan')->hiddenInput()->label(false);
                                       ?>
                                    </div>
                                </div>  
                           </div>
                    </div>
                </div>  
            </div>
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Penandatangan</div>
                        <div class="panel-body">
                    <div class="form-group" style="padding:10px 40px 10px 40px;">
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
                <label>Unggah Berkas WAS-15 Inspeksi : 
                     <?php if (substr($model->upload_file,-3)!='pdf'){?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                    <?php } ?>
                </label>
                <!-- <input type="file" name="upload_file" /> -->
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="upload_file" id="upload_file" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
            </div>
            <?php
            }
            ?>
            <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"> </i> Simpan' : '<i class="fa fa-save"> </i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord){ ?>  
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was15-inspeksi/cetakdocx'])?>"><i class="fa fa-print"></i> Cetak</a>
      <?php } ?>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was15-inspeksi/index'])?>"><i class="fa fa-arrow-left"></i> Kembali</a>
      
    </div>
        </div>
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
                            $searchModelWas15 = new Was15Search();
                            $dataProviderPenandatangan = $searchModelWas15->searchPenandatangan(Yii::$app->request->queryParams);
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
        bottom: -35%;
        right: 50%;
    }
    .nav-tabs {
        border-bottom: 0px;
    }
    .nav-tabs>li>a{
        border-radius: 0px;
        color: #fff;
        border: none!important;
    }
    .table-bordered>thead>tr>th{
        background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);
        border: 1px solid #81bcf8;
        color: #0f5e86;
    }
    .form-group label{
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
</style>

<script type="text/javascript">
    function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
            document.getElementById('ifYes').style.display = 'inline-table';
        }
        else document.getElementById('ifYes').style.display = 'none';
    }

    /*js upload*/
    !function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
    /*end js upload*/

    window.onload=function(){
        $(document).on('click','#tambah_penandatangan',function(){
            var data=JSON.parse($('.MPenandatangan_selection_one:checked').attr('json'));
            $('#was15-dari_was15').val(data.jabtan_asli);
            $('#was15-nama_penandatangan').val(data.nama);
            $('#was15-nip_penandatangan').val(data.nip);
            $('#was15-nama_penandatangan').val(data.nama);
            $('#was15-jabatan_penandatangan').val(data.nama_jabatan);
            $('#was15-pangkat_penandatangan').val(data.gol_pangkat2);
            $('#was15-golongan_penandatangan').val(data.gol_kd);
            $('#was15-jbtn_penandatangan').val(data.jabtan_asli);

            $('#penandatangan').modal('hide');
        });

        $(document).on('change','.saran_rencana',function(){
            var x=$(this).attr('rel');
            var nilai=$(this).val();
            $.ajax({
                    type:'POST',
                    url:'/pengawasan/was15-inspeksi/getobject',
                    data:'id='+nilai,
                    success:function(data){
                       
                        $('#'+x).html(data);
                }
                });
            // alert(x);
        });

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

        $(document).on('change','.saran_hukuman',function(){
            var x=$(this).attr('rel');
            var x2=$(this).attr('rellink');
            var nilai=$(this).val();
            $.ajax({
                    type:'POST',
                    url:'/pengawasan/was15-inspeksi/getpasal',
                    data:'id='+nilai,
                    success:function(data){
                        var pecah=data.split('#');
                        $('#'+x).val(pecah[0]);
                        $('#'+x2).val(pecah[1]);
                }
                });
        });

        $(document).on('change','.saran_ja',function(){
            var x=$(this).attr('rel');
            // var x2=$(this).attr('rellink');
            var nilai=$(this).val();
            
            $.ajax({
                    type:'POST',
                    url:'/pengawasan/was15-inspeksi/getobject',
                    data:'id='+nilai,
                    success:function(data){
                        $('#'+x).html(data);
                        // alert(data);
                       
                }
                });
        });

        $(document).on('change','.hukuman_ja',function(){
            var x=$(this).attr('rel');
            var x2=$(this).attr('rellink');
            var x3=$(this).attr('keterangan');
            var x4=$(this).attr('rellink2');
            var nilai=$(this).val();
            
            $.ajax({
                    type:'POST',
                    url:'/pengawasan/was15-inspeksi/getdata',
                    data:'id='+nilai,
                    success:function(data){
                        var pecah=data.split('#');
                        $('#'+x).val(pecah[0]);
                        $('#'+x2).val(pecah[1]);
                        if(x3==pecah[1]){
                            // alert('sama');
                            // $(this).closest('tr').find('.keterangan_ja').html('sama');
                            $('#'+x4).html('Setuju Saran JAMWAS')
                        }else{
                            $('#'+x4).html('Tidak Setuju Saran JAMWAS')
                            // $(this).closest('tr').find('.keterangan_ja').html('tidak sama');
                            // alert('tidak sama');
                            // rellink2
                        }
                        // $('#'+x).html(data);
                        // alert(data);
                       
                }
                });
        });
    }
    function validateForm() {
        var x =$(".psl").val();
        if (x == "") {
                bootbox.alert({
                    message: "Harap pilih Saran!",
                    size: 'small'
                });
            return false;
        }
    } 
</script>