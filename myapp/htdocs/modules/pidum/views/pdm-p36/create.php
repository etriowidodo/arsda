<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP36 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p36-create">

    <?= $this->render('_form', [
        'model'     => $model,
        'sysMenu'   => $sysMenu,
    ]) ?>

</div>
