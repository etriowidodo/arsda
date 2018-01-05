<?php

use yii\helpers\ArrayHelper;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwPenandatangan;
use app\modules\pidum\models\MsLokTahanan;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT9 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 't9-form',
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
        <?= $this->render('//default/_formHeaderT9', ['form' => $form, 'model' => $model]) ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 12px;overflow: hidden;">
            <div class="box-header with-border" style="padding-left:0px;">
                <div class="col-md-6" style="padding-left:6px">
                    <h3 class="box-title">Tersangka</h3>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <a class="btn btn-danger delete hapusTersangka"></a> 
                            <table id="table_tersangka_baru" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="2%" style="text-align: center;vertical-align: middle;">#</th>
                                        <th width="14%" style="text-align: center;vertical-align: middle;">Nama</th>
                                        <th width="14%" style="text-align: center;vertical-align: middle;">Tahanan</th>
                                        <th width="14%" style="text-align: center;vertical-align: middle;">Dipindahkan ke</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_tersangka_baru">
                                    <?php
                                    
                                    if (!$model->isNewRecord) {
                                        $i = 0;
                                        foreach ($modelTersangka as $value):
                                            echo '<tr id="row-' . $value['id_tersangka'] . '">';
                                            echo '<td style="text-align: center">
                                            <input type="hidden" name="DetailT9[no_urut_tersangka][]" value='.$value['id_tersangka'].'>
                                            <input type="hidden" name="DetailT9[no_reg_tahanan_jaksa][]" value='.$value['no_reg_tahanan_jaksa'].'>
                                            <input type="checkbox" name="DetailT9[new_check][]" class="hapusTersangkaCheck" value=""></td>';
                                            echo '<td style="text-align: center"><input type="text" style="width:100%" readonly="true"  name="DetailT9[nama][]" value='.$value['nama'].'></td>';
                                            echo '<td style="text-align: center"><input type="text" style="width:100%" readonly="true"  name="DetailT9[lokasi_tahanan][]" value='.$value['lokasi_tahanan'].'></td>';
                                            echo '<td style="text-align: left; "><input type="text" name="DetailT9[lokasi_pindah][]" value='.$value['lokasi_pindah'].' style="width:100%"></td>';
                                            
                                            echo '</tr>';
                                            $i++;
                                        endforeach;
                                    }else {

                                        foreach ($modelTersangka as $value):
                                            echo '<tr id="row-' . $value['no_urut_tersangka'] . '">';
                                            echo '<td style="text-align: center">
                                            <input type="hidden" name="DetailT9[no_urut_tersangka][]" value='.$value['no_urut_tersangka'].'>
                                            <input type="hidden" name="DetailT9[no_reg_tahanan_jaksa][]" value='.$value['no_reg_tahanan'].'>
                                            <input type="checkbox" name="DetailT9[new_check][]" class="hapusTersangkaCheck" value=""></td>';
                                            echo '<td style="text-align: center"><input type="text" style="width:100%" readonly="true"  name="DetailT9[nama][]" value='.$value['nama'].'></td>';
                                            echo '<td style="text-align: center"><input type="text" style="width:100%" readonly="true"  name="DetailT9[lokasi_tahanan][]" value='.$value['lokasi_tahanan'].'></td>';
                                            echo '<td style="text-align: left; "><input type="text" name="DetailT9[lokasi_pindah][]" style="width:100%"></td>';
                                            
                                            echo '</tr>';
                                            $i++;
                                        endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
<?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T9, 'id_table' => $model->no_surat_t9]) ?>

        <div class="box-footer" style="text-align: center;">
<?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
<?php if (!$model->isNewRecord) { ?>
                <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-t9/cetak?id_t9=' . $model->no_surat_t9]) ?>">Cetak</a>
        <?php } ?>
        </div>


            <?php ActiveForm::end(); ?>

    </div>
</section>
<?php
$script = <<< JS
        var n=1;
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<input type="text" class="form-control" style="margin-left:180px" id="field_'+n+'" name="mytext[]"><br />'
                )
                n=n+$('.tembusan').length;
            });

        $('.cb_loktahanan').change(function(e){
            var id = $(this).attr('id').replace("cb-", "");
            var val = e.target.value;
            if(val == 4){
                $('#lokasi-' + id).hide();
            }else{
                $('#lokasi-' + id).show();
            }
        });

        $('.hapusTersangka').click(function(){
         $.each($('input[type=\"checkbox\"][name=\"DetailT9[new_check][]\"]'),function(x)
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
$this->registerJs($script);
?>
<br>