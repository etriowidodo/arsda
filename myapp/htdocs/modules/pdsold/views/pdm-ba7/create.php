<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA10 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba10-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelT7' => $modelT7,
        'sysMenu' => $sysMenu,
        'modelTerdakwa' => $modelTerdakwa
            
    ]) ?>

</div>