<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPerpanjanganTahanan */

$this->title = 'Tambah Perpanjangan Tahanan';
?>

<div class="pdm-perpanjangan-tahanan-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelAsalSurat' => $modelAsalSurat,
        'modelPenyidik' => $modelPenyidik,
		'modelTersangkas' => $modelTersangkas
		// tambahin model disini
    ]) ?>
</div>
