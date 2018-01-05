<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP13 */

$this->title = $model->id_p13;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P13s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p13-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p13], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p13], [
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
            'id_p13',
            'id_ba5',
            'no_surat',
            'sifat',
            'lampiran',
            'dikeluarkan',
            'tgl_surat',
            'kepada',
            'ket_saksi:ntext',
            'ket_ahli:ntext',
            'ket_surat:ntext',
            'petunjuk:ntext',
            'ket_tersangka:ntext',
            'hukum:ntext',
            'yuridis:ntext',
            'kesimpulan:ntext',
            'saran:ntext',
        ],
    ]) ?>

</div>
