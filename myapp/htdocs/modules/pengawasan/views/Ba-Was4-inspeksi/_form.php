<?php

/*use yii\helpers\Html;
use yii\widgets\ActiveForm;*/

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
// use kartik\grid\GridView;
use yii\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;
use kartik\widgets\FileInput;
use app\modules\pengawasan\models\BaWas4InspeksiSearch;

?>


<?php $form = ActiveForm::begin([
        'id' => 'ba-was4-inspeksi-form',
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
                ]
    ]); ?>
<section class="content" style="padding: 0px;">
    <div class="">     
        <div class="box box-primary">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                    <label class="control-label col-md-4">Nama Saksi</label>
                    <div class="col-md-8">
                            <?= $form->field($model, 'nama_saksi_eksternal',[
                                            'addon' => [
                                                'append' => [
                                                    'content' => Html::button('Cari', ['class'=>'btn btn-primary', "data-toggle"=>"modal", "data-target"=>"#SaksiEk", "data-backdrop"=>"static", "data-keyboard"=>"false"]),
                                                    'asButton' => true
                                                ]
                                            ]
                                        ])->textInput()?>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tempat Lahir</label>
                        <div class="col-md-8">
                             <?= $form->field($model, 'tempat_lahir_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Lahir</label>
                        <div class="col-md-8">
                             <?= $form->field($model, 'tanggal_lahir_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                        </div>
                    </div>
                </div>
            </div>
             
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kewarganegaraan</label>
                        <div class="col-md-8">
                             <?= $form->field($model, 'negara_eks')->textInput(['readonly'=>'readonly','value'=>$modelSaksiEksternal['negara_eks']]);
                             ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">Agama</label>
                        <div class="col-md-8">
                             <?php
                            // print_r($modelSaksiEksternal);
                             //if(!$model->isNewRecord){
                             echo $form->field($model, 'agama_eks')->textInput(['readonly'=>'readonly','value'=>$modelSaksiEksternal['agama_eks']]);
                             // }
                             ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                             <?= $form->field($model, 'pendidikan_eks')->textInput(['readonly'=>'readonly','value'=>$modelSaksiEksternal['pendidikan_eks']]) 
                             ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label col-md-4">Alamat</label>
                        <div class="col-md-8" style="right:16.6%;width: 66%;">
                            <?= $form->field($model, 'alamat_saksi_eksternal')->textArea(['readonly'=>'readonly'])?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nama Kota</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'nama_kota_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Pekerjaan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'pekerjaan_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Ba.Was-4</label>
                        <div class="col-md-8">
                           <?= $form->field($model, 'tanggal_ba_was_4',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]]);?>
                        </div>
                    </div>
                </div>    
               <div class="col-md-4">     
                    <div class="form-group">
                        <label class="control-label col-md-4">Tempat Ba.Was-4</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'tempat_ba_was_4')->textInput()?>
                        </div>
                    </div>
                </div>
            </div> 

           <?= $form->field($model, 'id_agama_saksi_eksternal')->hiddenInput(['readonly'=>'readonly']) ?> 
           <?= $form->field($model, 'pendidikan_saksi_eksternal')->hiddenInput(['readonly'=>'readonly'])  ?>
           <?= $form->field($model, 'id_negara_saksi_eksternal')->hiddenInput(['readonly'=>'readonly']) ?>
           <?= $form->field($model, 'id_saksi_eksternal')->hiddenInput(['readonly'=>'readonly']) ?>
    </div>
</div>   

