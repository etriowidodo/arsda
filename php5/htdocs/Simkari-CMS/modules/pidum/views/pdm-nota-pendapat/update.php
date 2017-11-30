<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapat */

$this->title = 'Nota Pendapat';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm Nota Pendapats', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->no_register_perkara, 'url' => ['view', 'no_register_perkara' => $model->no_register_perkara, 'jenis_nota_pendapat' => $model->jenis_nota_pendapat, 'id_nota_pendapat' => $model->id_nota_pendapat]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-nota-pendapat-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model'         => $model,
        'modeljns'      => $modeljns,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
    ]) ?>

</div>