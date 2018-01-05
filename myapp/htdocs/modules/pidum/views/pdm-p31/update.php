<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP30 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
/*$this->params['breadcrumbs'][] = ['label' => 'Pdm P30s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_p30, 'url' => ['view', 'id' => $model->id_p30]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="pdm-p31-update">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'id' => $idPerkara,
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'modelTersangka'=>$modelTersangka,
         'dataProviderTersangka' => $dataProviderTersangka
        //'terdakwa' => $terdakwa,
    ]) ?>

</div>
