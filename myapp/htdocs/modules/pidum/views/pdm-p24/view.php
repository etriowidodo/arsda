<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP24 */

$this->title = $model->id_p24;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P24s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="pdm-p24-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p24], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p24], [
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
            'id_p24',
            'id_berkas',
            'tgl_surat',
            'ket_saksi:ntext',
            'ket_ahli:ntext',
            'alat_bukti:ntext',
            'benda_sitaan:ntext',
            'ket_tersangka:ntext',
            'fakta_hukum:ntext',
            'yuridis:ntext',
            'kesimpulan:ntext',
            'pendapat:ntext',
            'saran:ntext',
            'petunjuk:ntext',
            'status_berkas:boolean',
        ],
    ]) ?>

</div>
