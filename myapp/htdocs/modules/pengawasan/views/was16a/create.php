<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16a */

$this->title = 'WAS-16a';
$this->subtitle = 'Surat Pemberitahuan Usulan Untuk Dijatuhi Hukuman Disiplin Berat Terhadap Terlapor';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
$this->params['breadcrumbs'][] = ['label' => 'Was16as', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was16a-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1>-->
    <?= $this->render('_form',[
						'model'=>$model,
			]) ?>

</div>
