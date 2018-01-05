<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpah */

$this->title = 'Update Pdm Penyelesaian Pratut Limpah: ' . ' ' . $model->id_pratut_limpah;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penyelesaian Pratut Limpahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pratut_limpah, 'url' => ['view', 'id' => $model->id_pratut_limpah]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-penyelesaian-pratut-limpah-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
