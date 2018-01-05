<?php

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
use app\modules\pengawasan\models\BaWas4Search;


use app\models\LookupItem;

?>

<div class="bawas4-form">

  <?php $form = ActiveForm::begin([
        'id' => 'ba-was4-form',
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

 <div class="box box-primary">
    <div class="box-body" style="padding:20px;">
        <div class="col-md-12">
            <div class="col-md-6">
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
				 <div class="col-md-6">
		
                 </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tempat Lahir</label>
                    <div class="col-md-8">
                       <?= $form->field($model, 'tempat_lahir_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal Lahir</label>
                    <div class="col-md-8">
                       <?= $form->field($model, 'tanggal_lahir_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Kewarganegaraan</label>
                    <div class="col-md-8">
                       <?= $form->field($model, 'id_warganegara')->textInput(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">agama</label>
                    <div class="col-md-8">
                       <?= $form->field($model, 'id_agama_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Pendidikan</label>
                    <div class="col-md-8">
                       <?= $form->field($model, 'pendidikan')->textInput(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Alamat</label>
                    <div class="col-md-10">
                       <?= $form->field($model, 'alamat_saksi_eksternal')->textArea(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
            <!-- <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Kewarganegaraan</label>
                    <div class="col-md-8">
                       <?//= $form->field($model, 'nama_kota_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div> -->
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Kota</label>
                    <div class="col-md-8">
                       <?= $form->field($model, 'nama_kota_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Pekerjaan</label>
                    <div class="col-md-8">
                       <?= $form->field($model, 'pekerjaan_saksi_eksternal')->textInput(['readonly'=>'readonly'])?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal</label>
                    <div class="col-md-6">
                       <?= $form->field($model, 'tanggal',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]]);?>
                    </div>
                </div>
                 <div class="col-md-6">
        
                 </div>
            </div>
           
        </div>
               
				
				
			
            <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas Ba-WAS-4 :
                    <?php if (substr($model->upload_file,-3)!='pdf'){?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&id_was10='.$model['id_surat_was10'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['upload_file']!='' ? '<a href="viewpdf?id='.$model['no_register'].'&id_was10='.$model['id_surat_was10'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
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

        <div class="col-md-12" style="padding:0px;">
            <div class="panel panel-primary">
                <div class="panel-heading">Hasil Permintaan Keterangan</div>
                    <div class="panel-body">
                        <div class="btn-toolbar">
                        <?php //if ($model->isNewRecord) { ?>
		                   <a class="btn btn-primary btn-sm pull-right" type="button" style="margin-left:-10%;" id="tambah_pertanyaan"><i class="glyphicon glyphicon-plus">  </i> Tambah</a>
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
    				echo '<tr data-id="'.$rowhasil['id_ba_was_4_detail'].'" id="trpertanyaan"'.$rowhasil['id_ba_was_4_detail'].'""></td>';
    				echo '<td align="center"> '.$i++.'</td>';
    				echo '<td><input type="hidden" class="form-control" name="pertanyaan[]" readonly="true" value="'.$rowhasil['pernyataan'].'">'.$rowhasil['pernyataan'].'</td>';
    				
    				echo '<td></td>';
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
<!--=====================================================3-->

			
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="clearfix"></div>

    <div class="box-footer" style="margin:0px;padding:0px;background:none;">
      <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
	  <input type="hidden" name="print" value="0" id="print"/>
      <?php
      if (!$model->isNewRecord) {
        echo Html::a('<i class="fa fa-print"></i> Cetak', ['/pengawasan/ba-was4/cetak', 'id_ba_was_4' => $model->id_ba_was4], ['id' => 'cetak','class' => 'btn btn-primary']);
       // echo " ".Html::a('<i class ="fa fa-times"></i> Hapus', ['/pengawasan/ba-was3/hapus', 'id' => $model->id_sp_was1], ['id' => 'hapusSpwas2', 'class' => 'btn btn-primary']);
      }
      
       echo " ".Html::a('<i class ="fa fa-arrow-left"></i> Batal', ['/pengawasan/ba-was4/index'], ['id' => 'KembaliBaWas4', 'class' => 'btn btn-primary']);
	   ?>
    </div>
    
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>

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
                            $searchModelBaWas4 = new Bawas4Search();
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
$('#bawas4-tanggal').datepicker();
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/

$(function () {
        $("#bawas4-nama_saksi").change(function () {
		var id=$(this).val();
			var tempat=$('#tempat_lahir_saksi_eksternal').val();
			var tgl=$('#tanggal_lahir_saksi_eksternal').val();
			var warga=$('#warga_saksi_eksternal').val();
			var agama=$('#agama_saksi_eksternal').val();
			var pendidikan=$('#pendidikan_saksi_eksternal').val();
			var kota=$('#kota_asal_saksi_eksternal').val();
			var alamat=$('#alamat_saksi_eksternal').val();
			var pekerjaan=$('#pekerjaan_saksi_eksternal').val();
			
			$('#bawas4-tmpt_lahir').val(tempat);
			$('#bawas4-tgl_lahir-disp').val(tgl);
			$('#bawas4-warga').val(warga);
			$('#bawas4-agama').val(agama);
			$('#bawas4-pendidikan').val(pendidikan);
			$('#bawas4-kota').val(kota);
			$('#bawas4-alamat').val(alamat);
			$('#bawas4-pekerjaan').val(pekerjaan);
			

        });
    });
	
	window.onload = function () {
     	$(document).on('click','#tambah_saksiEk', function(){
                var data=JSON.parse($('.selection_one:checked').attr('json'));
                // alert(data.id_warganegara);
                $('#bawas4-nama_saksi_eksternal').val(data.nama_saksi_eksternal);
                $('#bawas4-alamat_saksi_eksternal').val(data.alamat_saksi_eksternal);
                $('#bawas4-nama_kota_saksi_eksternal').val(data.nama_kota_saksi_eksternal);
                $('#bawas4-tanggal_lahir_saksi_eksternal').val(data.tanggal_lahir_saksi_eksternal);
                $('#bawas4-tempat_lahir_saksi_eksternal').val(data.tempat_lahir_saksi_eksternal);
                $('#bawas4-id_agama_saksi_eksternal').val(data.id_agama_saksi_eksternal);
                $('#bawas4-id_warganegara').val(data.id_warganegara);
                $('#bawas4-pendidikan').val(data.pendidikan);
                $('#bawas4-pekerjaan_saksi_eksternal').val(data.pekerjaan_saksi_eksternal);
                $('#bawas4-nama_saksi_eksternal').val(data.nama_saksi_eksternal);
                $('#SaksiEk').modal('hide');
            });

        $(document).on('click','a#hapus_pertanyaan', function(){
    			var x=$(this).attr('rel');
    			$('.'+x).remove();
    		});
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