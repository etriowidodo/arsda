<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwPenandatangan;
?>

<div class="col-sm-12">
    <div class="box box-warning">
        <div class="box-body">
            <div class="class-md-4 pull-right">

                <label class="control-label col-md-4">Penanda Tangan</label>
                <div class="col-md-8">
                    <?php

                    echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nik','nama','id_penandatangan')  ?>
                </div>
            </div>
            <div class="col-md-8 pull-left">
                <?= Yii::$app->globalfunc->getTembusan($form,$GlobalConst,$this,$id_table, $model->id_perkara) ?>
            </div>
        </div>
    </div>
</div>
