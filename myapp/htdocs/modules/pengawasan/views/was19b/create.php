<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was19b */

$this->title = 'Was-19b';
$this->subtitle = 'Nota Dinas Pemberitahuan Usulan Untuk Dijatuhi Hukuman Disiplin Berat Terhadap Terlapor';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['breadcrumbs'][] = ['label' => 'Was19b', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

    // print_r($modelTembusanMaster);
   //  exit();
?>
<div class="was19b-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusanMaster' => $modelTembusanMaster,
        'modelwas19b' => $modelwas19b,
        
    ]) 
    ?>

</div>
