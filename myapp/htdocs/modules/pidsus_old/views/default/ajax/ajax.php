<?php
use yii\helpers\Html;
echo Html::beginForm('', 'post', ['id' => 'link_form']);

echo "<div>" . Html::label('Name', 'name') . " "
		. Html::textInput('name', null, ['id' => 'name']) . "</div>";

echo "<div>" . Html::label('E-mail', 'email') . " "
		. Html::input('email', 'email', null, ['id' => 'email']) . "</div>";

echo Html::a('Click me', ['default/link-form'], [
		'id' => 'ajax_link_02',
		'data-on-done' => 'linkFormDone',
		'data-form-id' => 'link_form',
]
);

echo Html::endForm();

echo Html::tag('pre', '...', ['id' => 'ajax_result_02']);

$this->registerJs("$('#ajax_link_02').click(handleAjaxLink);", \yii\web\View::POS_READY);
?>