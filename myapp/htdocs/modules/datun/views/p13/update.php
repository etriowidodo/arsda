<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdp */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pidum-pdm-p13-update">   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
