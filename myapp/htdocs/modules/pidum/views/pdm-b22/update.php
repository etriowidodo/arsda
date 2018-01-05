<?php

use app\modules\pidum\models\PdmB22;
use yii\web\View;

/* @var $this View */
/* @var $model PdmB22 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b22-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
