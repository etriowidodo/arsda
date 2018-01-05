<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT6 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t6-update">
    <?= $this->render('_form', [
        'model' => $model,
		'no_register_perkara' => $no_register_perkara,
    ]) ?>

</div>
