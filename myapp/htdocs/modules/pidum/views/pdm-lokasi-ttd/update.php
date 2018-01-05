<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPratutPutusan */

$this->title = 'Lokasi Penandatangan';
/*$this->params['breadcrumbs'][] = ['label' => 'Pdm Pratut Putusans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pratut, 'url' => ['view', 'id' => $model->id_pratut]];
$this->params['breadcrumbs'][] = 'Update'; */
?>
<div class="pdm-pratut-putusan-update">

   <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
