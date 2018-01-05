<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmD2 */

$this->title = 'Pdm D2';
// $this->params['breadcrumbs'][] = ['label' => 'Pdm D2s', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-d2-create">

     <?= $this->render('_form', [
        'model' => $model,
		'searchJPU' => $searchJPU,
		 'dataJPU' => $dataJPU,
		 'modelpenerima'=>$modelpenerima,
		 'terdakwa' => $terdakwa,
		 'd1' => $d1,
		 'putusan' => $putusan,
    ]) ?>

</div>
