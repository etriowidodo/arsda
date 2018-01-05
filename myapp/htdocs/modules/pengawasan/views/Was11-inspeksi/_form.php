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
use app\modules\pengawasan\models\Was11InspeksiSearch;
use yii\widgets\Pjax;

use app\models\LookupItem;
/* @var $this yii\web\View */
/* @var $model app\models\Was10 */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$form = ActiveForm::begin([
            'id' => 'was11form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ],
            'options' => ['enctype' => 'multipart/form-data']
        ]);
?>

<?php //print_r($modelSpwas2['tanggal_mulai_sp_was2']);
//exit();?>
<div class="box box-primary" style="padding: 15px 0px;">
    <?php
      if($result_expire=='0'){
    ?>
        <div class="alert alert-warning" style="margin:0 15px 15px 15px;">
            <strong>Peringatan!</strong> . Batas Tanggal Sp-Was-2 Sudah Kadaluarsa
        </div>
    <?php
      }
    ?>
    <br>
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-4">No. Surat</label>
                <div class="col-md-8">
                <?= $form->field($model, 'no_was_11')->textInput(['maxlength' => true,'readonly' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-4">Tanggal Surat</label>
                <div class="col-md-8">
                <?= $form->field($model, 'tgl_was_11',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'displayFormat' => 'dd-MM-yyyy',
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startDate' => date("d/m/Y", strtotime($modelSpwas2['tanggal_mulai_sp_was2'])),
                            'endDate' => date("d/m/Y", strtotime($modelSpwas2['tanggal_akhir_sp_was2'])),
                        ]
                    ]
                ]); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-4">Sifat Surat</label>
                <div class="col-md-8">
                <?= $form->field($model, 'sifat_surat')->dropDownList(['Biasa','Segera','Rahasia']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-2">Perihal</label>
                <div class="col-md-10">
                <?php 
                  if($model->isNewRecord){
                       $model->perihal='Bantuan penyampaian Surat panggilan saksi';
                    echo $form->field($model, 'perihal')->textArea(['maxlength' => true]);
                  }else{
                    echo $form->field($model, 'perihal')->textArea(['maxlength' => true]);
                  }
                  

                  ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label col-md-4">Lampiran</label>
                <div class="col-md-8">
                <?= $form->field($model, 'lampiran_was11')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label col-md-3">Kepada</label>
                <div class="col-md-9">
                <?= $form->field($model, 'kepada_was11')->textArea(['maxlength' => true, 'style'=>'margin-left: 6px']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label col-md-2">Di</label>
                <div class="col-md-10">
                <?= $form->field($model, 'di_was11')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Saksi <?= $_GET['jns']?></div>
                <div class="panel-body">
                   <div class="btn-toolbar role">
                      <?php if($_GET['jns']== 'Internal') {?>
                        <a class="btn btn-primary btn-sm pull-right" id="hapus_saksi_int"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;
                      <?php }else{?>
                        <a class="btn btn-primary btn-sm pull-right" id="hapus_saksi_eks"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;
                      <?php }?>

                        <a class="btn btn-primary btn-sm pull-right" id="tambah_saksi"><i class="glyphicon glyphicon-pencil"> </i> Tambah</a>&nbsp;
                  </div>
                  <input type="hidden" name="jenis_saksi" value="<?=$_GET['jns']?>">
                  <?php
                  if($_GET['jns']=='Internal'){
                  ?>
                  <table class="table table-bordered" style="margin-top:10px;">
                    <thead>
                        <tr>
                           <th width="4%" style="text-align:center;">No</th>
                              <th style="text-align:center;">NIP/NRP</th>
                              <th width="20%" style="text-align:center;">Nama</th>
                              <th style="text-align:center;">Jabatan</th>
                              <th style="text-align:center;">Pangkat</th>
                              <th width="2%" rowspan="2"><input class="" value="" type="checkbox" name="hapus_all_saksi" id="hapus_all_saksi_in"></th>
                        </tr>
                    </thead>
                    <tbody class="bd_saksi_in_tmp">
                      <?php
                      if(!$model->isNewRecord){
                      $no_saksi_in=1;
                      foreach ($modelSaksiIn_trans as $key_saksi_in) {
                        // print_r($key_saksi_in);
                        ?>
                        <tr classs="tr_ek" id="tr_ek<?= $key_saksi_in['nip_saksi_internal'] ?>">
                          <td style="text-align:center;"><?= $no_saksi_in ?>
                            <input value="<?= $key_saksi_in['nip_saksi_internal'] ?>" type="hidden" class="form-control" id="Mnip_saksi" name="Mnip_saksi[]"  readonly>
                            <input value="<?= $key_saksi_in['id_was11_saksi_int'] ?>" type="hidden" class="form-control" id="Mid_saksi" name="Mid_saksi[]"  readonly>
                            <input value="<?= $key_saksi_in['nrp_saksi_internal'] ?>" type="hidden" class="form-control" id="Mnrp_saksi" name="Mnrp_saksi[]"  readonly>
                            <input value="<?= $key_saksi_in['nama_saksi_internal'] ?>" type="hidden" class="form-control" id="Mnama_saksi" name="Mnama_saksi[]" readonly>
                            <input value="<?= $key_saksi_in['jabatan_saksi_internal'] ?>" type="hidden" class="form-control" id="Mjabatan_saksi" name="Mjabatan_saksi[]"  readonly>
                            <input value="<?= $key_saksi_in['pangkat_saksi_internal'] ?>" type="hidden" class="form-control" id="Mpangkat_saksi" name="Mpangkat_saksi[]"  readonly>
                            <input value="<?= $key_saksi_in['golongan_saksi_internal'] ?>" type="hidden" class="form-control" id="Mgolongan_saksi" name="Mgolongan_saksi[]"  readonly>
                          </td>
                          <td><?= $key_saksi_in['nip_saksi_internal'] ?></td>
                          <td><?= $key_saksi_in['nama_saksi_internal'] ?></td>
                          <td><?= $key_saksi_in['jabatan_saksi_internal'] ?></td>
                          <td><?= $key_saksi_in['pangkat_saksi_internal'] ?></td>
                          <td><input class="selection_one_saksi_in" value="<?= $key_saksi_in['nip_saksi_internal'] ?>" type="checkbox" name="hapus_tr_saksi_in" id="<?= $key_saksi_in['nip_saksi_internal'] ?>"></td>
                        </tr>
                      <?php
                      $no_saksi_in++;
                      }
                    }
                      ?>
                    </body>
                </table>
                <?php }else{ ?>
                <table class="table table-bordered" style="margin-top:10px;">
                    <thead>
                        <tr>
                           <th width="4%" style="text-align:center;">No</th>
                              <th style="text-align:center;">Nama Saksi</th>
                              <th width="20%" style="text-align:center;">Alamat</th>
                              <th style="text-align:center;">Kota</th>
                              <th width="2%" rowspan="2"><input class="" value="" type="checkbox" name="hapus_all_saksi" id="hapus_all_saksi_ek"></th>
                        </tr>
                    </thead>
                    <tbody class="bd_saksi_ek_tmp">
                      <?php
                      if(!$model->isNewRecord){
                      $no_saksi_ek=1;
                      foreach ($modelSaksiIn_trans as $key_saksi_ek) {
                      //  print_r($key_saksi_ek);
                        $nok = $key_saksi_ek['id_was_11'];
                        ?>
                        <tr id="tr_ek<?= $nok  ?>">
                          <td style="text-align:center;"><?= $no_saksi_ek ?>
                          <input value="<?= $key_saksi_ek['id_was_11_saksi_ext'] ?>" type="hidden" class="form-control" id="Mid_saksi_eksternal" name="Mid_saksi_eksternal[]"  readonly>
                          <input value="<?= $key_saksi_ek['nama_saksi_eksternal'] ?>" type="hidden" class="form-control" id="Mnama_saksi_eksternal" name="Mnama_saksi_eksternal[]"  readonly>
                          <input value="<?= $key_saksi_ek['alamat_saksi_eksternal'] ?>" type="hidden" class="form-control" id="Malamat_saksi_eksternal" name="Malamat_saksi_eksternal[]" readonly>
                          <input value="<?= $key_saksi_ek['nama_kota_saksi_eksternal'] ?>" type="hidden" class="form-control" id="Mnama_kota_saksi_eksternal" name="Mnama_kota_saksi_eksternal[]"  readonly>
                          </td>
                          <td><?= $key_saksi_ek['nama_saksi_eksternal'] ?></td>
                          <td><?= $key_saksi_ek['alamat_saksi_eksternal'] ?></td>
                          <td><?= $key_saksi_ek['nama_kota_saksi_eksternal'] ?></td>
                          <td><input class="selection_one_saksi_ek" value="<?= $key_saksi_ek['id_was_11'] ?>" type="checkbox" name="hapus_tr_saksi_ek" id="hapus_tr_ek"></td>
                        </tr>
                      <?php
                      $no_saksi_ek++;
                      }
                    }
                      ?>
                    </body>
                </table>
                <?php } ?>
              <!-- </div> -->

                </div>
        </div>
    </div>


<?php 
// print_r($model);
//exit(); ?>
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
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan", "data-backdrop"=>"static", "data-keyboard"=>"false"]),
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
                        //if(!$model->isNewRecord){
                        echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                      /* }else{
                        echo $form->field($model, 'jabatan_penandatangan_spwas1')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['jabatan']]);
                      } */
                      ?>
                       <?php
                        
                        echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      
                      ?>
                       <?php
                        
                        echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                       // echo $form->field($model, 'status_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                      
                      ?>
                      <?php
                        
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
<?php  if (!$model->isNewRecord){ ?>  
    <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
        <label>Unggah Berkas WAS-11 : 
             <?php if (substr($model->upload_file,-3)!='pdf'){?>
                <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_surat_was11'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
            <?php } else{?>
                <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_surat_was11'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
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
<?php } ?>    

    <div class="col-md-12">
        <div class="form-group">
        <hr style="border-color: #c7c7c7;margin: 10px 0;">  
        <div class="box-footer" style="margin:0px;padding:0px;background:none;">
     
     <?php  
      if ($model->no_was_11==''){   
       if (!$model->isNewRecord){
         if($result_expire=='1'){
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ;
          }
       }else{
          echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ;
       }
     }  
    ?>   
            <?//= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
        <input type="hidden" name="print" value="0" id="print"/>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was11-inspeksi/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a>
       <?php if (!$model->isNewRecord){ ?>
         <?php if($_GET['jns']=='Internal'){ ?>
            <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was11-inspeksi/cetak?jns='."Internal".'&id='. $model['id_surat_was11']])?>"><i class="fa fa-print"></i> Cetak</a>       
         <?php }else {?>
            <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was11-inspeksi/cetak?jns='."Eksternal".'&id='. $model['id_surat_was11']])?>"><i class="fa fa-print"></i> Cetak</a>       
         <?php }?>
        <?php }?>
       
        </div>
        </div>
    </div>


        </div>
    <!-- </div>
</section> -->
<?php ActiveForm::end(); ?>

<!-- modal saksi internal -->
<div class="modal fade" id="Mtambah_internal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Saksi</h4>
                </div>
                <div class="modal-body">
                  <?php
            $searchModel = new Was11InspeksiSearch();
            $dataProvider_int = $searchModel->searchsaksi_int(Yii::$app->request->queryParams);
            ?>
            <?= GridView::widget([
            'dataProvider'=> $dataProvider_int,
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'NIP',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nip',    
                ],

                
                ['label'=>'Nama',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nama_saksi_internal',
                ],

                ['label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan_saksi_internal',
                ],   
              
               ['label'=>'Golongan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'golongan_saksi_internal',
                ],

                ['label'=>'pangkat',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'pangkat_saksi_internal',
                ],   

              ['class' => 'yii\grid\CheckboxColumn',
               'headerOptions'=>['style'=>'text-align:center'],
               'contentOptions'=>['style'=>'text-align:center; width:5%'],
                         'checkboxOptions' => function ($data) {
                          $result=json_encode($data);
                          return ['value' => $data['id_surat'],'class'=>'Msaksi_int','json'=>$result];
                          },
                  ],
                
             ],   

        ]); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="tambah_saksi_int">Tambah</button>
                </div>
            </div>
        </div>
</div>

<!-- modal saksi Eksternal -->
<div class="modal fade" id="Mtambah_eksternal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Saksi</h4>
                </div>
                <div class="modal-body">
                  <?php
                      $searchModel = new Was11InspeksiSearch();
                      $dataProvider_Eks = $searchModel->searchsaksi_eks(Yii::$app->request->queryParams);
                      ?>
                      <?= GridView::widget([
                      'dataProvider'=> $dataProvider_Eks,
                      // 'filterModel' => $searchModel,
                      // 'layout' => "{items}\n{pager}",
                      'columns' => [
                          ['header'=>'No',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'contentOptions'=>['style'=>'text-align:center;'],
                          'class' => 'yii\grid\SerialColumn'],
                          
                          ['label'=>'Nama',
                              'headerOptions'=>['style'=>'text-align:center;'],
                              'attribute'=>'nama_saksi_eksternal',
                          ],

                          ['label'=>'Alamat',
                              'headerOptions'=>['style'=>'text-align:center;'],
                              'attribute'=>'alamat_saksi_eksternal',
                          ],   
                         
                        ['class' => 'yii\grid\CheckboxColumn',
                         'headerOptions'=>['style'=>'text-align:center'],
                         'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                   'checkboxOptions' => function ($data) {
                                    $result=json_encode($data);
                                    return ['value' => $data['id_saksi_eksternal'],'class'=>'Msaksi_eks','json'=>$result];
                                    },
                            ],
                          
                       ],   

                  ]); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="tambah_saksi_eks">Tambah</button>
                </div>
            </div>
        </div>
