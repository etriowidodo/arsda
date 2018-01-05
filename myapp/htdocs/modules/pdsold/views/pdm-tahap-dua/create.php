<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTahapDua */

$this->title = 'Berkas Tahap Dua';
// $this->params['breadcrumbs'][] = ['label' => 'Pdm Tahap Duas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-tahap-dua-create">

      <?= $this->render('_form', [
      	'modeluu'=> $modeluu,
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'searchUU' => $searchUU,
    	'dataUU' => $dataUU,
    	'modelPasal' => $modelPasal,
    	'searchModelt' => $searchModelt,
        'dataProvidert' => $dataProvidert,
        'putusan' => $putusan,
        'putusanTerdakwa' => $putusanTerdakwa,
        'modelSaksi'=>$modelSaksi,
        'modelAhli'=>$modelAhli,
    ]) ?>

</div>
