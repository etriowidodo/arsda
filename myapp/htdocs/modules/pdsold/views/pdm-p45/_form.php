<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\GlobalConstMenuComponent;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP45 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-header"></div>

<?php
$form = ActiveForm::begin(
    [
        'id' => 'p45-form',
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
    
<div class="content-wrapper-1">
    <div class="pdm-p45-form">
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=>'_p45']) ?>
                <div class="box box-primary" style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="box-header with-border">
                                    <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                        <h3 class="box-title">
                                            <a class='btn btn-danger delete hapus hapusamar1'></a>
                                            &nbsp;
                                            <a class="btn btn-primary tambah_amar1">+ Amar Putusan</a>
                                        </h3>
                                    </div>
                                    <table id="table_grid_amar1" class="table table-bordered table-striped">
                                        <thead>
                                            <th></th>
                                            <th style="width: 96%"></th>
                                        </thead>
                                        <tbody id="tbody_grid_amar1">
                                            <?php if(!$model->isNewRecord){ ?>
                                                <?php //foreach($penasehat_hkm as $value): ?>
                                                <?php for($i=0; $i < count($ket_amar);$i++){ ?>
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusAmarCheck1'></td>
                                                    <td width="98%"><textarea name="txt_nama_amar1[]" id=""  type='textarea' class='form-control'><?=$ket_amar[$i]?></textarea></td>
                                                </tr>
                                                <?php } ?>
                                            <?php }else{ ?>
                                            <tr>
                                                <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusAmarCheck1'></td>
                                                <td width="98%"><textarea name="txt_nama_amar1[]" id=""  type='textarea' class='form-control'></textarea></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row" style="height: 45px; margin-top: 60px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tanggal Tuntutan</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'tgl_tuntutan')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => [
                                                        'placeholder' => 'Tanggal Tuntutan',
                                                    ],
                                                    'pluginOptions' => [
                                                        'autoclose' => true
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
                                        <label class="control-label col-md-4">Sikap Terdakwa</label>
                                        <div class="col-md-6">
                                            <?php echo $form->field($model, 'pernyataan_terdakwa')->radioList(['menerima' => 'Menerima', 'banding' => 'Banding']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Sikap Jaksa</label>
                                        <div class="col-md-6">
                                            <?php echo $form->field($model, 'pernyataan_jaksa')->radioList(['menerima' => 'Menerima', 'banding' => 'Banding', 'kasasi'=>'Kasasi']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="box-header with-border">
                                    <?php if ($model->isNewRecord){?>
                                    <?php foreach ($modeltsk as $rowmodeltsk) { ?>
                                    <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                        <h3 class="box-title">
                                            <a class='btn btn-danger delete hapus hapusSurat<?=($i+1)?>' onclick="hapus(<?=($i+1)?>);"></a>
                                            &nbsp;
                                            <a class="btn btn-primary tambah_memperhatikan<?=($i+1)?>" onclick="tambah(<?=($i+1)?>, '<?=$rowmodeltsk[nama]?>');">+ Pertimbangan <?=$rowmodeltsk[nama]?></a>
                                        </h3>
                                    </div>
                                    <table id="table_grid_surat<?=($i+1)?>" class="table table-bordered table-striped">
                                        <thead>
                                            <th></th>
                                            <th style="width: 96%"></th>
                                        </thead>
                                        <tbody id="tbody_grid_surat<?=($i+1)?>">
                                                <?php// foreach($majelis1 as $value): ?>
                                                
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check<?=($i+1)?>[]' class='hapusSuratCheck<?=($i+1)?>'></td>
                                                    <td width="96%"><textarea name="txt_nama_surat[<?=$rowmodeltsk[nama]?>][]" id=""  type='textarea' class='form-control'></textarea></td>
                                                </tr>
                                        </tbody>
                                    </table>
                                    <?php 
                                        $hps   .= '.hapusSurat'.($i+1).', ';
                                        $tmbh  .= '.tambah_memperhatikan'.($i+1).', ';
                                        $tbl   .= '#table_grid_surat'.($i+1).', ';
                                        $hpsc  .= 'hapusSuratCheck'.($i+1).', ';
                                        $txt  .= 'txt_nama_surat'.($i+1).'[], ';
                                    $i++ ;}
                                        $hsl  = count($modeltsk);
                                        $hps  = substr($hps, 0,-2);
                                        $tmbh = substr($tmbh, 0,-2);
                                        $tbl  = substr($tbl, 0,-2);
                                        $hpsc = substr($hpsc, 0,-2);
                                        $txt = substr($txt, 0,-2);
                                        ?>
                                    <?php } else {
                                        $pertimbangan1  = json_decode($model->pertimbangan);
                                        $i=1;
                                        foreach ($pertimbangan1[0] as $key => $value){
//                                            echo $key; print_r($value).'<br\>';
                                            ?>
                                            <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                                <h3 class="box-title">
                                                    <a class='btn btn-danger delete hapus hapusSurat<?=($i)?>' onclick="hapus(<?=($i)?>);"></a>
                                                    &nbsp;
                                                    <a class="btn btn-primary tambah_memperhatikan<?=($i)?>" onclick="tambah(<?=($i)?>, '<?=$key?>');">+ Pertimbangan <?=$key?></a>
                                                </h3>
                                            </div>
                                            <table id="table_grid_surat<?=($i)?>" class="table table-bordered table-striped">
                                                <thead>
                                                    <th></th>
                                                    <th style="width: 96%"></th>
                                                </thead>
                                                <tbody id="tbody_grid_surat<?=($i)?>">
                                                    <?php
                                                    foreach ($value as $key1 => $value1){
//                                                        echo $key1; print_r($value1).'<br\>';
                                                    ?>
                                                        <tr>
                                                            <td style="height: 70px"><input type='checkbox' name='new_check<?=($i)?>[]' class='hapusSuratCheck<?=($i)?>'></td>
                                                            <td width="96%"><textarea name="txt_nama_surat[<?=$key?>][]" id=""  type='textarea' class='form-control'><?=$value1?></textarea></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    
                                                    ?>
                                                </tbody>
                                            </table>
                                   <?php 
                                           $i++;
                                        }
                                        ?>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->no_surat_p45, 'GlobalConst' => GlobalConstMenuComponent::P45]) ?>
                <div class="form-group" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if(!$model->isNewRecord){ ?><a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p45/cetak?id='.rawurlencode($model->no_surat_p45)])?>">Cetak</a><?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>

<script>
    var id=1;
     function tambah(i, nama){
         var tabel="#table_grid_surat"+i;
            $(tabel+" > tbody").append("<tr id='tr_"+i+"_"+id+"'><td><input type='checkbox' name='new_check"+i+"[]' class='$hpsc'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat["+nama+"][]' /></td></tr>");
            id++;
     }
     
     function hapus(i){
         $.each($('input[type=\"checkbox\"][name=\"new_check'+i+'[]\"]'),function(x)
                {
                    var input = $(this);
                    if(input.prop('checked')==true)
                    {   var id = input.parent().parent();
                            id.remove();
                    }
                }
         )
     }
</script>

<?php
$script1 = <<< JS
        var id=1;
	$('.tambah_amar1').on('click', function() {
		$("#table_grid_amar1 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check1_1[]' class='hapusAmarCheck1'></td><td><textarea type='textarea' class='form-control' name='txt_nama_amar1[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusamar1').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check1_1[]\"]'),function(x)
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


