<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP17 */

$this->title = $model->id_p11;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P11s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p17-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p11], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p11], [
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
            'id_p16',
            'id_p11',
            'no_surat',
            'sifat',
            'lampiran',
            'perihal',
            'tgl_surat',
            'dikeluarkan',
            'kepada',
            'di',
            'id_penandatangan',
        ],
    ]) ?>

</div>
