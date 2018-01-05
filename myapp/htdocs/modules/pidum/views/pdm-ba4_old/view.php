<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA4 */

$this->title = $model->id_ba4;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba4-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_ba4], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_ba4], [
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
            'id_ba4',
            'id_berkas',
            'tgl_ba',
        ],
    ]) ?>

</div>
