<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT13 */

$this->title = $model->id_t13;
$this->params['breadcrumbs'][] = ['label' => 'Pdm T13s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-t13-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_t13], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_t13], [
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
            'id_t13',
            'id_t8',
            'no_surat',
            'tgl_surat',
            'dikeluarkan',
            'kepada',
            'sp_penahanan',
            'penetapan',
            'no_penahanan',
            'tgl_penahanan',
            'keperluan',
            'menghadap',
            'tempat',
            'tgl_penetapan',
            'jam',
            'id_penandatangan',
        ],
    ]) ?>

</div>
