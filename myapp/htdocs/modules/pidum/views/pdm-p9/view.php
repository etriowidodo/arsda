<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP9 */

$this->title = $model->id_p9;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P9s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p9-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p9], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p9], [
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
            'id_p9',
            'id_perkara',
            'no_surat',
            'kepada',
            'di_kepada',
            'tgl_panggilan',
            'jam',
            'tempat',
            'menghadap',
            'sebagai',
            'id_msstatusdata',
            'id_panggilan_saksi',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'id_penandatangan',
            'flag',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
            'di',
        ],
    ]) ?>

</div>
