<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use yii\widgets\Pjax;
use app\modules\pengawasan\models\Was23aSearch;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was23a */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was23a-form">

    <?php $form = ActiveForm::begin([
            // 'id' => 'was11form',
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
        ]); ?>
<div class="box box-primary" style="padding: 15px 15px;">
    <div class="col-md-12">

    <?//= $form->field($model, 'id_tingkat')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'id_kejati')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'id_kejari')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'id_cabjari')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'no_register')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'id_sp_was2')->textInput() ?>

    <?//= $form->field($model, 'id_ba_was2')->textInput() ?>

    <?//= $form->field($model, 'id_l_was2')->textInput() ?>

    <?//= $form->field($model, 'id_was15')->textInput() ?>

    <?//= $form->field($model, 'id_was_23a')->textInput() ?>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">No. Surat</label>
                <div class="col-md-8">
                <?= $form->field($model, 'no_was_23a')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Tanggal</label>
                <div class="col-md-8">
                <?= $form->field($model, 'tgl_was_23a',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'displayFormat' => 'dd-MM-yyyy',
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startDate' =>0,
                            // 'endDate' => date("d/m/Y", strtotime($modelSpwas1['tanggal_akhir_sp_was1'])),
                        ]
                    ]
                ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Sifat</label>
                <div class="col-md-8">
                <?= $form->field($model, 'sifat_surat')->dropDownList(['Biasa','Segera','Rahasia'])->label(false); ?>
                
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Kepada</label>
                <div class="col-md-8">
                <?= $form->field($model, 'kpd_was_23a')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Lampiran</label>
                <div class="col-md-8">
                <?= $form->field($model, 'lampiran')->textInput(['maxlength' => true]) ?>
                
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Di</label>
                <div class="col-md-8">
                <?= $form->field($model, 'di')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Perihal</label>
                <div class="col-md-8">
                <?= $form->field($model, 'perihal')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-4">Tanggal Nota Dinas</label>
                <div class="col-md-8">
               <?= $form->field($model, 'tgl_nota_dinas',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'displayFormat' => 'dd-MM-yyyy',
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startDate' =>0,
                            // 'endDate' => date("d/m/Y", strtotime($modelSpwas1['tanggal_akhir_sp_was1'])),
                        ]
                    ]
                ]) ?>
                </div>
            </div>
        </div>
    </div>

    <?php
        $connection = \Yii::$app->db;
        $sql="select string_agg(nip_pegawai_terlapor,',') as nip_pegawai_terlapor from was.was_23a where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $resultNip=$connection->createCommand($sql)->queryOne();

    ?>

    <?= $form->field($model, 'id_sp_was2')->hiddenInput(['maxlength' => true])->label(false); ?>
    <?= $form->field($model, 'id_ba_was2')->hiddenInput(['maxlength' => true])->label(false); ?>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Terlapor</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nip</label>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'nip_pegawai_terlapor',[
                                                  'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#terlapor","data-backdrop"=>"static", "data-keyboard"=>"false"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['maxlength' => true,'readonly'=>true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nama</label>
                                <div class="col-md-8">
                               <?= $form->field($model, 'nama_pegawai_terlapor')->textInput(['maxlength' => true,'readonly'=>true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Pangkat</label>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'pangkat_pegawai_terlapor')->textInput(['maxlength' => true,'readonly'=>true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Golongan</label>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'golongan_pegawai_terlapor')->textInput(['maxlength' => true,'readonly'=>true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Jabatan</label>
                                <div class="col-md-8">
                                   <?= $form->field($model, 'jabatan_pegawai_terlapor')->textInput(['maxlength' => true,'readonly'=>true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label class="control-label col-md-4">Sk</label> -->
                                <div class="col-md-8">
                                    <?= $form->field($model, 'sk')->hiddenInput(['maxlength' => true])->label(false); ?>
                                    <?= $form->field($model, 'tanggal_ba')->hiddenInput(['maxlength' => true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <?//= $form->field($model, 'nip_pegawai_terlapor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nrp_pegawai_terlapor')->hiddenInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'nama_pegawai_terlapor')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'pangkat_pegawai_terlapor')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'golongan_pegawai_terlapor')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'jabatan_pegawai_terlapor')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'satker_pegawai_terlapor')->textInput(['maxlength' => true]) ?>

    

    

    <?//= $form->field($model, 'tempat')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'sifat_surat')->textInput() ?>

    <?//= $form->field($model, 'lampiran')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'perihal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_l_was2')->hiddenInput(['maxlength' => true])->label(false); ?>
    <?= $form->field($model, 'id_was15')->hiddenInput(['maxlength' => true])->label(false); ?>

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Penandatanagan</div>
                <div class="panel-body">

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nip</label>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'nip_penandatangan',[
                                                  'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#penandatangan","data-backdrop"=>"static", "data-keyboard"=>"false"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['maxlength' => true,'readonly'=>true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nama</label>
                                <div class="col-md-8">
                               <?= $form->field($model, 'nama_penandatangan')->textInput(['maxlength' => true,'readonly'=>true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-4">Jabatan</label>
                                <div class="col-md-8">
                               <?= $form->field($model, 'jabatan_penandatangan')->textInput(['maxlength' => true,'readonly'=>true])->label(false); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?= $form->field($model, 'pangkat_penandatangan')->hiddenInput(['maxlength' => true])->label(false) ?>
                        <?= $form->field($model, 'golongan_penandatangan')->hiddenInput(['maxlength' => true])->label(false) ?>
                        <?= $form->field($model, 'jbtn_penandatangan')->hiddenInput(['maxlength' => true])->label(false) ?>
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

    <?//= $form->field($model, 'nip_penandatangan')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'nama_penandatangan')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'pangkat_penandatangan')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'golongan_penandatangan')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'jabatan_penandatangan')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'jbtn_penandatangan')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'upload_file')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'created_by')->textInput() ?>

    <?//= $form->field($model, 'created_ip')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'created_time')->textInput() ?>

    <?//= $form->field($model, 'updated_ip')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'updated_by')->textInput() ?>

    <?//= $form->field($model, 'updated_time')->textInput() ?>


    <?= $form->field($model, 'tanggal_ba')->hiddenInput() ?>

    <?php if(!$model->isNewRecord){ ?>
    <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
        <label>Unggah Berkas WAS-23a : 
             <?php if (substr($model->upload_file,-3)!='pdf'){?>
                <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_was_23a'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
            <?php } else{?>
                <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_was_23a'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
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
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was23a/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a>
    </div>
</div>
    <?php ActiveForm::end(); ?>

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
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Penandatanagan"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas23a = new Was23aSearch();
                            $dataProviderPenandatangan = $searchModelWas23a->searchPenandatangan(Yii::$app->request->queryParams);
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
                           <div class="modal-loading-new"></div>
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

<div class="modal fade" id="terlapor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Terlapor</h4>
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
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Terlapor"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-terlapor" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelWas23a = new Was23aSearch();
                            $dataProviderTerlapor = $searchModelWas23a->searchTerlapor(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mterlapor-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormTerlapor','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderTerlapor,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_terlapor',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_terlapor',
                                    ],

                                    ['label'=>'Jabatan Alias',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'pangkat_terlapor',
                                    ],

                                    ['label'=>'Jabatan Sebenarnya',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_terlapor',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_surat'],'class'=>'MTerlapor_selection_one','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_terlapor">Tambah</button>
                </div>
            </div>
        </div>
</div>


<style type="text/css">
#grid-terlapor.loading,#grid-penandatangan.loading{overflow: hidden;}
#grid-terlapor.loading .modal-loading-new,#grid-penandatangan.loading .modal-loading-new{display: block;}

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
$("#Mterlapor-tambah-grid").on("pjax:send", function(){
  $("#grid-terlapor").addClass("loading");  
}).on("pjax:success", function(){
  $("#grid-terlapor").removeClass("loading");  
}); 

$("#Mpenandatangan-tambah-grid").on("pjax:send", function(){
      $("#grid-penandatangan").addClass("loading");  
    }).on("pjax:success", function(){
      $("#grid-penandatangan").removeClass("loading");  
    });


  /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/
window.onload=function(){

    $(document).on('click','#tambah_terlapor',function() {
      var data=JSON.parse($(".MTerlapor_selection_one:checked").attr("json"));
      var jml=$(".MTerlapor_selection_one:checked").length;
      var ceknip="<?php echo $resultNip['nip_pegawai_terlapor']; ?>";
      var pecah=ceknip.split(',');
      if(jml=>1 && jml<2){
        if(jQuery.inArray(data.nip_terlapor,pecah)==-1){
         $('#was23a-nip_pegawai_terlapor').val(data.nip_terlapor);
         $('#was23a-nrp_pegawai_terlapor').val(data.nrp_terlapor);
         $('#was23a-nama_pegawai_terlapor').val(data.nama_terlapor);
         $('#was23a-jabatan_pegawai_terlapor').val(data.jabatan_terlapor);
         $('#was23a-golongan_pegawai_terlapor').val(data.golongan_terlapor);
         $('#was23a-pangkat_pegawai_terlapor').val(data.pangkat_terlapor);
         $('#was23a-sk').val(data.sk);
         $('#was23a-tanggal_ba').val(data.tanggal_pemberitahuan_ba);

         $('#was23a-id_sp_was2').val(data.id_sp_was2);
         $('#was23a-id_ba_was2').val(data.id_ba_was2);
         $('#was23a-id_l_was2').val(data.id_l_was2);
         $('#was23a-id_was15').val(data.id_was15);
         $('#terlapor').modal('hide');
        }else{
            bootbox.alert({
                    message:"Terlapor Ini Sudah Ada",
                    size:'small'
                });
        }
      }
    });

    $(document).on('click','#tambah_penandatangan',function() {
      var data=JSON.parse($(".MPenandatangan_selection_one:checked").attr("json"));
      var jml=$(".MPenandatangan_selection_one:checked").length;
      if(jml=>1 && jml<2){
         $('#was23a-nip_penandatangan').val(data.nip);
         $('#was23a-nama_penandatangan').val(data.nama);
         $('#was23a-pangkat_penandatangan').val(data.gol_pangkat2);
         $('#was23a-golongan_penandatangan').val(data.gol_kd);
         $('#was23a-jabatan_penandatangan').val(data.nama_jabatan);
         $('#was23a-jbtn_penandatangan').val(data.jabtan_asli);
         $('#penandatangan').modal('hide');
      }
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

}
</script>