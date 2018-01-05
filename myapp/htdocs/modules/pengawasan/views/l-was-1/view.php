<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\LWas1 */

$this->title = $model->id_l_was_1;
$this->params['breadcrumbs'][] = ['label' => 'Lwas1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lwas1-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_l_was_1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_l_was_1], [
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
            'id_l_was_1',
            'id_register',
            'inst_satkerkd',
            'tgl',
            'data_data',
            'upload_file_data',
            'analisa',
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
