<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas1 */

$this->title = 'Tambah BA.WAS-2';
$this->params['breadcrumbs'][] = ['label' => 'Ba Was2', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="sp-was1-create">

    <?= $this->render('_form', [
        'model' => $model,
		'modelSpWas1' => $modelSpWas1,
		'modelPemeriksa' => $modelPemeriksa,
		'modelSaksiInternal' =>  $modelSaksiInternal,
		'modelSaksiEksternal' => $modelSaksiEksternal,
		// 'spwas1' => $spwas1,
    ]) ?>

</div>
