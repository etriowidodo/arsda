<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB12 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b12-create">

   

    <?= $this->render('_form', [
        'model' => $model,
		'model2' => $model2,
    ]) ?>

</div>
