<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was23b */

$this->title = 'Create Was23b';
$this->params['breadcrumbs'][] = ['label' => 'Was23b', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was23b-create">
	<h1></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
    ]) ?>

</div>
