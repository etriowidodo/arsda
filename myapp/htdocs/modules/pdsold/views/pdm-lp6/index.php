<?php

use app\modules\pidsus\models\KpInstSatker;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\VLaporanP6Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'LP-6';
$this->subtitle = 'Laporan Kegiatan Penuntutan';

/*$this->params['breadcrumbs'][] = $this->title;*/
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
            [
                'id' => 'lp6-form',
                'action' => Url::to(['pdm-lp6/cetak/']),
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
                    <strong>CETAK LAPORAN KEGIATAN PENUNTUTAN</strong>
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
                                            <div class="form-group field-vlaporanp6-bulan">
                                                <?php echo Html::dropDownList('bulan', '', [
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
                                                ) ?>
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
                                            <div class="form-group field-vlaporanp6-tahun">
                                                <select class="form-control" name="tahun">
                                                    <option value="">Pilih Tahun</option>
                                                <?php
                                                    $starting_year = date('Y', strtotime('-10 year'));
                                                    $ending_year = date('Y');
                                                    for($ending_year;$ending_year>=$starting_year;$ending_year--) {
                                                        echo '<option value="'. $ending_year .'" >'.$ending_year.'</option>';
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
                <?php /*echo DatePicker::widget([
                    'name' => 'dp_1',
                    'type' => DatePicker::TYPE_INPUT,
                    //'value' => '23-Feb-1982',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'MM-yyyy'
                    ]
                ]); */
                ?>
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