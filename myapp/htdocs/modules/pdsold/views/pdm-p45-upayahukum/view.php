<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP45 */

$this->title = $model->id_p45;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P45s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p45-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p45], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p45], [
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
            'id_p45',
            'id_perkara',
            'no_surat',
            'sifat',
            'lampiran',
            'kepada',
            'di_kepada',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'id_tersangka',
            'put_pengadilan',
            'no_put_pengadilan',
            'tgl_put_pengadilan',
            'menyatakan:ntext',
            'tgl_tuntutan',
            'menuntut:ntext',
            'pernyataan_terdakwa:ntext',
            'pernyataan_jaksa:ntext',
            'pertimbangan:ntext',
            'id_penandatangan',
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
