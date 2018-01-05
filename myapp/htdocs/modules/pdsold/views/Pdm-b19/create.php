<?php

use yii\helpers\Html;


/* @var $this View */
/* @var $model PdmB19 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = 'Permohonan Izin Pelelangan Barang Bukti yang Tidak Diambil';
?>
<div class="pdm-b19-create">

    <?= $this->render('_form', [
        'model'         => $model,
        'status'        => $status,
        'modelbarbuk'   => $modelbarbuk,
    ]) ?>

</div>
