<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */

$this->title = $model->id_dasar_spwas;
$this->params['breadcrumbs'][] = ['label' => 'Dasar Sp Was Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dasar-sp-was-master-view">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_dasar_spwas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_dasar_spwas], [
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
            'id_dasar_spwas',
            'isi_dasar_spwas:ntext',
            'tahun',
        ],
    ]) ?>

</div>
