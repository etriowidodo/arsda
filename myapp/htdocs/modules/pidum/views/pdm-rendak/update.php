<?php

use yii\helpers\Html;

$this->title = $sysMenu->kd_berkas;

?>
<div class="pdm-rendak-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelBerkas' => $modelBerkas,
        'p21' => $p21,
    ]) ?>

</div>
