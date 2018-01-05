<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT5 */

$this->title = $model->id_t5;
$this->params['breadcrumbs'][] = ['label' => 'Pdm T5s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-t5-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_t5], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_t5], [
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
            'id_t5',
            'id_p16',
            'no_surat',
            'sifat',
            'lampiran',
            'perihal',
            'tgl_surat',
            'dikeluarkan',
            'kepada',
            'di',
            'alasan:ntext',
            'id_penandatangan',
        ],
    ]) ?>

</div>
