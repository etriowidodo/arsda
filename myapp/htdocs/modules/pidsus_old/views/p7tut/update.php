<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidsus\models\PdsDikMatrixPerkara */

$this->title = 'P7- Matrix Perkara Penuntutan';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-tut-matrix-perkara-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
