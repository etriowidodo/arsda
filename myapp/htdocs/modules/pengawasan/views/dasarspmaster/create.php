<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */

$this->title = 'Tambah Dasar Sp Was Master';
$this->params['breadcrumbs'][] = ['label' => 'Dasar Sp Was Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dasar-sp-was-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
