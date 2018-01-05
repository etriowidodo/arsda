<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB18 */

$this->title = $model->id_b18;
$this->params['breadcrumbs'][] = ['label' => 'Pdm B18s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-b18-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_b18], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_b18], [
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
            'id_b18',
            'id_berkas',
            'no_surat',
            'tgl_surat',
            'dikeluarkan',
            'id_penandatangan',
        ],
    ]) ?>

</div>
