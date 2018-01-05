<?php

use app\modules\pidum\models\PdmB20;
use yii\web\View;

/* @var $this View */
/* @var $model PdmB20 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b20-create">


    <?=
    $this->render('_form', [
        'model' => $model,
        'modelbarbuk' => $modelbarbuk
    ])
    ?>

</div>
