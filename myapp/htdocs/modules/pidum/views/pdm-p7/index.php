<?php
$this->title = 'P7';
$this->subtitle = $this->title;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmBa4;
use app\modules\pidum\models\PdmBarbuk;
use app\modules\pidum\models\PdmUuPasalTahap2;

/* @var $this yii\web\View */
$id = Yii::$app->session->get('no_register_perkara');
?>
<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p7/cetak?id='.$id] ) ?>">Cetak</a>
<?= GridView::widget([
       'dataProvider' => $dataProvider,
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           'no_register_perkara',
           [
                'attribute'=>'nama',
                'label' => 'Nama Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
    //                                $nama1 = PdmBa4::findAll(['no_surat_p16a'=>$model->no_surat_p16a]);
                    $nama1 = PdmBa4::findAll(['no_register_perkara'=>$model['no_register_perkara']]);

                    $no = 1;
                    foreach($nama1 as $rownama1){
                            $isi .= $no."&nbsp;".$rownama1->nama."<br/>";
                            $no++;
                    }
                    return $isi;
                },
            ],
           'kasus_posisi',
//           'undang',
//           'pasal',
           [
                'attribute'=>'pasal',
                'label' => 'Pasal',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
    //                                $nama1 = PdmBa4::findAll(['no_surat_p16a'=>$model->no_surat_p16a]);
                    $nama1 = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$model['no_register_perkara']]);

                    $no = 1;
                    foreach($nama1 as $rownama1){
                            $isi .= $no."&nbsp; ".$rownama1->undang." ".$rownama1->pasal."<br/>";
                            $no++;
                    }
                    return $isi;
                },
            ],
           'uraian',
//           'alat_bukti',
           [
                'attribute'=>'barbuk',
                'label' => 'Nama Barbuk',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
    //                                $nama1 = PdmBa4::findAll(['no_surat_p16a'=>$model->no_surat_p16a]);
                    $nama1 = PdmBarbuk::findAll(['no_register_perkara'=>$model['no_register_perkara']]);

                    $no = 1;
                    foreach($nama1 as $rownama1){
                            $isi .= $no."&nbsp;".$rownama1->nama."<br/>";
                            $no++;
                    }
                    return $isi;
                },
            ],
           'keterangan'
       ],
       'export' => false,
       'pjax' => true,
       'responsive' => true,
       'hover' => true,
   ]); ?>
