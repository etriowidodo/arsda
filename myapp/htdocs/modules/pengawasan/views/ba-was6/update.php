<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas1 */

$this->title = 'Ubah BA.WAS-6';
$this->params['breadcrumbs'][] = ['label' => 'Ba Was6', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="sp-was1-create">
	
    <?= $this->render('_form', [
        'model' => $model,
		
    ]) ?>

</div>