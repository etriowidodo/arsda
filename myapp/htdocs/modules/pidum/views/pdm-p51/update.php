<?php

use app\modules\pidum\models\PdmP51;
use yii\web\View;

/* @var $this View */
/* @var $model PdmP51 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p51-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
