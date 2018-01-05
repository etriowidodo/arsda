<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpahTersangka */

$this->title = 'Update Pdm Penyelesaian Pratut Limpah Tersangka: ' . ' ' . $model->id_pratut_limpah_tersangka;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penyelesaian Pratut Limpah Tersangkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pratut_limpah_tersangka, 'url' => ['view', 'id' => $model->id_pratut_limpah_tersangka]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-penyelesaian-pratut-limpah-tersangka-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
