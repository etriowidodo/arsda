<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas1 */

$this->title = 'Ubah L.WAS-2 Inspeksi';
$this->params['breadcrumbs'][] = ['label' => 'L WAS-2 Inspeksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="l_was_2-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'modelTerlaporUpd' => $modelTerlaporUpd,
        'modelHukdisUpd'=>$modelHukdisUpd,
        'modelPenandatangan'=>$modelPenandatangan,
    ]) ?>

</div>
