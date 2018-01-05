<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was20a */

$this->title = 'Tambah Was20a';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Was20a', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was20a-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
        'modelPertanyaan' => $modelPertanyaan,
    ]) ?>

</div>
