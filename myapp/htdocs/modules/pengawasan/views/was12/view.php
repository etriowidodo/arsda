<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was12 */

$this->title = $model->id_was_12;
$this->params['breadcrumbs'][] = ['label' => 'Was12', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was12-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_12], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_12], [
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
			  'id_was10',
			  'id_was_12',
			  'tanggal_was12',
			  'perihal_was12',
			  'lampiran_was12',
			  'kepada_was12',
			  'di_was12',
			  'nip_penandatangan',
			  'nama_penandatangan',
			  'pangkat_penandatangan',
			  'golongan_penandatangan',
			  'jabatan_penandatangan',
			  'was12_file',
			  'sifat_surat',
			  'jbtn_penandatangan,'
			  'no_surat',
			  'inst_satkerkd,'
			  'no_register',
        ],
    ]) ?>

</div>
