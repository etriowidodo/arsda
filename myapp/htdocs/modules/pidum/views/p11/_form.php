<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwPenandatangan;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\MsSifatSurat;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP11 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-header"></div>
	
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
        <div class="form-group">
            <label class="control-label col-md-2">Wilayah Kerja</label>
            <div class="col-md-4">
                <input class="form-control" readonly='true' value="<?php echo \Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
            </div>
           
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Nomor:</label>
            <div class="col-md-4">
                <?= $form->field($model, 'no_surat') ?>
            </div>
            
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Sifat:</label>
            <div class="col-md-4">
                <?= Yii::$app->globalfunc->returnDropDownList($form,$model,MsSifatSurat::find()->all(),'nama','nama','sifat',false) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Lampiran:</label>
            <div class="col-md-4">
                <?= $form->field($model, 'lampiran') ?>
            </div>
        </div>
         <div class="form-group">
            <label class="control-label col-md-2">Kepata YTH:</label>
            <div class="col-md-4">
                <?= $form->field($model, 'kepada') ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Di</label>
            <div class="col-md-4">
                <?= $form->field($model, 'di') ?>
            </div>
        </div>
        
        <div class="panel box box-warning">
	            <div class="box-header with-border">
	                <h3 class="box-title">
	                    Tersangka
	                </h3>
	            </div>
	            <table id="table_jpu" class="table table-bordered">
	                <thead>
	                <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Pekerjaan</th>
	                </tr>
	                </thead>
	                <tbody id="tbody_tersangka">
	
	                <?php
	                if($modelTersangka != null){
	                    foreach($modelTersangka as $key => $value){
                            echo "<tr>";
                            echo "<td>".$value['nama']."</td>";
                            echo "<td>".$value['alamat']."</td>";
                            echo "<td>".$value['no_hp']."</td>";
	                        echo "<td>".$value['pekerjaan']."</td>";
                            echo "</tr>";
	                    }
	                }
	                ?>
	
	                </tbody>
	            </table>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-md-2">Dikeluarkan & Tanggal</label>
	            <div class="col-md-4">
	            	<?php echo $form->field($model, 'dikeluarkan')->input('text', ['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst])?>
	            </div>
	            <div class="col-md-3">
	              	<?= $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]); ?>
	            </div>
	        </div>
			<div class="form-group">
            <label class="control-label col-md-2">Penandatangan</label>
            <div class="col-md-3">
                <?php  echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nik','nama','id_penandatangan')  ?>
               
            </div>
        </div>
        <div class="panel box box-warning">
            <div class="box-header with-border">
                
            </div>            
			<?= Yii::$app->globalfunc->getTembusan($form,GlobalConstMenuComponent::P11,$this,$model->id_p11, $model->id_perkara) ?>
                
            
        </div>
			
			
        
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Simpan</button>

        <button class="btn btn-primary" type="submit">Cetak</button>
    </div>
</div>
<?php ActiveForm::end(); ?>
<br>
