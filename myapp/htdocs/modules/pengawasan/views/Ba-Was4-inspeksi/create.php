<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Tambah BA.WAS-4 SURAT PERNYATAAN';
$this->params['breadcrumbs'][] = ['label' => 'Dipa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
