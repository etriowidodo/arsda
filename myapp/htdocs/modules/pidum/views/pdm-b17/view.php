<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\pdmb17 */

$this->title = $model->id_b1;
$this->params['breadcrumbs'][] = ['label' => 'Pdmb17s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdmb17-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_b1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_b1], [
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
            'id_b1',
            'id_perkara',
            'no_surat',
            'no_reg_bukti',
            'barbuk:ntext',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'id_penandatangan',
            'upload_file',
            'flag',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
