<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTahapDua */

$this->title = 'Berkas Tahap Dua ';
// $this->params['breadcrumbs'][] = ['label' => 'Pdm Tahap Duas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-tahap-dua-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'modelPasal' => $modelPasal,
        'searchUU' => $searchUU,
        'dataUU' => $dataUU,
        'modelUuTahap1'=>$modelUuTahap1,
        'searchModelt' => $searchModelt,
        'dataProvidert'=>$dataProvidert,
        'modeluu'=> $modeluu,
        'modelSaksi'=>$modelSaksi,
        'modelAhli'=>$modelAhli,
    ]) ?>

</div>
