<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */

$this->title = 'Tambah WAS 14D';
$this->params['breadcrumbs'][] = ['label' => 'Dasar Sp Was Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dasar-sp-was-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
    ]) ?>

</div>
