<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT6 */

$this->title = $model->id_t6;
$this->params['breadcrumbs'][] = ['label' => 'Pdm T6s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-t6-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_t6], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_t6], [
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
            'id_t6',
            'id_perkara',
            'id_berkas',
            'no_surat',
            'sifat',
            'lampiran',
            'kepada',
            'di',
            'id_tersangka',
            'alasan:ntext',
            'karena:ntext',
            'tgl_mulai',
            'tgl_selesai',
            'dikeluarkan',
            'tgl_surat',
            'id_penandatangan',
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
