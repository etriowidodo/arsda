<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16b */

$this->title = 'Was-17';
$this->subtitle = 'Nota Dinas Pemberitahuan Usulan Untuk Dijatuhi Hukuman Disiplin Berat Terhadap Terlapor';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Was17s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

  	// print_r($modelTembusanMaster);
   //  exit();
?>
<div class="was17-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
        'modelwas17' => $modelwas17,
        
    ]) 
    ?>

</div>
