<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MkjBapeg */

$this->title = 'Create Mkj Bapeg';
$this->params['breadcrumbs'][] = ['label' => 'Mkj Bapegs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mkj-bapeg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
