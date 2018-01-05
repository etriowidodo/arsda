<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Tambah WAS-9 Inspeksi';
$this->params['breadcrumbs'][] = ['label' => 'WAS-9 Inspeksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'spwas2' => $spwas2,
        'modelTembusanMaster' => $modelTembusanMaster,
        //'modelSaksiEksternal' => $modelSaksiEksternal,
        // 'LoadSaksiEksternal' => $LoadSaksiEksternal,
        // 'LoadSaksiInternal' => $LoadSaksiInternal,
		'result_expire' => $result_expire,
    ]) ?>

</div>
