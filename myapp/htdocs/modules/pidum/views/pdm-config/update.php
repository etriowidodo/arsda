<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmConfig */

$this->title = 'Ubah Config';

?>
<div class="pdm-config-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
