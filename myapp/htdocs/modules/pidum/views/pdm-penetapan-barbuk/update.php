<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenetapanBarbuk */
$this->title = 'Penetapan Sita Narkotika';

?>
<div class="pdm-penetapan-barbuk-update">

   

    <?= $this->render('_form', [
        'model' => $model,
		'searchSPDP' => $searchSPDP,
		'dataSPDP' => $dataSPDP,
		'modelSurat' => $modelSurat,
		'modelBarbuk' => $modelBarbuk,
		'modelKepentingan' => $modelKepentingan,
    ]) ?>

</div>
