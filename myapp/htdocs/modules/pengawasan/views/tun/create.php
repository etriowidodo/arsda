<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Tun */

$this->title = 'Create Tun';
$this->params['breadcrumbs'][] = ['label' => 'Tuns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tun-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
