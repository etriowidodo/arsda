<?php

use app\modules\pdsold\models\PdmB20;
use yii\web\View;

/* @var $this View */
/* @var $model PdmB20 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b20-update">


    <?=
    $this->render('_form', [
        'model' => $model,
        'modelbarbuk' => $modelbarbuk
    ])
    ?>

</div>
