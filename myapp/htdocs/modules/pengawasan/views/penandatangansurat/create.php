<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Penandatangan */

$this->title = 'Tambah Penandatangan Surat';
$this->params['breadcrumbs'][] = ['label' => 'Penandatangan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penandatangan-surat-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
