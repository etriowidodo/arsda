<?php

use kartik\file\FileInput;
use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jalankan Restore';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
	$form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]);
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-warning"></i>
                <h3 class="box-title">Alerts</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            	<?php

				    // Usage with ActiveForm and model
				    //change here: need to add image_path attribute from another table and add square bracket after image_path[] for multiple file upload.
				     echo $form->field($model, 'restore_path')->widget(FileInput::classname(), [
				        'options' => ['multiple' => true],
				        'pluginOptions' => [
				            //'previewFileType' => 'image',
				            //change here: below line is added just to hide upload button. Its up to you to add this code or not.
				            'showUpload' => false
				        ],
				    ]);
				    ?>
            	<div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Restore'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			    </div>
            	<?php //= Html::a('Jalankan Restore', '#', ['class' => 'btn btn-danger restore']) ?>
                <div id="prog"></div>
                <div class="hasil"><?= $json ?></div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div>
<?php ActiveForm::end(); ?>
<?php

$js = <<< JS
    $('.restore').click(function(e){
    	alert($('input[type=file]').val());
                return false;
        /*$.ajax({
                type: "POST",
                url: '/backup/backup',
                data: 'backup=true',
                success:function(data){
                    $('.hasil').html(data);
                },
                progress: function(e) {
                    if(e.lengthComputable) {
                        var pct = (e.loaded / e.total) * 100;
                        console.log(pct)
                    } else {
                        console.warn('Content Length not reported!');
                    }
                }
            });*/
    });
JS;
$this->registerJs($js);
?>