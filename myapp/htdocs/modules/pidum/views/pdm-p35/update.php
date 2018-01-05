<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP35 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p35-update">

    <?= $this->render('_form', [
        'model' => $model,
        'no_register_perkara' => $no_register_perkara,
        //'modelSpdp' => $modelSpdp,
		'modelP29' => $modelP29,
    ]) ?>

</div>
