<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP26 */

$this->title = $model->id_p26;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P26s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p26-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p26], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p26], [
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
            'id_p26',
            'id_perkara',
            'id_p13',
            'no_surat',
            'tgl_ba',
            'tgl_persetujuan',
            'id_tersangka',
            'kasus_posisi:ntext',
            'pasal_disangka:ntext',
            'barbuk:ntext',
            'alasan:ntext',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'id_penandatangan',
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
