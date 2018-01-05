<?php

use app\models\KpPegawaiSearch;
use yii\grid\GridView;
use app\modules\pengawasan\models\VPejabatPimpinan;
use app\modules\pengawasan\models\BaWas7Search;
use app\modules\pengawasan\models\FungsiComponent;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\db\Query;
use app\models\LookupItem;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas3a */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ba-was7-form">
<?php
$form = ActiveForm::begin(
    [
        'id' => 'ba-was7-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'action' => $model->isNewRecord ? Url::toRoute('ba-was7/create') : Url::toRoute('ba-was7/update?id=' . $model->id_ba_was_7),
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'labelSpan' => 1,
            'showLabels' => false,
        ],
        'options' => [
            'enctype' => 'multipart/form-data',
        ]
    ]
)
?>
<section class="content" style="padding: 0px;">
    <div class="box box-primary">
        <div class="box-body" style="padding:15px;">
            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal BA.WAS-7</label>
                        <div class="col-md-8">
                            <?php
                                $connection = \Yii::$app->db;
                                $sql="select*from was.was_16b where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
                                $was16b=$connection->createCommand($sql)->queryOne();
                            ?>

                            <?= $form->field($model, 'tgl_ba_was_7',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'startDate' => date("d-m-Y",strtotime($was16b['tgl_was_16b'])),
                                    'endDate' => '0day',
                                    'autoclose' => true,
                                ]
                            ]
                        ])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tempat</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'tempat')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $form->field($model, 'pelanggaran')->hiddenInput(['maxlength' => true])->label(false) ?>
            <?php
            $connection = \Yii::$app->db;
            $sql="select string_agg(nip_terlapor,',') as nip_terlapor from was.ba_was_7 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $hasil=$connection->createCommand($sql)->queryOne();
            ?>
            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nama Terlapor</label>
                        <div class="col-md-8">
                            <div class="input-group" style="width: 100%;">
                                   <?php 
                                    echo $form->field($model, 'nama_terlapor',[
                                                        'addon' => [
                                                            'append' => [
                                                                'content' => Html::button('Cari', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#terlapor"]),
                                                                'asButton' => true
                                                            ]
                                                        ]
                                                    ])->textInput(['readonly'=>'readonly'])->label(false);
                                   ?>
                                    <?= $form->field($model, 'nip_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                    <?= $form->field($model, 'nrp_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                    <?= $form->field($model, 'pangkat_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                    <?= $form->field($model, 'golongan_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                    <?= $form->field($model, 'jabatan_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                    <?= $form->field($model, 'sk')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                    <?php  if(!$model->isNewRecord){ ?>
                                     <input id="bawas7-idwas16" name="bawas7-idwas16" type="hidden" value="<?= $model['id_was_16b'] ?>">
                                    <?php }else{ ?>
                                     <input id="bawas7-idwas16" name="bawas7-idwas16" type="hidden">
                                    
                                    <?php } ?>
                                     
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor WAS-16B</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'no_was_16b')->textInput(['maxlength' => true,'readonly'=> true])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
            
             <div class="col-md-6" style="padding-top: 15px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Saksi 1</div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <label class="control-label col-md-4">Nama</label>
                                <div class="col-md-8">
                                    <div class="form-group">
                                         <?php 
                                            echo $form->field($model, 'nama_saksi1',[
                                                                'addon' => [
                                                                    'append' => [
                                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd1', "data-toggle"=>"modal", "data-target"=>"#saksi1"]),
                                                                        'asButton' => true
                                                                    ]
                                                                ]
                                                            ])->textInput(['readonly'=>'readonly'])->label(false);
                                           ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" >
                                    <label class="control-label col-md-4">Jabatan</label>
                                    <div class="col-md-8">
                                <div class="form-group">
                                        <?= $form->field($model, 'jabatan_saksi1')->textInput(['maxlength' => true])->label(false) ?>
                                        <?= $form->field($model, 'nip_saksi1')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                        <?= $form->field($model, 'nrp_saksi1')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                        <?= $form->field($model, 'pangkat_saksi1')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                        <?= $form->field($model, 'golongan_saksi1')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="col-md-6" style="padding-top: 15px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Saksi 2</div>
                        <div class="panel-body">
                            <div class="">
                                <label class="control-label col-md-4">Nama</label>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <?php 
                                            echo $form->field($model, 'nama_saksi2',[
                                                                'addon' => [
                                                                    'append' => [
                                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd2', "data-toggle"=>"modal", "data-target"=>"#saksi2"]),
                                                                        'asButton' => true
                                                                    ]
                                                                ]
                                                            ])->textInput(['readonly'=>'readonly'])->label(false);
                                           ?>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                    <label class="control-label col-md-4">Jabatan</label>
                                    <div class="col-md-8">
                                <div class="form-group">
                                        <?= $form->field($model, 'jabatan_saksi2')->textInput(['maxlength' => true])->label(false) ?>
                                        <?= $form->field($model, 'nip_saksi2')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                        <?= $form->field($model, 'nrp_saksi2')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                        <?= $form->field($model, 'pangkat_saksi2')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                        <?= $form->field($model, 'golongan_saksi2')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Petugas Yang Menyampaikan</div>
                        <div class="panel-body">
                            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="control-label col-md-4">Nama</label>
                                        <div class="col-md-8">
                                            <div class="input-group" style="width: 100%;">
                                                 <?php 
                                                    echo $form->field($model, 'nama_penyampai',[
                                                                        'addon' => [
                                                                            'append' => [
                                                                                'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd3', "data-toggle"=>"modal", "data-target"=>"#petugas"]),
                                                                                'asButton' => true
                                                                            ]
                                                                        ]
                                                                    ])->textInput(['readonly'=>'readonly'])->label(false);
                                                   ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">NIP</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'nip_penyampai')->textInput(['maxlength' => true, 'readonly'=>true])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Pangkat</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'pangkat_penyampai')->textInput(['maxlength' => true, 'readonly'=>true])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Jabatan</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'jabatan_penyampai')->textInput(['maxlength' => true, 'readonly'=>true])->label(false) ?>
                                            <?= $form->field($model, 'nrp_penyampai')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                            <?= $form->field($model, 'golongan_penyampai')->hiddenInput(['maxlength' => true,])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <?php if(!$model->isNewRecord){ ?>
            <div class="col-md-12" style="padding-top: 15px;">
                <label>Unggah Berkas WAS-16b : 
                     <?php if (substr($model->upload_file,-3)!='pdf'){?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_ba_was_7'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_ba_was_7'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
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

        <div class="form-group" style="text-align: center;margin-bottom: 10px;">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"> </i> Simpan' : '<i class="fa fa-save"> </i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['ba-was7/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </div>
</section>

<?php ActiveForm::end(); ?>
</div>

<!-- begin Terlapor yang Dilanjutkan -->
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
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Penandatangan"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelBaWas7terlapor = new BaWas7Search();
                            $dataProviderPenandatanganBaWas7bterlapor = $searchModelBaWas7terlapor->searchTerlapor(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mterlapor-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormTerlapor','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatanganBaWas7bterlapor,
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
                                        'attribute'=>'nip_pegawai_terlapor',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pegawai_terlapor',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_pegawai_terlapor',
                                    ],

                                    ['label'=>'Pangkat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'pangkat_pegawai_terlapor',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['nip_pegawai_terlapor'],'class'=>'selection_one_terlapor','json'=>$result];
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

<!-- Begin Saksi1 -->
<div class="modal fade" id="saksi1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Daftar Saksi</h4>
                </div>
                <div class="modal-body">
                  <div class="box box-primary"  id="get-saksi-index" style="padding: 15px;overflow: hidden;">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormSaksi', 
                                      'options'=>['name'=>'searchFormSaksi'],
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
                                      <input type="text" name="cari_saksi1" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Penandatangan"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan_surat1" style="padding: 15px;overflow: hidden;">
                        <?php Pjax::begin(['id' => 'Msaksi-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormSaksi','enablePushState' => false]) ?>
                        <?php
                           // $searchModelBawas3 = new BaWas3inspeksiSearch();
                           //$dataProviderBawas3 = $searchModelBawas3->searchBawas3Inspeksiterlapor(Yii::$app->request->queryParams);
                            $searchModelSaksi = new BaWas7Search();
                            $dataProviderBawas7 = $searchModelSaksi->searchBawas7Saksi1(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?= GridView::widget([
                                'dataProvider'=> $dataProviderBawas7,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'Nip / Nrp',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_nrp',
                                    ],
                                    ['label'=>'Nama Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],
                                    ['label'=>'Golongan Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_kd',
                                    ],
                                    ['label'=>'Pangkat Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_pangkat2',
                                    ],
                                    ['label'=>'Jabatan Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan',
                                    ],
                                    ['class' => 'yii\grid\CheckboxColumn',
                                     'headerOptions'=>['style'=>'text-align:center'],
                                     'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                               'checkboxOptions' => function ($data) {
                                                $result=json_encode($data);
                                                return ['value' => $data['peg_nip_baru'],'class'=>'selection_saksi1','json'=>$result];
                                                },
                                        ],


                                 ],   

                            ]); ?>
                           <?php Pjax::end(); ?> 
                        </div>
                        <div class="modal-loading-new">
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="Mtambah_saksi1">Tambah</button>
                </div>
            </div>
        </div>
</div>

<!-- Begin Saksi1 -->
<div class="modal fade" id="saksi2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Daftar Saksi</h4>
                </div>
                <div class="modal-body">
                  <div class="box box-primary"  id="get-saksi-index2" style="padding: 15px;overflow: hidden;">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormSaksi', 
                                      'options'=>['name'=>'searchFormSaksi'],
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
                                      <input type="text" name="cari_saksi2" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Penandatangan"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan_surat2" style="padding: 15px;overflow: hidden;">
                        <?php Pjax::begin(['id' => 'Msaksi-tambah-grid2', 'timeout' => false,'formSelector' => '#searchFormSaksi','enablePushState' => false]) ?>
                        <?php
                           // $searchModelBawas3 = new BaWas3inspeksiSearch();
                           //$dataProviderBawas3 = $searchModelBawas3->searchBawas3Inspeksiterlapor(Yii::$app->request->queryParams);
                            $searchModelSaksi = new BaWas7Search();
                            $dataProviderBawas7 = $searchModelSaksi->searchBawas7Saksi2(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?= GridView::widget([
                                'dataProvider'=> $dataProviderBawas7,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'Nip / Nrp',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_nrp',
                                    ],
                                    ['label'=>'Nama Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],
                                    ['label'=>'Golongan Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_kd',
                                    ],
                                    ['label'=>'Pangkat Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_pangkat2',
                                    ],
                                    ['label'=>'Jabatan Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan',
                                    ],
                                    ['class' => 'yii\grid\CheckboxColumn',
                                     'headerOptions'=>['style'=>'text-align:center'],
                                     'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                               'checkboxOptions' => function ($data) {
                                                $result=json_encode($data);
                                                return ['value' => $data['peg_nip_baru'],'class'=>'selection_saksi2','json'=>$result];
                                                },
                                        ],


                                 ],   

                            ]); ?>
                           <?php Pjax::end(); ?> 
                        </div>
                        <div class="modal-loading-new">
                            
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="Mtambah_saksi2">Tambah</button>
                </div>
            </div>
        </div>
</div>


<!-- Begin Petugas -->
<div class="modal fade" id="petugas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Daftar Petugas Yang Menyampaikan</h4>
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
                                      <input type="text" name="cari_petugas" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Penandatangan"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penandatangan_surat3" style="padding: 15px;overflow: hidden;">
                        <?php Pjax::begin(['id' => 'Mpetugas-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormTerlapor','enablePushState' => false]) ?>
                        <?php 
                           // $searchModelBawas3 = new BaWas3inspeksiSearch();
                           //$dataProviderBawas3 = $searchModelBawas3->searchBawas3Inspeksiterlapor(Yii::$app->request->queryParams);
                            $searchModelSaksi = new BaWas7Search();
                            $dataProviderBawas7 = $searchModelSaksi->searchBawas7Petugas(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?= GridView::widget([
                                'dataProvider'=> $dataProviderBawas7,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'Nip / Nrp',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_nrp',
                                    ],
                                    ['label'=>'Nama Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],
                                    ['label'=>'Golongan Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_kd',
                                    ],
                                    ['label'=>'Pangkat Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'gol_pangkat2',
                                    ],
                                    ['label'=>'Jabatan Saksi',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan',
                                    ],
                                    ['class' => 'yii\grid\CheckboxColumn',
                                     'headerOptions'=>['style'=>'text-align:center'],
                                     'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                               'checkboxOptions' => function ($data) {
                                                $result=json_encode($data);
                                                return ['value' => $data['peg_nip_baru'],'class'=>'selection_petugas','json'=>$result];
                                                },
                                        ],


                                 ],   

                            ]); ?>
                           <?php Pjax::end(); ?> 
                        </div>
                        <div class="modal-loading-new">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" id="tambah_petugas">Tambah</button>
                </div>
            </div>
        </div>
