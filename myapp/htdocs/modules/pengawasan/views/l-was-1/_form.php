<?php

use app\models\LookupItem;
use app\modules\pengawasan\models\LWas1;
use app\modules\pengawasan\models\LWas1Search;

use kartik\datecontrol\DateControl;
use yii\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;
use yii\widgets\ActiveForm as ActiveForm2;
// use yii\widgets\ActiveForm;


/* @var $this View */
/* @var $model LWas1 */
/* @var $form ActiveForm2 */
?>

<?php


$form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'l-was-1-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ]
        ]);
?>
<section class="content" style="padding: 0px;margin-top: 20px;">
    <div class="content-wrapper-1">
        <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading single-project-nav">
                    <ul class="nav nav-tabs"> 
                        <li class="active">
                            <a href="#permasalahan" data-toggle="tab">Permasalahan</a>
                        </li>
                        <li>
                            <a href="#data" data-toggle="tab">Data</a>
                        </li>
                        <li>
                            <a href="#analisa" data-toggle="tab">Analisa</a>
                        </li>
                        <li>
                            <a href="#kesimpulan" data-toggle="tab">Kesimpulan</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="permasalahan">
                            <!-- <textarea name="editor1" id="editor1">Permasalahan</textarea> -->
                            <?= $form->field($model, 'permasalahan_lwas1')->textarea(['class'=>'ckeditor','rows' => 3]) ?>
                        </div>
                        <div class="tab-pane fade" id="data">
                            <!-- <textarea name="editor2" id="editor2">Data</textarea> -->
                            <?= $form->field($model, 'data_lwas1')->textarea(['class'=>'ckeditor','rows' => 3]) ?>
                        </div>
                        <div class="tab-pane fade" id="analisa">
                            <!-- <textarea name="editor3" id="editor3">Analisa</textarea> -->
                            <?= $form->field($model, 'analis_lwas1')->textarea(['class'=>'ckeditor','rows' => 3]) ?>
                        </div>
                        <div class="tab-pane fade" id="kesimpulan">
                            <!-- <textarea name="editor4" id="editor4">Kesimpulan</textarea> -->
                            <?= $form->field($model, 'pendapat')->textarea(['class'=>'ckeditor','rows' => 3]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding:0px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Daftar Terlapor</div>
                        <div class="panel-body">
                            <!-- <div class="col-md-12"> -->
                                <?//= $form->field($model, 'pendapat')->textarea(['class'=>'ckeditor','rows' => 3]) ?>
                            <!-- </div> -->
                            <br>
                             <div class="btn-toolbar" style="margin-bottom:10px">
                              <a class="btn btn-danger btn-sm pull-right" id="tidak_lanjut"><i class="glyphicon glyphicon-trash"> </i> Tidak Ditandak Lanjuti</a>
                              <a class="btn btn-primary btn-sm pull-right" id="lanjut"><i class="glyphicon glyphicon-plus">  </i> Tindak Lanjuti</a>&nbsp;
                            </div>
            
                            <!-- <div class="box-header with-border"> -->
                            <?php

                            // $searchModel = new LWas1Search();
                            // $dataProvider = $searchModel->searchPemeriksaLwas1($_SESSION['was_register']);
                            ?>
                            <?php Pjax::begin(['id' => 'Mpemeriksa-grid', 'timeout' => false,'formSelector' => '#searchFormTerlapor','enablePushState' => false]) ?>
                                <?= GridView::widget([
                                'dataProvider'=> $dataProvider,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    ['label'=>'Nip',
                                        'format'=>'raw',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'value' => function ($data) {
                                               
                                                // return '<input type="text" name="nip" vlaue="'.$data['nip'].'">'; 
                                                return $data['nip'].'<input type="hidden" name="nip[]" value="'.$data['nip'].'">'; 
                                        },   
                                    ],

                                    
                                    ['label'=>'Nama',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pegawai_terlapor',
                                    ],

                                    ['label'=>'Golongan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'golongan_pegawai_terlapor',
                                    ],

                                    ['label'=>'Pangkat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'pangkat_pegawai_terlapor',
                                    ],

                                    ['label'=>'Jabatan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabatan_pegawai_terlapor',
                                    ],  

                                    ['label'=>'Saran',
                                        'format'=>'raw',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'contentOptions'=>['class'=>'keputusan'],
                                        'attribute'=>'saran',
                                    ],   

                                    ['class' => 'yii\grid\CheckboxColumn',
                                       'checkboxOptions' => function ($data) {
                                        $result=json_encode($data);
                                        return ['value' => $data['nip'],'class'=>'selection_one','json'=>$result];
                                        },
                                    ],
                                    
                                 ],   

                            ]); ?>
                            <?php Pjax::end(); ?>
                          <!-- </div> -->

                        </div>
                </div>
            </div>
            <?php if(!$model->isNewRecord){ ?>
            <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas L-WAS-1 :
                    <?php if (substr($model->file_lwas1,-3)!='pdf'){?>
                        <?= ($model['file_lwas1']!='' ? '<a href="viewpdf?id='.$model['id_l_was_1'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-image-o"></i></span></a>' :'') ?>
                    <?php } else{?>
                        <?= ($model['file_lwas1']!='' ? '<a href="viewpdf?id='.$model['id_l_was_1'].'" target="_blank"><span style="cursor:pointer;font-size:28px;"><i class="fa fa-file-pdf-o"></i></span></a>' :'') ?> 
                    <?php } ?>
                </label>
                <!-- <input type="file" name="file_lwas1" /> -->
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <span class="btn btn-primary btn-file fa fa-folder-open"><span class="fileupload-new"> Browse </span>
                <span class="fileupload-exists "> Rubah File</span>         <input type="file" name="file_lwas1" id="file_lwas1" /></span>
                <span class="fileupload-preview"></span>
                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
            </div>
            </div>
            <?php
            }
            ?>
      
            <div class="box-footer" style="margin:0px;padding:0px;background:none;">
                <?php echo Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> Simpan' : '<i class="fa fa-save"></i> Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
                <input type="hidden" name="print" value="0" id="print"/>
                <!-- <input name="action" type="submit" value="Cetak" class="btn btn-primary" id="cetak"/> -->
                <?php echo Html::a('<i class="fa fa-print"></i> Cetak', ['/pengawasan/l-was-1/printlwas', 'id_l_was_1' => $model->id_l_was_1], ['class' => 'btn btn-primary']);?>
            </div>
                           
    </div>
</section>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
window.onload=function(){
    $('#lanjut, #tidak_lanjut').addClass('disabled');

    $(document).on('click','#tidak_lanjut',function(){
        $('.selection_one:checked').closest('tr').find('.keputusan').html('Tidak Ditindak Lanjuti'+'<input type="hidden" name="keputusan[]" value="1">');
    });

    $(document).on('click','#lanjut',function(){
        $('.selection_one:checked').closest('tr').find('.keputusan').html('Tindak Lanjuti'+'<input type="hidden" name="keputusan[]" value="2">');
    });
    $(document).on('change','.select-on-check-all',function() {
        var c = this.checked ? true : false;
        if(c==true){
            $('tbody tr').addClass('danger');
        }else{
            $('tbody tr').removeClass('danger');
        }

        $('.selection_one').prop('checked',c);
        var x=$('.selection_one:checked').length;
        ConditionOfButton(x);
    });
            
    $(document).on('change','.selection_one',function() {
        var c = this.checked ? '#f00' : '#09f';
        if(c=='#f00'){
            $(this).closest('tr').addClass('danger');
        }else{
            $(this).closest('tr').removeClass('danger');
        }
        var x=$('.selection_one:checked').length;
        ConditionOfButton(x);
    });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#lanjut, #tidak_lanjut').removeClass('disabled');
                } else if(n > 1){
                   $('#lanjut, #tidak_lanjut').removeClass('disabled');
                   // $('#lanjut').addClass('disabled');
                } else{
                   $('#lanjut, #tidak_lanjut').addClass('disabled');
                }
        }
}
/*js upload*/
!function(e){var t=function(t,n){this.$element=e(t),this.type=this.$element.data("uploadtype")||(this.$element.find(".thumbnail").length>0?"image":"file"),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||n.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=e('<input type="hidden" />'),this.$element.prepend(this.$hidden)),this.$preview=this.$element.find(".fileupload-preview");var r=this.$preview.css("height");this.$preview.css("display")!="inline"&&r!="0px"&&r!="none"&&this.$preview.css("line-height",r),this.original={exists:this.$element.hasClass("fileupload-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.$remove=this.$element.find('[data-dismiss="fileupload"]'),this.$element.find('[data-trigger="fileupload"]').on("click.fileupload",e.proxy(this.trigger,this)),this.listen()};t.prototype={listen:function(){this.$input.on("change.fileupload",e.proxy(this.change,this)),e(this.$input[0].form).on("reset.fileupload",e.proxy(this.reset,this)),this.$remove&&this.$remove.on("click.fileupload",e.proxy(this.clear,this))},change:function(e,t){if(t==="clear")return;var n=e.target.files!==undefined?e.target.files[0]:e.target.value?{name:e.target.value.replace(/^.+\\/,"")}:null;if(!n){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);if(this.type==="image"&&this.$preview.length>0&&(typeof n.type!="undefined"?n.type.match("image.*"):n.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var r=new FileReader,i=this.$preview,s=this.$element;r.onload=function(e){i.html('<img src="'+e.target.result+'" '+(i.css("max-height")!="none"?'style="max-height: '+i.css("max-height")+';"':"")+" />"),s.addClass("fileupload-exists").removeClass("fileupload-new")},r.readAsDataURL(n)}else this.$preview.text(n.name),this.$element.addClass("fileupload-exists").removeClass("fileupload-new")},clear:function(e){this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(navigator.userAgent.match(/msie/i)){var t=this.$input.clone(!0);this.$input.after(t),this.$input.remove(),this.$input=t}else this.$input.val("");this.$preview.html(""),this.$element.addClass("fileupload-new").removeClass("fileupload-exists"),e&&(this.$input.trigger("change",["clear"]),e.preventDefault())},reset:function(e){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.original.exists?this.$element.addClass("fileupload-exists").removeClass("fileupload-new"):this.$element.addClass("fileupload-new").removeClass("fileupload-exists")},trigger:function(e){this.$input.trigger("click"),e.preventDefault()}},e.fn.fileupload=function(n){return this.each(function(){var r=e(this),i=r.data("fileupload");i||r.data("fileupload",i=new t(this,n)),typeof n=="string"&&i[n]()})},e.fn.fileupload.Constructor=t,e(document).on("click.fileupload.data-api",'[data-provides="fileupload"]',function(t){var n=e(this);if(n.data("fileupload"))return;n.fileupload(n.data());var r=e(t.target).closest('[data-dismiss="fileupload"],[data-trigger="fileupload"]');r.length>0&&(r.trigger("click.fileupload"),t.preventDefault())})}(window.jQuery)
/*end js upload*/
</script>
<style type="text/css">
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
        bottom: -40%;
        right: 50%;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        color: black;
        cursor: pointer;
        border: 1px solid transparent;
        border-radius: 0px;
        background-image: #fff;
    }
    .nav-tabs {
        border-bottom: 0px;
    }
    .nav-tabs>li>a{
        border-radius: 0px;
        color: #fff;
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