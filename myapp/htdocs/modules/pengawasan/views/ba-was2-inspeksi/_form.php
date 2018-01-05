<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use app\modules\pengawasan\models\BaWas2InspeksiSearch;
use yii\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\widgets\Pjax;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\db\Query;

$this->title = 'BA.WAS-2 Berita Acara Hasil Wawancara';
$this->params['breadcrumbs'][] = $this->title;
// $this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<?php $form = ActiveForm::begin([
        'id' => 'ba-was2-form',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'autoPlaceholder' => false
        ],
        'formConfig' => [
            'deviceSize' => ActiveForm::SIZE_SMALL,
            'showLabels' => false

        ],
        'options'=>['enctype'=>'multipart/form-data'] ,
    ]); ?>
<div class="ba-was2-index" style="margin-bottom: 10px;">
    <div class="col-md-6" style="padding-left: 0px;margin-top: 10px;">
        <div class="form-group" style="padding-bottom: 30px;">
            <label class="control-label col-sm-4">Tanggal Berita Acara</label>
            <div class="col-sm-8">
                <div class="form-group">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'tgl_ba_was_2',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'pluginOptions' => [
                            'startDate' => date("d-m-Y",strtotime($spwas1['tanggal_mulai_sp_was1'])),
                            'endDate' => 0,
                            'autoclose' => true,
                        ]
                    ]
                ]);
                ?>
                    </div>
                </div>
            </div>                    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Tempat</label>
            <div class="col-sm-8">
                <div class="form-group">
                    <div class="col-sm-12">
                    <?php echo $form->field($model, 'tempat_ba_was_2')->textArea(); ?>
                        <!-- <textarea class="form-control"></textarea> -->
                    </div>
                </div>
            </div>                    
        </div>
    </div>

    <div class="col-md-6" style="padding-right: 0px;padding-bottom: 30px;">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border"> SPRINT</legend>
            <div class="form-group row">
                <label for="inputKey" class="col-md-3 control-label">Nomor</label>
                <div class="col-md-7">
                    <?php echo $form->field($model, 'nomor_sp_was_2')->textInput(['readonly'=>'readonly','value'=>$modelSpWas2['nomor_sp_was2']]); ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputKey" class="col-md-3 control-label">Tanggal</label>
                <div class="col-md-7">
                    <?php echo $form->field($model, 'tanggal_sp_was_2')->textInput(['readonly'=>'readonly','value'=>$modelSpWas2['tanggal_sp_was2']]); ?>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="clearfix"></div>

<!-- tabel Daftar Pemeriksa -->
<div class="judul-tabel">
    <h4 class="pull-left" style="margin-left: 5px;"><strong>Daftar Pemeriksa</strong></h4>
