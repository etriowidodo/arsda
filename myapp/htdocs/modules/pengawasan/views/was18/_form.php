<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\datecontrol\DateControl;
//use kartik\widgets\DatePicker;
//use kartik\grid\GridView;
use yii\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was18Search;
use yii\db\Query;
use yii\web\View;
?>
<?php $form = ActiveForm::begin([
                'options'=>['enctype'=>'multipart/form-data'] ,
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
                ]); ?>
<div class="was18-form">
    <section class="content" style="padding: 0px;">
        <div class="box box-primary">
            <div class="box-body" style="padding:15px;">
                <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nomor Surat</label>
                            <div class="col-md-8">
                               <?= $form->field($model, 'no_was_18')->textInput()->label(false);?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal Surat</label>
                            <div class="col-md-8">
                            <?php
                                echo $form->field($model, 'tgl_was_18',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        //'startDate' =>  date("d-m-Y",strtotime($was14d['tgl_was14d'])),
                                        'endDate' => '0day',
                                    ]
                                ],
                            ])->label(false);
                            ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Perihal</label>
                            <div class="col-md-8">
                                <?php 
                                    if($model->isNewRecord){
                                    echo $form->field($model, 'perihal')->textArea(['value'=>'Penerbitan Suarat Keputusan Penjatuhan Hukuman Disiplin Terhadap Terlapor an.'])->label(false);
                                    }else{
                                    echo $form->field($model, 'perihal')->textArea()->label(false);
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Lampiran</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'lampiran')->textInput()->label(false);?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Terlapor</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'nama_pegawai_terlapor',[
                                    'addon' => [
                                        'append' => [
                                            'content' => Html::button('Pilih', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#terlapor"]),
                                            'asButton' => true
                                        ]
                                    ]
                                ])->textInput(['readonly'=>'readonly'])->label(false);?>
                            </div>
                        </div>
                    </div>
                    <?php  if (!$model->isNewRecord){ ?> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal Disposisi</label>
                            <div class="col-md-8">
                                <?php
                                echo $form->field($model, 'tgl_disposisi',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        //'startDate' =>  date("d-m-Y",strtotime($was14d['tgl_was14d'])),
                                        'endDate' => '0day',
                                    ]
                                ],
                            ])->label(false);
                            ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?> 
                </div>
                <?php
                $connection = \Yii::$app->db;
                $sql="select*,(select string_agg('Nama : '||b.nama_pelapor||' Alamat : '||b.alamat_pelapor,', ') as nama_pelapor from was.pelapor b where b.no_register=a.no_register and b.id_tingkat=a.id_tingkat and b.id_kejati=a.id_kejati and b.id_kejari=a.id_kejari and b.id_cabjari=a.id_cabjari)from was.lapdu a where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'";
                $lapdu=$connection->createCommand($sql)->queryOne();
                ?>
                <div class="col-md-12" style="margin-top:20px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Isi Laporan</div>
                    <div class="panel-body">
                        <?= $form->field($model, 'isi_laporan')->textarea(['class'=>'ckeditor','rows' => 3,'id'=>'isi'])->label(false) ?>
                    </div>
                </div>
            </div>
 
            </div>

            <div class="col-md-12" style="padding: 30px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Penandatangan</div>
                        <div class="panel-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-3">NIP</label>
                            <div class="col-md-9">
                                    <?= $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#penandatangan"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly'])->label(false);?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama</label>
                            <div class="col-md-9">
                                <!-- <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text"> -->
                                <?= $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-3">Jabatan</label>
                            <div class="col-md-9">
                                <?= $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly'])->label(false);?>
                               
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            
                <div class="panel panel-primary">
                    <div class="panel-heading">Tembusan</div>
                        <div class="panel-body">
                    <div class="form-group"style="margin:10px">
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
            
        <?php  if (!$model->isNewRecord){ ?>  
            <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas WAS18 : 
                     <?php if (substr($model->upload_file,-3)!='pdf'){?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_was18'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_was18'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                    <?php } ?>
                </label>
                <!-- <input type="file" name="upload_file" /> -->
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                <span class="fileupload-exists "> Rubah File</span><input type="file" name="upload_file" id="upload_file" /></span>
                <span class="fileupload-preview"></span>
            <!-- <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>-->
            </div>
            </div>
        <?php } ?> 
        </div>
        <div class="form-group" style="text-align: center;">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was18/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a> 
        </div>
        <?= $form->field($model, 'nip_pegawai_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
        <?= $form->field($model, 'pangkat_pegawai_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
        <?= $form->field($model, 'jabatan_pegawai_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
        <?= $form->field($model, 'golongan_pegawai_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
        <?= $form->field($model, 'nrp_pegawai_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
        <?= $form->field($model, 'pangkat_penandatangan')->hiddenInput(['maxlength' => true,])->label(false) ?> 
        <?= $form->field($model, 'golongan_penandatangan')->hiddenInput(['maxlength' => true,])->label(false) ?>

        <?= $form->field($model, 'id_sp_was2')->hiddenInput(['maxlength' => true,])->label(false) ?>
        <?= $form->field($model, 'id_ba_was2')->hiddenInput(['maxlength' => true,])->label(false) ?>
        <?= $form->field($model, 'id_l_was2')->hiddenInput(['maxlength' => true,])->label(false) ?>
        <?= $form->field($model, 'id_was15')->hiddenInput(['maxlength' => true,])->label(false) ?> 
        <?= $form->field($model, 'kode_sk')->hiddenInput(['maxlength' => true,])->label(false) ?> 
        <?= $form->field($model, 'pasal')->hiddenInput(['maxlength' => true,])->label(false) ?> 
        <?= $form->field($model, 'sanksi')->hiddenInput(['maxlength' => true,])->label(false) ?> 
    </section>
 </div>
 <?php ActiveForm::end(); ?>

<div class="modal fade" id="penandatangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Undang Terlapor</h4>
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
                            $searchModelWas18 = new Was18Search();
                            $dataProviderPenandatangan = $searchModelWas18->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w0" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatangan,
                                
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                     

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
                            $searchModelwas18 = new Was18Search();
                            $dataProviderTerlapor = $searchModelwas18->searchTerlapor(Yii::$app->request->queryParams);
                        ?>
                        <div id="w0" class="grid-view">
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
                                    'header'=>'No',
                                    'class' => 'yii\grid\SerialColumn'],
                                     
                                    ['label'=>'Nip Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_pegawai_terlapor',
                                    ],


                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pegawai_terlapor',
                                    ],

                                    ['label'=>'Pangkat Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'pangkat_pegawai_terlapor',
                                    ],

                                    ['label'=>'Jabatan Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_pegawai_terlapor',
                                    ],

                                    ['label'=>'Kode SK',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'kode_sk',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_surat'],'class'=>'selection_onex','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]);  ?>
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

<style type="text/css">
    #grid-penandatangan_surat.loading{overflow: hidden;}
    #grid-penandatangan_surat.loading .modal-loading-new{display: block;}

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

</style>
 <script type="text/javascript">
    $("#Mpenandatangan-tambah-grid").on("pjax:send", function(){
      $("#grid-penandatangan_surat").addClass("loading");  
    }).on("pjax:success", function(){
      $("#grid-penandatangan_surat").removeClass("loading");  
    }); 

    $(document).ready(function(){
        $('#was18-tgl_was_18').datepicker();
        $('#was18-tgl_disposisi').datepicker();
        /*js upload*/
            !function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
        /*end js upload*/
    });

    $(document).on('click','#tambah_terlapor',function() {
    var data=JSON.parse($(".selection_onex:checked").attr("json"));   
        $('#was18-nama_pegawai_terlapor').val(data.nama_pegawai_terlapor);   
        $('#was18-nip_pegawai_terlapor').val(data.nip_pegawai_terlapor);   
        $('#was18-pangkat_pegawai_terlapor').val(data.pangkat_pegawai_terlapor);   
        $('#was18-jabatan_pegawai_terlapor').val(data.jabatan_pegawai_terlapor);   
        $('#was18-golongan_pegawai_terlapor').val(data.golongan_pegawai_terlapor);   
        $('#was18-nrp_pegawai_terlapor').val(data.nrp_pegawai_terlapor);   
        $('#was18-id_sp_was2').val(data.id_sp_was2);     
        $('#was18-id_ba_was2').val(data.id_ba_was2);     
        $('#was18-id_l_was2').val(data.id_l_was2);     
        $('#was18-id_was15').val(data.id_was15);    
        $('#was18-kode_sk').val(data.kode_sk);    
        $('#was18-pasal').val(data.pasal);    
        $('#was18-sanksi').val(data.isi_sk);   
        // $('#was18-isi_laporan').val('fffff');  
        var lapdu_pelapor="<?php echo $lapdu['nama_pelapor'] ?>";
        var lapdu_ringkasan="<?php echo $lapdu['ringkasan_lapdu'] ?>";
        var lapdu_tanggal="<?php echo $lapdu['tanggal_surat_lapdu'] ?>";
       
        var lapdu_nomor="<?php echo $lapdu['nomor_surat_lapdu'] ?>";
        $('#was18-perihal').val('Penerbitan Suarat Keputusan Penjatuhan Hukuman Disiplin Terhadap Terlapor an. '+data.nama_pegawai_terlapor);   
        var tmp_isi="<ol style='list-style-type: lower-alpha;'>"+
                        "<li>  Identitas lengkap Pegawai Negeri Sipil yang dijatuhi hukuman disiplin ("+data.nama_pegawai_terlapor+" "+data.pangkat_pegawai_terlapor+" ("+data.golongan_pegawai_terlapor+") "+data.nip_pegawai_terlapor+"/"+data.nrp_pegawai_terlapor+" "+data.jabatan_pegawai_terlapor+");</li>"+
                        "<li>  Identitas lengkap pejabat yang memeriksa ("+data.nama_pemeriksa+" "+data.pangkat_pemeriksa+" "+data.nip_pemeriksa+"/"+data.nrp_pemeriksa+" "+data.jabatan_pemeriksa+");</li>"+
                        "<li>  Identitas lengkap pelapor  ("+lapdu_pelapor+");</li>"+
                        "<li>  Isi laporan (Nomor: "+lapdu_nomor+" Tanggal: "+lapdu_tanggal+" Pokok-Pokok Laporan: "+lapdu_ringkasan+")</li>"+
                        "<li>  Jenis pelanggaran disiplin yang dilakukan ("+data.pelanggaran+");</li>"+
                        "<li>  Pasal yang dilanggar ("+data.pasal+")</li>"+
                        "<li>  Sanksi pasal yang dilanggar ("+data.isi_sk+");</li>"+
                    "</ol>";


         CKEDITOR.instances.isi.setData(tmp_isi);
        $('#terlapor').modal('hide');     
    });

    $(document).on('click','#tambah_penandatangan',function() {
    var data=JSON.parse($(".selection_one:checked").attr("json")); 
        $('#was18-nip_penandatangan').val(data.nip);    
        $('#was18-nama_penandatangan').val(data.nama);    
        $('#was18-jabatan_penandatangan').val(data.nama_jabatan);  
        $('#was18-pangkat_penandatangan').val(data.gol_pangkat2);  
        $('#was18-golongan_penandatangan').val(data.gol_kd);  
        $('#penandatangan').modal('hide');        
    });

    window.onload=function(){

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