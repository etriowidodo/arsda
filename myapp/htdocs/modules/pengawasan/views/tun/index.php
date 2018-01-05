<?php

use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\TunSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'TUN';
$this->subtitle = 'Tata Usaha Negara';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
/*$this->title = 'Tuns';
$this->params['breadcrumbs'][] = $this->title;*/
?>

<?php
$form = ActiveForm::begin([
    'id' => 'hapus-index',
    'action' => '/pengawasan/tun/delete'
]);
?>
<div id="temp-hapus" style="text-align: right;">
    <!--<a class="btn btn-warning btnHapusCheckboxIndex">hapus</a>-->
</div>
<!--<div id="btnHapus"></div><div id="btnUpdate"></div>-->
<?php ActiveForm::end() ?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1" style="margin-top: 20px;">
        <div class="sk-was3a-index">
            <div id="divHapus">
                <div class="pull-left">
                    <button id="btnTambah" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>Tambah TUN</button>
                </div>
                <div class="pull-right">
                    <!--<button id="btnCetak" class="btn btn-primary" type="button"><i class="fa fa-print"></i> Cetak
                    </button>
                    &nbsp;-->
                    <button id="btnHapusCheckboxIndex" class="btn btn-primary" type="button"><i
                            class="fa fa-times"></i> Hapus
                    </button>
                </div>
            </div>

            <br/><br/>

            <?=
            GridView::widget([
                'id' => 'was-tun',
                'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-id' => $model['id_tun']];
                    },
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'no_tun',
                        'label' => 'No. TUN',
                    ],
                    [
                        'attribute' => 'peg_nip',
                        'label' => 'NIP',
                        //'format' => ['date', 'php:d-m-Y'],
                    ],
                    [
                        'attribute' => 'peg_nama',
                        'label' => 'Nama',
                    ],
                    [
                        'attribute' => 'jabatan',
                        'label' => 'Jabatan',
                    ],
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        //'header' => '',
                        'multiple' => true,
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model['id_tun'], 'class' => 'checkHapusIndex'];
                            }
                    ],
                ],
                'export' => false,
                'pjax' => true,
                'responsive' => true,
                'hover' => true,
            ]); ?>

            <?php /*echo
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id_sk_was_3a',
                        'no_sk_was_3a',
                        'inst_satkerkd',
                        'id_register',
                        'tgl_sk_was_3a',
                        // 'ttd_sk_was_3a',
                        // 'id_terlapor',
                        // 'tingkat_kd',
                        // 'ttd_peg_nik',
                        // 'ttd_id_jabatan',
                        // 'upload_file',
                        // 'flag',
                        // 'created_by',
                        // 'created_ip',
                        // 'created_time',
                        // 'updated_ip',
                        // 'updated_by',
                        // 'updated_time',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); */
            ?>
        </div>

    </div>
  <br>
  <?= Html::Button('<i class="fa fa-arrow-left"></i> Kembali', ['class' => 'tombolbatal btn btn-primary', 'value' => $session->get('was_register')]) ?>
</section>

<?php
Modal::begin([
    'id' => 'm_tun',
    'size' => 'modal-lg',
    'header' => 'Form Tata Usaha Negara',
]);
?>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'id' => 'm_kejaksaan',
    'header' => 'Data Kejaksaan',
    'options' => [
        'data-url' => '',
    ],
]);

echo $this->render('@app/modules/pengawasan/views/global/_modalKejaksaan', [
    'model' => $model,
    'searchSatker' => $searchSatker,
    'dataProviderSatker' => $dataProviderSatker,
]);
Modal::end();
?>

<?php $indexJS = <<< JS
    $('td').css('cursor', 'pointer');
    $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        $("#m_tun").modal('show').load('/pengawasan/tun/update','id='+id);
    });

    $('#btnTambah').click(function() {
        $("#m_tun").modal('show').load('/pengawasan/tun/create');
    });
JS;

$this->registerJs($indexJS);
?>

<?php $this->registerJs("
    $(document)
  .on('show.bs.modal', '.modal', function(event) {
    $(this).appendTo($('body'));
  })
  .on('shown.bs.modal', '.modal.in', function(event) {
    setModalsAndBackdropsOrder();
  })
  .on('hidden.bs.modal', '.modal', function(event) {
    setModalsAndBackdropsOrder();
  });
 $.fn.modal.Constructor.DEFAULTS.backdrop = 'static';
function setModalsAndBackdropsOrder() {
  var modalZIndex = 1040;
  $('.modal.in').each(function(index) {
    var modal = $(this);
    modalZIndex++;
    modal.css('zIndex', modalZIndex);
    modal.css('overflow', 'scroll');
    modal.next('.modal-backdrop.in').addClass('hidden').css('zIndex', modalZIndex - 1);

});
  $('.modal.in:visible:last').focus().next('.modal-backdrop.in').removeClass('hidden');

} ", \yii\web\View::POS_END);
?>