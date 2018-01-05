<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PdsDikRendik */

$this->title = 'P8A - Rencana Jadwal Kegiatan Penyidikan';
//$this->params['breadcrumbs'][] = ['label' => 'Pds Dik Rendiks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pds_dik_rendik, 'url' => ['view', 'id' => $model->id_pds_dik_rendik]];
//$this->params['breadcrumbs'][] = 'Update';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-dik-rendik-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
