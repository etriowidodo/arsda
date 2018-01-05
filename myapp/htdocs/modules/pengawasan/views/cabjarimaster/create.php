<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Tambah Cabjari ';
$this->params['breadcrumbs'][] = ['label' => 'Cabjari', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabjari-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
