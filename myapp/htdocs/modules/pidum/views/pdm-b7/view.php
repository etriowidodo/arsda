<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB7 */

$this->title = $model->id_b7;
$this->params['breadcrumbs'][] = ['label' => 'Pdm B7s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-b7-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_b7], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_b7], [
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
            'id_b7',
            'id_perkara',
            'no_surat',
            'sifat',
            'lampiran',
            'kepada',
            'di_kepada',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'id_tersangka',
            'barbuk:ntext',
            'tindakan:ntext',
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
