<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpahJaksa */

$this->title = 'Update Pdm Penyelesaian Pratut Limpah Jaksa: ' . ' ' . $model->id_pratut_limpah_jaksa;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penyelesaian Pratut Limpah Jaksas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pratut_limpah_jaksa, 'url' => ['view', 'id' => $model->id_pratut_limpah_jaksa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-penyelesaian-pratut-limpah-jaksa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
