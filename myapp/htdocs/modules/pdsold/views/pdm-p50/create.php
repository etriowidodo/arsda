<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP50 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p50-create">

    <?= $this->render('_form', [
        'model'     => $model,
        'terdakwa'  => $terdakwa,
    	'modelSpdp' => $modelSpdp
    ]) ?>

</div>
