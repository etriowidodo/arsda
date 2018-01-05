<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was20b */

$this->title = 'Tambah Was20b';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Was20b', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was20b-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
        'modelPertanyaan' => $modelPertanyaan,
    ]) ?>

</div>
