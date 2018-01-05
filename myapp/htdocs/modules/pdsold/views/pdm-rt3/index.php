<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmP16a;
use app\modules\pdsold\models\PdmJaksaP16a;
use yii\web\Session;
use yii\helpers\Url;

$this->title = "RT-3";
$this->subtitle = "Register Tahanan Perkara Tahap Penuntutan";
?>

<div class="pdm-p38-index">
    <div class="clearfix"><br><br></div>
    <?php
            $form = \kartik\widgets\ActiveForm::begin([
                        'id' => 'hapus-index',
                        //'action' => '/pdsold/spdp/delete'
            ]);
            ?>
            <div id="divHapus">
                
            </div>
            <div class="inline"><a class='btn btn-warning'  href="/pdsold/pdm-nota-pendapat/create" title="Tambah Nota Pendapat">Tambah</a></div>
            <div class="pull-right"><a class='btn btn-success btnUbahCheckboxIndex' id="idUbah" title="Edit">Ubah</a>&nbsp
            <a class='btn btn-danger hapusTembusan btnHapusCheckboxIndex'  id="idHapus" title="Hapus">Hapus</a><br></div><br><br>
            <div id="btnHapus"></div><div id="btnUpdate"></div>
            <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="row">
        <div class="col-md-12">
            <?=
                GridView::widget([
                    'id' => 'spdp',
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-id' => $model['no_reg_tahanan']];
                    },
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                          'attribute' => 'no_register_perkara',
                          'header' => 'No. Register Tahanan<br />Terdakwa',
                          'format' => 'raw',
                          'value' => function ($model, $key, $index, $widget) {
                                return $model['no_reg_tahanan'] . '<br />' . $model['nama'];
                            },
                        ],
                        [
                            'attribute'=>'ket_tersangka',
                            'header' => 'No.& Tgl. P-16A<br />Jaksa Penuntut Umum',
                            'format' => 'raw',
                            'value'=>function ($model, $key, $index, $widget) {
                                $session        = new Session();
                                $id_perkara     = $session->get('id_perkara');
                                $no_register    = $session->get('no_register_perkara');
                                $qry_p16a       = "select * from pidum.pdm_p16a where no_register_perkara = '".$no_register."' order by tgl_dikeluarkan desc limit 1 ";
                                $p16a           = PdmP16a::findBySql($qry_p16a)->asArray()->one();
                                return $p16a[no_surat_p16a].' & '.Yii::$app->globalfunc->ViewIndonesianFormat($p16a[tgl_dikeluarkan]);
//                                echo $p16a[no_surat_p16a];exit();
//                                echo $qry_p16a;exit();
//                                $jaksap16a      = PdmJaksaP16a::findAll(['no_surat_p16a'=>$p16a[no_surat_p16a]]);
//                                
////                                print_r($p16a);exit();
//                                $jaksax = '';
//                                $no = 1;
//                                for ($i=0; $i < count($jaksap16a); $i++) { 
//                                    $jaksax .= $jaksap16a[$i]['no_surat_p16a'].'<br>'.$jaksap16a[$i]['nama'];
//                                    $no++;
//                                }
//                                return $jaksax;
                            },
                        ],
                        [
                            'attribute'=>'ket_tersangka',
                            'header' => 'Tahap Penyidikan',
                            'format' => 'raw',
                            'value'=>function ($model, $key, $index, $widget) {
                                return 'Jenis Penahanan: '.$model['jns_penahanan'] .'<br>Lokasi: '.$model['lokasi_penyidik']. '<br>Tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_awal_penyidik']). ' sampai '.Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_akhir_penyidik']);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Tahap Penuntutan',
                            'template' => '{my_action}',
                            'buttons' => [
                                    'my_action' => function ($url, $model) {
                                    return Html::a('Riwayat Penahanan', $url, 
                                    [
                                        'title' => Yii::t('app', 'My Action'),
                                        'class'=>'btn btn-warning riwayat',
//                                        'id'=>'riwayat',
                                        'data-id' => $model['no_urut_tersangka'],
//                                        'href' => Url::to(['pdm-rt3/riwayat?id='.rawurlencode($model['no_reg_tahanan'])]) 
                                    ]);
                                }
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'my_action') {
            //                        return Url::to(['user/my-action']);
                                }
                            }
                         ],
                         [
                            'attribute'=>'ket_tersangka',
                            'header' => 'Tahap Persidangan',
                            'format' => 'raw',
                            'value'=>function ($model, $key, $index, $widget) {
//                                return 'Status '.$model['jns_penahanan']. ' & Tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba4']);
                            },
                        ],
                        [
                            'attribute'=>'ket_tersangka',
                            'header' => 'Amar Putusan',
                            'format' => 'raw',
                            'value'=>function ($model, $key, $index, $widget) {
//                                return 'Status '.$model['jns_penahanan']. ' & Tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba4']);
                            },
                        ],
                        [
                            'attribute'=>'ket_tersangka',
                            'header' => 'No & Tgl P-48, Tgl BA-17',
                            'format' => 'raw',
                            'value'=>function ($model, $key, $index, $widget) {
//                                return 'Status '.$model['jns_penahanan']. ' & Tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba4']);
                            },
                        ],
                        [
                            'class' => 'kartik\grid\CheckboxColumn',
                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                            'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model['no_reg_tahanan'], 'class' => 'checkHapusIndex'];
                            }
                        ],
                    ],
                    'export' => false,
                    'pjax' => true,
                    'responsive' => true,
                    'hover' => true,
                ]);
            ?>
        </div>
    </div>
</div>

<div class="modal fade" id="m_riwayat" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-danger close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Riwayat Penahanan</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>


<?php
$script1 = <<< JS
        
        
        $(document).ready(function(){
			$('body').addClass('fixed sidebar-collapse');
		});

        $(".riwayat").on('click', function(e){
            var no_urut_tsk = $(this).data('id');
            $("#m_riwayat").find(".modal-body").load("/pdsold/pdm-rt3/riwayat?id="+no_urut_tsk);
            $("#m_riwayat").modal({backdrop:"static"});
        });
JS;
$this->registerJs($script1);
?>
<!--<script type="text/javascript">
    
    $("#riwayat").on('click', function(e){
            var no_urut_tsk = $(this).data('id');
            alert(no_urut_tsk);
            $("#m_riwayat").find(".modal-body").load("/pidsus/pds-pengembalian-spdp/getspdp");
            $("#m_riwayat").modal({backdrop:"static"});
    });
</script>-->


        