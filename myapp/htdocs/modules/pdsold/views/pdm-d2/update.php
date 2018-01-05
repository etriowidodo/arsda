<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmD2 */

$this->title = 'Update Pdm D2';
// $this->params['breadcrumbs'][] = ['label' => 'Pdm D2s', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_d2, 'url' => ['view', 'id' => $model->id_d2]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-d2-update">

    <?= $this->render('_form', [
        'model' => $model,
		'id'=>$id,
		'searchJPU' => $searchJPU,
		'dataJPU' => $dataJPU,
		'modelpenerima'=>$modelpenerima,
		'terdakwa' => $terdakwa,
		'd1' => $d1,
		'putusan' => $putusan,
    ]) ?>

</div>
