<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmSysMenu */

$this->title = 'Template Persuratan';
?>
<div class="pdm-sys-menu-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
