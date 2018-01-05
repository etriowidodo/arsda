<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;
use yii\db\Query;
use yii\db\Command;
use app\modules\pengawasan\models\Was13InspeksiSearch;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was13 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
  <div class="content-wrapper-1">
    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'id' => 'was10form',
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
 
 <div class="box box-primary" style="overflow:hidden;padding:15px 0px 8px 0px;">
<!-- <div class="col-md-6">
     <fieldset class="group-border">
        <legend class="group-border">Pilih Nama Surat</legend>
            <input name="nama_surat" type="radio" id="nama_surat_was9" value="0"> WAS-9 &nbsp;
            <input name="nama_surat" type="radio" id="nama_surat_was10" value="1"> WAS-10 &nbsp;
            <input name="nama_surat" type="radio" id="nama_surat_was11" value="2"> WAS-11 &nbsp;
            <input name="nama_surat" type="radio" id="nama_surat_was12" value="3"> WAS-12 &nbsp;
     </fieldset>
</div> -->
<div calss="col-md-12">
<div class=" col-md-12 container">
<?= $form->field($model, 'nip_pengirim')->hiddenInput(['readonly'=>true]) ?> 
<?= $form->field($model, 'golongan_pengirim')->hiddenInput(['readonly'=>true]) ?> 
<?= $form->field($model, 'pangkat_pengirim')->hiddenInput(['readonly'=>true]) ?> 
<?= $form->field($model, 'jabatan_pengirim')->hiddenInput(['readonly'=>true]) ?> 
<div class="panel with-nav-tabs panel-default">
  <div class="panel-heading single-project-nav">
  <ul class="nav nav-tabs"> 
    <li id="was9" class="active not-active"><a id="was_9" href="#home"  data-toggle="tab">WAS-9 Inspeksi</a></li>
    <li id="was10" class="not-active"><a id="was_10" href="#menu1"  data-toggle="tab">WAS-10 Inspeksi</a></li>
    <li id="was11" class="not-active"><a id="was_11" href="#menu2"  data-toggle="tab">WAS-11 Inspeksi</a></li>
    <li id="was12" class="not-active"><a id="was_12" href="#menu3"  data-toggle="tab">WAS-12 Inspeksi</a></li>
  </ul>
  </div>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>Was-9 Inspeksi</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Was-9 Inspeksi</th>
                    <th>Nama Saksi</th>
                    <th>Nama Pemeriksa</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no_was9=1;
                foreach ($modelWas9 as $key) {
                 ?>
                <tr>
                    <td><?= $no_was9 ?></td>
                    <td><?= $key['nomor_surat_was9'] ?></td>
                    <td><?= $key['nama_saksi'] ?></td>
                    <td><?= $key['nama_pemeriksa'] ?></td>
                    <td><?= $key['jenis_saksi'] ?></td>
                    <td><input type="checkbox" name="ck_was9" value="<?=$key['id_surat_was9']?>" idspwas2="<?=$key['id_sp_was2'] ?>" nama_surat="WAS-9" tanggal_surat="<?=$key['tanggal_was9']?>" nomor_surat="<?=$key['nomor_surat_was9']?>" penandatangan="<?=$key['nama_penandatangan']?>" saksi="<?= $key['nama_saksi'] ?>" class="ck_was9" <?=($key['id_surat_was9']==$_GET['id']? 'checked':'') ?>></td>
                </tr>
                <?php
                    $no_was9++;
                 } 
                ?>
            </tbody>
        </table>
          
      </div>
    

    <div id="menu1" class="tab-pane fade">
      <h3>Was-10 Inspeksi</h3>
      <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Was-10 Inspeksi</th>
                    <th>Nama Terlapor</th>
                    <th>Nama Pemeriksa</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no_was10=1;
                foreach ($modelWas10 as $key) {
                 ?>
                <tr>
                    <td><?= $no_was10 ?></td>
                    <td><?= $key['no_surat'] ?></td>
                    <td><?= $key['nama_pegawai_terlapor'] ?></td>
                    <td><?= $key['nama_pemeriksa'] ?></td>
                    <td><input type="checkbox" name="ck_was10" value="<?=$key['id_surat_was10']?>" idspwas2="<?=$key['id_sp_was2'] ?>"  nama_surat="WAS-10" tanggal_surat="<?=$key['was10_tanggal']?>" nomor_surat="<?=$key['no_surat']?>" penandatangan="<?=$key['nama_penandatangan']?>" terlapor="<?= $key['nama_pegawai_terlapor'] ?>" class="ck_was10" <?=($key['id_surat_was10']==$_GET['id']? 'checked':'') ?>></td>
                </tr>
                <?php
                    $no_was10++;
                 } 
                ?>
            </tbody>
        </table>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>WAS-11 Inspeksi</h3>
      <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Was-11 Inspeksi</th>
                    <th>Nama Saksi</th>
                    <th>Atasan</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no_was11=1;
                foreach ($modelWas11 as $key) {
                 ?>
                <tr>
                    <td><?= $no_was11 ?></td>
                    <td><?= $key['no_was_11'] ?></td>
                    <td><?php 
                      $pecah=explode('#', $key['nama_saksi']); 
                      $no=1;
                      for ($i=0; $i <count($pecah) ; $i++) { 
                          if(count($pecah)<=1){
                            echo $pecah[$i];
                          }else{
                            echo $no.'. '.$pecah[$i].'<br>';
                          }
                        $no++;
                      }
                    ?></td>
                    <td><?= $key['kepada_was11'] ?></td>
                    <td><?php
                          if($key['jenis_saksi']=='0'){
                            echo $jenis_saksi="Saksi Internal";
                          }else{
                            echo $jenis_saksi="Saksi Eksternal";
                          }?>
                    </td>
                    <td><input type="checkbox" name="ck_was11" value="<?=$key['id_surat_was11']?>" idspwas2="<?=$key['id_sp_was2'] ?>" nama_surat="WAS-11" tanggal_surat="<?=$key['tgl_was_11']?>" nomor_surat="<?=$key['no_was_11']?>" penandatangan="<?=$key['nama_penandatangan']?>" atasan="<?= $key['kepada_was11'] ?>" class="ck_was11" <?=($key['id_surat_was11']==$_GET['id']? 'checked':'') ?>></td> 
                </tr>
                <?php
                    $no_was11++;
                 } 
                ?>
            </tbody>
        </table>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>WAS-12 Inspeksi</h3>
     <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Was-12 Inspeksi</th>
                    <th>Nama Terlapor</th>
                    <th>Jabatan Atasan Terlapor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no_was12=1;
                foreach ($modelWas12 as $key) {
                 ?>
                <tr>
                    <td><?= $no_was12 ?></td>
                    <td><?= $key['no_surat_was12'] ?></td>
                    <td><?= $key['nama_pegawai_terlapor'] ?></td>
                    <td><?= $key['kepada_was12'] ?></td>
                    <td><input type="checkbox" name="ck_was12" value="<?=$key['id_was_12']?>" idspwas2="<?=$key['id_sp_was2'] ?>" nama_surat="WAS-12" tanggal_surat="<?=$key['tanggal_was12']?>" nomor_surat="<?=$key['no_surat_was12']?>" penandatangan="<?=$key['nama_penandatangan']?>" atasan="<?= $key['kepada_was12'] ?>" class="ck_was12" <?=($key['id_was_12']==$_GET['id']? 'checked':'') ?>></td>
                </tr>
                <?php
                    $no_was12++;
                 } 
                ?>
            </tbody>
        </table>
    </div>
  </div>
  <?= $form->field($model, 'nip_penerima')->hiddenInput(['readonly'=>true]) ?> 
  <?= $form->field($model, 'golongan_penerima')->hiddenInput(['readonly'=>true]) ?> 
  <?= $form->field($model, 'pangkat_penerima')->hiddenInput(['readonly'=>true]) ?> 
  <?= $form->field($model, 'jabatan_penerima')->hiddenInput(['readonly'=>true]) ?> 
