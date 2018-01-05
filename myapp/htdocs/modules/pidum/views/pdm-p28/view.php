<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP28 */

$this->title = $model->id_p28;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P28s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p28-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p28], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p28], [
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
            'id_p28',
            'id_berkas',
            'no_surat',
            'pelimpahan',
            'tgl_apsapb',
            'id_jaksa1',
            'id_jaksa2',
            'id_jaksa3',
            'hakim1',
            'hakim2',
            'hakim3',
            'panitera',
            'penasehat',
        ],
    ]) ?>

</div>
