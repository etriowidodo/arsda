<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT9 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t9-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelDetailT9' => $modelDetailT9,
        'modelTersangka' => $modelTersangka,
    ]) ?>

</div>