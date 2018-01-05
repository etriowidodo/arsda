<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTetapHakim */

$this->title = 'Tetap Penetapan Hakim';
/* $this->params['breadcrumbs'][] = ['label' => 'Pdm Tetap Hakims', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_thakim, 'url' => ['view', 'id' => $model->id_thakim]];
$this->params['breadcrumbs'][] = 'Update'; */
?>
<div class="pdm-tetap-hakim-update">

    <?= $this->render('_form', [
        'model' => $model,
		'modelSpdp'=> $modelSpdp,
    ]) ?>

</div>
