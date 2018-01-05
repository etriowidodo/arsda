<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas1 */

$this->title = 'Tambah BA.WAS-3';
$this->params['breadcrumbs'][] = ['label' => 'Ba Was3', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="ba-was3-create">
	
    <?= $this->render('_form', [
        'model' => $model,		
		'modelSpWas1' =>$modelSpWas1,
		// 'modelPemeriksa'=>$modelPemeriksa,
		// 'modelTerlapor' => $modelTerlapor,
		// 'modelSaksiInternal'=>$modelSaksiInternal,
		// 'modelSaksiEksternal'=>$modelSaksiEksternal,
		//'modelPertanyaan'=>$modelPertanyaan,
    ]) ?>

</div>
