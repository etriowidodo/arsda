<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT15 */

$this->title = $model->id_t15;
$this->params['breadcrumbs'][] = ['label' => 'Pdm T15s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-t15-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_t15], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_t15], [
            'class' => 'btn btn-danger delete hapus',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_t15',
            'id_t8',
            'no_surat',
            'sifat',
            'lampiran',
            'modus:ntext',
            'kerugian:ntext',
            'id_penandatangan',
        ],
    ]) ?>

</div>
