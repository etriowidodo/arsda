<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16b */

$this->title = 'Was-16b';
$this->subtitle = 'Nota Dinas Pemberitahuan Usulan Untuk Dijatuhi Hukuman Disiplin Berat Terhadap Terlapor';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Was16bs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

  	// print_r($modelTembusanMaster);
   //  exit();
?>
<div class="was16b-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
        'modelPertanyaan' => $modelPertanyaan,
        
    ]) 
    ?>

</div>
