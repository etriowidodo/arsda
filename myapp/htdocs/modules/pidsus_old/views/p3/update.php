<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidRenlid */

$this->title = 'P3 - Rencana Penyelidikan';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Rencana Penyelidikan', 'url' => ['index?id='.$modelSurat->id_pds_lid]];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-renlid-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
