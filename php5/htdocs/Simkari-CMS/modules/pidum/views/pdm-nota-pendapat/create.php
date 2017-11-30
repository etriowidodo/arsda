<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapat */

$this->title = 'Nota Pendapat';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm Nota Pendapats', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-nota-pendapat-create">

    <!--<h1><? // Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model'         => $model,
        'modeljns'      => $modeljns,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
    ]) ?>

</div>