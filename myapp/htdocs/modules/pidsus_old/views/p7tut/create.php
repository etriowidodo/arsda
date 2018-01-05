<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidsus\models\PdsDikMatrixPerkara */

$this->title = 'P7- Matrix Perkara Penuntutan';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-dik-matrix-perkara-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
