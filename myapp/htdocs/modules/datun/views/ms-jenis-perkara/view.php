<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsJenisPerkara */

$this->title = $model->kode_pidana;
$this->params['breadcrumbs'][] = ['label' => 'Ms Jenis Perkaras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-jenis-perkara-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'kode_pidana' => $model->kode_pidana, 'jenis_perkara' => $model->jenis_perkara], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'kode_pidana' => $model->kode_pidana, 'jenis_perkara' => $model->jenis_perkara], [
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
            'kode_pidana',
            'jenis_perkara',
            'nama',
        ],
    ]) ?>

</div>
