<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MasterPeraturan */

$this->title = 'Tambah Peraturan';
$this->params['breadcrumbs'][] = ['label' => 'Tambah Peraturan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-peraturan-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
