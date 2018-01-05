<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BackupConfig */

$this->title = 'Update Backup Config: ' . ' ' . $model->db;
$this->params['breadcrumbs'][] = ['label' => 'Backup Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->db, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="backup-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
