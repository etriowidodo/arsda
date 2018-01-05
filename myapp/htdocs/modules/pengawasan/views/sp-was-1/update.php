<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas1 */

$this->title = 'Ubah SP.WAS-1';
$this->params['breadcrumbs'][] = ['label' => 'Sp Was1', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="sp-was1-create">

    

    <?= $this->render('_form', [
         'model' => $model,
         'modelPemeriksa' => $modelPemeriksa,
         'modelTembusan' => $modelTembusan,
         'modelDasarSurat' => $modelDasarSurat,
         'modelTerlapor' => $modelTerlapor,
         'modelPegawaiTerlapor' => $modelPegawaiTerlapor,
         'modelWas1' => $modelWas1,
         'result_expire' => $result_expire,
    ]) ?>

</div>
