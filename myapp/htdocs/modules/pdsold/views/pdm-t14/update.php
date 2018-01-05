<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT14 */


$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;

/* $this->params['breadcrumbs'][] = ['label' => 'Pdm T14s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_t14, 'url' => ['view', 'id' => $model->id_t14]];
$this->params['breadcrumbs'][] = 'Update'; */
?>
<div class="pdm-t14-update">

   

    <?= $this->render('_form', [
         'model' => $model,
         'ciri2' => $ciri2,
         'modeljaksi' => $modeljaksi,
		 'modelTerdakwa' => $modelTerdakwa,
         'sysMenu' => $sysMenu
    ]) ?>

</div>
