<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmRP11 */

$this->title = $model->no_register_perkara;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Rp11s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-rp11-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'no_register_perkara' => $model->no_register_perkara, 'no_akta' => $model->no_akta, 'no_reg_tahanan' => $model->no_reg_tahanan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'no_register_perkara' => $model->no_register_perkara, 'no_akta' => $model->no_akta, 'no_reg_tahanan' => $model->no_reg_tahanan], [
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
            'no_register_perkara',
            'no_akta',
            'tgl_akta',
            'no_reg_tahanan',
            'id_pengajuan',
            'id_jns_pengajuan',
            'id_kejati',
            'id_kejari',
            'id_cabjari',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
