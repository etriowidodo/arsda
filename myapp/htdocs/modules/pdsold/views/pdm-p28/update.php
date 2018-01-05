<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP28 */

$this->title = 'P28';
$this->subtitle = 'Riwayat Perkara';
?>
<div class="pdm-p28-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelRp9' => $modelRp9,
        'modelRt3' => $modelRt3,
        'modelRb2' => $modelRb2,
        'modelSidang'=>$modelSidang
    ]) ?>

</div>
