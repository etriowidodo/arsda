<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\pidum\models\VwTerdakwaT2;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmRP11 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'rp11-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 2,
                'showLabels' => false

            ]
        ]);
    ?>

    <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
        <div class="col-md-12">
        
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label col-md-4">Status Upaya Hukum</label>
                    <div class="col-sm-6">
                         <?= $form->field($model, 'id_status_yakum')->dropDownList(['0'=>'Pilih Status', '1' => 'Banding', '2' => 'Kasasi']) ?>
                    </div>
                </div>
            </div>

            <div id="kasasi">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label col-md-4">No Kasasi</label>
                        <div class="col-sm-6">
                             <?= $form->field($model, 'no_permohonan_kasasi')->textInput() ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label col-md-4">Tgl Kasasi</label>
                        <div class="col-sm-4">
                             <?= $form->field($model, 'tgl_permohonan_kasasi')->widget(DateControl::classname(), [
                                    'type'=>DateControl::FORMAT_DATE,
                                    'ajaxConversion'=>false,
                                    'readonly' => false,
                                    'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    ]
                                ]
                            ]);
                             ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label col-md-4">No Permohonan</label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'no_permohonan')->textInput() ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="control-label col-md-4">Tgl Permohonan</label>
                    <div class="col-sm-4">
                         <?= 
                            $form->field($model, 'tgl_permohonan')->widget(DateControl::classname(), [
                                    'type'=>DateControl::FORMAT_DATE,
                                    'ajaxConversion'=>false,
                                    'readonly' => false,
                                    'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    ]
                                ]
                            ]);

                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label col-md-4">Pemohon</label>
                    <div class="col-sm-6">
                         <?= $form->field($model, 'id_pemohon')->dropDownList(['0'=>'Pilih Pemohon', '1' => 'Jaksa', '2' => 'Terdakwa']) ?>
                    </div>
                </div>
            </div>

            

            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label col-md-4">Pilih No Register Perkara</label>
                    <div class="col-sm-4">
                         <?= $form->field($model, 'no_register_perkara')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-md-4">
                        <a data-toggle="modal" data-target="#_berkas" class="btn btn-primary cari_berkas">Pilih Berkas</a>
                    </div>
                </div>
            </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label col-md-4">Pilih Terdakwa</label>
                        <div class="col-sm-4">
                            <select class="form-control selectTerdakwa" id="testxterdakwa" name="PdmRp11[no_reg_tahanan]">
                                <option value=''>Pilih Tersangka</option>
                                <?php if (!$model->isNewRecord){ 
                                       $modelTerdakwa = VwTerdakwaT2::find()->select('no_reg_tahanan, nama')->where(['no_register_perkara'=>$model->no_register_perkara])->all();
                                       foreach ($modelTerdakwa as $key) { ?>                                       
                                          <option value="<?= $key->no_reg_tahanan ?>" <?php echo $key->no_reg_tahanan == $model->no_reg_tahanan ? 'selected' : '' ; ?> ><?= $key->nama ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
        </div>
    </div>


    <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
          <?php if(!$model->isNewRecord): ?>  
            <!-- <a class="btn btn-warning" href="<?= Url::to(['pdm-rp11/cetak?id=' . $model->no_akta]) ?>">Cetak</a> -->
          <?php endif ?>  
        </div>
        
        

<?php 
    if(!$model->isNewRecord ){
        echo $form->field($model, 'no_akta')->hiddenInput();
    }else{
        echo $form->field($model, 'no_akta')->hiddenInput(['value'=>trim(uniqid())]);
    }

    ActiveForm::end(); ?>

    </div>
</section>


<?php
Modal::begin([
    'id' => '_berkas',
    'header' => 'Data Berkas',
    'options' => [
        'data-url' => '',
    ],
]);
/*echo '<pre>';print_r($dataProvidert);exit;*/
?> 



<div class="modalContent">

<?php echo GridView::widget([
        'dataProvider' => $dataProviderBerkas,
        'filterModel' => $searchModelBerkas,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_register_perkara']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'no_register_perkara',
                'label' => 'Nomor dan Tanggal Berkas',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    //return $model['nomor'].'<br>  Tanggal '.$model['tgl'];
                    return $model['no_register_perkara'].'<br>  Tanggal '.$model['tgl_terima'];
                },
            ],

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => $model['no_register_perkara'], "class" => "btn btn-warning",
                                    "onClick" => "pilihBerkas($(this).attr('id'))"]);
                    }
                        ],
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ]
    ]); ?>
    
</div>

<?php
Modal::end();
?>
<?php
$script = <<< JS
$(function(){
    var stat = '$model->id_status_yakum';
    if(stat=='2'){
        $('#kasasi').show();
    }else{
        $('#kasasi').hide();
    }
});

$('#pdmrp11-id_status_yakum').on("change", function(){
        var kode = $(this).val();
        console.log(kode);
        if(kode==2){
            $('#kasasi').show();
        }else{
            $('#kasasi').hide();
        }
    });


JS;
$this->registerJs($script);
?>

<script>
    function pilihBerkas(id) {
        $('#_berkas').modal('hide');
        $('#pdmrp11-no_register_perkara').val(id);
        $.ajax({
            type        : 'POST',
            url         :'/pidum/pdm-rp11/get-terdakwa',
            data        : 'no_register_perkara='+id,                 
            success     : function(data){
                            //alert(data);
                            var toAppend = '';
                            $.each(data,function(i,hasil){
                                toAppend += '<option value="'+hasil.no_reg_tahanan+'">'+hasil.nama+'</option>';
                            });
                            $('#testxterdakwa').empty().append(toAppend);
                          }

    });
}
</script>
