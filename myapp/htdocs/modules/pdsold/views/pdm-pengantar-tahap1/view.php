<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPengantarTahap1 */

$this->title = $model->id_pengantar;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Pengantar Tahap1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-pengantar-tahap1-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pengantar], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pengantar], [
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
            'id_pengantar',
            'id_berkas',
            'no_pengantar',
            'tgl_pengantar',
            'tgl_terima',
        ],
    ]) ?>

</div>
