<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP48;
use app\modules\pidum\models\VwPenandatangan;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmMsBendaSitaan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP48 */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

     <?php
    $form = ActiveForm::begin(
        [
            'id' => 'p48-form',
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
	
	<div class="box box-primary" style="border-color: #f39c12;">
        <!--<div class="box-header with-border" style="border-color: #c7c7c7;"></div>-->
        <div class="box-header with-border" style="border-bottom:none;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Nomor</label>
                            <div class="col-sm-3">
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
                            <label class="control-label col-sm-2" style="width: 10%;">Dikeluarkan</label>
                            <div class="col-sm-3" style="width: 19%;">
                                <?php
                                    if($model->isNewRecord){
                                       echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                                    }else{
                                       echo $form->field($model, 'dikeluarkan');
                                    } 
                                //Danar Wido validasi tgl dikeluarkan min 1 hari setelah tgl terima Spdp :15/06/2016
                                $TglTerima = $_SESSION['tgl_terima'];
                                if(isset($id_p17)){
                                    $MinTgl  = date('d-m-Y', strtotime('+30 days', strtotime($TglTerima))); 
                                    $MaxTgl  = date('d-m-Y', strtotime('+90 days', strtotime($TglTerima)));         
                                }else if(isset($id_p17)){
                                    $MinTgl  = date('d-m-Y', strtotime('+14 days', strtotime($TglTerima))); 
                                    $MaxTgl  = date('d-m-Y', strtotime('+90 days', strtotime($TglTerima)));     
                                }else
                                {
                                    $MinTgl  = date('d-m-Y', strtotime('+1 days', strtotime($TglTerima))); 
                                    $MaxTgl  = date('d-m-Y', strtotime('+30 days', strtotime($TglTerima))); 
                                }

                                            
                                ?>
                            </div>
                             <label class="control-label col-sm-2" style="width: 9%;">Tanggal</label>
                            <div class="col-sm-2" style="width:12%;"><!-- jaka merubah lebar field tanggal -->
                            <?php if ($_SESSION['tgl_terima'] != '')
                            {
                                
                                ?>
                                <?=
                                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options' => [
                                            'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi surat
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            //'startDate' => $MinTgl,
                                            //'endDate'   => $MaxTgl,
                                            'endDate' => date('d-m-Y'),
                                        ]
                                    ]
                                ]);
                                //End Danar
                                ?>
                                <?php
                            }else { ?>
                                <?=
                                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options' => [
                                            'placeholder' => 'Tgl Surat',//dikeluarkan jadi surat
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'endDate' => date('d-m-Y'),
                                        ]
                                    ]
                                ]);
                                ?>
                        <?php       
                            }
                        //End Danar
                        ?>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
	
	
	<div class="box box-primary" style="border-color: #f39c12;">
		<div class="col-sm-12">
            <div class="box-body">
                <div class="form-group">
					<label class="control-label col-md-2">Pilih No Register Perkara</label>
				<div class="col-sm-4">
					<?=
                        $form->field($model, 'no_register_perkara', [
                                                  'addon' => [
                                                     'append' => [
                                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_putusan']),
                                                          'asButton' => true
                                                     ]
                                                 ]
                                             ]);
                                           ?>
				</div>
				</div>

                <div class="form-group">
                        <label class="control-label col-md-2">Pilih Terdakwa</label>
                        <div class="col-sm-3">
                            <select class="form-control selectTerdakwa" id="testxterdakwa" name="PdmP48[no_reg_tahanan]">
                                <option value=''>Pilih Terpidana</option>
                                <?php if (!$model->isNewRecord){ 
                                       $modelTerdakwa = VwTerdakwaT2::find()->select('no_reg_tahanan, nama')->where(['no_register_perkara'=>$model->no_register_perkara])->all();
                                       foreach ($modelTerdakwa as $key) { ?>                                       
                                          <option value="<?= $key->no_reg_tahanan ?>" <?php echo $key->no_reg_tahanan == $model->no_reg_tahanan ? 'selected' : '' ; ?> ><?= $key->nama ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                </div>

                <div class="form-group">
                        <label class="control-label col-md-2">No Putusan</label>
                        <div class="col-sm-4">
                            <?=
                                $form->field($model, 'no_putusan')->textInput(['readonly'=>true]);
                                                   ?>
                        </div>
                        <label class="control-label col-md-2">Tgl Putusan</label>
                        <div class="col-sm-2">
                            <?php if(!$model->isNewRecord){ 
                                $tgx = date('d-m-Y', strtotime($model->tgl_putusan));
                             }else{
                                $tgx = '';
                             } ?>
                             <input type="text" value="<?= $tgx ?>" class="form-control" disabled="true" readonly="true" id="tgl_putusan_show">
                        </div>
                        <?= $form->field($model, 'tgl_putusan')->hiddenInput();?>
                        <?= $form->field($model, 'no_akta')->hiddenInput(); ?>
                        <?= $form->field($model, 'id_ms_rentut')->hiddenInput(); ?>
                </div>

                <div id="denda" class="form-group">
                        <label class="control-label col-md-3">Apakah Terpidana Sudah Membayar Denda/Biaya Perkara?</label>
                        <div class="col-sm-4">
                            <?php echo $form->field($model, 'is_denda')->radioList(['1' => 'Ya', '0' => 'Tidak']) ?>
                        </div>
                </div>


			</div>
		</div>
	</div>
	
	<div class="box box-primary" style="border-color: #f39c12;">
       <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P48, 'id_table' => $model->no_surat]) ?>
	
	</div>
  

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
          <?php if(!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-p48/cetak?id=' . $model->no_surat]) ?>">Cetak</a>
          <?php endif ?>  
        </div>


    <?php ActiveForm::end(); ?>

</div>
    </section>
	
	
	

<?php
Modal::begin([
    'id' => 'm_putusan',
    'header' => 'Data Putusan Pengadilan',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<div class="modalContent">

    <?=
    GridView::widget([
        'id' => 'm_putusan',
        'dataProvider' => $dataRegister,
        'filterModel' => $searchRegister,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'No Register Perkara',
                'attribute' => 'no_register_perkara',
            ],
            ['label' => 'Tanggal Register',
                'attribute' => 'tgl_terima',
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => "buttonPilihRegister", "class" => "btn btn-warning",
                                    "nomor" => $model['no_register_perkara'],
                                    "onClick" => "pilihRegister($(this).attr('nomor'))"]);
                    }
                        ],
                    ]
                ],
                'export' => false,
                'pjax' => true,
                'responsive' => true,
                'hover' => true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ],
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ]
            ]);
            ?>

