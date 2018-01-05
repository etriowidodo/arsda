<?php

use app\modules\pidsus\models\KpInstSatker;
use app\modules\pdsold\models\VwPenandatangan;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;

//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\VLaporanP6Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'LP-7';
$this->subtitle = 'Laporan Rekapitulasi Kegiatan Penuntutan';

/* $this->params['breadcrumbs'][] = $this->title; */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'lp7-form',
                            'action' => Url::to(['pdm-lp7/cetak/']),
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
                        ]
                )
        ?>

        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>CETAK LAPORAN REKAPITULASI KEGIATAN PENUNTUTAN</strong>
                </h3>
            </div>
            <div class="box-header with-border" style="border-bottom:none;">
                <fieldset>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="kv-nested-attribute-block form-sub-attributes form-group">
                                <label class="col-sm-5 control-label"> Wilayah Kerja </label>
                                <div class="col-md-4" style="margin-left: 11px">
                                    <input id="satker" name="wilayah_kerja">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="kv-nested-attribute-block form-sub-attributes form-group">
                                <label class="col-sm-6 control-label"> Bulan </label>
                                <!--div class="col-sm-8"-->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <!--div class="col-sm-12"-->
                                        <div class="col-sm-10">
                                            <div class="form-group field-vlaporanp7-bulan">
                                                <?php
                                                echo Html::dropDownList('bulan', '', [
                                                    '01' => 'Januari',
                                                    '02' => 'Februari',
                                                    '03' => 'Maret',
                                                    '04' => 'April',
                                                    '05' => 'Mei',
                                                    '06' => 'Juni',
                                                    '07' => 'Juli',
                                                    '08' => 'Agustus',
                                                    '09' => 'September',
                                                    '10' => 'Oktober',
                                                    '11' => 'November',
                                                    '12' => 'Desember',
                                                        ], ['prompt' => 'Pilih Bulan', 'class' => 'form-control']
                                                )
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="kv-nested-attribute-block form-sub-attributes form-group">
                                <label class="col-sm-4 control-label"> Tahun </label>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group field-vlaporanp7-tahun">
                                                <select class="form-control" name="tahun">
                                                    <option value="">Pilih Tahun</option>
                                                    <?php
                                                    $starting_year = date('Y', strtotime('-10 year'));
                                                    $ending_year = date('Y');
                                                    for ($ending_year; $ending_year >= $starting_year; $ending_year--) {
                                                        echo '<option value="' . $ending_year . '" >' . $ending_year . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <br>
                <div class="form-group" >
                    <label class="col-sm-2 control-label">Dikeluarkan & Tanggal</label>
                    <div class="col-md-3" style="margin-left:-14px;">
                        <?php echo Html::input('text', 'dikeluarkan', '', ['class' => 'form-control']); ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo DateControl::widget([
                            'name' => 'tgl_dikeluarkan',
                            'type' => DateControl::FORMAT_DATE,
                            'pluginOptions' => [
                                'autoclose' => true,
                            ],
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Dikeluarkan',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <br>
                <div class="kv-nested-attribute-block form-sub-attributes form-group">
                    <label class="col-sm-2 control-label">Penandatangan</label>
                    <div class="col-md-4" style="margin-left:-14px;">
                        <?php
                        echo Html::dropDownList('penandatangan', '', ArrayHelper::map(VwPenandatangan::find()->where('is_active=:is_active', [':is_active' => '1'])->all(), 'peg_nik', 'nama'), ['class' => 'form-control', 'prompt' => '--Pilih Penandatangan--']);
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer">
            <?= Html::submitButton('Cetak', ['class' => 'btn btn-warning']); ?>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>


<?php $satker = $this->context->getSatker(); ?>
<script type="text/javascript">
    var satker = JSON.parse('<?php echo json_encode($satker); ?>');
    console.log(satker);
</script>

<?php
$script = <<< JS
        $("#satker").select2({
            minimumInputLength: 2,
            placeholder: 'Pilih Wilayah Kerja',
            data: satker,
            width: '430',
         });
JS;
$this->registerJs($script);
?>   