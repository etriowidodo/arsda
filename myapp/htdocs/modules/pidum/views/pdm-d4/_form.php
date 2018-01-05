<?php

use app\components\ConstDataComponent;
use app\modules\pidum\models\PdmD4;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\VwPenandatangan;
use app\modules\pidum\models\PdmPkTingRef;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\web\Response;

/* @var $this View */
/* @var $model PdmD4 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-d4-form">

    <?php //echo '<pre>';print_r($modelSpdp);exit;
    $form = ActiveForm::begin(
                    [
                        'id' => 'd4-form',
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
                    ]
    );
    ?>
    <div class="box box-warning">
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">No Sprint</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'no_surat')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Dikeluarkan</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'dikeluarkan')->textInput(['maxlength' => true]) ?>
                    </div>
                    <label class="control-label col-md-2">Tanggal</label>
                    <div class="col-md-4">
                        <?=
                        $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                //'options' => [
                                //    'placeholder' => 'Tanggal Dikeluarkan',
                                //],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                //'endDate' => '+1y'
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">
                DITUJUKAN KEPADA
            </h3>
            <hr style="border-color: #c7c7c7;margin: 10px 0;">
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Jaksa Penuntut Umum</label>
                    <div class="col-md-4">
                        <?=
                        $form->field($model, 'nama_jaksa', [
                            'addon' => [
                                'append' => [
                                    'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                    'asButton' => true
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" style="margin:0px;padding:0px;">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    ACUAN PUTUSAN
                </h3>
                <hr style="border-color: #c7c7c7;margin: 10px 0;">
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Keputusan</label>
                        <div class="col-md-8">
                            <?php switch ($putusan->status_yakum){
                                        case 1:
                                            $pengadilan = 'Pengadilan Tinggi';
                                            break;
                                        case 2:
                                            $pengadilan = 'Mahkamah Agung RI';
                                            break;
                                        default:
                                            $pengadilan = 'Pengadilan Negeri';
                                            break;
                                    }?>
                            <input type="text" value="<?= $pengadilan ?>" class="form-control" disabled="true">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">No Surat Putusan</label>
                        <div class="col-md-8">
                            <?= $form->field($putusan, 'no_surat')->textInput(['readOnly' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" disabled value="<?= Yii::$app->globalfunc->ViewIndonesianFormat($putusan->tgl_dikeluarkan)?>" >
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tindak Pidana</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" disabled value="<?= PdmPkTingRef::findOne($modelSpdp->id_pk_ting_ref)->nama ?>" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6" style="margin:0px;padding:0px;">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    ISI PERINTAH
                </h3>
                <hr style="border-color: #c7c7c7;margin: 10px 0;">
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php
                                $listData = PdmMsStatusData::findAll(['is_group' => ConstDataComponent::LunasiD1, 'flag'=>1]);
                                $new = array();
                                foreach ($listData as $key) {
                                    $new = $new + [$key->id => $key->nama];
                                }
                                echo $form->field($model, 'id_msstatusdata')
                                        //->radioList($new);
                                        ->radioList($new, ['inline' => false]);
                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jumlah Biaya (Rp.)</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'nilai')->textInput(['readonly'=>true]) ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pembayaran Kepada Kasubag bin Kejari</label>
                        <div class="col-md-8">
                            <?php  //$form->field($model, 'bayar_kepada') ?>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

     <?= $form->field($model, 'nip_jaksa')->hiddenInput() ?>
     <?= $form->field($model, 'jabatan_jaksa')->hiddenInput() ?>
     <?= $form->field($model, 'pangkat_jaksa')->hiddenInput() ?>




    
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
            <div class="box-body">
                <div class="col-md-7 pull-right">

                    <label class="control-label col-md-2" style="padding-right:0;margin-left:7%">Penanda Tangan</label>
                    <div class="col-md-9 pull-right">
                        <?php
                        //CMS_PIDUM04_P16_02 #dropdown penandatangan yang di tampilkan jabatannya #06062016
                        echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nip_baru','jabatan','id_penandatangan')  ?> 
                        <input type="hidden" name="hdn_nama_penandatangan" id="hdn_nama_penandatangan" value="<?= $model->nama_ttd ?>" />
                        <input type="hidden" name="hdn_pangkat_penandatangan" id="hdn_pangkat_penandatangan" value="<?= $model->pangkat_ttd ?>"/>
                        <input type="hidden" name="hdn_jabatan_penandatangan" id="hdn_jabatan_penandatangan" value="<?= $model->jabatan_ttd ?>"/>
                        <div></div><span class="input-group-addon icon-arrow"><i class="fa fa-fw fa-ellipsis-h"></i></span>                   
                    </div>
                </div>
            </div>

    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-d4/cetak?no_surat='.$model->no_surat]) ?>">Cetak</a>
        <?php endif ?>	
    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Penuntut Umum',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>

<?php
$script = <<< JS
$("input[name='PdmD4[id_msstatusdata]']").on('change', function(){
    var kode = $(this).val();

    $.ajax({
        type: "POST",
        url: '/pidum/pdm-d4/uang',
        data: {kode: kode, no_putusan: '$putusan->no_surat'},
        success:function(data){
            //console.log(data.nilai);
            $('#pdmd4-nilai').val(data.nilai);
           
        }
    });
    
})

JS;

$this->registerJs($script);
?>

<?php $arrow =  'http://'.$_SERVER['HTTP_HOST'].'/image/elips.png';?>
   <?php

$this->registerJs(\yii\web\View::POS_BEGIN);
$js1 = <<< JS

$('#m_tanda_tangan').insertAfter($('form'));
id_select = $('select[peg_nip_baru=jabatan]').attr('id');
     $('#'+id_select).css('cursor','pointer');
     $('#'+id_select).css('pointer-events','pointer');
     $('#'+id_select).css('-webkit-appearance','none');
     $('#'+id_select).css('-moz-appearance','none');
     $('#'+id_select).css('text-indent','1px');
     $('#'+id_select).css('text-overflow','');
     $('#'+id_select).parent().addClass('input-group');
     $('.icon-arrow').css('cursor','pointer');
     $('.icon-arrow').insertAfter($('#'+id_select));

$('select[peg_nip_baru=jabatan],.icon-arrow').on('click',function(){
    id = $('select[peg_nip_baru=jabatan]').attr('id');
    $('#'+id+' option').hide();
    $('#m_tanda_tangan').html('');
    $('#m_tanda_tangan').load('/pidum/default/popup-penanda-tangan');
    $('#m_tanda_tangan').modal('show');
    $('#m_tanda_tangan').appendTo("body").modal('show');
});


JS;
$this->registerJs($js1);
?>
<?php
//ActiveForm::end(); 
Modal::begin([
    'id' => 'm_tanda_tangan',
    'header' => '<h7>Data Tersangka</h7>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
Modal::end();
?>