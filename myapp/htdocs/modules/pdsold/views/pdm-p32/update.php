<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmSysMenu;

$SysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P32]);
$this->title = $SysMenu->kd_berkas;
$this->subtitle = $SysMenu->keterangan;
?>
<div class="pdm-p32-update">

    <?=
    $this->render('_form', [
        'model' => $model,
        'ba5' => $ba5,
    ])
    ?>

</div>
