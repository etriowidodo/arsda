<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Was2 */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->registerJs("
    $(document).ready(function(){
         
    $('#addtembusan1').click(function(){
        // alert('ss');
        $('.for_tembusan').append('<div class=\"col-sm-7\" style=\"margin-bottom: 15px;\"><div class=\"col-sm-1\"><input type=\"checkbox\" value=\"\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\" readonly=\"readonly\"></div><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" id=\"pejabat\" name=\"pejabat[]\"></div></div>');
        i = 0;
    $('.for_tembusan').each(function () {
        i++;
        $(this).addClass('no_'+i);
        $(this).find('.cekbok').val(i);
    });
    });

    $('#hapus_tembusan1').click(function(){
        var cek = $('.cekbok:checked').length;
        //alert(cek);
         var checkValues = $('.cekbok:checked').map(function()
            {
                return $(this).val();
            }).get();
            alert(checkValues);
                for (var i = 0; i < cek; i++) {
                    $('.tembusan'+checkValues[i]).remove();
                };
    });


    $('#cetak').click(function(){
          $('#print').val('1');
        });

        $('#simpan').click(function(){
          $('#print').val('0');
        });

}); ", \yii\web\View::POS_END);
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'was3-form',
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
        ]);
        ?>
        <div class="box box-primary">
            <?= Html::hiddenInput('delete_tembusan', null, ['id' => 'delete_tembusan']); ?>
            <?= $form->field($model, 'id_was3')->hiddenInput(['maxlength' => true]) ?>
            <input type="hidden" value="<?php echo $model->no_register ?>" name="Was3[no_register]" class="form-control" id="was3-no_register">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No. Surat</label>
                        <div class="col-md-8" style="padding-top:1%;">
                            <?= $form->field($model, 'no_surat')->textInput()?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="text-align:right; right:2%;">Tanggal</label>
                        <div class="col-md-3" style="margin-left:-26px; padding-top:1%;">
                            <?=
                            $form->field($model, 'was3_tanggal')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                
                                'displayFormat' => 'dd-MM-yyyy',
                                'options' => [
                                    
                                    'pluginOptions' => [

                                        'autoclose' => true,
                                       // 'startDate' => '0',
                                      //  'endDate' => '+5y',
                                    ]
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- xxxxxxxxxxx -->
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Ditujukan Kepada</label>
                        <div class="col-md-8" style="padding-top:1%;">
                            <?php
                                $kpd_was2 = array(); 
                            ?>
                            <?= $form->field($model, 'was3_kepada')->dropDownList(ArrayHelper::map(\app\modules\pengawasan\models\VPejabatPimpinan::find()->where("unitkerja_kd in ('1.1','1.2','1.3','1.4','1.5','1.6')")->all(), 'id_jabatan_pejabat', 'jabatan'), ['prompt' => 'Pilih'])?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="text-align:right; right:2%;">Lampiran</label>
                        <div class="col-md-8" style="margin-left:-26px; padding-top:1%;">
                            <?= $form->field($model, 'was3_lampiran')->textInput()?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label col-md-3" >Perihal</label>
                        <div class="col-md-9">
                           <?php if (!$model->isNewRecord) { 
                             echo $form->field($model, 'was3_perihal')->textArea(['row' => 3]) ;
						}else{
							 echo $form->field($model, 'was3_perihal')->textArea(['value'=>$modelLapdu[0]['perihal_lapdu']]);
						}?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">

                <fieldset class="group-border">
                    <legend class="group-border">Penandatangan</legend>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Nip</label>
                                    <div class="col-md-10">
                                      <?php
                                      /* if(!$model->isNewRecord){
                                          echo $form->field($model, 'nip')->textInput(['readonly'=>'readonly']);
                                        }else{
                                        echo $form->field($model, 'nip')->textInput(['readyonly'=>'readyonly','value'=>$modelPenandatangan[0]['nip']]);
                                        } */
										echo $form->field($model, 'nip_penandatangan')->textInput(['readonly'=>'readonly']);
                                       ?>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary" type="button" id="pilih_bidang_1" data-toggle="modal" data-target="#peg_tandatangan">Pilih</button>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!--<label class="control-label col-md-3">WAS-1</label>-->
                                    <label class="control-label col-md-2">Nama</label>
                                    <div class="col-md-10">
                                      <?php
                                        /* if(!$model->isNewRecord){
                                            echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                                          }else{
                                            echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly','value'=>$modelPenandatangan[0]['nama_pemeriksa']]);
                                          } */
										  echo $form->field($model, 'nama_penandatangan')->textInput(['readonly'=>'readonly']);
                                       ?>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!--<label class="control-label col-md-3">WAS-1</label>-->
                                    <label class="control-label col-md-3">Jabatan</label>
                                    <div class="col-md-9">
                                      <?php
										  echo $form->field($model, 'jabatan_penandatangan')->textInput(['readonly'=>'readonly']);
                                          ?>
                                      <?php
									   echo $form->field($model, 'golongan_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                          ?>

                                         <?php
										   echo $form->field($model, 'pangkat_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                       ?>
									   <?php
										   echo $form->field($model, 'jbtn_penandatangan')->hiddenInput(['readonly'=>'readonly']);
                                       ?>
                                    </div>
                                </div>  
                            </div>
                </fieldset>
            </div>

            <div class="col-md-12 kejaksaan">   
             <label class="control-label col-md-3" style="padding:0px">Unggah File Was-3:</label>
             
             <div class="col-md-1 kejaksaan">
                      <div class="form-group" >
                       <?php if (substr($model['was3_file'],-3)!='pdf'){?>
                         <?= ($model->was3_file!='' ? '<a href="viewpdf?id='.$model['id_was3'].'&id_register='.$model['no_register'].'&id_tingkat='.$model['id_tingkat'].'&id_kejati='.$model['id_kejati'].'&id_kejari='.$model['id_kejari'].'&id_cabjari='.$model['id_cabjari'].'" ><span style="cursor:pointer;font-size:28px;">
                        <i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                        <?php } else{?>
                         <?= ($model->was3_file!='' ? '<a href="viewpdf?id='.$model['id_was3'].'&id_register='.$model['no_register'].'&id_tingkat='.$model['id_tingkat'].'&id_kejati='.$model['id_kejati'].'&id_kejari='.$model['id_kejari'].'&id_cabjari='.$model['id_cabjari'].'" target="_blank"><span style="cursor:pointer;font-size:28px;">
                        <i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> <?php } ?>
                      </div>
             </div>
            </div>
            <div class="col-md-12 kejaksaan">
             <div class="col-md-12 kejaksaan" style="padding:0px">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                    <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="was3_file" id="was3_file" /></span>
                    <span class="fileupload-preview"></span>
                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                </div>  
            </div> 
            </div> 

			
			<div class="col-md-12">
                <fieldset class="group-border">
                    <legend class="group-border">Tembusan</legend>
                    <!-- <div class="col-md-12" style="margin-bottom:10px;"> -->
                    <div class="col-sm-12" style="margin-bottom: 15px">
                        <div class="col-sm-6">
                     <a class="btn btn-primary" id="hapus_tembusan"><span class="glyphicon glyphicon-trash"><i></i></span></a>
                    <a class="btn btn-primary"  id="addtembusan" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span> Tembusan</a>
                        </div>
                    </div>
                    <div class="for_tembusan">
                        <?php 
                    if(!$model->isNewRecord){
                       // print_r($modelTembusan);
                        $no=1;
                        foreach ($modelTembusan as $key) {
                    ?>
                    <div class="col-sm-7" style="margin-bottom: 15px" id="<?= $key['id_tembusan_was']?>">
                        <div class="col-sm-1" style="text-align:center">
                           <input type="checkbox" value="<?= $key['id_tembusan_was']?>" id="cekbok" class="cekbok">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no ?>" size="1" readonly>
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

                          <div class="col-sm-7" style="margin-bottom: 15px" id="<?= $valueTembusanAwal['id_tembusan']?>">
                              <div class="col-sm-1" style="text-align:center">
                                 <input type="checkbox" value="<?= $valueTembusanAwal['id_tembusan']?>" id="cekbok" class="cekbok">
                              </div>
                              <div class="col-sm-2">
                                  <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no_2 ?>" size="1" readonly>
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
                </fieldset>
            </div>
            

            <?//= $form->field($model, 'satuan_lampiran')->hiddenInput() ?>
            <?//= $form->field($model, 'id_terlapor')->hiddenInput() ?>
            <?//= $form->field($model, 'created_ip')->hiddenInput(['maxlength' => true]) ?>

        </div>
            
        <hr style="border-color: #c7c7c7;margin: 10px 0;">  
        <div class="box-footer" style="margin:0px;padding:0px;background:none;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'simpan']) ?>
        <input type="hidden" name="print" value="0" id="print"/>
        <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['was3/cetak?no_register='.$model->no_register.'&id_was3='. $model['id_was3'].'&id_tingkat='. $model['id_tingkat'].'&id_kejati='. $model['id_kejati'].'&id_kejari='. $model['id_kejari'].'&id_cabjari='. $model['id_cabjari']])?>">Cetak</a>       
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
        </div>
<?php ActiveForm::end(); ?>
    </div> 
</section>

<style type="text/css">
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

$(document).on('click','#addtembusan',function() {
    $('.for_tembusan').append('<div class=\"col-sm-7\" style=\"margin-bottom: 15px;\"><div class=\"col-sm-1\" style=\"text-align: center\"><input type=\"checkbox\" value=\"0\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-2\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\" class=\"no_urut\" readonly></div><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" id=\"pejabat\" name=\"pejabat[]\"></div></div>');
        i = 0;
    // $('.for_tembusan').find('.col-sm-7').each(function () {

    //     i++;
    //     $(this).addClass('tembusan'+i);
    //     $(this).find('.cekbok').val(i);
    // });
    });

$(document).on('click','#hapus_tembusan',function() {
     // $('#hapus_tembusan').click(function(){
        // var cek = $('.cekbok:checked').length;
        //  var checkValues = $('.cekbok:checked').map(function()
        //     {
        //         return $(this).val();
        //     }).get();
        //         for (var i = 0; i < cek; i++) {
        //             $('.tembusan'+checkValues[i]).remove();
        //         };
        $('.cekbok:checked').closest('.col-sm-7').remove();
                                
    });


</script>
<?php
Modal::begin([
    'id' => 'peg_tandatangan',
    'size' => 'modal-lg',
    'header' => 'Pilih Pegawai',
]);

echo $this->render('@app/modules/pengawasan/views/global/_dataPegawai', ['param' => 'was3']);

Modal::end();
?>
<?php
Modal::begin([
    'id' => 'tembusan',
    'size' => 'modal-lg',
    'header' => 'Pilih Tembusan',
]);
echo $this->render('@app/modules/pengawasan/views/global/_tembusan', ['param' => 'was3']);
Modal::end();
?>