</div>


<!-- penandatangan -->

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
                        <div class="box box-primary" id="grid-penandatangan_surat" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas11Penandatangan = new Was11InspeksiSearch();
                            $dataProviderPenandatangan = $searchModelWas11Penandatangan->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w8" class="grid-view">
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

    $("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
       $('#grid-penandatangan_surat').addClass('loading');
     }).on('pjax:success', function(){
       $('#grid-penandatangan_surat').removeClass('loading');
     });

   
    $('#hapus_saksi_eks').click(function(){
        var cek = $('.selection_one_saksi_ek:checked').length;
         $('.selection_one_saksi_ek:checked').closest('tr').remove();
     // alert(cek);
         // var checkValues = $('.selection_one_saksi_ek:checked').map(function()
         //    {
         //        return $(this).val();
         //    }).get();
         //        for (var i = 0; i < cek; i++) {
         //           //alert($('#tr_ek'+checkValues[i]));
         //            $('#tr_ek'+checkValues[i]).remove();
         //        };
    });

    $('#hapus_saksi_int').click(function(){
        var cek = $('.selection_one_saksi_in:checked').length;
         $('.selection_one_saksi_in:checked').closest('tr').remove();
         // //var checkValues = $('.selection_one_saksi_in:checked').map(function()
         //    {
         //        return $(this).val();
         //    }).get();
         //        for (var i = 0; i < cek; i++) {
         //         //  alert(checkValues[i]);
         //           $('#tr_ek'+checkValues[i]).remove();
         //        };
    });
