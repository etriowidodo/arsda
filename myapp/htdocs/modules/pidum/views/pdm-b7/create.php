<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB7 */

$this->title = 'B-7';
$this->subtitle = 'Copy Pemberitahuan Surat Perintah Penyitaan';
?>
<div class="pdm-b7-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp
    ]) ?>

</div>
