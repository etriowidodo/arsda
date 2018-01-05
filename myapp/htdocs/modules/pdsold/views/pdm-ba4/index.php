<?php

use yii\helpers\Html;
use app\components\GlobalConstMenuComponent;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmPengantarTahap1;
use app\modules\pdsold\models\PdmTahapDua;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA15 */

$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA4]);
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<section class="content" style="padding: 0px;">
    <?php $lel = Yii::$app->session->get('no_register_perkara'); 
                $id_berkas = PdmTahapDua::findOne($lel)->id_berkas;
                //echo '<pre>';print_r($id_berkas);exit;
                $no_pengantar = PdmPengantarTahap1::find()->where(['id_berkas'=>$id_berkas])->orderBy('tgl_pengantar desc')->limit(1)->one()->no_pengantar;
                $sql="SELECT count(*) from  pidum.pdm_tahap_dua a
                left join pidum.ms_tersangka_berkas b on a.id_berkas=b.id_berkas
                where a.no_register_perkara='$lel' and b.no_pengantar='$no_pengantar' ";

                $query = \Yii::$app->db->createCommand($sql);
                $result = $query->queryScalar();
                //echo '<pre>';print_r($result);exit; ?>
    <div style="padding: 0px;"><h2><b>Jumlah Tersangka <?= $result ?></b></h2></div>
    <div class="content-wrapper-1">
        <div class="pdm-ba15-index">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php
            $form = \kartik\widgets\ActiveForm::begin([
                        'id' => 'hapus-index',
                        'action' => '/pdsold/pdm-ba4/delete'
            ]);
            ?>
            <div id="divHapus">
                <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
                <a type="button" id="apus" class='btn btn-warning'>Hapus</a>
                <a type="button" id="draft" class='btn btn-warning pull-right'>Cetak Draft</a>
                <a type="button" id="cetak" class='btn btn-primary btnPrintCheckboxIndex  pull-right' disabled>Cetak</a>
            </div>
            <div id="btnHapus"></div><div id="btnUpdate"></div>
                    

            <?php \kartik\widgets\ActiveForm::end() ?>
            <?= 
            GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-no_reg'               => $model['no_register_perkara'],
                            'data-tgl_ba4'              => $model['tgl_ba4'],
                            'data-no_urut_tersangka'    => $model['no_urut_tersangka']
                            ];
                },
                        //'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            ['label' => 'Terdakwa',
                                'attribute' => 'nama',
                            ],
                            // 'attribute' => 'jaksa',
                            [
                                'attribute' => 'tgl_ba4',
                                'value' => function ($model, $index, $widget) {
                                    return date('d-m-Y', strtotime($model['tgl_ba4']));
                                },
                                'filterType' => GridView::FILTER_DATE,
                                'filterWidgetOptions' => [
                                    'pluginOptions' => [
                                        'format' => 'dd-mm-yyyy',
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                    ]
                                ],
                                'width' => '160px',
                                'hAlign' => 'center',
                            ],
                            
                            [
                                'class' => 'kartik\grid\CheckboxColumn',
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model['no_register_perkara']."#".$model['tgl_ba4']."#".$model['no_urut_tersangka'], 'class' => 'checkHapusIndex'];
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
        </section>
        <?php
        $js = <<< JS
        $('td').dblclick(function (e) {
        var  no_register_perkara = $(this).closest('tr').data('no_reg');
        var  tgl_ba4             = $(this).closest('tr').data('tgl_ba4');
        var  no_urut_tersangka   = $(this).closest('tr').data('no_urut_tersangka');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-ba4/update?no_register_perkara="+no_register_perkara+"&tgl_ba4="+tgl_ba4+"&no_urut_tersangka="+no_urut_tersangka;
        $(location).attr('href',url);
        });

        $("#apus").on("click",function(){
            $('form').submit();
        });

        $("#draft").on("click", function(){
                var url    = '/pdsold/pdm-ba4/cetak-draft';
                window.open(url, '_blank');
                window.focus();
        });
    
        

        $('.btnPrintCheckboxIndex').click(function(){
              var count =$('.checkHapusIndex:checked').length;
              if (count != 1 ){
                  bootbox.dialog({
                      message: "Silahkan pilih hanya 1 data untuk Dicetak",
                      buttons:{
                          ya : {
                              label: "OK",
                              className: "btn-warning",

                          }
                      }
                  });
              } else {
                  var id = $('.checkHapusIndex:checked').val();
                  var has = id.split('#');
                  var url    = '/pdsold/pdm-ba4/cetak?no_register_perkara='+has[0]+'&tgl_ba4='+has[1]+'&no_urut_tersangka='+has[2];
                  window.open(url, '_blank');
                  window.focus();
              }
          }); 

JS;

        $this->registerJs($js);
        ?>