$(document).ready(function(){
  /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload

  /*remove localstorage*/
    localStorage.removeItem("nip_saksi");
    localStorage.removeItem("id_saksi_eksternal");
        var arrnip = $('.selection_one_saksi_in').map(function()
                              {
                                  return $(this).val();
                              }).get();
    localStorage.setItem("nip_saksi", JSON.stringify(arrnip));

    var id_saksi = $('.selection_one_saksi_ek').map(function()
                              {
                                  return $(this).val();
                              }).get();
    
    localStorage.setItem("id_saksi_eksternal", JSON.stringify(id_saksi));


});

/*get parameter in URL*/
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};





window.onload=function(){


    $(document).on('click','#tambah_saksi',function(){
      
      var jns = getUrlParameter('jns');
    if(jns=='Internal'){
      $('#Mtambah_internal').modal({backdrop: 'static', keyboard: false});
    }else if(jns=='Eksternal'){
      $('#Mtambah_eksternal').modal({backdrop: 'static', keyboard: false});
    }
   
    });

  

    $(document).on('click','#tambah_penandatangan',function() {
      var data=JSON.parse($(".MPenandatangan_selection_one:checked").attr("json"));
      var jml=$(".MPenandatangan_selection_one:checked").length;
      if(jml=>1 && jml<2){
         $('#was11inspeksi-nip_penandatangan').val(data.nip);
         $('#was11inspeksi-nama_penandatangan').val(data.nama);
         $('#was11inspeksi-jabatan_penandatangan').val(data.nama_jabatan);
         $('#was11inspeksi-jbtn_penandatangan').val(data.jabtan_asli);
         $('#was11inspeksi-golongan_penandatangan').val(data.gol_kd);
         $('#was11inspeksi-pangkat_penandatangan').val(data.gol_pangkat2);
         $('#penandatangan').modal('hide');
      }
    });

    $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
      $('#grid-penandatangan_surat').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penandatangan_surat').removeClass('loading');
    });

    $(document).on('click','#tambah_saksi_int',function() {
      // var data=JSON.parse($(".Msaksi_int:checked").attr("json"));
      var jml=$('.Msaksi_int:checked').length;
      var checkValues = $('.Msaksi_int:checked').map(function()
                                {
                                    return $(this).attr('json');
                                }).get();
      var data='';
      var cek = JSON.parse(localStorage.getItem("nip_saksi"));
      for (var i = 0; i <jml; i++) {
        data=JSON.parse(checkValues[i]);
        if(jQuery.inArray(data.nip,cek)==-1){/*jika kondisi tidak sama maka tambahkan data*/
          $('.bd_saksi_in_tmp').append('<tr>'+
                              '<td></td>'+
                              '<td>'+data.nip+'</td>'+
                              '<td>'+data.nama_saksi_internal+'</td>'+
                              '<td>'+data.jabatan_saksi_internal+'</td>'+
                              '<td>'+data.pangkat_saksi_internal+'</td>'+
                              '<td>'+
                              '<input type="checkbox" class="selection_one_saksi_in" nama="selection_one_saksi_in" value="'+data.nip+'">'+
                              '<input type="hidden" name="Mnip_saksi[]" value="'+data.nip+'">'+
                              '<input type="hidden" name="Mid_saksi[]" value="'+data.id_saksi_internal+'">'+
                              '<input type="hidden" name="Mnrp_saksi[]" value="'+data.nrp+'">'+
                              '<input type="hidden" name="Mnama_saksi[]" value="'+data.nama_saksi_internal+'">'+
                              '<input type="hidden" name="Mjabatan_saksi[]" value="'+data.jabatan_saksi_internal+'">'+
                              '<input type="hidden" name="Mpangkat_saksi[]" value="'+data.pangkat_saksi_internal+'">'+
                              '<input type="hidden" name="Mgolongan_saksi[]" value="'+data.golongan_saksi_internal+'">'+
                              '</td>'+
                              '</tr>');
        }
      };
        $('#Mtambah_internal').modal('hide');
      var arrnip = $('.selection_one_saksi_in').map(function()
                                {
                                    return $(this).val();
                                }).get();
      localStorage.setItem("nip_saksi", JSON.stringify(arrnip));
    });

    $(document).on('click','#tambah_saksi_eks',function() {
          // var data=JSON.parse($(".Msaksi_int:checked").attr("json"));
          var jml=$('.Msaksi_eks:checked').length;
          var valueSaksi = $('.Msaksi_eks:checked').map(function()
                                    {
                                        return $(this).attr('json');
                                    }).get();
          // var data='';
          var cek = JSON.parse(localStorage.getItem("id_saksi_eksternal"));
         // alert(cek);
          var x="1";
          var x1=["1","2"];
          for (var i = 0; i <jml; i++) {
            data=JSON.parse(valueSaksi[i]);
            console.log(data.id_saksi_eksternal);
           // alert(jQuery.inArray(x,x));
            if(jQuery.inArray(data.id_saksi_eksternal.toString(),cek)==-1){/*jika kondisi tidak sama maka tambahkan data*/
            $('.bd_saksi_ek_tmp').append('<tr class="tr_ek">'+
                                '<td></td>'+
                                '<td>'+data.nama_saksi_eksternal+'</td>'+
                                '<td>'+data.alamat_saksi_eksternal+'</td>'+
                                '<td>'+data.nama_kota_saksi_eksternal+'</td>'+
                                '<td>'+
                                '<input type="checkbox" class="selection_one_saksi_ek" nama="selection_one_saksi_ek" value="'+data.id_saksi_eksternal.toString()+'">'+
                                '<input type="hidden" name="Mid_saksi_eksternal[]" value="'+data.id_saksi_eksternal+'">'+
                                '<input type="hidden" name="Mnama_saksi_eksternal[]" value="'+data.nama_saksi_eksternal+'">'+
                                '<input type="hidden" name="Malamat_saksi_eksternal[]" value="'+data.alamat_saksi_eksternal+'">'+
                                '<input type="hidden" name="Mnama_kota_saksi_eksternal[]" value="'+data.nama_kota_saksi_eksternal+'">'+
                                '</td>'+
                                '</tr>');
          }
          };
          $('#Mtambah_eksternal').modal('hide');
          var id_saksi = $('.selection_one_saksi_ek').map(function()
                                    {
                                        return $(this).val();
                                    }).get();
          localStorage.setItem("id_saksi_eksternal", JSON.stringify(id_saksi));
        });
    
    $(document).on('hidden.bs.modal','#Mtambah_internal', function (e) {
      $(this)
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

    });
	
	$(document).on('hidden.bs.modal','#Mtambah_eksternal', function (e) {
      $(this)
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

    });

    // $(document).on('hidden.bs.modal','#penandatangan', function (e) {
    //   $(this)
    //     .find("input[name=cari_penandatangan]")
    //        .val('')
    //        .end()
    //     .find("input[type=checkbox], input[type=radio]")
    //        .prop("checked", "")
    //        .end();

    // });

    $(document).on('hidden.bs.modal','#penandatangan', function (e) {
  $(this)
    .find("input[name=cari_penandatangan]")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

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

  $(document).on('click','.cari_ttd',function() {  
    $('#grid-penandatangan_surat').addClass('loading');
    $("#grid-penandatangan_surat").load("/pengawasan/was11-inspeksi/getttd",function(responseText, statusText, xhr)
        {
            if(statusText == "success")
                     $('#grid-penandatangan_surat').removeClass('loading');
            if(statusText == "error")
                    alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
        });
  });

};
</script>
      
      
      