</div>
</div>
</div>


<div class="col-md-12">
      <div class="panel panel-primary">
          <div class="panel-heading">Pengirim dan Penerima</div>
              <div class="panel-body">
                <div class="col-md-12" style="margin-top:10px">
                    <div class="col-md-6">
                          <div class="form-group">
                                <label class="control-label col-md-3">Nama Pengirim</label>
                            <div class="col-md-9">
                            <?= $form->field($model, 'nama_pengirim',['addon' => [
                                                                        'append' => [
                                                                            'content' => Html::button('Cari', ['class'=>'btn btn-primary get_pengirim', "data-toggle"=>"modal", "data-target"=>"#pengirim","data-backdrop"=>"static","data-keyboard"=>"false"]),
                                                                            'asButton' => true
                                                                        ]
                                                                    ]
                                                                ])->textInput(['readonly'=>true]) ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    $connection = \Yii::$app->db;
                      $sql_level2 = "select tanggal_mulai_sp_was1,tanggal_akhir_sp_was1 from was.sp_was_1 where no_register='".$_SESSION['was_register']."' and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
                      $result_sql_level2 = $connection->createCommand($sql_level2)->queryOne();
                      $awal=$result_sql_level2['tanggal_mulai_sp_was1'];
                      $akhir=$result_sql_level2['tanggal_akhir_sp_was1'];
                      // echo $awal;
                    ?>
                    <div class="col-md-6">
                          <div class="form-group">
                                <label class="control-label col-md-3">Tanggal Dikirim</label>
                            <div class="col-md-5">
                              
                         <?//= $form->field($model, 'tanggal_dikirim',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                            //                'type' => DateControl::FORMAT_DATE,
                                        //     'ajaxConversion' => false,
                                        //     'displayFormat' => 'dd-MM-yyyy',
                                        //     'options' => [

                                        //         'pluginOptions' => [
                                        //             'startDate' => date("d-m-Y",strtotime($awal)),
                                        //             // 'startDate' =>  $modelLapdu[0]['tanggal_surat_diterima'],
                                        //             'endDate' => date("d-m-Y",strtotime($akhir)),
                                        //             'autoclose' => true,
                                        //         ]
                                        //     ],
                                        // ]);
                            echo $form->field($model, 'tanggal_dikirim',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top:10px">
                    <div class="col-md-6">
                          <div class="form-group">
                                <label class="control-label col-md-3">Nama Penerima</label>
                            <div class="col-md-9">
                         <?= $form->field($model, 'nama_penerima',['addon' => [
                                                                    'append' => [
                                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary get_penerima', "data-toggle"=>"modal", "data-target"=>"#penerima","data-backdrop"=>"static","data-keyboard"=>"false"]),
                                                                        'asButton' => true
                                                                    ]
                                                                ]
                                                            ])->textInput(['readonly'=>true]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                          <div class="form-group">
                                <label class="control-label col-md-3">Tanggal Diterima</label>
                            <div class="col-md-5">
                         <?= $form->field($model, 'tanggal_diterima',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]]);
                         // ->widget(DateControl::className(), [
                         //                    'type' => DateControl::FORMAT_DATE,
                         //                    'ajaxConversion' => false,
                         //                    'displayFormat' => 'dd-MM-yyyy',
                         //                    'options' => [

                         //                        'pluginOptions' => [
                         //                            'startDate' => date("d-m-Y",strtotime($awal)),
                         //                            // 'startDate' =>  $modelLapdu[0]['tanggal_surat_diterima'],
                         //                            'endDate' =>  0,
                         //                            // 'startDate' => '-17y',
                         //                            'autoclose' => true,
                         //                        ]
                         //                    ],
                         //                ]);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
      </div>