</div>


<style type="text/css">

#grid-penandatangan_surat1.loading {overflow: hidden;}
#grid-penandatangan_surat1.loading .modal-loading-new {display: block;}

#grid-penandatangan_surat2.loading {overflow: hidden;}
#grid-penandatangan_surat2.loading .modal-loading-new {display: block;}

#grid-penandatangan_surat3.loading {overflow: hidden;}
#grid-penandatangan_surat3.loading .modal-loading-new {display: block;}

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


#get-saksi-index.loading {overflow: hidden;}
#get-saksi-index.loading .modal-loading-new {display: block;}

#get-saksi-index2.loading {overflow: hidden;}
#get-saksi-index2.loading .modal-loading-new {display: block;}
</style>

<script type="text/javascript">
  /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/
    
    /*id_tingkat":"0","id_kejati":"00","id_kejari":"00","id_cabjari":"00","no_register":"Reg00190","id_sp_was2":1,
    "id_ba_was2":1,"id_l_was2":1,"id_was15":2,"id_was_16b":2,"id_wilayah":1,"id_level1":6,"id_level2":8,"id_level3":2,
    "id_level4":1,"id_ba_was_7":null,"id_ba_was_8":null,"kpd_was_16b":"test kepada 2","dari_was_16b":"An. Inspektur II",
    tgl_was_16b":"2017-09-14","no_was_16b":"456","sifat_surat":0,"lampiran":"test lampiran 2","perihal":"wer",
    "id_terlapor":null,"nip_pegawai_terlapor":"198712252009122002","nrp_pegawai_terlapor":"5108789",
    "nama_pegawai_terlapor":"ZIDNI ILMA, S.Kom.","pangkat_pegawai_terlapor":"II\/d",
    "golongan_pegawai_terlapor":"Sena Darma TU","jabatan_pegawai_terlapor":"Operator Komputer KEPEGAWAIAN",
    "satker_pegawai_terlapor":"KEJAGUNG RI","nip_penandatangan":"196409291989101001",
    "nama_penandatangan":"MARTONO, S.H., M.H.","pangkat_penandatangan":"Jaksa Utama Madya",
    "golongan_penandatangan":"IV\/d","jabatan_penandatangan":"An. Inspektur II","upload_file":null,
    "created_by":6,"created_ip":"127.0.0.1","created_time":"2017-09-08 05:45:01","updated_ip":"127.0.0.1",
    "updated_by":6,"updated_time":"2017-09-08 05:56:37*/
    $(document).on('click','#tambah_saksi', function(){
         $('#saksi').modal({backdrop: 'static', keyboard: false});
        });

    $(document).on('click','#tambah_petugas', function(){
         $('#petugas').modal({backdrop: 'static', keyboard: false});
        });

    // $(document).on('click','#tambah_saksi', function(){
    //      $('#saksi').modal({backdrop: 'static', keyboard: false});
    //     });
    
    $(document).on('click','#tambah_terlapor',function() {
        var data=JSON.parse($(".selection_one_terlapor:checked").attr("json"));
        var nip_terlapor="<?=$hasil['nip_terlapor']?>";
        var pecah=nip_terlapor.split(',');
        // alert(pecah[0]);
        
        if(jQuery.inArray(data.nip_pegawai_terlapor,pecah)==-1){
           $('#bawas7-nip_terlapor').val(data.nip_pegawai_terlapor);
           $('#bawas7-nrp_terlapor').val(data.nrp_pegawai_terlapor);
           $('#bawas7-nama_terlapor').val(data.nama_pegawai_terlapor);
           $('#bawas7-pangkat_terlapor').val(data.pangkat_pegawai_terlapor);
           $('#bawas7-golongan_terlapor').val(data.golongan_pegawai_terlapor);
           $('#bawas7-jabatan_terlapor').val(data.jabatan_terlapor);
           $('#bawas7-no_was_16b').val(data.no_was_16b);
           $('#bawas7-idwas16').val(data.id_was_16b);
           $('#bawas7-sk').val(data.sk);
           $('#bawas7-pelanggaran').val(data.pelanggaran);
           $('#terlapor').modal('hide');
        }else{
            bootbox.alert({
                    message:"Terlpor Ini Sudah ada",
                    size:'small'
                });
        }

        });

     $(document).on('click','#tambah_petugas',function() {
        var data=JSON.parse($(".selection_petugas:checked").attr("json"));
         if(data.peg_nip_baru == $('#bawas7-nip_saksi2').val() || data.peg_nip_baru == $('#bawas7-nip_saksi1').val()){
                bootbox.alert({
                    message:"Saksi Sudah ada",
                    size:'small'
                });
              }else{
                   $('#bawas7-nip_penyampai').val(data.peg_nip_baru);
                   $('#bawas7-nrp_penyampai').val(data.peg_nrp);
                   $('#bawas7-nama_penyampai').val(data.nama);
                   $('#bawas7-pangkat_penyampai').val(data.gol_pangkat2);
                   $('#bawas7-golongan_penyampai').val(data.gol_kd);
                   $('#bawas7-jabatan_penyampai').val(data.jabatan);
               }
                    $('#petugas').modal('hide');

        });


        $(document).on('click','#Mtambah_saksi1',function() {
            var data=JSON.parse($(".selection_saksi1:checked").attr("json"));
              if(data.peg_nip_baru == $('#bawas7-nip_saksi2').val() || data.peg_nip_baru == $('#bawas7-nip_penyampai').val()){
                bootbox.alert({
                    message:"Saksi Sudah ada",
                    size:'small'
                });
              }else{
               $('#bawas7-nip_saksi1').val(data.peg_nip_baru);
               $('#bawas7-nrp_saksi1').val(data.peg_nrp);
               $('#bawas7-nama_saksi1').val(data.nama);
               $('#bawas7-pangkat_saksi1').val(data.gol_pangkat2);
               $('#bawas7-golongan_saksi1').val(data.gol_kd);
               $('#bawas7-jabatan_saksi1').val(data.jabatan);
             }  
               $('#saksi1').modal('hide');


        });

        $(document).on('click','#Mtambah_saksi2',function() {
            var data=JSON.parse($(".selection_saksi2:checked").attr("json"));
             if(data.peg_nip_baru == $('#bawas7-nip_saksi1').val() || data.peg_nip_baru == $('#bawas7-nip_penyampai').val()){
                bootbox.alert({
                    message:"Saksi Sudah ada",
                    size:'small'
                });
              }else{
               $('#bawas7-nip_saksi2').val(data.peg_nip_baru);
               $('#bawas7-nrp_saksi2').val(data.peg_nrp);
               $('#bawas7-nama_saksi2').val(data.nama);
               $('#bawas7-pangkat_saksi2').val(data.gol_pangkat2);
               $('#bawas7-golongan_saksi2').val(data.gol_kd);
               $('#bawas7-jabatan_saksi2').val(data.jabatan);
              } 
               $('#saksi2').modal('hide');

        });

