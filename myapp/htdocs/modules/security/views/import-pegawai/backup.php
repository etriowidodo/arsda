<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jalankan Backup';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::a('Jalankan Backup', '#', ['class' => 'btn btn-danger backup']) ?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-warning"></i>
                <h3 class="box-title">Alerts</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div id="prog"></div>
                <div class="hasil"></div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div>

<?php

$js = <<< JS
    $('.backup').click(function(e){

        $.ajax({
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
            });
    });
JS;
$this->registerJs($js);
?>
