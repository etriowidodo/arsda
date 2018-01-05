<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA13 */

$this->title = $model->id_ba13;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba13s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba13-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_ba13], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_ba13], [
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
            'id_ba13',
            'id_t8',
            'tgl_pengeluaran',
            'no_surat',
            'tgl_penahanan',
            'id_ms_loktahanan',
            'tgl_mulai',
            'id_penandatangan',
            'kepala_rutan',
        ],
    ]) ?>

</div>
