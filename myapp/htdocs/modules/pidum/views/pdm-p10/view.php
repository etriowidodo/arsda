<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP10 */

$this->title = $model->id_p10;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P10s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p10-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p10], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p10], [
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
            'id_p10',
            'id_berkas',
            'no_surat',
            'sifat',
            'lampiran',
            'dikeluarkan',
            'tgl_surat',
            'proses',
            'ket_ahli:ntext',
            'id_penandatangan',
        ],
    ]) ?>

</div>
