<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpahTersangka */

$this->title = $model->id_pratut_limpah_tersangka;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penyelesaian Pratut Limpah Tersangkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penyelesaian-pratut-limpah-tersangka-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pratut_limpah_tersangka], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pratut_limpah_tersangka], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_pratut_limpah_tersangka',
            'id_ms_tersangka_berkas',
            'status_penahanan',
        ],
    ]) ?>

</div>
