<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	//use mdm\admin\models\searchs\Menu as MenuSearch;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <?php $form = ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
    <div class="row">
        <div class="col-md-11">
            <div class="form-group">
                <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
                <div class="col-md-10"><input type="text" name="id" id="q1" class="form-control" /></div>                    
			</div>
        </div>
        <div class="col-md-1">
            <div class="form-group"><button class="btn btn-warning" type="submit">Cari</button></div>
        </div>
    </div>     
    <?php ActiveForm::end(); ?>
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">