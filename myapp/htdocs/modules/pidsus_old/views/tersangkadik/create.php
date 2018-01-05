<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidsus\models\PdsDikTersangka */

$this->title = 'Tambah Tersangka';

$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-dik-tersangka-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
