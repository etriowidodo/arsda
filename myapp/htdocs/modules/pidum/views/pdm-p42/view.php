<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP42 */

$this->title = $model->id_p42;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P42s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p42-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p42], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p42], [
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
            'id_p42',
            'no_perkara',
            'ket_saksi:ntext',
            'ket_ahli:ntext',
            'ket_surat:ntext',
            'petunjuk:ntext',
            'ket_tersangka:ntext',
            'barbuk:ntext',
            'unsur_dakwaan:ntext',
            'memberatkan:ntext',
            'meringankan:ntext',
            'tgl_dikeluarkan',
            'id_penandatangan',
            'id_perkara',
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