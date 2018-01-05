<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27Klari */

$this->title = $model->id_was_27_klari;
$this->params['breadcrumbs'][] = ['label' => 'Was27 Klaris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was27-klari-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_27_klari], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_27_klari], [
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
            'id_was_27_klari',
            'no_register',
            'inst_satkerkd',
            'no_was_27_klari',
            'tgl',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            // 'data_data',
            'upload_file_data',
            'analisa',
            'kesimpulan',
            'rncn_henti_riksa_1_was_27_kla',
            'rncn_henti_riksa_2_was_27_kla',
            'pendapat_1_was_27_kla',
            'pendapat',
            'persetujuan',
            
        ],
    ]) ?>

</div>
