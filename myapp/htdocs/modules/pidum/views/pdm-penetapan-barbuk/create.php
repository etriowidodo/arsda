<?php

use yii\helpers\Html;

$this->title = 'Penetapan Sita Narkotika';
?>
<div class="pdm-penetapan-barbuk-create">


    <?= $this->render('_form', [
        'model' => $model,
        'searchSPDP' => $searchSPDP,
		'dataSPDP' => $dataSPDP,
    ]) ?>

</div>
