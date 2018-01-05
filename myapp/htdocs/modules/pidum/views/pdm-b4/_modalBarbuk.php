<?php
/**
 * Created by PhpStorm.
 * User: citraprana
 * Date: 10/9/15
 * Time: 4:05 PM
 */
use app\components\ConstDataComponent;
use app\modules\pidum\models\PdmMsSatuan;
use app\modules\pidum\models\PdmMsStatusData;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>

<script>
    function tambahBarbuk(){
        var e = document.getElementById("satuan_barbuk");
        var satuan = e.options[e.selectedIndex].text;

        var d = document.getElementById("kondisi_barbuk");
        var kondisi = d.options[d.selectedIndex].text;

        $('#tbody_barbuk').append(
            '<tr id="row">' +
                '<td style="text-align: center"><input type="checkbox" name="chkHapusBarbuk" class="chkHapusBarbuk"></td>' +
                '<td><input type="hidden" class="form-control idbarbuk" name="idBarbuk[]" readonly="true" value="">' +
                '<input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="'+$("#nm_barbuk").val()+'"></td>' +
                '<td><input type="text" class="form-control" name="pdmBarbukJumlah[]" readonly="true" value="'+$("#jml_barbuk").val()+'"></td>' +
                '<td><input type="hidden" class="form-control" name="pdmBarbukSatuan[]" readonly="true" value="'+$("#satuan_barbuk").val()+'">' +
                '<input type="text" class="form-control" name="txtBarbukSatuan" readonly="true" value="'+satuan+'"></td>' +
                '<td><input type="text" class="form-control" name="pdmBarbukSitaDari[]" readonly="true" value="'+$("#sita_barbuk").val()+'"></td>' +
                '<td><input type="text" class="form-control" name="pdmBarbukTindakan[]" readonly="true" value="'+$("#tmpt_simpan_barbuk").val()+'"></td>' +
                '<td><input type="hidden" class="form-control" name="pdmBarbukKondisi[]" readonly="true" value="'+$("#kondisi_barbuk").val()+'">' +
                '<input type="text" class="form-control" name="txtBarbukKondisi" readonly="true" value="'+kondisi+'"></td>' +
                '</tr>'
        );
        $('#m_barbuk').modal('hide');
    }
</script>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1 form-horizontal">
        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-bottom:none;">
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Nama Barang
                        </label>

                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group field-nama-barbuk">
                                        <?= Html::textarea('nama_barbuk','',['class'=>'form-control','id'=>'nm_barbuk']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Jumlah
                        </label>

                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group field-jumlah">
                                        <?= Html::input('text','jumlah_barbuk','',['class'=>'form-control','id'=>'jml_barbuk']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Satuan
                        </label>

                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group field-satuan">
                                        <?= Html::dropDownList('satuan_barbuk','', ArrayHelper::map(PdmMsSatuan::find()->asArray()->all(),'id','nama'),['class'=>'form-control','id'=>'satuan_barbuk','prompt'=>'Pilih Satuan']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Di Sita
                        </label>

                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group field-disita">
                                        <?= Html::input('text','sita_barbuk','',['class'=>'form-control','id'=>'sita_barbuk']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Tempat Simpan
                        </label>

                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group field-tmpt-simpan-barbuk">
                                        <?= Html::input('text','tmpt_simpan_barbuk','',['class'=>'form-control','id'=>'tmpt_simpan_barbuk']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Kondisi
                        </label>

                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group field-kodisi-barbuk">
                                        <?= Html::dropDownList('kondisi_barbuk','',ArrayHelper::map(PdmMsStatusData::find()->where('is_group=:is_group',[':is_group'=>ConstDataComponent::KondisiBarang])->all(),'id','nama'),['class'=>'form-control','id'=>'kondisi_barbuk','prompt'=>'Pilih Kondisi']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
            <?= Html::buttonInput('Simpan', ['class' => 'btn btn-warning','onClick'=>'tambahBarbuk()']); ?>
        </div>
    </div>
</section>