<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA11 */

$this->title = $model->id_ba11;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba11s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba11-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_ba11], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_ba11], [
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
            'id_ba11',
            'id_berkas',
            'tgl_surat',
            'reg_nomor',
            'reg_perkara',
            'tahanan',
            'ke_tahanan',
            'tgl_mulai',
            'kepala_rutan',
        ],
    ]) ?>

</div>