// $(document).on('hidden.bs.modal','#saksi2', function (e) {
//   $(this)
//     .find("input[type=checkbox], input[type=radio]")
//        .prop("checked", "")
//        .end();

// });

// $(document).on('hidden.bs.modal','#saksi1', function (e) {
//   $(this)
//     .find("input[type=checkbox], input[type=radio]")
//        .prop("checked", "")
//        .end();

// });

// $(document).on('hidden.bs.modal','#petugas', function (e) {
//   $(this)
//     .find("input[type=checkbox], input[type=radio]")
//        .prop("checked", "")
//        .end();

// });

$(document).on('hidden.bs.modal','#terlapor', function (e) {
  $(this)
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});


    /*Fungsi Loading di grid*/
    // $("#Msaksi-tambah-grid").on('pjax:send', function(){
    //   $('#get-saksi-index').addClass('loading');
    // }).on('pjax:success', function(){
    //   $('#get-saksi-index').removeClass('loading');
    // });

/*/////////PENANDATANGAN SAKSI 1 LOADING GRID//////////////*/
    $(document).on("#Msaksi-tambah-grid").on('pjax:send', function(){
      $('#grid-penandatangan_surat1').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penandatangan_surat1').removeClass('loading');
    });

    $(document).on('click','.cari_ttd1',function() { 
      $('#grid-penandatangan_surat1').addClass('loading');
        $("#grid-penandatangan_surat1").load("/pengawasan/ba-was7/getttd1",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penandatangan_surat1').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

     $(document).on('hidden.bs.modal','#saksi1', function (e) {
      $(this)
        .find("input[name=cari_saksi1]")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

    });

     /*/////////PENANDATANGAN SAKSI 2 LOADING GRID//////////////*/
    $(document).on("#Msaksi-tambah-grid2").on('pjax:send', function(){
      $('#grid-penandatangan_surat2').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penandatangan_surat2').removeClass('loading');
    });

    $(document).on('click','.cari_ttd2',function() { 
      $('#grid-penandatangan_surat2').addClass('loading');
        $("#grid-penandatangan_surat2").load("/pengawasan/ba-was7/getttd2",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penandatangan_surat2').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

     $(document).on('hidden.bs.modal','#saksi2', function (e) {
      $(this)
        .find("input[name=cari_saksi2]")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();
    });


     /*/////////PENANDATANGAN PENYAMPAI LOADING GRID//////////////*/
    $(document).on("#Mpetugas-tambah-grid").on('pjax:send', function(){
      $('#grid-penandatangan_surat3').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penandatangan_surat3').removeClass('loading');
    });

    $(document).on('click','.cari_ttd3',function() { 
      $('#grid-penandatangan_surat3').addClass('loading');
        $("#grid-penandatangan_surat3").load("/pengawasan/ba-was7/getttd3",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penandatangan_surat3').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

     $(document).on('hidden.bs.modal','#petugas', function (e) {
      $(this)
        .find("input[name=cari_petugas]")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

    });
</script>