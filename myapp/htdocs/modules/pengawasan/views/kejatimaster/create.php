<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Tambah Kejati ';
$this->params['breadcrumbs'][] = ['label' => 'Kejati', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kejati-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
