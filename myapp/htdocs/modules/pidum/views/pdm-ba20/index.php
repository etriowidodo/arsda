<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\VwTerdakwaT2;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBA20Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'BA-20';
$this->subtitle = 'Surat Perintah Lelang Barang Bukti';
?>
<div class="pdm-ba20-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-ba20/delete'
        ]);  
    ?> 
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
	
    <?=
    GridView::widget([
        'id' => 'pdm-b4',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model->no_register_perkara."#".$model->tgl_ba20];
            },
        'dataProvider' => $dataProvider,
        //'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_register_perkara'." ".'tgl_ba20',
                'label' => 'No Register Perkara dan Tgl BA-20',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_register_perkara." dan ".$model->tgl_ba20;
                },
            ],
            [
                'attribute'=>'id_tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                        
                    return Yii::$app->globalfunc->getListTerdakwaBa4($model->no_register_perkara);
                },
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                //'header' => '',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->no_register_perkara.'#'.$model->tgl_ba20, 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>

</div>

<?php
$js = <<< JS
        $('td').dblclick(function (e) {
        var id  = $(this).closest('tr').data('id');
        var tm 	= id.toString().split("#");
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-ba20/update?id="+tm[0]+"&id2="+tm[1];
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>