<div class="col-md-12" style="padding:0px;">
            <div class="panel panel-primary">
                <div class="panel-heading">Jadwal Kehadiran</div>
                    <div class="panel-body">
                        <div class="btn-toolbar">
                        <?php //if ($model->isNewRecord) { ?>
                           <a class="btn btn-primary btn-sm pull-right" type="button" style="margin-left:-10%;" id="tambah_pertanyaan"><i class="glyphicon glyphicon-plus"> Tambah </i></a>
                        <?php// } else{ ?> 
                          <!-- <a class="btn btn-primary btn-sm pull-right"  style="margin-left:-10%;"   type="button" id="tambah_pertanyaan" data-toggle="modal" data-target="#modal_pertanyaan"><i class="glyphicon glyphicon-pencil"> Ubah </i></a> -->
                        <?php// } ?>
                        </div>


        <!-- </div> -->
            <table id="table_pertanyaan" style="margin-top:3%;" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="4%">No</th>
                        <th width="93%">Pernyataan</th>
                        <th width="3%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody_pertanyaan">
                    <?php
                if(!$model->isNewRecord){
                    $i=1;                   
                    foreach($modelPernyataan as $rowhasil){
                    echo '<tr data-id="'.$rowhasil['id_ba_was4_pernyataan'].'" id="trpertanyaan"'.$rowhasil['id_ba_was4_pernyataan'].'""></td>';
                    echo '<td align="center"> '.$i++.'</td>';
                    echo '<td><input type="hidden" class="form-control" name="pertanyaan[]" readonly="true" 
                        value="'.$rowhasil['pernyataan_ba_was_4'].'">'.$rowhasil['pernyataan_ba_was_4'].'</td>';
                    
                    echo '<td><a class="btn btn-primary btn-sm hapus_pertanyaan" rel="trpertanyaan'.$rowhasil['id_ba_was4_pernyataan'].'" type="button" style="margin-left:-10%;" id="hapus_pertanyaan"><i class="glyphicon glyphicon-trash"></i></a></td>';
                    echo '</tr>';
                    } 
                            }
                    ?>
                </tbody>
            </table>
<!-- </fieldset>   
  </div>
</div> -->
                </div>
        </div>
    </div> 
