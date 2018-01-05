<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP35 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p35-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'modelSpdp' => $modelSpdp,
    	'modelP29' => $modelP29,
    ]) ?>

</div>
