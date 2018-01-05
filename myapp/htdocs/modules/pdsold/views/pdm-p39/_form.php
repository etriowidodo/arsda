<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmP39;
use app\modules\pdsold\models\VwTerdakwaT2;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditorAsset;
CKEditorAsset::register($this);

/* @var $this View */
/* @var $model PdmP39 */
/* @var $form ActiveForm2 */
?>

<div class="box-header"></div>

<?php
$form = ActiveForm::begin(
[
    'id' => 'p39-form',
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'enableAjaxValidation' => false,
    'fieldConfig' => [
        'autoPlaceholder' => false
    ],
    'formConfig' => [
        'deviceSize' => ActiveForm::SIZE_SMALL,
        'labelSpan' => 1,
        'showLabels' => false
    ]
]);
?>

<div class="content-wrapper-1">
    <div class="pdm-p30-form">
        <div class="row">
            <div class="col-md-12">
                <div class="row" style="height: 45px">
                    <div class="col-md-12">
                        <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=> '_p39']) ?>
                    </div>
                </div>
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <h4 class="box-title">
                            Susunan Persidangan
                        </h4>
                        <br/>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Agenda Persidangan</label>
                                        <div class="col-sm-8">
                                            <?php echo $form->field($model, 'no_agenda')->dropDownList(
                                                ArrayHelper::map($agenda,'no_agenda', 'acara_sidang_ke'), 
                                                ['prompt' => '--- Pilih ---', 'class' => 'cmb_agenda']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="content-wrapper-1 hide">
                            <div class="row" style="height: 45px">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">
                                                Majelis Hakim
                                            </h3>
                                            <br/>
                                            <table id="table_grid_surat1" class="table table-bordered table-striped">
                                                <thead>
                                                    <!--<th></th>-->
                                                    <th style="width: 20%"></th>
                                                    <th style="width: 77%"></th>
                                                </thead>
                                                <tbody id="tbody_grid_surat1">
                                                    <?php if(!$model->isNewRecord){ ?>
                                                        <?php// foreach($majelis1 as $value): ?>
                                                        <?php for($i=0; $i < count($majelis1);$i++){ ?>
                                                        <tr>
                                                            <!--<td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>-->
                                                            <td width="20%"><textarea name="txt_nama_surat1[]" id=""  type='textarea' class='form-control'><?=$majelis1[$i]?></textarea></td>
                                                            <td width="20%"><textarea name="txt_nama_surat1_1[]" id=""  type='textarea' class='form-control'><?=$majelis2[$i]?></textarea></td>
                                                        </tr>
                                                        <?php }?>
                                                    <?php }else{ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">
                                                Panitera
                                            </h3>
                                            <br/>
                                            <table id="table_grid_surat2" class="table table-bordered table-striped">
                                                <thead>
                                                    <!--<th></th>-->
                                                    <th style="width: 20%"></th>
                                                    <th style="width: 77%"></th>
                                                </thead>
                                                <tbody id="tbody_grid_surat2">
                                                    <?php if(!$model->isNewRecord){ ?>
                                                        <?php// foreach($majelis1 as $value): ?>
                                                        <?php for($i=0; $i < count($panitera1);$i++){ ?>
                                                        <tr>
                                                            <!--<td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>-->
                                                            <td width="20%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'><?=$panitera1[$i]?></textarea></td>
                                                            <td width="20%"><textarea name="txt_nama_surat2_2[]" id=""  type='textarea' class='form-control'><?=$panitera2[$i]?></textarea></td>
                                                        </tr>
                                                        <?php }?>
                                                    <?php }else{ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="height: 45px">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">
                                                Penuntut Umum
                                            </h3>
                                            <br/>
                                            <table id="table_grid_surat3" class="table table-bordered table-striped">
                                                <thead>
                                                    <!--<th></th>-->
                                                    <th style="width: 100%"></th>
                                                    <!--<th style="width: 77%"></th>-->
                                                </thead>
                                                <tbody id="tbody_grid_surat3">
                                                        <?php foreach ($jaksap16a as $rowjaksap16a) { ?>
                                                        <tr>
                                                            <!--<td style="height: 70px"><input type='checkbox' name='new_check1[]' class='hapusSuratCheck1'></td>-->
                                                            <td width="20%"><textarea name="txt_nama_surat3[]" id=""  type='textarea' class='form-control'><?=$rowjaksap16a[nama]?></textarea></td>
                                                            <!--<td width="20%"><textarea name="txt_nama_surat3_3[]" id=""  type='textarea' class='form-control'><?//$majelis2[$i]?></textarea></td>-->
                                                        </tr>
                                                        <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">
                                                Penasehat Hukum
                                            </h3>
                                            <br/>
                                            <table id="table_grid_surat4" class="table table-bordered table-striped">
                                                <thead>
                                                    <!--<th></th>-->
                                                    <th style="width: 20%"></th>
                                                    <th style="width: 77%"></th>
                                                </thead>
                                                <tbody id="tbody_grid_surat4">
                                                    <?php if(!$model->isNewRecord){ ?>
                                                        <?php// foreach($majelis1 as $value): ?>
                                                        <?php for($i=0; $i < count($penasehat1);$i++){ ?>
                                                        <tr>
                                                            <!--<td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>-->
                                                            <td width="20%"><textarea name="txt_nama_surat4[]" id=""  type='textarea' class='form-control'><?=$penasehat1[$i]?></textarea></td>
                                                            <td width="20%"><textarea name="txt_nama_surat4_4[]" id=""  type='textarea' class='form-control'><?=$penasehat2[$i]?></textarea></td>
                                                        </tr>
                                                        <?php }?>
                                                    <?php }else{ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <br/>
                        <div class="content-wrapper-1 hide">
                            <div class="row" style="height: 45px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2">Jalan Persidangan</label>
                                            <div class="col-sm-9">
                                                <?php //echo $form->field($model, 'uraian_sidang')->textarea(['placeholder' => 'Jalan Persidangan','class'=>'ckeditor','id'=>'uraiansidang']); ?>
                                                <?php echo $form->field($model, 'uraian_sidang')->textarea(['placeholder' => 'Jalan Persidangan','id'=>'uraiansidang']) ?>
                                                <?php
                                                $this->registerCss("div[contenteditable] {
                                                        outline: 1px solid #d2d6de;
                                                        min-height: 100px;
                                                    }");
                                                $this->registerJs("
                                                        CKEDITOR.inline( 'PdmP39[uraian_sidang]');
                                                        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                        CKEDITOR.config.autoParagraph = false;

                                                    ");
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="height: 45px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2">Pengunjung Sidang</label>
                                            <div class="col-sm-9">
                                                <?php// echo $form->field($model, 'pengunjung')->textarea(['placeholder' => 'Pengunjung','class'=>'ckeditor','id'=>'pengunjung']); ?>
                                                <?php echo $form->field($model, 'pengunjung')->textarea(['placeholder' => 'Pengunjung','id'=>'pengunjung']) ?>
                                                <?php
                                                $this->registerCss("div[contenteditable] {
                                                        outline: 1px solid #d2d6de;
                                                        min-height: 100px;
                                                    }");
                                                $this->registerJs("
                                                        CKEDITOR.inline( 'PdmP39[pengunjung]');
                                                        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                        CKEDITOR.config.autoParagraph = false;

                                                    ");
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="height: 45px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2">Kesimpulan</label>
                                            <div class="col-sm-9">
                                                <?php// echo $form->field($model, 'kesimpulan')->textarea(['placeholder' => 'Kesimpulan','class'=>'ckeditor','id'=>'kesimpulan']); ?>
                                                <?php echo $form->field($model, 'kesimpulan')->textarea(['placeholder' => 'Kesimpulan','id'=>'kesimpulan']) ?>
                                                <?php
                                                $this->registerCss("div[contenteditable] {
                                                        outline: 1px solid #d2d6de;
                                                        min-height: 100px;
                                                    }");
                                                $this->registerJs("
                                                        CKEDITOR.inline( 'PdmP39[kesimpulan]');
                                                        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                        CKEDITOR.config.autoParagraph = false;

                                                    ");
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="height: 45px">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2">Pendapat</label>
                                            <div class="col-sm-9">
                                                <?php// echo $form->field($model, 'pendapat')->textarea(['placeholder' => 'Pendapat','class'=>'ckeditor','id'=>'pendapat']); ?>
                                                <?php echo $form->field($model, 'pendapat')->textarea(['placeholder' => 'Pendapat','id'=>'pendapat']) ?>
                                                <?php
                                                $this->registerCss("div[contenteditable] {
                                                        outline: 1px solid #d2d6de;
                                                        min-height: 100px;
                                                    }");
                                                $this->registerJs("
                                                        CKEDITOR.inline( 'PdmP39[pendapat]');
                                                        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                        CKEDITOR.config.autoParagraph = false;

                                                    ");
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>



                <div class="box box-primary" style="border-color: #f39c12">
                    <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Upload File</label>
                                    <div class="col-md-6">
                                        <?php
                                        $preview = "";
                                        if($model->file_upload!=""){
                                            /*$preview = ["<a href='".$model->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                                         ];*/
                                            echo '<object width="150px" height="200px" data="'.$model->file_upload.'"></object>';
                                        }
                                        echo FileInput::widget([
                                            'name' => 'attachment_3',
                                            'id'   =>  'filePicker',
                                            'pluginOptions' => [
                                                'showPreview' => true,
                                                'showCaption' => true,
                                                'showRemove' => true,
                                                'showUpload' => false,
                                                'initialPreview' =>  $preview
                                            ],
                                        ]);
                                        ?>
                                        
                                        
                                        <?= $form->field($model, 'file_upload')->hiddenInput()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel box box-warning">
                    <div class="box-body">
                        <div class="col-md-7 pull-right">
                            <label class="control-label col-md-2" style="padding-right:0;margin-left:7%">Penanda Tangan</label>
                            <div class="col-md-9 pull-right">
                                <?php echo $form->field($model, 'id_penandatangan')->dropDownList(
                                    ArrayHelper::map($jaksap16a,'nip', 'nama'), 
                                    ['prompt' => '--- Pilih ---']);
                                ?>                 
                            </div>
                        </div>
                    </div>
                    <div class="box-body">   
                        <div class="col-md-8 pull-left">   
                            <?= Yii::$app->globalfunc->getTembusan($form,GlobalConstMenuComponent::P39,$this,$model->no_surat_p39, '') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if (!$model->isNewRecord): ?>
                    <a class="btn btn-warning" href="<?= Url::to(['pdm-p39/cetak?id=' .rawurlencode($model->no_surat_p39)]) ?>">Cetak</a>
                    <?php endif ?>	
                </div>
            </div>
        </div>
    </div>
</div>
<?= $form->field($model, 'sidang_ke')->hiddenInput(); ?>
<?php ActiveForm::end(); ?>
    
<?php
$script = <<< JS
        $('.cmb_agenda').change(function(){
                $("#table_grid_surat4 > tbody > tr").remove();
                $("#table_grid_surat1 > tbody > tr").remove();
                $("#table_grid_surat2 > tbody > tr").remove();
                var no_agenda = $(this).val();
                if (no_agenda != ''){
                    $.ajax({
                        type: "POST",
                        url: '/pdsold/pdm-p39/agenda',
                        data: 'no_agenda='+no_agenda,
                        success:function(data){
                            console.log(data);
                            $("#pdmp39-acara_sidang").val(data.acara_sidang);
                            $("#pdmp39-sidang_ke").val(data.sidang_ke);
//                            $("PdmP39[uraian_sidang]").val(data.uraian_sidang);
                            CKEDITOR.instances.uraiansidang.setData(data.uraian_sidang);
                            CKEDITOR.instances.pengunjung.setData(data.pengunjung);
                            CKEDITOR.instances.kesimpulan.setData(data.kesimpulan);
                            CKEDITOR.instances.pendapat.setData(data.pendapat);
//                            CKEDITOR.instances["PdmP39[uraian_sidang]"].val(data.uraian_sidang);
//                            $("#pdmp39-pengunjung").val(data.pengunjung);
//                            $("#pdmp37-kesimpulan").val(data.kesimpulan);
//                            $("#pdmp37-pendapat").val(data.pendapat);
                            var majelis_1   = data.majelis1.toString();
                            var tm          = majelis_1.split("#");
                            var majelis_2   = data.majelis2.toString();
                            var tm_2          = majelis_2.split("#");
                            for (i = 0; i < tm.length-1; i++){
                                $("#table_grid_surat1 > tbody").append("<tr ><td><textarea type='textarea' class='form-control' name='txt_nama_surat1[]'>"+tm[i]+"</textarea></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat1_1[]'>"+tm_2[i]+"</textarea></td></tr>");
                            }
        
                            var penasehat_1 = data.penasehat1.toString();
                            var pns         = penasehat_1.split("#");
                            var penasehat_2 = data.penasehat2.toString();
                            var pns_2       = penasehat_2.split("#");
                            for (i = 0; i < pns.length-1; i++){
                                $("#table_grid_surat4 > tbody").append("<tr ><td><textarea type='textarea' class='form-control' name='txt_nama_surat4[]'>"+pns[i]+"</textarea></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat4_4[]'>"+pns_2[i]+"</textarea></td></tr>");
                            }
                            
        
                            var panitera_1 = data.panitera1.toString();
                            var pnt         = panitera_1.split("#");
                            var panitera_2 = data.panitera2.toString();
                            var pnt_2       = panitera_2.split("#");
                            for (i = 0; i < pnt.length-1; i++){
                                $("#table_grid_surat2 > tbody").append("<tr ><td><textarea type='textarea' class='form-control' name='txt_nama_surat2[]'>"+pnt[i]+"</textarea></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat2_2[]'>"+pnt_2[i]+"</textarea></td></tr>");
                            }
                        }   
                    });
                }
                
            });

    var handleFileSelect = function(evt) {
         var files = evt.target.files;
         var file = files[0];

         if (files && file) {
             var reader = new FileReader();
             // console.log(file);
             reader.onload = function(readerEvt) {
                 var binaryString = readerEvt.target.result;
                 var mime = 'data:'+file.type+';base64,';
                 console.log(mime);
                 document.getElementById('pdmp39-file_upload').value = mime+btoa(binaryString);
                 // window.open(mime+btoa(binaryString));
             };
             reader.readAsBinaryString(file);
         }
     };

     if (window.File && window.FileReader && window.FileList && window.Blob) {
         document.getElementById('filePicker').addEventListener('change', handleFileSelect, false);
     } else {
         alert('The File APIs are not fully supported in this browser.');
     }
        
        
JS;
$this->registerJs($script);
?>
