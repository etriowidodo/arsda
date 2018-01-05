<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPelakPenyidikan */

$this->title = $model->kode_ip;
$this->params['breadcrumbs'][] = ['label' => 'Ms Inst Pelak Penyidikans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-inst-pelak-penyidikan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'kode_ip' => $model->kode_ip, 'kode_ipp' => $model->kode_ipp], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'kode_ip' => $model->kode_ip, 'kode_ipp' => $model->kode_ipp], [
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
            'kode_ip',
            'kode_ipp',
            'nama',
            'akronim',
        ],
    ]) ?>

</div>
