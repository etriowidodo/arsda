<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTemplateTembusan */

$this->title = 'Tembusan';
?>


<?php $form = ActiveForm::begin(
 [
			'id' => 'pdm-template-tembusan-form',
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'enableAjaxValidation' => false,
			'fieldConfig' => [
				'autoPlaceholder'=>false
			],
			'formConfig' => [
				'deviceSize' => ActiveForm::SIZE_SMALL,
				'labelSpan' => 1,
				'showLabels'=>false

			]
		]); 
		
		
?>



 <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                    <a class="btn btn-danger delete hapusTembusan"></a>&nbsp;<a id="tambah-tembusan" class="btn btn-primary">Tambah Tembusan <?php echo $kd_berkas; ?></a>
                </h3>
            </div>
            <div class="box-header with-border">


                <table id="table_tembusan" class="table table-bordered">
                    <thead>
                        <tr>
							<th></th>
                            <th>No Urut</th>
                            <th>Tembusan</th>
                        </tr>
                    </thead>
                    <tbody id="table_tembusan">
						<?php $no=1;foreach ($data_tembusan as $key => $value): ?>
                                <tr data-id="<?= $value['id_tmp_tembusan'] ?>">
									<td id="tdJPU">
										<input type='checkbox' name='chk_del_tembusan[]'  id='chk_del_tembusan' value="<?= $value['id_tmp_tembusan'] ?>">
									</td>
                                    <td>
										<input type="text" name="no_urut[]" class="form-control" value="<?= $no; ?>" style="width: 50px;">
									</td>
                                    <td>
										<input type="text" name="nama_tembusan[]" class="form-control"  value="<?= $value['tembusan'] ?>">
									</td>
                                </tr>
                        <?php $no++;endforeach; ?>
                    </tbody>
                </table>
             
            </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-warning' ]) ?>
    </div>
	
<?php ActiveForm::end(); ?>

<?php
$script1 = <<< JS
	var x=1;
	$('#tambah-tembusan').click(function(){
			$('#table_tembusan').append(
				'<tr data-id="'+x+'">' +
				'<td><input type="checkbox" name="chk_del_tembusan[]"  id="chk_del_tembusan" value="'+x+'"></td>'+
				'<td><input type="text" name="no_urut[]" class="form-control" readonly="true"  style="width: 50px;"></td>' +
				'<td><input type="text" name="nama_tembusan[]" class="form-control"> </td>' +
				'</tr>'
			);
			x++;
		});
								
	$(".hapusTembusan").click(function()
        {
             $.each($('input[type="checkbox"][name="chk_del_tembusan[]"]'),function(x)
                {
                    var input = $(this);
                    if(input.prop('checked')==true)
                    {   var id = input.parent().parent();
                        id.remove();
                    }
                }
             )
        }
    );
JS;
$this->registerJs($script1);
