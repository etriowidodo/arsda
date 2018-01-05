<?php

use app\models\KpPegawaiSearch;
use app\modules\pengawasan\models\VPejabatPimpinan;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use app\modules\pengawasan\models\BaWas9Search;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\db\Query;
use app\models\LookupItem;

use yii\widgets\Pjax;
use yii\grid\GridView;
?>

<div class="ba-was9-form">
<?php
$form = ActiveForm::begin(
    [
        'id' => 'ba-was9-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'action' => $model->isNewRecord ? Url::toRoute('ba-was9/create') : Url::toRoute('ba-was9/update?id=' . $model->id_ba_was_9),
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
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal BA.WAS-9</label>
                        <div class="col-md-8">
                            <?php
                                $connection = \Yii::$app->db;
                                $sql="select*from was.ba_was_7 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
                                $bawas7=$connection->createCommand($sql)->queryOne();
                            ?>

                            <?= $form->field($model, 'tgl_ba_was_9',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'startDate' => date("d-m-Y",strtotime($bawas7['tgl_ba_was_7'])),
                                    'endDate' => '0day',
                                    'autoclose' => true,
                                ]
                            ]
                        ])->label(false) ?>
                             
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal BA.WAS-7</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'tanggal_pemberitahuan_ba')->textInput(['maxlength' => true,'readonly'=>true])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
			<div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tempat</label>
								<div class="col-md-8">
										<?= $form->field($model, 'tempat')->textInput()->label(false);?>
								</div>
                        </div>
                    </div> 
                </div>
            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nama Terlapor</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'nama_terlapor',[
											'addon' => [
												'append' => [
													'content' => Html::button('Pilih', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#terlapor"]),
													'asButton' => true
												]
											]
										])->textInput(['readonly'=>'readonly'])->label(false);?>
                        </div>
						<?//= $form->field($model, 'sk')->hiddenInput(['maxlength' => true,])->label(false) ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pasal Pelanggaran</label>
                        <div class="col-md-8">
                            <!-- <input id="pasal" class="form-control" name="pasal" type="text" readonly> -->
                             <?= $form->field($model, 'sk')->textInput(['readonly'=>true])->label(false);?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding-top: 15px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Petugas Yang Menerima Surat Pernyataan </div>
                        <div class="panel-body">
                            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Nama</label>
										<div class="col-md-8">
												<?= $form->field($model, 'nama_menerima',[
													'addon' => [
														'append' => [
															'content' => Html::button('Pilih', ['class'=>'btn btn-primary cari_terima', "data-toggle"=>"modal", "data-target"=>"#penerima"]),
															'asButton' => true
														]
													]
												])->textInput(['readonly'=>'readonly'])->label(false);?>
										</div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">NIP/NRP</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'nip_menerima')->textInput(['readonly'=>'readonly'])->label(false);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Pangkat</label>
                                        <div class="col-md-8">
											<?= $form->field($model, 'pangkat_menerima')->textInput(['readonly'=>'readonly'])->label(false);?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Jabatan</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'jabatan_menerima')->textInput(['readonly'=>'readonly'])->label(false);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php  if (!$model->isNewRecord){ ?>  
                <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                    <label>Unggah Berkas WAS-9 : 
                         <?php if (substr($model->upload_file,-3)!='pdf'){?>
                            <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_ba_was_9'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                        <?php } else{?>
                            <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['id_ba_was_9'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
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
		<div class="form-group" style="text-align: center;">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['ba-was9/index'])?>"><i class="fa fa-arrow-left"></i> Batal</a> 
        </div>
            <?= $form->field($model, 'nip_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
			<?= $form->field($model, 'nrp_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
            <?= $form->field($model, 'jabatan_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
            <?= $form->field($model, 'golongan_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
            <?= $form->field($model, 'pangkat_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
            <?= $form->field($model, 'id_terlapor')->hiddenInput(['maxlength' => true,])->label(false) ?>
            <?= $form->field($model, 'golongan_menerima')->hiddenInput(['maxlength' => true,])->label(false) ?>
            <?= $form->field($model, 'nrp_menerima')->hiddenInput(['maxlength' => true,])->label(false) ?>
    </div>
</section>
            <?= $form->field($model, 'pelanggaran')->hiddenInput(['maxlength' => true,])->label(false) ?>
<?php ActiveForm::end(); ?>
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
                            $searchModelbawas9 = new BaWas9Search();
                            $dataProviderTerlapor = $searchModelbawas9->searchTerlapor(Yii::$app->request->queryParams);
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
                                        'attribute'=>'nip_terlapor',
                                    ],


                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_terlapor',
                                    ],

                                    ['label'=>'Pangkat Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'pangkat_terlapor',
                                    ],

                                    ['label'=>'Jabatan Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_terlapor',
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
                                        <button class="btn btn-default browse" type="submit" data-placement="left" title="Cari Penerima"><i class="fa fa-search"> Cari </i></button>
                                    </span>
                                  </div>
                              </div>
                            </div>
                          </div>
                          <?php ActiveForm::end(); ?>
                    </p>
                        <div class="box box-primary" id="grid-penerima_surat" style="padding: 15px;overflow: hidden;">
                        <?php
                            $searchModelbawas9penerima = new BaWas9Search();
                            $dataProviderPenerima = $searchModelbawas9penerima->searchPenerima(Yii::$app->request->queryParams);
                        ?>
                        <div id="w0" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenerima-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenerima','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenerima,
                               
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'header'=>'No',
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'peg_nip_baru',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan',
                                    ],

                                    /* ['label'=>'Jabatan Sebenarnya',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabtan_asli',
                                    ], */

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
                    <button type="button" class="btn btn-default" id="tambah_penerima">Tambah</button>
                </div>
            </div>
        </div>
	</div>

<style type="text/css">

#grid-penerima_surat.loading {overflow: hidden;}
#grid-penerima_surat.loading .modal-loading-new {display: block;}

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
<script>
	$(document).ready(function(){
		// $('#bawas9-tgl_ba_was_9').datepicker(); 
	});
	
	$(document).on('click','#tambah_terlapor',function() {
    var data=JSON.parse($(".selection_one:checked").attr("json"));
       $('#bawas9-nama_terlapor').val(data.nama_terlapor);  
       $('#bawas9-nip_terlapor').val(data.nip_terlapor);  
       $('#bawas9-nrp_terlapor').val(data.peg_nrp);  
       $('#bawas9-jabatan_terlapor').val(data.jabatan_terlapor);  
       $('#bawas9-pangkat_terlapor').val(data.pangkat_terlapor);  
       $('#bawas9-golongan_terlapor').val(data.golongan_terlapor);  
       $('#bawas9-id_terlapor').val(data.id_terlapor);  
       $('#bawas9-sk').val(data.sk);  
       $('#bawas9-tanggal_pemberitahuan_ba').val(data.tgl_ba_was_7); 
       $('#bawas9-pelanggaran').val(data.pelanggaran); 
       // $('#pasal').val(data.pasal);  
       $('#terlapor').modal('hide');
                                
    });
	
	$(document).on('click','#tambah_penerima',function() {
    var data=JSON.parse($(".selection_onex:checked").attr("json"));
       $('#bawas9-nip_menerima').val(data.peg_nip_baru);
       $('#bawas9-nama_menerima').val(data.nama);
       $('#bawas9-jabatan_menerima').val(data.jabatan);
       $('#bawas9-pangkat_menerima').val(data.gol_pangkat);
       $('#bawas9-nrp_menerima').val(data.peg_nrp);
       $('#bawas9-golongan_menerima').val(data.gol_kd);
       $('#penerima').modal('hide');
                                
    });

     /*/////////PENANDATANGAN LOADING GRID//////////////*/
    $(document).on("#Mpenerima-tambah-grid").on('pjax:send', function(){
      $('#grid-penerima_surat').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penerima_surat').removeClass('loading');
    });

    $(document).on('click','.cari_terima',function() { 
      $('#grid-penerima_surat').addClass('loading');
        $("#grid-penerima_surat").load("/pengawasan/ba-was8/getttd",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penerima_surat').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

     $(document).on('hidden.bs.modal','#penerima', function (e) {
      $(this)
        .find("input[name=cari_penerima]")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();

    });
</script>