</div>  

<?php
Modal::end();
?>

<?php
$script1 = <<< JS
    $('#hdn_jabatan_penandatangan').val('$model->jabatan_ttd');
    $('#hdn_pangkat_penandatangan').val('$model->pangkat_ttd');
    $('#hdn_nama_penandatangan').val('$model->nama_ttd');


    $('#popUpJpu').click(function(){
        $('#m_jpu').html('');
        $('#m_jpu').load('/pidum/p16/jpu');
        $('#m_jpu').modal('show');
    });

    $('#testxterdakwa').on("change",function(){
        var no_register_perkara =  $("#pdmp48-no_register_perkara").val();
        var no_reg_tahanan = $(this).val();
        $.ajax({
            type        : 'POST',
            url         :'/pidum/pdm-p48/get-putusan',
            data        : { 'no_register_perkara':no_register_perkara,
                            'no_reg_tahanan':no_reg_tahanan},                 
            success     : function(data){
                            console.log(data[0].no_surat);
                            $("#pdmp48-no_putusan").val(data[0].no_surat);
                            $("#pdmp48-tgl_putusan").val(data[0].tgl_hidden);
                            $("#pdmp48-no_akta").val(data[0].no_akta);
                            $("#pdmp48-id_ms_rentut").val(data[0].id_ms_rentut);
                            $("#tgl_putusan_show").val(data[0].tgl_show);
                          }

        });
    });

JS;
$this->registerJs($script1);
?>
<script>
    function pilihRegister(nomor){
        var register = nomor;
        console.log(register);
        $('#pdmp48-no_register_perkara').val(register);
        $('#m_putusan').modal('hide');
        getTerdakwa(register);
    }

    function getTerdakwa(register){
            $.ajax({
                type        : 'POST',
                url         :'/pidum/pdm-p48/get-terdakwa',
                data        : 'no_register_perkara='+register,                 
                success     : function(data){
                                //alert(data);
                                var toAppend = '<option value="0" selected="true">Pilih Terpidana</option>';
                                $.each(data,function(i,hasil){
                                    toAppend += '<option value="'+hasil.no_reg_tahanan+'">'+hasil.nama+'</option>';
                                });
                                $('#testxterdakwa').empty().append(toAppend);
                              }

            });
    }

</script>