<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT15 */

$this->title ='T15';
$this->subtitle = 'BANTUAN PENAYANGAN BURONAN';
/*$this->params['breadcrumbs'][] = ['label' => 'Pdm T15s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="pdm-t15-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelMsTersangka' => $modelMsTersangka,
        'id' => $idPerkara,
        'di' => $di,
        'dataProviderTersangka' => $dataProviderTersangka,
    ]) ?>

</div>
