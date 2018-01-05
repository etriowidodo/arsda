<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP45 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p45-create">

    <?= $this->render('_form', [
        'model'         => $model,
        'no_register'   => $no_register,
        'modeltsk'      => $modeltsk,
    ]) ?>

</div>