</div>
<!-- <div class="col-md-12"> -->
<!--     <div class="col-md-12">
                <label class="control-label col-md-1">Unggah</label>
                <?php// if (substr($model['was13_file'],-3)!='pdf'){?>
                 <?//= ($model->was13_file!='' ? '<a href="viewpdf?id='.$model['id_was13'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
                /*<i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                <?php } else{?>
                 <?//= ($model->was13_file!='' ? '<a href="viewpdf?id='.$model['id_was13'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
                <i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php } */?>
    </div>
    <div class="col-md-12">
     <div class="form-group">
          -->   <!-- <div class="col-md-4" style="padding:10px;margin-left:20px"> -->
<?php
    // echo $form->field($model, 'was13_file')->widget(FileInput::classname(), [
    //             'options'=>['accept'=>'application/*'],
    //             'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpeg','jpg','png'],
    //                               'showPreview' => true,
    //                             'showUpload' => false,
    //                             'showRemove' => false,
    //             'showClose' => false,
    //                             'showCaption'=> false,
    //                             'allowedFileExtension' => ['pdf','jpeg','jpg','png'],
    //                             'maxFileSize'=> 3027,
    //                             'browseLabel'=>'Pilih File',
    //         ],
    //         ]);
?>
           <!--  </div>
    </div>
    </div> -->


    <?php  if (!$model->isNewRecord){ ?>  
    <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
        <label>Unggah Berkas WAS-13 Inspeksi : 
             <?php if (substr($model->was13_file,-3)!='pdf'){?>
                <?= ($model['was13_file']!='' ? '<a href="viewpdf?id='.$model['id_was13'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
            <?php } else{?>
                <?= ($model['was13_file']!='' ? '<a href="viewpdf?id='.$model['id_was13'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
            <?php } ?>
        </label>
        <!-- <input type="file" name="upload_file" /> -->
        <div class="fileupload fileupload-new" data-provides="fileupload">
        <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
        <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="was13_file" id="was13_file" /></span>
        <span class="fileupload-preview"></span>
        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
    </div>
    </div>
<?php } ?>    
<!-- </div> -->

<!--Start Biar array nya (nama_surat="WAS-9") bisa k insert  -->
 <?= $form->field($model, 'nama_surat')->hiddenInput() ?>
 <?//= $form->field($model, 'id_surat')->hiddenInput() ?>
 <?= $form->field($model, 'tanggal_surat')->hiddenInput() ?>
 <?= $form->field($model, 'id_sp_was2')->hiddenInput() ?>
 <?= $form->field($model, 'dari')->hiddenInput() ?> 
 <?= $form->field($model, 'id_was9')->hiddenInput() ?> 
 <?= $form->field($model, 'id_was10')->hiddenInput() ?> 
 <?= $form->field($model, 'id_was11')->hiddenInput() ?> 
 <?= $form->field($model, 'id_was12')->hiddenInput() ?> 
  <?= $form->field($model, 'no_surat_was13')->hiddenInput() ?>
  <?= $form->field($model, 'kepada')->hiddenInput() ?>
 <!--End Biar array nya (nama_surat="WAS-9") bisa k insert  -->
 
  <?//= $form->field($model, 'id_kejati')->textInput() ?>
 <?//= $form->field($model, 'id_kejari')->textInput() ?>
 <?//= $form->field($model, 'id_cabjari')->textInput() ?>
 <?//= $form->field($model, 'id_surat')->textInput() ?>
 <?//= $form->field($model, 'no_register')->textInput() ?>
 <?//= $form->field($model, 'id_was13')->textInput() ?>
<div class="col-md-12 table">
   
</div>

    <div class="col-md-12">
        <div class="form-group">
        <hr style="border-color: #c7c7c7;margin: 10px 0;">  
        <div class="box-footer" style="margin:0px;padding:0px;background:none;">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
        <input type="hidden" name="print" value="0" id="print"/>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was13-inspeksi/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a>
    <?php if (!$model->isNewRecord){ ?>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was13-inspeksi/cetakwas?id='.$model[id_was13].''])?>"><i class="fa fa-print"></i> cetak</a>
    <?php } ?>
        </div>
        </div>
    </div>
</div>

    <?php ActiveForm::end(); ?>
</div> 
</section>


<div class="modal fade" id="pengirim" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pengirim</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormPengirim', 
                                      'options'=>['name'=>'searchFormPengirim'],
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
                                      <input type="text" name="cari_pengirim" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="pengirim_box" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas13 = new Was13InspeksiSearch();
                            $dataProviderPengirim = $searchModelWas13->searchPengirim(Yii::$app->request->queryParams);
                        ?>
                        <div id="w6" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpengirim-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPengirim','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPengirim,
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
                                        'attribute'=>'nip_nrp',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'golongan/pangkat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_pangkat',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan',
                                    ],


                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['nip_nrp'],'class'=>'selection_one_pengirim','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_pengirim">Tambah</button>
                </div>
            </div>
        </div>
</div>

<div class="modal fade" id="penerima" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Penerima</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormPenerima', 
                                      'options'=>['name'=>'searchFormPenerima'],
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
                                      <input type="text" name="cari_penerima" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="penerima_box" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas13 = new Was13InspeksiSearch();
                            $dataProviderPenerima = $searchModelWas13->searchPenerima(Yii::$app->request->queryParams);
                        ?>
                        <div id="w7" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenerima-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenerima','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenerima,
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
                                        'attribute'=>'nip_nrp',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'golongan/pangkat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_pangkat',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan',
                                    ],


                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['nip'],'class'=>'selection_one_penerima','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_penerima">Tambah</button>
                </div>
            </div>
        </div>
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
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}
#pemeriksa .modal-dialog  {width:1000px;}
#was13inspeksi-tanggal_dikirim {position: relative; z-index:100;}
#was13inspeksi-tanggal_diterima {position: relative; z-index:100;}

</style>

<script type="text/javascript">
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

$(document).ready(function(){


    // $("#was13-tanggal_dikirim").datepicker();
    var surat="<?php echo $model['nama_surat']?>";
    //alert(surat);
    if(surat=="WAS-9"){
         // $('.nav-tabs li').not('.active').addClass('disabled');
         // $('#was9').attr('class', 'active');
         $('.nav-tabs a[href="#home"]').tab('show');
         $('#was10').attr('class', ' disable activex');$('#was_10').css("color","#bababa !important"); $('#was_10').css("cursor","not-allowed");
         $('#was11').attr('class', ' disable activex');$('#was_11').css("color","#bababa !important"); $('#was_11').css("cursor","not-allowed");
         $('#was12').attr('class', ' disable activex');$('#was_12').css("color","#bababa !important"); $('#was_12').css("cursor","not-allowed");
         $('.nav li').not('.active').find('a').removeAttr("data-toggle");
         
    }else if(surat=="WAS-10"){
         // $('#was10').attr('class', 'active');
         $('.nav-tabs a[href="#menu1"]').tab('show');
         $('#was9').attr('class', ' disable activex');$('#was_9').css("color","#bababa !important"); $('#was_9').css("cursor","not-allowed");
         $('#was11').attr('class', ' disable activex');$('#was_11').css("color","#bababa !important"); $('#was_11').css("cursor","not-allowed");
         $('#was12').attr('class', ' disable activex');$('#was_12').css("color","#bababa !important"); $('#was_12').css("cursor","not-allowed");
         $('.nav li').not('.active').find('a').removeAttr("data-toggle");
    }else if(surat=="WAS-11"){
         // $('#was11').attr('class', 'active');
         $('.nav-tabs a[href="#menu2"]').tab('show');
         $('#was9').attr('class', ' disable activex');$('#was_9').css("color","#bababa !important"); $('#was_9').css("cursor","not-allowed");
         $('#was10').attr('class', ' disable activex');$('#was_10').css("color","#bababa !important"); $('#was_10').css("cursor","not-allowed");
         $('#was12').attr('class', ' disable activex');$('#was_12').css("color","#bababa !important"); $('#was_12').css("cursor","not-allowed");
         $('.nav li').not('.active').find('a').removeAttr("data-toggle");
    }else if(surat=="WAS-12"){
         // $('#was12').attr('class', 'active');
         $('.nav-tabs a[href="#menu3"]').tab('show');
         $('#was9').attr('class', ' disable active');$('#was_9').css("color","#bababa !important"); $('#was_9').css("cursor","not-allowed");
         $('#was10').attr('class', ' disable active');$('#was_10').css("color","#bababa !important"); $('#was_10').css("cursor","not-allowed");
         $('#was11').attr('class', ' disable active');$('#was_11').css("color","#bababa !important"); $('#was_11').css("cursor","not-allowed");
         $('.nav li').not('.active').find('a').removeAttr("data-toggle");
    }
    $("#nama_surat_was9").click(function(){
        var x=$(this).val();
        $.ajax({
                type:'POST',
                url:'/pengawasan/was13/was9',
                data:'id='+x,
                success:function(data){
                    $(".table").html(data);
                }
                });
    });

  $('#was13inspeksi-tanggal_dikirim').prop('readonly', true);
  
  $("#was13inspeksi-tanggal_dikirim").change(function(){
    var x=$(this).val();
    // var tgl = new Date('2010-10-11');
    // alert( tgl.getDate() + '-' +  (tgl.getMonth() + 1) + '-' +  tgl.getFullYear());
    $('#was13inspeksi-tanggal_diterima').datepicker('destroy');
    $("#was13inspeksi-tanggal_diterima").datepicker({dateFormat: "dd-mm-yy", minDate: x,});
});

$(".ck_was9").change(function(){
    var jml=$('.ck_was9:checked').length;

    if(jml=='1'){

    var nilai=$(this).val();
    var nama_surat=$(this).attr('nama_surat');
    var idspwas2=$(this).attr('idspwas2');
    //alert(idspwas2)
    var nomor_surat=$(this).attr('nomor_surat');
    var tanggal_surat=$(this).attr('tanggal_surat');
    var penandatangan=$(this).attr('penandatangan');
    var saksi=$(this).attr('saksi');
    $('#was13inspeksi-tanggal_dikirim').prop('readonly', false);
    var tgl = new Date(tanggal_surat);
    var contver=tgl.getDate() + '-' +  (tgl.getMonth() + 1) + '-' +  tgl.getFullYear();
      $('#was13inspeksi-tanggal_dikirim').datepicker('destroy');
      $("#was13inspeksi-tanggal_dikirim").datepicker({dateFormat: "dd-mm-yy", minDate: contver,});

      $("#was13inspeksi-id_was9").val(nilai);
      $("#was13inspeksi-id_sp_was2").val(idspwas2);
      $("#was13inspeksi-nama_surat").val(nama_surat);
      $("#was13inspeksi-no_surat_was13").val(nomor_surat);
      $("#was13inspeksi-tanggal_surat").val(tanggal_surat);
      $("#was13inspeksi-kepada").val(saksi);
      $("#was13inspeksi-dari").val(penandatangan);
    }else{
      $(this).attr('checked',false);
      $("#was13inspeksi-id_surat").val('');
      $("#was13inspeksi-id_sp_was2").val('');
      $("#was13inspeksi-nama_surat").val('');
      $("#was13inspeksi-no_surat_was13").val('');
      $("#was13inspeksi-tanggal_surat").val('')
      $("#was13inspeksi-kepada").val();
      $("#was13inspeksi-dari").val('');
    }

});

$(".ck_was10").change(function(){
   var jml=$('.ck_was10:checked').length;

    if(jml=='1'){
      var nilai=$(this).val();
      var idspwas2=$(this).attr('idspwas2');
      var nama_surat=$(this).attr('nama_surat');
      var nomor_surat=$(this).attr('nomor_surat');
      var tanggal_surat=$(this).attr('tanggal_surat');
      var penandatangan=$(this).attr('penandatangan');
      var terlapor=$(this).attr('terlapor');
      $('#was13inspeksi-tanggal_dikirim').prop('readonly', false);
      var tgl = new Date(tanggal_surat);
      var contver=tgl.getDate() + '-' +  (tgl.getMonth() + 1) + '-' +  tgl.getFullYear();
      $('#was13inspeksi-tanggal_dikirim').datepicker('destroy');
      $("#was13inspeksi-tanggal_dikirim").datepicker({dateFormat: "dd-mm-yy", minDate: contver,}); 
      
      $("#was13inspeksi-id_was10").val(nilai);
      $("#was13inspeksi-id_sp_was2").val(idspwas2);
      $("#was13inspeksi-nama_surat").val(nama_surat);
      $("#was13inspeksi-no_surat_was13").val(nomor_surat);
      $("#was13inspeksi-tanggal_surat").val(tanggal_surat);
      $("#was13inspeksi-kepada").val(terlapor);
      $("#was13inspeksi-dari").val(penandatangan);
    }else{
      $(this).attr('checked',false);
      $("#was13inspeksi-id_surat").val('');
      $("#was13inspeksi-id_sp_was2").val('');
      $("#was13inspeksi-nama_surat").val('');
      $("#was13inspeksi-no_surat_was13").val('');
      $("#was13inspeksi-tanggal_surat").val('');
      $("#was13inspeksi-kepada").val();
      $("#was13inspeksi-dari").val('');
    }


   
    // alert(nilai);
});

$(".ck_was11").change(function(){
  var jml=$('.ck_was11:checked').length;

    if(jml=='1'){
        var nilai=$(this).val();
        var idspwas2=$(this).attr('idspwas2');
        var nama_surat=$(this).attr('nama_surat');
        var nomor_surat=$(this).attr('nomor_surat');
        var tanggal_surat=$(this).attr('tanggal_surat');
        var penandatangan=$(this).attr('penandatangan');
        var kepada=$(this).attr('atasan');
        $('#was13inspeksi-tanggal_dikirim').prop('readonly', false);
        var tgl = new Date(tanggal_surat);
        var contver=tgl.getDate() + '-' +  (tgl.getMonth() + 1) + '-' +  tgl.getFullYear();
       
        $('#was13inspeksi-tanggal_dikirim').datepicker('destroy');
        $("#was13inspeksi-tanggal_dikirim").datepicker({dateFormat: "dd-mm-yy", minDate: contver,}); 
        $("#was13inspeksi-id_was11").val(nilai);
        $("#was13inspeksi-id_sp_was2").val(idspwas2);
        $("#was13inspeksi-nama_surat").val(nama_surat);
        $("#was13inspeksi-no_surat_was13").val(nomor_surat);
        $("#was13inspeksi-tanggal_surat").val(tanggal_surat);
        $("#was13inspeksi-kepada").val(kepada);
        $("#was13inspeksi-dari").val(penandatangan);
      }else{
        $(this).attr('checked',false);
        $("#was13inspeksi-id_surat").val('');
        $("#was13inspeksi-id_sp_was2").val('');
        $("#was13inspeksi-nama_surat").val('');
        $("#was13inspeksi-no_surat_was13").val('');
        $("#was13inspeksi-tanggal_surat").val('');
        $("#was13inspeksi-kepada").val();
        $("#was13inspeksi-dari").val('');
    }
    // alert(nilai);
});

$(".ck_was12").change(function(){
    var jml=$('.ck_was12:checked').length;
    if(jml=='1'){
      var nilai=$(this).val();
      var idspwas2=$(this).attr('idspwas2');
      var nama_surat=$(this).attr('nama_surat');
      var nomor_surat=$(this).attr('nomor_surat');
      var tanggal_surat=$(this).attr('tanggal_surat');
      var penandatangan=$(this).attr('penandatangan');
      var kepada=$(this).attr('atasan');
      $('#was13inspeksi-tanggal_dikirim').prop('readonly', false);
      
      var tgl = new Date(tanggal_surat);
      var contver=tgl.getDate() + '-' +  (tgl.getMonth() + 1) + '-' +  tgl.getFullYear();
      $('#was13inspeksi-tanggal_dikirim').datepicker('destroy');
      $("#was13inspeksi-tanggal_dikirim").datepicker({dateFormat: "dd-mm-yy", minDate: contver,}); 
      $("#was13inspeksi-id_was12").val(nilai);
      $("#was13inspeksi-id_sp_was2").val(idspwas2);
      $("#was13inspeksi-nama_surat").val(nama_surat);
      $("#was13inspeksi-no_surat_was13").val(nomor_surat);
      $("#was13inspeksi-tanggal_surat").val(tanggal_surat);
      $("#was13inspeksi-kepada").val(kepada);
      $("#was13inspeksi-dari").val(penandatangan);
    }else{
      $(this).attr('checked',false);
      $("#was13inspeksi-id_surat").val('');
      $("#was13inspeksi-id_sp_was2").val('');
      $("#was13inspeksi-nama_surat").val('');
      $("#was13inspeksi-no_surat_was13").val('');
      $("#was13inspeksi-tanggal_surat").val('');
      $("#was13inspeksi-kepada").val();
      $("#was13inspeksi-dari").val('');
  }
    // alert(nilai);
});

$("#was_9","#was_10","#was_11","#was_12").click(function(){
    $(".form-control").val('');
    $('input:checkbox').removeAttr('checked');
}); 

$("#cetak").click(function(){
  var cek_media=$('#lapdu-id_media_pelaporan').val();

  $("#print").val('1');
});

$("#simpan").click(function(){
    var jml=$('#was13-nama_surat').val();
  $("#print").val('0');
  if(jml==''){
                 bootbox.alert({ 
                  size: "small",
                  // title: "Your Title",
                  message: "Harap Pilih Data pada table !", 
                  callback: function(){ /* your callback code */ }
                });
    return false;
  }
  // var cek_media=$('#lapdu-id_media_pelaporan').val();

});
});

window.onload=function(){
  $(document).on('hidden.bs.modal','#pengirim,#penerima', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});

  $(document).on('click','#tambah_pengirim',function(){
    var data=JSON.parse($('.selection_one_pengirim:checked').attr('json'));
    $("#was13inspeksi-nip_pengirim").val(data.peg_nip_baru);
    $("#was13inspeksi-nrp_pengirim").val(data.peg_nrp_baru);
    $("#was13inspeksi-nama_pengirim").val(data.nama);
    $("#was13inspeksi-pangkat_pengirim").val(data.gol_pangkat2);
    $("#was13inspeksi-golongan_pengirim").val(data.gol_kd);
    $("#was13inspeksi-jabatan_pengirim").val(data.jabatan);
    $('#pengirim').modal('hide');
  });

  $(document).on('click','#tambah_penerima',function(){
    var data=JSON.parse($('.selection_one_penerima:checked').attr('json'));
    $("#was13inspeksi-nip_penerima").val(data.peg_nip_baru);
    $("#was13inspeksi-nrp_penerima").val(data.peg_nrp_baru);
    $("#was13inspeksi-nama_penerima").val(data.nama);
    $("#was13inspeksi-pangkat_penerima").val(data.gol_pangkat2);
    $("#was13inspeksi-golongan_penerima").val(data.gol_kd);
    $("#was13inspeksi-jabatan_penerima").val(data.jabatan);
    $('#penerima').modal('hide');
  });

  $(document).on('click','.get_pengirim',function() { 
      // alert('sss');
      $("#pengirim_box").load("/pengawasan/was13-inspeksi/getpengirim");
  });

  $(document).on('click','.get_penerima',function() { 
      // alert('sss');
      $("#penerima_box").load("/pengawasan/was13-inspeksi/getpenerima");
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
 /*   .nav-tabs .disable{
      pointer-events: none;
      cursor: not-allowed;
      color: #;
      background: transparent !important;

    }
    .nav-tabs .not-active a{
      color: #bababa !important;
    }
    .nav-tabs > li.disabled > a::after{
      background: transparent !important;
    }*/
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

    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.activex > a:focus {
        color: #555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }


</style>