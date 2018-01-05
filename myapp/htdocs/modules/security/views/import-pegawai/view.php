<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BackupConfig */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Backup Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-config-view">

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
            'host',
            'db',
            'port',
            'schema',
            'username',
            'password',
            'target_file',
            'command_path',
            'command_args',
            'createdby',
            'createdtime',
            'updatedby',
            'updatedtime',
        ],
    ]) ?>

</div>
