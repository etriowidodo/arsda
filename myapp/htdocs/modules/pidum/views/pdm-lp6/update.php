<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\VLaporanP6 */

$this->title = 'Update Vlaporan P6: ' . ' ' . $model->w;
$this->params['breadcrumbs'][] = ['label' => 'Vlaporan P6s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->w, 'url' => ['view', 'id' => $model->w]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vlaporan-p6-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
