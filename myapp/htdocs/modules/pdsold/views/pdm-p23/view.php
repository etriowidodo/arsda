<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP23 */

$this->title = $model->id_p23;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P23s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p23-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p23], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p23], [
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
            'id_p23',
            'id_p22',
            'no_surat',
            'sifat',
            'lampiran',
            'tgl_surat',
            'dikeluarkan',
            'kepada',
            'di',
            'id_penandatangan',
        ],
    ]) ?>

</div>
