<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP19 */

$this->title = $model->id_p19;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P19s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p19-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p19], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p19], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
		    'model2' => $model2,
			    'model3' => $model3,
        'attributes' => [
            'id_p19',
            'id_p24',
            'no_surat',
            'sifat',
            'lampiran',
            'tgl_surat',
            'dikeluarkan',
            'kepada',
            'di',
            'petunjuk:ntext',
            'id_penandatangan',
        ],
    ]) ?>

</div>
