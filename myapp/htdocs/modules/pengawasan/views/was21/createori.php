<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was21 */

$this->title = 'Create Was21';
$this->params['breadcrumbs'][] = ['label' => 'Was21s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was21-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
