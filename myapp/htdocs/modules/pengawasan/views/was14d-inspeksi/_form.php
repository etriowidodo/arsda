<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\modules\pengawasan\models\Was14dSearch;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was15-inspeksi-form">

   <?php $form = ActiveForm::begin([
            'id' => 'was14form',
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
        ]
    ); ?>

    <?//= $form->field($model, 'id_dasar_spwas')->textInput(['maxlength' => true]) ?>
    <div class="box box-primary">
        <div class="box-body" style="padding:15px;">
            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kepada</label>
                        <div class="col-md-8">
                             <?= $form->field($model, 'kepada_was14d')->textInput(['maxlength' => true,])->label(false) ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Dari</label>
                        <div class="col-md-8">
                           <div class="input-group">
                              <?php if(!$model->isNewRecord){ ?>
                                <input id="was14d-nama_dari" class="form-control cari_ttd" name="Was14d[nama_dari]" readonly="readonly" value="<?= $model['jabatan_penandatangan'] ?>"  type="text">
                              <?php }else{ ?>
                                <input id="was14d-nama_dari" class="form-control" name="Was14d[nama_dari]" readonly="readonly"  type="text">
                              <?php } ?>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary cari_ttd" data-toggle="modal" data-target="#penandatangan">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
               
            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor Surat</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'no_was14d')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Sifat</label>
                        <div class="col-md-8">
                             <?//= $form->field($model, 'sifat_was14b')->textInput(['maxlength' => true])->label(false) ?>
                             <?php
                             $model->sifat_was14d='2';
                             ?>
                             <?= $form->field($model, 'sifat_was14d')->dropDownList(['Biasa','Segera','Rahasia'])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Surat</label>
                            <div class="col-md-8">
                             <?= $form->field($model, 'tgl_was14d',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'pluginOptions' => [
                                            'startDate' => date("d-m-Y",strtotime($lwas2['tanggal_l_was_2'])),
                                            'endDate' => 0,
                                            'autoclose' => true,
                                        ]
                                    ]
                                ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Lampiran</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'lampiran_was14d')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Perihal</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'perihal_was14d')->textarea(['maxlength' => true,'value'=>'Penyampaian Laporan Hasil Inspeksi Kasus Terlapor atas nama'])->label(false) ?>
                        </div>
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Di -</label>
                        <div class="col-md-8">
                           <?= $form->field($model, 'di_was14d')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>
                </div>
             </div>

             <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">   
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Terlapor</label>
                        <div class="col-md-8">
                           <?php 
                            echo $form->field($model, 'nama_terlapor',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#terlapor", "data-backdrop"=>"static", "data-keyboard"=>"false"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly'])->label(false);
                           ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pasal Yang Dilanggar</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'pasal_pelanggaran')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

           <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">   
                <div class="col-md-6">   
                    <div class="form-group">
                        <label class="control-label col-md-4">Hukuman Disiplin</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'hukdis')->textInput(['maxlength' => true])->label(false) ?>
                            <?= $form->field($model, 'nip_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                            <?= $form->field($model, 'nrp_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                            <?= $form->field($model, 'pangkat_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                            <?= $form->field($model, 'golongan_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                            <?= $form->field($model, 'satker_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Uraian</div>
                    <div class="panel-body">
                        <div class="form-group">
                        </div>
                         <div class="col-sm-12" style="margin-bottom: 15px">
                            <div class="col-sm-6">
                              <a class="btn btn-primary btn-sm jarak-kanan" id="hapus-uraian" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>
                              <a class="btn btn-primary btn-sm" id="tambah-uraian" title="Tambah Uraian"><i class="fa fa-plus jarak-kanan"></i> Uraian</a><br>  
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-left: 0px;">
                            <div class="table-responsive">
                                <table id="table_uraian" class="table table-bordered">
                                    <tbody id="bd_uraian">
                                        <?php
                                            if(!$model->isNewRecord){
                                                foreach ($modelwas14d as $modelwas14d_terlapor) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center" width="4%">
                                                            <input id="box1" class="ck_uraian" type="checkbox">
                                                        </td>
                                                        <td><textarea name="uraian[]" class="form-control uraian"><?= $modelwas14d_terlapor['isi_uraian']?></textarea></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }else{
                                                    ?>
                                                    <tr>
                                                        <td class="text-center" width="4%">
                                                            <input id="box1" class="ck_uraian" type="checkbox">
                                                        </td>
                                                        <td><textarea name="uraian[]" class="form-control uraian"></textarea></td>
                                                    </tr>
                                                    <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
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
                                  <label class="control-label col-md-2" style="width:22%">Nip</label>
                                  <div class="col-md-10" style="width:75%">
                                    <?php
                                      if(!$model->isNewRecord){
                                      echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                    }else{
                                      echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                    }
                                     ?>
                                  </div>
                              </div>  
                          </div>
                          <div class="col-md-4">
                               <div class="form-group">
                                  <label class="control-label col-md-2">Nama</label>
                              <div class="col-sm-10">
                                   <?php
                                      if(!$model->isNewRecord){
                                      echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                    }else{
                                      echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                    }
                                    ?>
                              </div>
                              </div>
                          </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label col-md-2">Jabatan</label>
                            <div class="col-sm-10">
                              <?php
                              /*sebenarnya ini ada default pas awal tpi kang putut blm kasih tau defaulnya apa*/
                                    if(!$model->isNewRecord){
                                    echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                    echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly'])->label(false);
                                    echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly'])->label(false);
                                    echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly'])->label(false);
                                  }else{
                                    echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);
                                    echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly'])->label(false);
                                    echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly'])->label(false);
                                    echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly'])->label(false);
                                  }
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

            <?php if(!$model->isNewRecord){ ?>
            <div class="col-md-12" style="padding-top: 15px;">
                <label>Unggah Berkas WAS-14d : 
                     <?php if (substr($model->upload_file,-3)!='pdf'){?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_was14d'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_was14d'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
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
        </div>
    </div>
          
    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"> </i> Simpan' : '<i class="fa fa-save"> </i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was14b-inspeksi/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a>
    </div>
</div>
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
                                  <div class="col-md-8 kejaksaan">
                                    <div class="form-group input-group">       
                                      <input type="text" name="cari_penandatangan" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Penandatangan"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan_surat" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas14d = new Was14dSearch();
                            $dataProviderPenandatanganWas14d = $searchModelWas14d->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w4" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatanganWas14d,
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
                                            return ['value' => $data['id_surat'],'class'=>'selection_one','json'=>$result];
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

<!-- begin Terlapor yang Dilanjutkan -->
<div class="modal fade" id="terlapor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Terlapor yang ditindak lanjuti</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormTerlapor', 
                                      'options'=>['name'=>'searchFormTerlapor'],
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
                                      <input type="text" name="cari_terlapor" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari terlapor"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas14dterlapor = new Was14dSearch();
                            $dataProviderWas14dterlapor = $searchModelWas14dterlapor->searchTerlapor(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mterlapor-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormTerlapor','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderWas14dterlapor,
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
                                        'attribute'=>'nip_terlapor',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_terlapor',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_terlapor',
                                    ],

                                    ['label'=>'Pangkat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'pangkat_terlapor',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_surat'],'class'=>'selection_one_terlapor','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_terlapor">Tambah</button>
                </div>
            </div>
        </div>
</div>

<!-- begin kepada -->
<div class="modal fade" id="kepada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari kepada"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas14d = new Was14dSearch();
                            $dataProviderPenandatanganWas14d = $searchModelWas14d->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w4" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatanganWas14d,
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
                                            return ['value' => $data['id_surat'],'class'=>'selection_one','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_kepada">Tambah</button>
                </div>
            </div>
        </div>
</div>





<style type="text/css">
#grid-penandatangan_surat.loading {overflow: hidden;}
#grid-penandatangan_surat.loading .modal-loading-new {display: block;}
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


 /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

    window.onload=function(){
       $(document).on('click','#tambah_penandatangan',function() {
        var data=JSON.parse($(".selection_one:checked").attr("json"));
           $('#was14d-nip_penandatangan').val(data.nip);
           $('#was14d-nama_penandatangan').val(data.nama);
           $('#was14d-nama_dari').val(data.nama_jabatan);
           $('#was14d-jabatan_penandatangan').val(data.nama_jabatan);
           $('#was14d-golongan_penandatangan').val(data.gol_kd);
           $('#was14d-pangkat_penandatangan').val(data.gol_pangkat2);
           $('#was14d-jbtn_penandatangan').val(data.jabtan_asli);
           $('#penandatangan').modal('hide');
        });

       $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
       $('#grid-penandatangan_surat').addClass('loading');
     }).on('pjax:success', function(){
       $('#grid-penandatangan_surat').removeClass('loading');
     // alert(a);
     });

/*
{"id_tingkat":"0","id_kejati":"00","id_kejari":"00","id_cabjari":"00",
"no_register":"Reg00190","id_sp_was2":1,"id_ba_was2":1,"id_l_was2":1,
"id_terlapor_l_was_2":1,"id_wilayah":1,"id_level1":6,"id_level2":8,
"id_level3":2,"id_level4":1,"nip_terlapor":"199310272014031001",
"nrp_terlapor":"","nama_terlapor":"EDY PRIYANTO","pangkat_terlapor":"Jaksa Utama Pratama",
"golongan_terlapor":"IV\/b","jabatan_terlapor":"Kepala Sub Direktorat EKSEKUSI DAN EKSAMINASI PADA DIT TPUL",
"satker_terlapor":"KEJAGUNG RI","saran_l_was_2":1,"pendapat_l_was_2":1,"saran_pasal":"SK-WAS2-C",
"pendapat_pasal":"SK-WAS2-C","created_by":6,"created_ip":null,"created_time":"2017-08-30 04:21:43"}*/
       $(document).on('click','#tambah_terlapor',function() {
        var data=JSON.parse($(".selection_one_terlapor:checked").attr("json"));
        //alert(data.nama_terlapor);
           $('#was14d-nip_terlapor').val(data.nip_terlapor);
           $('#was14d-nrp_terlapor').val(data.nrp_terlapor);
           $('#was14d-nama_terlapor').val(data.nama_terlapor);
           $('#was14d-pasal_pelanggaran').val(data.pasal);
           $('#was14d-hukdis').val(data.isi_sk);
           $('#was14d-pangkat_terlapor').val(data.pangkat_terlapor);
           $('#was14d-golongan_terlapor').val(data.golongan_terlapor);
           $('#was14d-satker_terlapor').val(data.satker_terlapor);
           $('#was14d-perihal_was14d').val('Penyampaian Laporan Hasil Inspeksi Kasus Terlapor atas nama '+data.nama_terlapor);
        //   $('#was14b-jbtn_penandatangan').val(data.jabtan_asli);
           $('#terlapor').modal('hide');
        });

       $(document).on('hidden.bs.modal','#terlapor', function (e) {
        $(this)
          .find("input[name=cari_terlapor]")
             .val('')
             .end()
          .find("input[type=checkbox], input[type=radio]")
             .prop("checked", "")
             .end();

      });

       $(document).on('click','#tambah_kepada',function() {
        var data=JSON.parse($(".selection_one:checked").attr("json"));
           $('#was14d-nip_penandatangan').val(data.nip);
           $('#was14d-nama_penandatangan').val(data.nama);
           $('#was14d-kepada_was14d').val(data.nama);
           $('#was14d-jabatan_penandatangan').val(data.nama_jabatan);
           $('#was14d-golongan_penandatangan').val(data.gol_kd);
           $('#was14d-pangkat_penandatangan').val(data.gol_pangkat2);
           $('#was14d-jbtn_penandatangan').val(data.jabtan_asli);
           $('#kepada').modal('hide');
        });

       $(document).on('click','#tambah-uraian',function(){
            $('#bd_uraian').append('<tr>'+
                                    '<td class="text-center" width="4%"><input id="box1" class="ck_uraian" type="checkbox"></td>'+
                                    '<td><textarea maxlength="50" name="uraian[]" class="form-control uraian"></textarea></td>'+
                                    '</tr>');
       });

       $(document).on('click','#hapus-uraian',function(){
            $('.ck_uraian:checked').closest('tr').remove();
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
    $("#grid-penandatangan_surat").load("/pengawasan/was14d-inspeksi/getttd",function(responseText, statusText, xhr)
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

    }
</script>