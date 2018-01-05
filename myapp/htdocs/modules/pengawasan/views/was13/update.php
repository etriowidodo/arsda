<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was13 */

$this->title = 'Update Was13: ' . ' ' . $model->id_was13;
$this->params['breadcrumbs'][] = ['label' => 'Was13s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was13, 'url' => ['view', 'id' => $model->id_was13]];
$this->params['breadcrumbs'][] = 'Update';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was13-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
          'model' => $model,
          'modelWas9' => $modelWas9,
          'modelWas10' => $modelWas10,
		  'modelWas11' => $modelWas11,
          'modelWas12' => $modelWas12,
    ]) ?>

</div>
