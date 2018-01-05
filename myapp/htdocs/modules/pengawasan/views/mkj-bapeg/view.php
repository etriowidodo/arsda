<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MkjBapeg */

$this->title = $model->id_mkj_bapeg;
$this->params['breadcrumbs'][] = ['label' => 'Mkj Bapegs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mkj-bapeg-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_mkj_bapeg], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_mkj_bapeg], [
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
            'id_mkj_bapeg',
            'no_mkj_bapeg',
            'id_register',
            'inst_satkerkd',
            'tgl_mkj_bapeg',
            'id_terlapor',
            'hasil_putusan',
            'id_peraturan',
            'tingkat_kd',
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
