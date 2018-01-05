<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapatT4 */

$this->title = $model->id_perpanjangan;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Nota Pendapat T4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-nota-pendapat-t4-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_perpanjangan' => $model->id_perpanjangan, 'id_nota_pendapat' => $model->id_nota_pendapat], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_perpanjangan' => $model->id_perpanjangan, 'id_nota_pendapat' => $model->id_nota_pendapat], [
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
            'id_perpanjangan',
            'id_nota_pendapat',
            'tgl_nota',
            'persetujuan',
            'id_kejati',
            'id_kejari',
            'id_cabjari',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>