<?php
      if (!$model->isNewRecord) {
?>        
<div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
    <label>Unggah Berkas Ba-WAS-4 Inspeksi :
        <?php if (substr($model->file_ba_was_4,-3)!='pdf'){?>
            <?= ($model['file_ba_was_4']!='' ? '<a href="viewpdf?id='.$model['id_ba_was4'].'&id_was4='.$model['id_ba_was4'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
        <?php } else{?>
            <?= ($model['file_ba_was_4']!='' ? '<a href="viewpdf?id='.$model['id_ba_was4'].'&id_was4='.$model['id_ba_was4'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
        <?php } ?>
    </label>
    <!-- <input type="file" name="upload_file" /> -->
    <div class="fileupload fileupload-new" data-provides="fileupload">
    <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
    <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="file_ba_was_4" id="file_ba_was_4" /></span>
    <span class="fileupload-preview"></span>
    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
</div>
</div> 
<?php } ?>
<!-- <hr style="border-color: #c7c7c7;margin: 10px 0;"> -->

    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
     
      <input type="hidden" name="print" value="0" id="print"/>
    
    </div>
    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
      <button type="submit" id="simpan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
      <?php
      echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Batal', ['/pengawasan/ba-was4-inspeksi/index'], ['id' => 'Batal', 'class' => 'btn btn-primary']);
      if (!$model->isNewRecord) {
            echo " ".Html::a('<i class ="fa fa-print"></i> Cetak', ['/pengawasan/ba-was4-inspeksi/cetak', 'id' => $model->id_ba_was4], ['id' => 'hapusBaWas3', 'class' => 'btn btn-primary']);
      }
       ?>
       <!-- <a id="KembaliBaWas4" class="btn btn-primary" href="/pengawasan/ba-was4/index"><i class="fa fa-arrow-left"></i> Kembali</a>    </div>      -->
  </div>
</div>

<!--=====================================================3-->

            

    </div>

    </div> 
</section>  

<div class="modal fade" id="SaksiEk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                      'id'=>'searchFormSaksiEk', 
                                      'options'=>['name'=>'searchFormSaksiEk'],
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
                            $searchModelBaWas4 = new Bawas4InspeksiSearch();
                            $dataProvider = $searchModelBaWas4->searchSaksiEk(Yii::$app->request->queryParams);
                        ?>
                        <div id="w0" class="grid-view">
                            <?php Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormSaksiEk','enablePushState' => false]) ?>
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
                                    

                                    ['label'=>'Nama Saksi Eksternal',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_saksi_eksternal',
                                    ],

                                    ['label'=>'Alamat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'alamat_saksi_eksternal',
                                    ],

                                    ['label'=>'Kota',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_kota_saksi_eksternal',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_saksi_eksternal'],'class'=>'selection_one','json'=>$result];
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
                    <button type="button" class="btn btn-default" id="tambah_saksiEk">Tambah</button>
                </div>
            </div>
        </div>
</div>

<style type="text/css">
    div.form-group::after {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 5px;
    }

    .box {
        position: relative;
        border-radius: 4px;
        background: #ffffff;
        border-top: 3px solid #d2d6de;
        margin-bottom: 20px;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        padding-top: 10px;
        padding-bottom: 10px;
        padding-inline-end: inherit;
        padding-inline-start: inherit;
        padding-block-end: inherit;
        after: 10px;
    }
</style>
<style type="text/css">
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
$('#bawas4inspeksi-tanggal_ba_was_4').datepicker();
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

$(function () {
        $("#bawas4inspeksi-nama_saksi").change(function () {
            var id=$(this).val();
            var tempat=$('#tempat_lahir_saksi_eksternal').val();
            var tgl=$('#tanggal_lahir_saksi_eksternal').val();
            var warga=$('#id_negara_saksi_eksternal').val();
            var agama=$('#id_agama_saksi_eksternal').val();
            var pendidikan=$('#pendidikan_saksi_eksternal').val();
            var kota=$('#nama_kota_saksi_eksternal').val();
            var alamat=$('#alamat_saksi_eksternal').val();
            var pekerjaan=$('#pekerjaan_saksi_eksternal').val();
            
            $('#bawas4inspeksi-tmpt_lahir').val(tempat);
            $('#bawas4inspeksi-tgl_lahir-disp').val(tgl);
            $('#bawas4inspeksi-warga').val(warga);
            $('#bawas4inspeksi-agama_eks').val(agama);
            $('#bawas4inspeksi-pendidikan').val(pendidikan);
            $('#bawas4inspeksi-kota').val(kota);
            $('#bawas4inspeksi-alamat').val(alamat);
            $('#bawas4inspeksi-pekerjaan').val(pekerjaan);
            

        });
    });

// {"id_tingkat":"0","id_kejati":"00","id_kejari":"00","id_cabjari":"00","no_register":"Reg00190","id_sp_was2":1,"id_surat_was9":2,"id_saksi_internal":null,"id_saksi_eksternal":1,"id_wilayah":1,"id_level1":6,"id_level2":8,"id_level3":2,"id_level4":1,"nomor_surat_was9":"","tanggal_was9":"2017-08-24","perihal_was9":"test","lampiran_was9":"1","jenis_saksi":"Eksternal","nip_penandatangan":"195708071985031001","hari_pemeriksaan_was9":"Kamis","tanggal_pemeriksaan_was9":"2017-08-24","jam_pemeriksaan_was9":"15:20:00","tempat_pemeriksaan_was9":"test","nama_penandatangan":"Prof. Dr. R WIDYO PRAMONO, S.H., M.M., M.Hum.","pangkat_penandatangan":"","golongan_penandatangan":"","jabatan_penandatangan":"Jaksa Agung Muda Pengawasan","was9_file":null,"nomor_sp_was":null,"sifat_was9":1,"zona_waktu":"0","jbtn_penandatangan":"Jaksa Agung Muda PENGAWASAN","id_pemeriksa":2,"nip_pemeriksa":"198802072009122001","nrp_pemeriksa":"51088287","nama_pemeriksa":"IRA AFNESIA, A.Md.","pangkat_pemeriksa":"Sena Darma TU","golongan_pemeriksa":"II\/d","jabatan_pemeriksa":"Operator Komputer PERDATA DAN TATA USAHA NEGARA","di_was9":"test","trx_akhir":1,"created_by":6,"created_ip":"::1","created_time":"2017-07-24 09:15:22","updated_by":6,"updated_ip":"::1","updated_time":"2017-08-09 04:52:01","nama_saksi_eksternal":"asep sunardi","tempat_lahir_saksi_eksternal":"jkarta","tanggal_lahir_saksi_eksternal":"2000-07-19","id_negara_saksi_eksternal":16,"pendidikan":5,"id_agama_saksi_eksternal":4,"alamat_saksi_eksternal":"asdasd","nama_kota_saksi_eksternal":"aceh","pekerjaan_saksi_eksternal":"PNS","id_warganegara":null,"lokasi_saksi_eksternal":null,"is_inspektur_irmud_riksa":null}
    window.onload = function () {
        $(document).on('click','#tambah_saksiEk', function(){
                var data=JSON.parse($('.selection_one:checked').attr('json'));
                // alert(data.id_warganegara);
                $('#bawas4inspeksi-nama_saksi_eksternal').val(data.nama_saksi_eksternal);
                $('#bawas4inspeksi-alamat_saksi_eksternal').val(data.alamat_saksi_eksternal);
                $('#bawas4inspeksi-tanggal_lahir_saksi_eksternal').val(data.tanggal_lahir_saksi_eksternal);
                $('#bawas4inspeksi-tempat_lahir_saksi_eksternal').val(data.tempat_lahir_saksi_eksternal);
                $('#bawas4inspeksi-id_agama_saksi_eksternal').val(data.id_agama_saksi_eksternal);
                $('#bawas4inspeksi-id_negara_saksi_eksternal').val(data.id_negara_saksi_eksternal);
                $('#bawas4inspeksi-pendidikan_saksi_eksternal').val(data.pendidikan);
                $('#bawas4inspeksi-pekerjaan_saksi_eksternal').val(data.pekerjaan_saksi_eksternal);
                $('#bawas4inspeksi-nama_kota_saksi_eksternal').val(data.nama_kota_saksi_eksternal);
                $('#bawas4inspeksi-negara_eks').val(data.negara_eks);
                $('#bawas4inspeksi-agama_eks').val(data.agama_eks);
                $('#bawas4inspeksi-pendidikan_eks').val(data.pendidikan_eks);
                $('#bawas4inspeksi-id_saksi_eksternal').val(data.id_saksi_eksternal);
                $('#SaksiEk').modal('hide');
            });
        
        $(document).on('click','#hapus_pertanyaan',function() {
          var x=$(this).attr('rel');
          $(this).closest('tr').remove();
        });

        // $(document).on('click','a#hapus_pertanyaan', function(){
        //         var x=$(this).attr('rel');
        //         alert(x);
        //         $('.'+x).remove();
        //     });

        $(document).on('click','a#tambah_pertanyaan', function(){
                $('#tbody_pertanyaan').append('<tr class=\"rows\">'+
                    '<td class=\"no\"></td>'+
                    '<td><textarea class="form-control" name="pertanyaan[]" rows="2"></textarea></td>'+

                    '<td><a class="btn btn-primary btn-sm hapus_pertanyaan" rel="" type="button" style="margin-left:-10%;" id="hapus_pertanyaan"><i class="glyphicon glyphicon-trash"></i></a></td></tr>');
            i = 0;
            $('#tbody_pertanyaan').find('.rows').each(function () {

            i++;
            $(this).addClass('rows'+i);
            $(this).find('.hapus_pertanyaan').attr('rel','rows'+i);
            // $(this).find('.cekbok').val(i);
            }); 

            });
 }  
</script>