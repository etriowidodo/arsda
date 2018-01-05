<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditorAsset;
CKEditorAsset::register($this);
use kartik\widgets\FileInput;

use app\modules\pdsold\models\PdmPenandatangan;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP42 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-header"></div>

<?php
$form = ActiveForm::begin(
[
    'id' => 'pdm-p42-form',
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
    <div class="pdm-p42-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <br/>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Nomor Surat P-42</label>
                                        <div class="col-md-8">  
                                             <?= $form->field($model, 'no_surat_p42') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tanggal Surat</label>
                                        <div class="col-md-4">  
                                             <?= $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                                     'type' => DateControl::FORMAT_DATE,
                                                     'ajaxConversion' => false,
                                                     'options' => [
                                                         'pluginOptions' => [
                                                         'autoclose' => true,
                                                         'startDate'=>''
                                                         ]
                                                     ]
                                                 ]);
                                             ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No. Penetapan Hakim</label>
                                        <div class="col-md-8">  
                                        <?php  echo $form->field($model, 'no_penetapan_hakim')->dropDownList(
                                            ArrayHelper::map($modelhkm,'no_penetapan_hakim', 'no_penetapan_hakim'), 
                                            ['prompt' => '--- Pilih ---']);
                                            
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <br/>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tanggal Baca Surat Tuntutan</label>
                                        <div class="col-md-6">  
                                             <?= $form->field($model, 'tgl_baca_rentut')->widget(DateControl::className(), [
                                                     'type' => DateControl::FORMAT_DATE,
                                                     'ajaxConversion' => false,
                                                     'options' => [
                                                         'pluginOptions' => [
                                                         'autoclose' => true,
                                                         'startDate'=>''
                                                         ]
                                                     ]
                                                 ]);
                                             ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 240px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                Tersangka
                                            </h3>
                                        </div>

                                        

                                        <table id="table_grid_surat1" class="table table-bordered table-striped">
                                            <thead>
                                                <th></th>
                                                <th style="width: 90%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat1">
                                                    <?php// foreach($majelis1 as $value): ?>
                                                    <?php foreach ($modeltsk as $rowmodeltsk) { ?>
                                                    <tr>
                                                        <!--<td style=""><textarea name="txt_nama_surat1_[]" id=""  type='textarea' class='form-control'><?//($i+1)?></textarea></td>-->
                                                        <td style=""><?=($i+1)?></td>
                                                        <!--<td width="20%"><textarea name="txt_nama_surat1[]" id=""  type='textarea' class='form-control'><?//$rowmodeltsk[nama]?></textarea></td>-->
                                                        <td width="20%"><?=$rowmodeltsk[nama]?></td>
                                                    </tr>
                                                    <?php $i++ ;}?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row hide" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                <a class='btn btn-danger delete hapus hapusSurat7'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan7">+ Barang Bukti</a>
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat7" class="table table-bordered table-striped">
                                            <thead>
                                                <th></th>
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat7">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_Barbuk);$i++){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check7[]' class='hapusSuratCheck7'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat7[]" id=""  type='textarea' class='form-control'><?=$ket_Barbuk[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    <?php for($i=0; $i < count($modelbb);$i++){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check7[]' class='hapusSuratCheck7'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat7[]" id=""  type='textarea' class='form-control'><?=$modelbb[$i][nama]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 15px">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Upload File</label>
                                        <div class="col-md-4">  
                                        <?php
                                            $preview = "";
                                            if($model->file_upload!=""){
                                                $preview = ["<a href='".$model->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                                             ];
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
                        <div class="row hide">
                            <div class="col-md-12" style="margin-top: 15px">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Isi Tuntutan</label>
                                        <div class="col-md-9">  
                                        <?// $form->field($model, 'unsur_dakwaan')->textarea() ?>
                                            <?php echo $form->field($model, 'unsur_dakwaan')->textarea() ?>
                                                <?php
                                                $this->registerCss("div[contenteditable] {
                                                        outline: 1px solid #d2d6de;
                                                        min-height: 100px;
                                                    }");
                                                $this->registerJs("
                                                        CKEDITOR.inline( 'PdmP42[unsur_dakwaan]');
                                                        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                        CKEDITOR.config.autoParagraph = false;

                                                    ");
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px" hidden>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                <a class='btn btn-danger delete hapus hapusSurat2'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan2">+ Keterangan Saksi-saksi</a>
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat2" class="table table-bordered table-striped">
                                            <thead>
                                                <th></th>
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat2">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_Saksi);$i++){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'><?=$ket_Saksi[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>
                                                    <td width="98%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px" hidden>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                <a class='btn btn-danger delete hapus hapusSurat3'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan3">+ Keterangan Ahli</a>
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat3" class="table table-bordered table-striped">
                                            <thead>
                                                <th></th>
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat3">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_Ahli);$i++){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check3[]' class='hapusSuratCheck3'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat3[]" id=""  type='textarea' class='form-control'><?=$ket_Ahli[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check3[]' class='hapusSuratCheck3'></td>
                                                    <td width="98%"><textarea name="txt_nama_surat3[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px" hidden>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                <a class='btn btn-danger delete hapus hapusSurat4'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan4">+ Surat</a>
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat4" class="table table-bordered table-striped">
                                            <thead>
                                                <th></th>
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat4">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_Surat);$i++){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check4[]' class='hapusSuratCheck4'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat4[]" id=""  type='textarea' class='form-control'><?=$ket_Surat[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check4[]' class='hapusSuratCheck4'></td>
                                                    <td width="98%"><textarea name="txt_nama_surat4[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px" hidden>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                <a class='btn btn-danger delete hapus hapusSurat5'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan5">+ Petunjuk</a>
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat5" class="table table-bordered table-striped">
                                            <thead>
                                                <th></th>
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat5">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_Petunjuk);$i++){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check5[]' class='hapusSuratCheck5'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat5[]" id=""  type='textarea' class='form-control'><?=$ket_Petunjuk[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check5[]' class='hapusSuratCheck3'></td>
                                                    <td width="98%"><textarea name="txt_nama_surat5[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px" hidden>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                <a class='btn btn-danger delete hapus hapusSurat6'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan6">+ Keterangan Terdakwa</a>
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat6" class="table table-bordered table-striped">
                                            <thead>
                                                <th></th>
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat6">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_Tersangka);$i++){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check6[]' class='hapusSuratCheck6'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat6[]" id=""  type='textarea' class='form-control'><?=$ket_Tersangka[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check6[]' class='hapusSuratCheck6'></td>
                                                    <td width="98%"><textarea name="txt_nama_surat6[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px" hidden>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                <a class='btn btn-danger delete hapus hapusSurat8'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan8">+ Unsur Pasal</a>
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat8" class="table table-bordered table-striped">
                                            <thead>
                                                <th></th>
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat8">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_UnPas);$i++){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check8[]' class='hapusSuratCheck8'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat8[]" id=""  type='textarea' class='form-control'><?=$ket_UnPas[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check8[]' class='hapusSuratCheck8'></td>
                                                        <td width="98%"><textarea name="txt_nama_surat8[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <div class="col-md-12" style="margin-top: 15px">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Unsur Dakwaan</label>
                                        <div class="col-md-8">  
                                        <?// $form->field($model, 'unsur_dakwaan')->textarea() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Uraian</label>
                                        <div class="col-md-8">  
                                        <?= $form->field($model, 'uraian')->textarea() ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px" hidden>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                Memberatkan
<!--                                                <a class='btn btn-danger delete hapus hapusSurat9'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan9">+ Memberatkan</a>-->
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat9" class="table table-bordered table-striped">
                                            <thead>
                                                <!--<th></th>-->
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat9">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_Member);$i++){ ?>
                                                    <tr>
                                                        <!--<td style="height: 70px"><input type='checkbox' name='new_check9[]' class='hapusSuratCheck9'></td>-->
                                                        <td width="98%"><textarea name="txt_nama_surat9[]" id=""  type='textarea' class='form-control'><?=$ket_Member[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    <tr>
                                                        <!--<td style="height: 70px"><input type='checkbox' name='new_check9[]' class='hapusSuratCheck9'></td>-->
                                                        <td width="98%"><textarea name="txt_nama_surat9[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px" hidden>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                            <h3 class="box-title">
                                                Meringankan
<!--                                                <a class='btn btn-danger delete hapus hapusSurat10'></a>
                                                &nbsp;
                                                <a class="btn btn-primary tambah_memperhatikan10">+ Meringankan</a>-->
                                            </h3>
                                        </div>
                                        <table id="table_grid_surat10" class="table table-bordered table-striped">
                                            <thead>
                                                <!--<th></th>-->
                                                <th style="width: 77%"></th>
                                            </thead>
                                            <tbody id="tbody_grid_surat10">
                                                <?php if(!$model->isNewRecord){ ?>
                                                    <?php //foreach($penasehat_hkm as $value): ?>
                                                    <?php for($i=0; $i < count($ket_Mering);$i++){ ?>
                                                    <tr>
                                                        <!--<td style="height: 70px"><input type='checkbox' name='new_check10[]' class='hapusSuratCheck10'></td>-->
                                                        <td width="98%"><textarea name="txt_nama_surat10[]" id=""  type='textarea' class='form-control'><?=$ket_Mering[$i]?></textarea></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    <tr>
                                                        <!--<td style="height: 70px"><input type='checkbox' name='new_check10[]' class='hapusSuratCheck10'></td>-->
                                                        <td width="98%"><textarea name="txt_nama_surat10[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12" style="margin-top: 15px; margin-bottom: 20px;">
                                <div class="col-md-6 pull-right">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Penanda Tangan</label>
                                        <div class="col-md-8">
                                            <?php echo $form->field($model, 'id_penandatangan')->dropDownList(
                                                ArrayHelper::map($jaksap16a,'nip', 'nama'), 
                                                ['prompt' => '--- Pilih ---']);
                                            ?>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="text-align: center; margin-top: 15px">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if (!$model->isNewRecord){ ?>
                    <a class="btn btn-warning" href="<?= Url::to(['pdm-p42/cetak?id=' .rawurlencode($model->no_surat_p42)]) ?>">Cetak</a>
                    <?php }else{ ?>	
                    <a class="btn btn-warning" href="<?= Url::to(['pdm-p42/cetak?id=' .rawurlencode($model->no_surat_p42)]) ?>">Cetak Draft</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<?php
$script1 = <<< JS
        
        
        
        
        var handleFileSelect = function(evt) {
            var files = evt.target.files;
            var file = files[0];

            if (files && file) {
                var reader = new FileReader();
                // console.log(file);
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var mime = "data:"+file.type+";base64,";
                    console.log(mime);
                    document.getElementById("pdmp42-file_upload").value = mime+btoa(binaryString);
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
        
        
        
        
        var id=1;
	$('.tambah_memperhatikan2').on('click', function() {
		$("#table_grid_surat2 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat2[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat2').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check2[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan3').on('click', function() {
		$("#table_grid_surat3 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check3[]' class='hapusSuratCheck3'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat3[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat3').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check3[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan4').on('click', function() {
		$("#table_grid_surat4 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check4[]' class='hapusSuratCheck4'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat4[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat4').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check4[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan5').on('click', function() {
		$("#table_grid_surat5 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check5[]' class='hapusSuratCheck5'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat5[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat5').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check5[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan6').on('click', function() {
		$("#table_grid_surat6 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check6[]' class='hapusSuratCheck6'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat6[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat6').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check6[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        var id=1;
	$('.tambah_memperhatikan7').on('click', function() {
		$("#table_grid_surat7 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check7[]' class='hapusSuratCheck7'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat7[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat7').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check7[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan8').on('click', function() {
		$("#table_grid_surat8 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check8[]' class='hapusSuratCheck8'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat8[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat8').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check8[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan9').on('click', function() {
		$("#table_grid_surat9 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check9[]' class='hapusSuratCheck9'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat9[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat9').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check9[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan10').on('click', function() {
		$("#table_grid_surat10 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check10[]' class='hapusSuratCheck10'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat10[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat10').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check10[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
JS;
$this->registerJs($script1);
?>