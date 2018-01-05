<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT14 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t14-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modeljaksi' => $modeljaksi,
		'modelTerdakwa' => $modelTerdakwa,
        'sysMenu' => $sysMenu
    ]) ?>

</div>
