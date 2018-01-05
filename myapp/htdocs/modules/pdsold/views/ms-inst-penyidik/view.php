<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPenyidik */

$this->title = $model->kode_ip;
$this->params['breadcrumbs'][] = ['label' => 'Ms Inst Penyidiks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-inst-penyidik-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->kode_ip], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->kode_ip], [
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
            'nama',
            'akronim',
        ],
    ]) ?>

</div>
