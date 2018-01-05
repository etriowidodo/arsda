<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\VwPenandatangan;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\MsSifatSurat;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP11 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
   <div class ="content-wrapper-1">

<?php
$form = ActiveForm::begin(
    [
        'id' => 'p11-form',
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
    <div class="box-body">

        <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>
 
        
        <div class="panel box box-warning">
	            <div class="box-header with-border">
	                <h3 class="box-title">
	                    Saksi
	                </h3>
	            </div>
	            <table id="table_jpu" class="table table-bordered">
	                <thead>
	                <tr>
                        <th>No Urut</th>
                        <th>Nama </th>
                        <th>Alamat</th>
                        <th>Keterangan</th>
	                </tr>
	                </thead>
	                <tbody id="tbody_tersangka">
	
	                <?php
	                if($modelTersangka != null){
                        $no=1;
	                    foreach($modelTersangka as $key => $value){
                            echo "<tr>";
                            echo "<td width='7%'>".$no."</td>";
                            echo "<td>".$value['nama']."</td>";
                            echo "<td>".$value['alamat']."</td>";
                            echo "<td>".'-'."</td>";
                            echo "</tr>";
                            $no++;
	                    }
	                }else{
                        echo "<tr><td colspan='4'>data kosong</td</tr>";
                    }

	                ?>
	
	                </tbody>
	            </table>
	        </div>
	      
			<div class="form-group">
            <label class="control-label col-md-2">Penandatangan</label>
            <div class="col-md-3">
                <?php  echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nik','nama','id_penandatangan')  ?>
               
            </div>
        </div>
        
			
			
        
    </div>
    <div class="form-group" style="text-align: center;">
        <!-- <button class="btn btn-primary" type="submit">Simpan</button>

        <button class="btn btn-primary" type="submit">Cetak</button> -->
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord) { ?>
                <a class="btn btn-warning" href="<?= Url::to(['pdm-p11/cetak?id=' . $model->id_p11]) ?>">Cetak</a>
            <?php } ?>

    </div>
<?php ActiveForm::end(); ?>
<br>
   </div>
</section>