<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa20 */

$this->title = $model->id_ba8;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba20s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba20-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_ba8], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_ba8], [
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
            'id_ba8',
            'id_perkara',
            'tgl_surat',
            'lokasi',
            'id_tersangka',
            'bar_buk:ntext',
            'nama',
            'pekerjaan',
            'alamat',
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
