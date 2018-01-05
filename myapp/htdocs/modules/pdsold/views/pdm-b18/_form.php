<?php
use app\modules\pdsold\models\VwPenandatangan;
use app\modules\pdsold\models\PdmB18;
use app\modules\pdsold\models\PdmPenandatangan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model PdmB18 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-b18-form">

    <?php
    if(!$model->isNewRecord){
        $pelaksana = json_decode($model->pelaksana);
        //echo '<pre>';print_r($pelaksana);exit;
        //echo '<pre>';print_r($pelaksana->kasubag->nama);exit;
    }
    $form = ActiveForm::begin(
                    [
                        'id' => 'b18-form',
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
        <div class="box-header">
            <div class="form-group">
                <div class="col-md-6">
                <label class="control-label col-md-3">No Sprint</label>
                    <div class="col-md-6">
                        <?= $form->field($model, 'no_surat')->input('text',
                                ['oninput'  =>'
                                        var number =  /^[A-Za-z0-9-/]+$/;
                                        if(this.value.length>50)
                                        {
                                          this.value = this.value.substr(0,50);
                                        }
                                        if(this.value<0)
                                        {
                                           this.value =null
                                        }
                                        var str   = "";
                                        var slice = "";
                                        var b   = 0;
                                        for(var a =1;a<=this.value.length;a++)
                                        {
                                            
                                            slice = this.value.substr(b,1);
                                            if(slice.match(number))
                                            {
                                                
                                                str+=slice;
                                                
                                            }
                                            
                                            b++
                                        }
                                        this.value=str;
                                        '])  ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                <label class="control-label col-md-3">Dikeluarkan</label>
                    <div class="col-md-6">
                        <?php if($model->isNewRecord){
                           echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                        }else{
                           echo $form->field($model, 'dikeluarkan');
                        } ?>
                    </div>
                </div>
                <div class="col-md-6">
                <label class="control-label col-md-3">Tanggal</label>
                    <div class="col-md-4">
                        <?=
                        $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Dikeluarkan',
                                ],
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
            <h5 class="box-title"><b>Memerintahkan</b></h5>
        </div><br>
        <div class="form-group">
            <div class="col-md-12">
                <label class="control-label col-md-2">Kasi Pidum</label>
                <div class="col-md-4">
                   <?=
                      $form->field($model, 'pelaksana', [
                          'addon' => [
                             'append' => [
                                'content' => Html::a('Pilih', '', ['id'=>'kasipidum', 'class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_kasipidum']),
                                  'asButton' => true
                             ]
                         ]
                     ])->textInput(['id'=>'txtkasipidum', 'value'=>$pelaksana->kasipidum->nama]);
                   ?>    
                </div>
                </div>
            </div>
      

        <div class="form-group">
            <div class="col-md-12">
                <label class="control-label col-md-2">Kasubag Pembinaan</label>
                <div class="col-md-4">
                   <?=
                      $form->field($model, 'pelaksana', [ 
                          'addon' => [
                             'append' => [
                                'content' => Html::a('Pilih', '', ['id'=>'kasubag', 'class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_kasubag']),
                                  'asButton' => true
                             ]
                         ]
                     ])->textInput(['id'=>'txtkasubag', 'value'=>$pelaksana->kasubag->nama]);
                   ?>
                </div>
            </div>
        </div>
        <div class="hide">
            <input type="text" name="pelaksana[kasubag][nama]" value="<?= $pelaksana->kasubag->nama ?>">
            <input type="text" name="pelaksana[kasubag][nip]" value="<?= $pelaksana->kasubag->nip ?>">
            <input type="text" name="pelaksana[kasubag][pangkat]" value="<?= $pelaksana->kasubag->pangkat ?>">
            <input type="text" name="pelaksana[kasubag][jabatan]" value="<?= $pelaksana->kasubag->jabatan ?>">

            <input type="text" name="pelaksana[kasipidum][nama]" value="<?= $pelaksana->kasipidum->nama ?>">
            <input type="text" name="pelaksana[kasipidum][nip]" value="<?= $pelaksana->kasipidum->nip ?>">
            <input type="text" name="pelaksana[kasipidum][pangkat]" value="<?= $pelaksana->kasipidum->pangkat ?>">
            <input type="text" name="pelaksana[kasipidum][jabatan]" value="<?= $pelaksana->kasipidum->jabatan ?>">
        </div>
    </div>
    <!-- <div class="box box-warning">
        <div class="box-header">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Dikeluarkan</label>
                        <div class="col-md-4">
                            <?= $form->field($model, 'dikeluarkan')->textInput() ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                            $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => [
                                        'placeholder' => 'Tanggal Dikeluarkan',
                                    ],
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
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Penanda Tangan</label>
                        <div class="col-md-8">
                            <?php echo Yii::$app->globalfunc->returnDropDownList($form, $model, PdmPenandatangan::find()->all(), 'peg_nik', 'nama', 'id_penandatangan') ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
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
        <?php  if (!$model->isNewRecord) : ?>
          <a class="btn btn-warning" href="<?= Url::to(['pdm-b18/cetak?no_eksekusi=' . $model->no_eksekusi]) ?>">Cetak</a>
          <a class="btn btn-warning" href="<?= Url::to(['pdm-b18/delete?no_eksekusi=' . $model->no_eksekusi]) ?>">Hapus</a>
          <?php endif  ?>	
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
Modal::begin([
    'id' => 'm_kasipidum',
    'header' => 'Data Jaksa Pelaksana',
    'options' => [
        'data-url' => '',
    ],
]);
?> 


<?=
$this->render('_m_kasipidum', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'm_kasubag',
    'header' => 'Data Pegawai',
    'options' => [
        'data-url' => '',
    ],
]);
?> 


<?=
$this->render('_m_kasubag', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
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
    $('#m_tanda_tangan').load('/pdsold/default/popup-penanda-tangan');
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


