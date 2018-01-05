<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsDikRendik */

$this->title = 'P8A - Rencana Jadwal Kegiatan Penyidikan';
//$this->params['breadcrumbs'][] = ['label' => 'Pds Dik Rendiks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-dik-rendik-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