</div>
<div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <div class="btn-toolbar" style="margin-bottom:10px;display: none;">
        <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash">  </i> Hapus</a>
    </div>
    <div id="w0" class="grid-view">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="">
                    <th style="width: 1%;text-align: center;">No</th>
                    <th style="width: 15%;">NIP</th>
                    <th style="width: 10%;">Nama</th>
                    <th style="width: 5%;">Pangakat </th>
                    <th style="width: 10%;">Jabatan </th>
                    <th style="text-align: center;width: 1%;">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no=1;
                    foreach ($modelPemeriksa as $rowPemeriksa) {
                ?>
                <tr>
                    <td style="text-align: center;"><?=$no;?></td>
                    <td><?=$rowPemeriksa['nip_pemeriksa'];?></td>
                    <td><?=$rowPemeriksa['nama_pemeriksa'];?></td>
                    <td><?=$rowPemeriksa['pangkat_pemeriksa'];?></td>
                    <td><?=$rowPemeriksa['jabatan_pemeriksa'];?></td>
                    <td style="text-align: center;"><input type="checkbox" name="ck_pemeriksa" class="ck_pemeriksa"></input></td>
                </tr>
                <?php
                $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- tabel Daftar Pemeriksa -->

<!-- Daftar Saksi Yang Diwawancara (Saksi Internal) -->
<div class="judul-tabel">
    <h4 class="pull-left" style="margin-left: 5px;"><strong>Daftar Saksi Yang Diwawancara (Saksi Internal)</strong></h4>
</div>
<div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <div class="btn-toolbar" style="margin-bottom:10px;display: none;">
        <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash">  </i> Hapus </a>
    </div>
    <div id="w0" class="grid-view">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="">
                    <th style="width: 2%;text-align: center;">No</th>
                    <th style="width: 10%;">Nama</th>
                    <th style="width: 10%;">Pangkat</th>
                    <th style="width: 5%;">NIP/NRP</th>
                    <th style="width: 15%;">Jabatan</th>
                    <th style="width: 15%;">Pangkat</th>
                    <!-- <td style="text-align: center;width: 1%;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td> -->
                    <th style="width: 1%;text-align: center;">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no=1;
                foreach ($modelSaksiIn as $rowSaksiIn) {
                ?>
                <tr>
                    <td style="text-align: center;"><?=$no?></td>
                    <td><?=$rowSaksiIn['nama_saksi_internal']?></td>
                    <td><?=$rowSaksiIn['pangkat_saksi_internal']?></td>
                    <td><?=$rowSaksiIn['nip'].($rowSaksiIn['nrp']==''?'':'/'.$rowSaksiIn['nrp'])?></td>
                    <td><?=$rowSaksiIn['jabatan_saksi_internal']?></td>
                    <td><?=$rowSaksiIn['pangkat_saksi_internal']?></td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
                <?php
                $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Daftar Saksi Yang Diwawancara (Saksi Internal) -->

<!-- Daftar Saksi Yang Diwawancara (Saksi Eksternal) -->
<div class="judul-tabel">
    <h4 class="pull-left" style="margin-left: 5px;"><strong>Daftar Saksi Yang Diwawancara (Saksi Eksternal)</strong></h4>
</div>
<div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <div class="btn-toolbar" style="margin-bottom:10px;display: none;">
        <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash">  </i> Hapus </a>
    </div>
    <div id="w0" class="grid-view">
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="">
                    <th style="width: 2%;text-align: center;">No</th>
                    <th style="width: 10%;">Nama</th>
                    <th style="width: 15%;">TTL</th>
                    <th style="width: 5%;">Kewarganegaraan</th>
                    <th style="width: 20%;">Alamat</th>
                    <th style="width: 5%;">Agama</th>
                    <th style="width: 5%;">Pekerjaan</th>
                    <!-- <td style="text-align: center;width: 1%;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td> -->
                    <th style="width: 1%;text-align: center;">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modelSaksiEk as $rowSaksiEk) {
                ?>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">1</td>
                    <td><?=$rowSaksiEk['nama_saksi_eksternal']?></td>
                    <td><?=$rowSaksiEk['tempat_lahir_saksi_eksternal'].($rowSaksiEk['tanggal_lahir_saksi_eksternal']==''?'':','.\Yii::$app->globalfunc->ViewIndonesianFormat($rowSaksiEk['tanggal_lahir_saksi_eksternal']))?></td>
                    <td>Indonesia</td>
                    <td><?=$rowSaksiEk['alamat_saksi_eksternal']?></td>
                    <td>Islam</td>
                    <td><?=$rowSaksiEk['pekerjaan_saksi_eksternal']?></td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Daftar Saksi Yang Diwawancara (Saksi Eksternal) -->

<!-- Hasil Wawancara -->
<div class="judul-tabel">
    <h4 class="pull-left" style="margin-left: 5px;"><strong>Hasil Wawancara</strong></h4>
</div>
<div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <div class="btn-toolbar" style="margin-bottom:10px;">
        <a class="btn btn-primary btn-sm pull-right" id="tambah_pertanyaan"><i class="glyphicon glyphicon-plus">  </i> Tambah </a>
    </div>
    <div id="w0" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="">
                    <th style="width: 1%;text-align: center;">No</th>
                    <th style="width: 98%;">Hasil Wawancara</th>
                    <!-- <td style="text-align: center;width: 1%;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td> -->
                    <th style="width: 1%;text-align: center;">Pilih</th>
                </tr>
            </thead>
            <tbody id="tbody_pertanyaan">
                <?php if(!$model->isNewRecord){ 
                    $no=1;
                    foreach ($modelKesimpulan as $rowKesimpulan) {
                ?>
                    <tr>
                        <td><?=$no?></td>            
                        <td><textarea class="form-control" name="pertanyaan[]" rows="2"><?=$rowKesimpulan['kesimpulan_ba_was_2']?></textarea></td>            
                        <td><a class="btn btn-primary btn-sm hapus_pertanyaan" rel="" type="button" style="margin-left:-10%;" id="hapus_pertanyaan"><i class="glyphicon glyphicon-trash"></i></a></td>            
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
<!-- Hasil Wawancara -->
<div class="col-md-12" style="padding:0px;">
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
                            echo $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan", "data-backdrop"=>"static", "data-keyboard"=>"false"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly']);
                          }else{
                            echo $form->field($model, 'nip_penandatangan',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-primary cari_ttd', "data-toggle"=>"modal", "data-target"=>"#penandatangan"]),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['readonly'=>'readonly']);
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
                              echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                            }else{
                              echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
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
                            echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                          }else{
                            echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                            echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                          }
                          ?>
                    </div>
                </div>
            </div>
          </div>
         </div>
      </div>


<div class="clearfix"></div>

<?php 
    if(!$model->isNewRecord){
?>

<div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
    <label>Unggah Berkas Ba-WAS-2 :
        <?php if (substr($model->file_ba_was_2,-3)!='pdf'){?>
            <?= ($model['file_ba_was_2']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&id_ba_was2='.$model['id_ba_was2'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
        <?php } else{?>
            <?= ($model['file_ba_was_2']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&id_ba_was2='.$model['id_ba_was2'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
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

<hr style="border-color: #c7c7c7;margin: 10px 0;">

    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
      <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'simpan']) ?>
      <?php
      if (!$model->isNewRecord) {
        echo Html::a('<i class="fa fa-print"></i> Cetak', ['/pengawasan/ba-was2-inspeksi/cetak', 'id_ba_was2' => $model->id_ba_was2], ['id' => 'cetak','class' => 'btn btn-primary']);
       // echo " ".Html::a('<i class ="fa fa-times"></i> Hapus', ['/pengawasan/ba-was3/hapus', 'id' => $model->id_sp_was1], ['id' => 'hapusSpwas2', 'class' => 'btn btn-primary']);
      }
      
       echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Kembali', ['/pengawasan/ba-was2-inspeksi/index'], ['id' => 'KembaliBaWas2', 'class' => 'btn btn-primary']);
       ?>
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
                            $searchModelBaWas2Inspeksi = new BaWas2InspeksiSearch();
                            $dataProviderPenandatanganBaWas2Inspeksi = $searchModelBaWas2Inspeksi->searchPenandatangan(Yii::$app->request->queryParams);
                        ?>
                        <div id="w4" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]) ?>
                            <?php
                            echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatanganBaWas2Inspeksi,
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
    fieldset.scheduler-border {
        border: 1px solid #ddd;
        margin: 0;
        padding: 10px;
    }
    legend.scheduler-border {
        border-bottom: none;
        width: inherit;
        margin: 0;
        padding: 0px 5px;
        font-size: 14px;
        font-weight: bold;
    }
    .judul-tabel h4{
        border-bottom: 2px solid #73a8de;
    }
</style>

<script type="text/javascript">
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

window.onload = function () {
    $(document).on('click','a.hapus_pertanyaan', function(){
            $(this).closest('tr').remove();
            // $('.'+x).remove();
        });
    $(document).on('click','a#tambah_pertanyaan', function(){
            $('#tbody_pertanyaan').append('<tr class=\"rows\">'+
                '<td class=\"no\"></td>'+
                '<td><textarea class="form-control" name="pertanyaan[]" rows="2"></textarea></td>'+

                '<td style=\"width: 1%;text-align: center;\"><a class="btn btn-primary btn-sm hapus_pertanyaan" rel="" type="button" style="margin-left:-10%;" id="hapus_pertanyaan"><i class="glyphicon glyphicon-trash"></i></a></td></tr>');
        i = 0;
        $('#tbody_pertanyaan').find('.rows').each(function () {

        i++;
        $(this).addClass('rows'+i);
        $(this).find('.hapus_pertanyaan').attr('rel','rows'+i);
        // $(this).find('.cekbok').val(i);
        }); 

        });

    $(document).on('click','#tambah_penandatangan',function() {
    var data=JSON.parse($(".selection_one:checked").attr("json"));
       $('#bawas2inspeksi-nip_penandatangan').val(data.nip);
       $('#bawas2inspeksi-nama_penandatangan').val(data.nama);
       $('#bawas2inspeksi-jabatan_penandatangan').val(data.nama_jabatan);
       $('#bawas2inspeksi-golongan_penandatangan').val(data.gol_kd);
       $('#bawas2inspeksi-pangkat_penandatangan').val(data.gol_pangkat2);
       $('#bawas2inspeksi-jbtn_penandatangan').val(data.jabtan_asli);
       $('#penandatangan').modal('hide');
                                
    });

/*////////////reload grid penandatangan surat/////////////////*/
     $(document).on('click','.cari_ttd',function() { 
      $('#grid-penandatangan_surat').addClass('loading');
        $("#grid-penandatangan_surat").load("/pengawasan/ba-was2-inspeksi/getttd",function(responseText, statusText, xhr)
            {
                if(statusText == "success")
                         $('#grid-penandatangan_surat').removeClass('loading');
                if(statusText == "error")
                        alert("An error occurred: " + xhr.status + " - " + xhr.statusText);
            });
      });

      $(document).on("#Mpenandatangan-tambah-grid").on('pjax:send', function(){
          $('#grid-penandatangan_surat').addClass('loading');
      }).on('pjax:success', function(){
          $('#grid-penandatangan_surat').removeClass('loading');
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

<style type="text/css">

/*Penandatangan-id-grid*/
#grid-penandatangan_surat.loading {overflow: hidden;}
#grid-penandatangan_surat.loading .modal-loading-new {display: block;}

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