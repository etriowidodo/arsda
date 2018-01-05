<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmSysMenu */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Sys Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-sys-menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'kd_berkas',
            'no_urut',
            'durasi',
            'keterangan',
            'url:url',
            'id__group_perkara',
            'flag',
            'akronim',
            'no_surat',
            'id_menu',
            'is_show',
        ],
    ]) ?>

</div>
