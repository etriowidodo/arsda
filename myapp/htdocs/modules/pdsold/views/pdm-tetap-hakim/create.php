<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTetapHakim */

$this->title = 'Tetap Penetapan Hakim';
// $this->params['breadcrumbs'][] = ['label' => 'Pdm Tetap Hakims', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-tetap-hakim-create">

   
    <?= $this->render('_form', [
        'model' => $model,
		'modelSpdp'=> $modelSpdp,
    ]) ?>

</div>
