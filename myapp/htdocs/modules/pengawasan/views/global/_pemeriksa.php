<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
  function pilihPemeriksa(id, param) {
    var value = $("#pilihPemeriksa" + id).val();
    var data = value.split('#');
    var count = 1;
    $('#tbody_pemeriksa-' + param).append(
            '<tr id="pemeriksa-' + data[4] + '">' +
            '<td><input type="text" class="form-control" name="peg_nama[]" readonly="true" value="' + data[0] + '"> </td>' +
            '<td><input type="text" class="form-control" name="peg_nip_baru[]" readonly="true" value="' + data[1] + '"> </td>' +
            '<td><input type="text" class="form-control" name="jabatan[]" readonly="true" value="' + data[2] + '"> </td>' +
            '<td><button onclick="removeRow(\'pemeriksa-' + data[4] + '\')" class="btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button></td>' +
            '</tr>'
            + '<input type="hidden" name="id_pemeriksa[]" value="' + data[3] + '" />'
            + '<input type="hidden" name="peg_nik_pemeriksa[]" value="' + data[4] + '" />'
            );
    $('#pemeriksa').modal('hide');
  }
</script>
<?php

$searchModel = new \app\models\KpPegawaiSearch();
$dataProvider = $searchModel->searchPegawai(Yii::$app->request->queryParams);
$gridColumn = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        //'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_nama',
        'label' => 'Nama',
    ],
    [
        //'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_nip_baru',
        'label' => 'NIP',
    ],
    [
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jabatan',
        'label' => 'Jabatan',
    ],
    [
        'class' => '\kartik\grid\ActionColumn',
        'template' => '{pilih}',
        'buttons' => [
            'pilih' => function ($url, $model, $key) use($param) {
              return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary', 'onClick' => 'pilihPemeriksa(' . $model['id'] . ',"' . $param . '")',
                          'id' => 'pilihPemeriksa' . $model['id'],
                          'value' => $model['peg_nama'] . '#' .
                          $model['peg_nip_baru'] . '#' .
                          $model['jabatan'] . '#' .
                          $model['id'] . '#' .
                          $model['peg_nik']]);
            }
                ],
            ]
        ];
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => 'gridPegawaiTT',
            'layout' => "{items}\n{pager}",
            'columns' => $gridColumn,
            'responsive' => true,
            'hover' => true,
            'export' => false,
            'pjax' => true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
            ],
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ],
                'neverTimeout' => true,
            //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]
        ]);
        ?>
