<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP43 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p43-create">

   <?= $this->render('_form', [
        'model'     => $model,
        'modelSpdp' => $modelSpdp,
        'petunjuk'  =>$petunjuk,
    ]) ?>

</div>
