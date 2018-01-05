<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPengantarTahap1 */

$this->title = 'Update Pdm Pengantar Tahap1: ' . ' ' . $model->id_pengantar;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Pengantar Tahap1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pengantar, 'url' => ['view', 'id' => $model->id_pengantar]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-pengantar-tahap1-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
