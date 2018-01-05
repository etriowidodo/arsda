<?php

use app\modules\pdsold\models\PdmB19;
use yii\web\View;

/* @var $this View */
/* @var $model PdmB19 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = 'Permohonan Izin Pelelangan Barang Bukti yang Tidak Diambil';
?>
<div class="pdm-b19-update">

    <?=
    $this->render('_form', [
        'model'         => $model,
        'status'        => $status,
        'modelbarbuk'   => $modelbarbuk
    ])
    ?>

</div>
