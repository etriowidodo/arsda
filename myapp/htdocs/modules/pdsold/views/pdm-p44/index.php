<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP44Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Pdm P44s';
//$this->params['breadcrumbs'][] = $this->title;
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p44-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_register_perkara']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_register_perkara',
                'label' => 'Nomor Register Perkara',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_register_perkara;
                },


            ],

            [
                'attribute'=>'tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $tersangList = explode('#', $model->tersangka);
                    $no =1;
                    foreach ($tersangList as $key => $value) {
                        $tsk .=  $no.'. '.$value.'<br>';
                        $no++;
                    }

                    return $tsk;
                },


            ],
            
            [
                'attribute'=>'undang',
                'label' => 'Pasal Dakwaan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $tersangList = explode('#', $model->tersangka);
                    $undangList = explode('#', $model->undang);
                    $pasalList = explode('#', $model->pasal);
                    $no =1;
                   // foreach ($tersangList as $key => $value) {
                        
                        foreach ($undangList as $key2 => $value2) {
                            $undang .=  $no.'. '.$value2.' '.$pasalList[$key2].'<br>';
                            $no++;
                        }
                        $undang .= '<br>';
                        
                    //}
                    return $undang;
                    //return date("d-m-Y", strtotime($model->tgl_dikeluarkan));
                },


            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                            'template' => '{my_action}',
                            'buttons' => [
                                            'my_action' => function ($url, $model) {
                                            return Html::a('Cetak', $url, 
                                            [
                                                'title' => Yii::t('app', 'My Action'),
                                                'class'=>'cetakp44 btn btn-primary',
                                                'data-id' => $model['no_register_perkara']
                                            ]);
                                        }
                                    ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'my_action') {
            //                        return Url::to(['user/my-action']);
                                }
                            }
            ],

            /*[
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{my_action}',
                            'buttons' => [
                                            'my_action' => function ($url, $model) {
                                            return Html::a('Unggah P-16A', $url, 
                                            [
                                                'title' => Yii::t('app', 'My Action'),
                                                'class'=>'unggah_p16a btn btn-primary',
                                                'data-id' => $model['no_surat_p16a']
                                            ]);
                                        }
                                    ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'my_action') {
            //                        return Url::to(['user/my-action']);
                                }
                            }
                         ],*/
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>

</div>

<?php
$js = <<< JS
        
            $(".cetakp44").on('click', function(e){
                var id=$(this).data('id');
                var url    = '/pdsold/pdm-p44/cetak?id='+id;  
                window.open(url, '_blank');
                window.focus();
            });
JS;

    $this->registerJs($js);
?>