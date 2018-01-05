<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT4 */

$this->title = $model->id_t4;
$this->params['breadcrumbs'][] = ['label' => 'Pdm T4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-t4-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_t4], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_t4], [
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
            'id_t4',
            'id_p16',
            'id_loktahanan',
            'no_surat',
            'tgl_buat',
            'dikeluarkan',
            'tgl_mulai',
            'tgl_selesai',
            'id_penandatangan',
        ],
    ]) ?>

</div>
