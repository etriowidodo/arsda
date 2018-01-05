<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmB16Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b16-index">



	
	<?php
    $form = ActiveForm::begin([
        'id' => 'hapus-index',
        'action' => '/pidum/pdm-b16/delete'
    ]);
    ?>
	
    <div id="divHapus">
                <div class="pull-left"><?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?></div>
            </div>
	
	<div id="divHapus">
                <div class="pull-right"><a class='btn btn-danger delete hapusTembusan btnHapusCheckboxIndex'></a><br></div>
            </div>
			
    <?php ActiveForm::end() ?>
	
	<div class="row">
                <div class="col-md-12">
    <?=
    GridView::widget([
        'id' => 'pdm-b16',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['id_b16']];
            },
        'dataProvider' => $dataProvider,
        //'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'no_surat',
                'label' => 'Nomor Surat',
                //'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute' => 'nama',
                'label' => 'Tersangka',
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                //'header' => '',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id_b16'], 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>

	
    <?php  /*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_b16',
            'id_perkara',
            'no_surat',
            'sifat',
            'lampiran',
            // 'kepada',
            // 'di_kepada',
            // 'dikeluarkan',
            // 'tgl_dikeluarkan',
            // 'id_tersangka',
            // 'pelaksanaan_lelang',
            // 'tgl_lelang',
            // 'total',
            // 'bank',
            // 'ba_penitipan',
            // 'tgl_ba',
            // 'no_persetujuan',
            // 'tgl_persetujuan',
            // 'kantor_lelang',
            // 'no_risalan',
            // 'id_penandatangan',
            // 'flag',
            // 'created_by',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'updated_by',
            // 'updated_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */ ?>
	</div>
	</div>

</div>

<?php
$js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-b16/update?id="+id;
        $(location).attr('href',url);
    });
JS;
$this->registerJs($js);
?>