<?php

use kartik\form\ActiveForm;

$this->title = 'Export Data Perkara';
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="hasil"></div>
<?php //$form = ActiveForm::begin(); ?>
	<button class="btn btn-primary export">Export</button>
<?php //ActiveForm::end(); ?>
<?php

$js = <<< JS
    $('.export').click(function(e){
    	$.ajax({
                type: "POST",
                url: '/backup/export',
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
            });
    });
JS;
$this->registerJs($js);
?>