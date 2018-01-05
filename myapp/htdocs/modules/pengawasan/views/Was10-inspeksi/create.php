<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Tambah WAS-10';
$this->params['breadcrumbs'][] = ['label' => 'WAS-10', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="dipa-master-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
<?php //print_r($spWas2); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'spWas2' => $spWas2,
        'result_expire' => $result_expire,
        'modelTembusanMaster' => $modelTembusanMaster,
    ]) ?>

</div>
