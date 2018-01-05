<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT15 */

$this->title = 'T15';
$this->subtitle = 'BANTUAN PENAYANGAN BURONAN';
/*$this->params['breadcrumbs'][] = ['label' => 'Pdm T15s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_t15, 'url' => ['view', 'id' => $model->id_t15]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="pdm-t15-update">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
        'di' => $di,
        'modelMsTersangka'=>$modelMsTersangka,
        'tblTersangka'=>$tblTersangka,
        'style'=>$style,
        'dataProviderTersangka'=>$dataProviderTersangka,
    ]) ?>

</div>
