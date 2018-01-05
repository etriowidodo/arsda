<?php

use app\modules\pidum\models\PdmPenandatangan;
use app\components\GlobalConstMenuComponent;
use kartik\builder\Form;
use kartik\grid\GridView;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB4 */
/* @var $form yii\widgets\ActiveForm */
\dosamigos\ckeditor\CKEditorAsset::register($this);
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'b4-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false,
                            ],
                            'options' => [
                                'enctype' => 'multipart/form-data',
                            ]
                        ]
                )
        ?>

        <div class="box box-primary" style="border-color: #f39c12;">
            <!--<div class="box-header with-border" style="border-color: #c7c7c7;"></div>-->
            <div class="box-header with-border" style="border-bottom:none;">
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Wilayah Kerja
                        </label>

                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group field-wilayah_kerja">
                                        <input type="text" name="wilayah_kerja" class="form-control" id="wilayah_kerja"
                                               value="<?= $wilayah ?>" readonly="readonly">

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php
                echo Form::widget([ /* nomor sprint */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'nomor_surat' => [
                            'label' => 'Nomor Surat',
                            'labelSpan' => 2,
                            'columns' => 8,
                            'attributes' => [
                                'no_surat' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' => 4],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>PERTIMBANGAN</strong>
                </h3>
            </div>
            <div class="box-header with-border" style="border-bottom:none;">
                <?php
                /*                echo Form::widget([
                  'model' => $model,
                  'form' => $form,
                  'columns' => 1,
                  'attributes' => [
                  'kepentingan' => [
                  'label' => 'Kepentingan',
                  'labelSpan' => 2,
                  'columns' => 8,
                  'attributes' => [
                  'kepentingan' => [
                  'type' => Form::INPUT_RADIO_LIST,
                  'items' => ["penyidikan" => "Penyidikan", "penuntutan" => "Penuntutan"],
                  'options' => ['inline' => true],
                  'columnOptions' => ['colspan' => 4],
                  ],
                  ]
                  ],
                  ]
                  ]);
                 */
                ?>
                <?php
                /* tersangka */
                /* echo Form::widget([
                  'model' => $model,
                  'form' => $form,
                  'columns' => 1,
                  'attributes' => [
                  'tersangka' => [
                  'label' => 'Tersangka',
                  'labelSpan' => 2,
                  'columns' => 8,
                  'attributes' => [
                  'id_tersangka' => [
                  'type' => Form::INPUT_DROPDOWN_LIST,
                  'options' => ['prompt' => 'Pilih Tersangka'],
                  'items' => ArrayHelper::map($list_tersangka, 'id_tersangka', 'nama'),
                  'columnOptions' => ['colspan' => 4],
                  ],
                  ]
                  ],
                  ]
                  ]); */
                ?>
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Tindakan Pidana
                        </label>

                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group field-tindak-pidana">
                                        <input type="text" name="tindak_pidana" class="form-control" id="tindak_pidana"
                                               value="<?= $tindak_pidana['nama'] ?>" readonly="readonly">

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php
                $model->sprint_kepala = $wilayah;
                echo Form::widget([ /* Surat perintah penyidik dari kepala */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'surat_perintah' => [
                            'label' => 'Surat Perintah Penyidik dari Kepala',
                            'labelSpan' => 2,
                            'columns' => 8,
                            'attributes' => [
                                'sprint_kepala' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' => 4],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
                <?php
                echo Form::widget([ /* nomor & tanggal */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'no_sprint' => [
                            'label' => 'Nomor PRINT',
                            'labelSpan' => 4,
                            'columns' => 8,
                            'attributes' => [
                                'no_sprint' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                        'tgl_sprint' => [
                            'label' => 'Tanggal PRINT',
                            'labelSpan' => 4,
                            'columns' => 8,
                            'attributes' => [
                                'tgl_sprint' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => '\kartik\datecontrol\DateControl',
                                    //'hint' => 'format tanggal DD/MM/YYYY',
                                    'options' => [
                                        'pluginOptions' => [
                                            'format' => 'dd-mm-yyyy',
                                            'autoclose' => true,
                                            'todayHighlight' => true,
                                        //'endDate' => '+1y',
                                        ]],
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>PELAKSANA PERINTAH</strong>
                </h3>
            </div>
            <div class="box-header with-border" style="border-bottom:none;">
                <?=
                GridView::widget([
                    'id' => 'pdm-b4',
                    'dataProvider' => $dataProvider,
                    //'showOnEmpty' => false,
                    'layout' => '{items}',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'nip',
                            'label' => 'NIP',
                        ],
                        [
                            'attribute' => 'nama',
                            'label' => 'NAMA',
                        ],
                        [
                            'attribute' => 'pangkat',
                            'label' => 'PANGKAT',
                        ],
                        [
                            'attribute' => 'jabatan',
                            'label' => 'JABATAN',
                        ],
                    ],
                    'export' => false,
                    'pjax' => true,
                    'responsive' => true,
                    'hover' => true,
                ]);
                ?>
                <?php
                echo Form::widget([ /* Penggeledahan */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'penggeledahan' => [
                            'label' => 'Melakukan Penggeledahan',
                            'labelSpan' => 2,
                            'columns' => 8,
                            'attributes' => [
                                'penggeledahan' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                    ]
                ]);
                $this->registerCss("div[contenteditable] {
                    outline: 1px solid #d2d6de;
                    min-height: 100px;
                }");
                $this->registerJs("
                    CKEDITOR.inline( 'PdmB4[penggeledahan]');
                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                    CKEDITOR.config.autoParagraph = false;

                ");
                ?>
                <?php
                /* Penyitaan */
                /* echo Form::widget([
                  'model' => $model,
                  'form' => $form,
                  'columns' => 1,
                  'attributes' => [
                  'penyitaan' => [
                  'label' => 'Melakukan Penyitaan',
                  'labelSpan' => 2,
                  'columns' => 8,
                  'attributes' => [
                  'penyitaan' => [
                  'type' => Form::INPUT_TEXTAREA,
                  'columnOptions' => ['colspan' => 12],
                  ],
                  ]
                  ],
                  ]
                  ]); */
                ?>
                <!--<hr style="border-color: #c7c7c7;margin: 10px 0;">-->
                <div class="box-header" style="padding: 10px 10px 5px 0;">
                    <span class="pull-left">
                        <a class="btn btn-primary" id="btnTmbhTersangka" data-toggle="modal"
                           data-target="#m_barbuk"><i
                                class="glyphicon glyphicon-plus"></i> Barang Bukti</a>
                    </span>
                </div>
                <div class="" style="border-bottom:none;">
                    <table id="table_barbuk" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="6%"
                                    style="text-align: center;"><?= Html::buttonInput('Hapus', ['class' => 'btn btn-warning', 'id' => 'tmblhapusbaris']) ?></th>
                                <th width="14%" style="text-align: center;vertical-align: middle;">Nama</th>
                                <th width="14%" style="text-align: center;vertical-align: middle;">Jumlah [decimal]</th>
                                <th width="14%" style="text-align: center;vertical-align: middle;">Satuan</th>
                                <th width="14%" style="text-align: center;vertical-align: middle;">Disita dari</th>
                                <th width="14%" style="text-align: center;vertical-align: middle;">Tempat Simpan</th>
                                <th width="14%" style="text-align: center;vertical-align: middle;">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_barbuk">

                            <?php
                            if (!$model->isNewRecord) {
                                foreach ($tabelbarbuk as $barbuk):
                                    echo '<tr id="row">';
                                    echo '<td style="text-align: center"><input type="checkbox" name="chkHapusBarbuk" class="chkHapusBarbuk"></td>';
                                    echo '<td><input type="hidden" class="form-control idbarbuk" name="idBarbuk[]" readonly="true" value="' . $barbuk['id'] . '">';
                                    echo '<input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="' . $barbuk['nama'] . '"></td>';
                                    echo '<td><input type="text" class="form-control" name="pdmBarbukJumlah[]" readonly="true" value="' . $barbuk['jumlah'] . '"></td>';
                                    echo '<td><input type="hidden" class="form-control" name="pdmBarbukSatuan[]" readonly="true" value="' . $barbuk['id_satuan'] . '">';
                                    echo '<input type="text" class="form-control" name="txtBarbukSatuan" readonly="true" value="' . \app\modules\pidum\models\PdmMsSatuan::findOne($barbuk['id_satuan'])->nama . '"></td>';
                                    echo '<td><input type="text" class="form-control" name="pdmBarbukSitaDari[]" readonly="true" value="' . $barbuk['sita_dari'] . '"></td>';
                                    echo '<td><input type="text" class="form-control" name="pdmBarbukTindakan[]" readonly="true" value="' . $barbuk['tindakan'] . '"></td>';
                                    echo '<td><input type="hidden" class="form-control" name="pdmBarbukKondisi[]" readonly="true" value="' . $barbuk['id_stat_kondisi'] . '">';
                                    echo '<input type="text" class="form-control" name="txtBarbukKondisi" readonly="true" value="' . \app\modules\pidum\models\PdmMsStatusData::findOne(['id' => $barbuk['id_stat_kondisi'], 'is_group' => \app\components\ConstDataComponent::KondisiBarang])->nama . '"></td>';
                                    echo '</tr>';
                                endforeach;
                            }
                            ?>

                            <?php
                            /* if (!$model->isNewRecord) {
                              foreach ($terlapor as $data) {
                              $query = new Query;
                              $query->select('*')
                              ->from('was.v_riwayat_jabatan')
                              ->where("id= :id", [':id' => $data->id_h_jabatan]);

                              $pegawai = $query->one();

                              echo '<tr id="trterlapor' . $pegawai['peg_nip_baru'] . '">';
                              echo '<td><input type="text" class="form-control" name="namaTerlapor[]" readonly="true" value="' . $pegawai['peg_nama'] . '"> </td>';
                              echo '<td><input type="text" class="form-control" name="nipTerlapor[]" readonly="true" value="' . $pegawai['peg_nip_baru'] . '">';
                              echo '<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="' . $data->id_h_jabatan . '">';
                              echo '<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="' . $pegawai['peg_nik'] . '">';
                              echo '</td>';
                              echo '<td><input type="text" class="form-control" name="jabatanTerlapor[]" readonly="true" value="' . $pegawai['jabatan'] . '"> </td>';
                              echo '<td><a class="btn btn-primary" id="btn_delete_terlapor">Hapus</a></td>';
                              '</tr>';
                              }
                              } */
                            ?>

                        </tbody>
                    </table>
                    <div id="hapusBaris"></div>
                </div>
                <?php
                echo Form::widget([ /* di & tanggal dikeluarkan */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'dikeluarkan' => [
                            'label' => 'Dikeluarkan di',
                            'labelSpan' => 4,
                            'columns' => 8,
                            'attributes' => [
                                'dikeluarkan' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                        'tgl_dikeluarkan' => [
                            'label' => 'Tanggal Dikeluarkan',
                            'labelSpan' => 4,
                            'columns' => 8,
                            'attributes' => [
                                'tgl_dikeluarkan' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => '\kartik\datecontrol\DateControl',
                                    //'hint' => 'format tanggal DD/MM/YYYY',
                                    'options' => ['pluginOptions' => [
                                            'format' => 'dd-mm-yyyy',
                                            'autoclose' => true,
                                            'todayHighlight' => true,
                                        ]],
                                    'columnOptions' => ['colspan' => 12],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <label class="col-sm-2 control-label">
                            Upload File
                        </label>

                        <div class="col-sm-4">
                            <div class="row">
                                <?php
                                echo $form->field($model, 'upload_file')->widget(FileInput::className(), [
                                    'options' => [
                                        //'accept' => 'image/*'
                                        'multiple' => false,
                                    ],
                                    'pluginOptions' => [
                                        //'uploadUrl' => Url::to('@web/modules/pidum/upload_file/b4/'),
                                        'showPreview' => true,
                                        'showUpload' => false,
                                        'browseLabel' => 'Pilih',
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="row">
                                <?php if (!$model->isNewRecord && !empty($model['upload_file'])) { ?>
                                    <label
                                        class="control-label col-md-12"><?= Html::label($model['upload_file']); ?></label>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::B4, 'id_table' => $model->id_b4]) ?>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php
            if (!$model->isNewRecord)
                echo Html::a('Cetak', ['/pidum/pdm-b4/cetak', 'id' => $model->id_b4], ['class' => 'btn btn-warning']);
            ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</section>

<?php
Modal::begin([
    'id' => 'm_barbuk',
    'header' => 'Barang Bukti',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_modalBarbuk', [
        //'model' => $model,
        //'searchPegawai' => $searchPegawai,
        //'dataProviderTersangka' => $dataProviderTersangka,
])
?>

<?php
Modal::end();
?>

<script>
    var urlAjax = '<?= Url::toRoute('pdm-b4/tersangka'); ?>';
</script>

<?php
$hapusRow = <<< JS
    $('#tmblhapusbaris').click(function(){
        /*var checked = jQuery('input:checkbox:checked').map(function () {
            return this.value;
        }).get();*/

        $('#table_barbuk :checkbox:checked').each(function() {
            var idBarbuk = $(this).closest("tr").find('.idbarbuk').val();
            //var sumrow = $('table#table_barbuk tr:last').index() + 1;
            $('#hapusBaris').append(
               "<input type='hidden' id='hapus' name='hapusIndex[]' value='"+idBarbuk+"'>"
            );
        });

        jQuery('input:checkbox:checked').parents("tr").remove();
    });
JS;

$this->registerJs($hapusRow);
?>

<?php /* $cekCentang = <<< JS
  $(document).on('click','.chkHapusBarbuk',function(e) {
  var input = $(this);
  var idBarbuk = $(this).closest("tr").find('.idbarbuk').val();
  var sumrow = $('table#table_barbuk tr:last').index() + 1;
  if(input.prop( 'checked' ) == true){
  $('#hapusBaris').append(
  "<input type='hidden' id='hapus-"+sumrow+"' name='hapusIndex[]' value='"+idBarbuk+"'>"
  );
  }else{
  $('#hapus').remove();
  $('#hapus-'+sumrow).remove();
  }
  });
  JS;

  $this->registerJs($cekCentang);
 */ ?>

<?php
$this->registerJs(
        "$('#pdmb4-id_tersangka').change(function() {
        var id_tersangka = $(this).val();
        $.ajax({
            url: urlAjax,
            type:'POST',
            data:{id_tersangka: id_tersangka},
            dataType:'JSON',
            success: function(data) {
                var formatDate = new Date(data.tersangka.tgl_surat);
                var tgl = formatDate.getDate();
                var bln = formatDate.getMonth() + 1;
                var thn = formatDate.getFullYear();

                if(tgl < 10) {
                    tgl = '0' + tgl;
                }
                if(bln < 10) {
                    bln = '0' + bln;
                }

                $('#pdmb4-no_sprint').val(data.tersangka.no_surat);
                $('#pdmb4-tgl_sprint-disp').val(tgl + '-' + bln + '-' + thn);
            }
        });
    });"
);
?>