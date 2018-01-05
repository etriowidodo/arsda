<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP38 */

$this->title = "Penetapan Hakim";
//$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-penetapan-hakim-update">

    <!--<h1><?// Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model'         => $model,
    ]) ?>

</div>
