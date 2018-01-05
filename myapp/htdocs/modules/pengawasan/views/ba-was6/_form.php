<?php

use app\models\KpPegawaiSearch;
// use kartik\grid\GridView;
use yii\grid\GridView;
use app\modules\pengawasan\models\VPejabatPimpinan;
use app\modules\pengawasan\models\Bawas6Search;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\db\Query;
use app\models\LookupItem;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas3a */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ba-was5-form">
<?php
$form = ActiveForm::begin(
    [
        'id' => 'ba-was5-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
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
    <div class="box box-primary">
        <div class="box-body">
           <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label col-md-4">Tanggal Berita Acara</label>
                    <div class="col-md-6">          
                         <?=
                            $form->field($model, 'tgl_ba_was_6',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        // 'startDate' => date('d-m-Y',strtotime($modelSpWas2['tanggal_sp_was2'])),
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
                         <?=
                            $form->field($model, 'tempat')->textInput(['maxLenght'=>true]);
                            ?>
                    </div>
                    </div>
                </div>
            </div>

             <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Petugas Yang Menyampaikan</div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nip</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'nip_menerima',[
                                                    'addon' => [
                                                        'append' => [
                                                            'content' => Html::button('Cari', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#menerima", "data-backdrop"=>"static", "data-keyboard"=>"false"]),
                                                            'asButton' => true
                                                        ]
                                                    ]
                                                ])->textInput()?>
                                    </div>
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nama</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'nama_menerima')->textInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Pangkat</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'pangkat_menerima')->textInput(['maxLenght'=>true])?>
                                        <?= $form->field($model, 'golongan_menerima')->hiddenInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Jabatan</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'jabatan_menerima')->textInput(['maxLenght'=>true])?>
                                        <?= $form->field($model, 'nrp_menerima')->hiddenInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                </div>
            </div>


                <?php
                $connection = \Yii::$app->db;
                $sql="select string_agg(nip_menerima,',') as nip_penerima from was.ba_was_6 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
                $resultNip=$connection->createCommand($sql)->queryOne();
               
            ?>
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Data Surat Keputusan</div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nip</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'nip_terlapor',[
                                                    'addon' => [
                                                        'append' => [
                                                            'content' => Html::button('Cari', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#terlapor", "data-backdrop"=>"static", "data-keyboard"=>"false"]),
                                                            'asButton' => true
                                                        ]
                                                    ]
                                                ])->textInput()?>
                                    </div>
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Nama</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'nama_terlapor')->textInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Pangkat</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'pangkat_terlapor')->textInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Jabatan</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'jabatan_terlapor')->textInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                            </div>
                           
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">SK</label>
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'tgl_sk')->textInput(['maxLenght'=>true])?>
                                        <?= $form->field($model, 'sk')->hiddenInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">No SK</label>
                                    <div class="col-md-9">   
                                        <!-- <input type="text" maxlenght="true" name="sk" class="form-control" id="sk"> -->
                                        <?= $form->field($model, 'no_sk')->textInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <!-- <label class="control-label col-md-3">No SK</label> -->
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'id_was15')->hiddenInput(['maxLenght'=>true])?>
                                        <?= $form->field($model, 'id_sp_was2')->hiddenInput(['maxLenght'=>true])?>
                                    </div>
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <!-- <label class="control-label col-md-3">SK</label> -->
                                    <div class="col-md-9">   
                                        <?= $form->field($model, 'id_l_was2')->hiddenInput(['maxLenght'=>true])?>
                                        <?= $form->field($model, 'id_ba_was2')->hiddenInput(['maxLenght'=>true])?>

                                    </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <?= $form->field($model, 'golongan_terlapor')->hiddenInput(['maxLenght'=>true])->label(false)?>
                 <?= $form->field($model, 'nrp_terlapor')->hiddenInput(['maxLenght'=>true])->label(false)?>

             <div class="col-md-12">    
               <div class="col-md-6"> 
                <div class="form-group">
                    <label class="control-label col-md-4">Pernyataan</label>
                    <div class="col-md-4">
                         <?php 
                            $list = [0 => 'Pilih',
                                 1 => 'Terima', 
                                 2 => 'Tolak', 
                                 ];
                                 echo $form->field($model, 'terima_tolak')->dropDownList($list)->label(false);
                        ?> 
                    </div>
                </div>
               </div>  
              </div>  
                 
            <?php
                // $connection = \Yii::$app->db;
                // $sql="select string_agg(nip_penerima,',') as nip_penerima from was.ba_was_6 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
                // $resultNip=$connection->createCommand($sql)->queryOne();
               
            ?>
           
                <?php 
                    if(!$model->isNewRecord){ 
                ?>
                <div class="col-md-12">
                <label>Unggah File Ba-Was-6 : 
                     <?php if (substr($model['upload_file'],-3)!='pdf'){?>
                     <?= ($model->upload_file!='' ? '<a href="viewpdf?id='.$model['id_ba_was_6'].'" ><span style="cursor:pointer;font-size:28px;">
                    <i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                     <?= ($model->upload_file!='' ? '<a href="viewpdf?id='.$model['id_ba_was_6'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
                    <i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php } ?>
                </label>
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

                <div class="form-group" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"> </i> Tambah' : '<i class="fa fa-save"> </i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                    <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['ba-was5/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a>
                </div>

        </div>


    </div>
<?php ActiveForm::end(); ?>
</div>

<div class="modal fade" id="menerima" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Penyampai</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?php $form = ActiveForm::begin([
                                      // 'action' => ['create'],
                                      'method' => 'get',
                                      'id'=>'searchFormPenyampai', 
                                      'options'=>['name'=>'searchFormPenyampai'],
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
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search">  </i> Cari</button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penyampai" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchMBawas6 = new Bawas6Search();
                            $dataProviderPenyampai = $searchMBawas6->searchPenyampai(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?php Pjax::begin(['id' => 'MPenyampai-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenyampai','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenyampai,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip',
                                    ],

                                    ['label'=>'Nama',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_penandatangan',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_penandatangan',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['nip'],'class'=>'selection_one','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_menerima">Tambah</button>
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
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Pemeriksa"><i class="fa fa-search">  </i> Cari</button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-terlapor" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelBaWas6 = new Bawas6Search();
                            $dataProvider = $searchModelBaWas6->searchTerlapor(Yii::$app->request->queryParams);
                        ?>
                        <div id="w1" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mterlapor-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormTerlapor','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip_pegawai_terlapor',
                                    ],

                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pegawai_terlapor',
                                    ],

                                    ['label'=>'Jabatan terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_pegawai_terlapor',
                                    ],

                                 [
                                 'class' => 'yii\grid\CheckboxColumn',
                                  'header' => Html::checkBox('select_all_in', false, [
                                    'class' => 'select-all-in',
                                    
                                ]),
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['nip'],'class'=>'selection_one_terlapor','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_terlapor">Tambah</button>
                </div>
            </div>
        </div>
</div>  


<style type="text/css">
#grid-terlapor.loading,#grid-penyampai.loading{overflow: hidden;}
#grid-terlapor.loading .modal-loading-new,#grid-penyampai.loading .modal-loading-new{display: block;}


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
</style>
<script type="text/javascript">
$("#Mterlapor-tambah-grid").on("pjax:send", function(){
      $("#grid-terlapor").addClass("loading");  
    }).on("pjax:success", function(){
      $("#grid-terlapor").removeClass("loading");  
    }); 

$("#MPenyampai-tambah-grid").on("pjax:send", function(){
      $("#grid-penyampai").addClass("loading");  
    }).on("pjax:success", function(){
      $("#grid-penyampai").removeClass("loading");  
    });



    /*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

window.onload=function(){
localStorage.clear();
localStorage.removeItem("bawas6_saksi");
// var nip_saksi=$('#Nip_Terlapor_TMP').val().split(',');
// localStorage.setItem('bawas6_saksi_OnDB', JSON.stringify(nipTerlapor));

$(document).on('click','.select-all-in',function(){
if ($(this).is(':checked')) {
    $('.selection_one_terlapor').prop('checked',true);
}else{
    $('.selection_one_terlapor').prop('checked',false);
}

});
$(document).on('click','#tambah_terlapor',function(){
    var data=JSON.parse($('.selection_one_terlapor:checked').attr('json'));
    var ceknip="<?php echo $resultNip['nip_penerima']; ?>";
    var pecah=ceknip.split(',');
    // alert(pecah);
    if(jQuery.inArray(data.nip_pegawai_terlapor,pecah)==-1){
    $('#bawas6-nip_terlapor').val(data.nip_pegawai_terlapor);
    $('#bawas6-pangkat_terlapor').val(data.pangkat_pegawai_terlapor);
    $('#bawas6-golongan_terlapor').val(data.golongan_pegawai_terlapor);
    $('#bawas6-nama_terlapor').val(data.nama_pegawai_terlapor);
    $('#bawas6-jabatan_terlapor').val(data.jabatan_pegawai_terlapor);
    $('#bawas6-no_sk').val(data.no_sk);
    $('#bawas6-id_sp_was2').val(data.id_sp_was2);
    $('#bawas6-id_ba_was2').val(data.id_ba_was2);
    $('#bawas6-id_l_was2').val(data.id_l_was2);
    $('#bawas6-id_was15').val(data.id_was15);
    $('#bawas6-sk').val(data.sk);
    
    // $('#sk').val(data.sk);
    $('#bawas6-tgl_sk').val(data.tgl_sk);
    $('#terlapor').modal('hide');
    // alert(data.nip_pegawai_terlapor);
    }else{
        bootbox.alert({
                    message:"Terlapor Ini Sudah Ada",
                    size:'small'
                });
    }
});

$(document).on('click','#tambah_menerima',function(){
    var data=JSON.parse($('.selection_one:checked').attr('json'));
    $('#bawas6-nip_menerima').val(data.nip);
    $('#bawas6-pangkat_menerima').val(data.pangkat_penandatangan);
    $('#bawas6-nama_menerima').val(data.nama_penandatangan);
    $('#bawas6-jabatan_menerima').val(data.jabatan_penandatangan);
    $('#bawas6-golongan_menerima').val(data.golongan_penandatangan);
    
    $('#menerima').modal('hide');
});

$(document).on('hidden.bs.modal','#terlapor,#penyampai,#Saksi', function (e) {
  $(this).find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();

});

$(document).on('click','#Mtambah_saksi',function(){
    // $('#Saksi').modal({backdrop: 'static', keyboard: false});
    var data=JSON.parse($('.selection_one_saksi:checked').attr('json'));
    var asal=$('#asal').val();
    if(asal=='saksi1'){
        if(data.peg_nip_baru!=$('#bawas6-nip_saksi2').val()){
            $('#bawas6-nama_saksi1').val(data.nama);
            $('#bawas6-nip_saksi1').val(data.peg_nip_baru);
            $('#bawas6-nrp_saksi1').val(data.peg_nrp);
            $('#bawas6-pangkat_saksi1').val(data.gol_pangkat2);
            $('#bawas6-golongan_saksi1').val(data.gol_kd);
            $('#bawas6-jabatan_saksi1').val(data.jabatan);
        }else{
            bootbox.alert({
                    message:"Saksi Sudah ada",
                    size:'small'
                });
        }
    }else{
        if(data.peg_nip_baru!=$('#bawas6-nip_saksi1').val()){
            $('#bawas6-nama_saksi2').val(data.nama);
            $('#bawas6-nip_saksi2').val(data.peg_nip_baru);
            $('#bawas6-nrp_saksi2').val(data.peg_nrp);
            $('#bawas6-pangkat_saksi2').val(data.gol_pangkat2);
            $('#bawas6-golongan_saksi2').val(data.gol_kd);
            $('#bawas6-jabatan_saksi2').val(data.jabatan);
        }else{
            bootbox.alert({
                    message:"Saksi Sudah ada",
                    size:'small'
                });
        }
    }
     $('#Saksi').modal('hide');
  });

$(document).on('click','#add_saksi1',function(){
   $('#asal').val('saksi1');
});

$(document).on('click','#add_saksi2',function(){
   $('#asal').val('saksi2');
});


    
}
</script>