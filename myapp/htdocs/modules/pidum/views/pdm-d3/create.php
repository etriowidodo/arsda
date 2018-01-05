<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmD3 */

$this->title = 'Tanda terima Pembayaran';

?>
<div class="pdm-d3-create">

    <?= $this->render('_form', [
        'model' => $model,
        'tersangka' => $tersangka,
        'jum' => $jum,
        'putusan' => $putusan,
    ]) ?>

</div>
