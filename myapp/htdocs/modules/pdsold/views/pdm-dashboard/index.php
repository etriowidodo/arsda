<?php

use app\modules\pdsold\models\MsJenisPidana;
use app\modules\pdsold\models\PdmSpdp;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\typeahead\TypeaheadAsset;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use kartik\builder\Form;
use app\modules\pdsold\models\MsTersangkaBerkas;
use kartik\grid\GridView;

?>

<div class="dashboard">   
    <div class="col-md-12">
    <div class="col-md-5">
       <div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-6" style="padding: 0px;">
                <h3 class="box-title">Jumlah SPDP</h3>
            </div>
        </div>
        <div class="box-header with-border">
        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">
        <thead>
            <tr>
                <th style="width: 5.05%;">No</th>
                <th data-col-seq="1" >
                    <a href="/pdsold/p16/index?sort=no_surat" data-sort="no_surat">Jenis Surat</a>
                </th>
                <th data-col-seq="1" style="width: 35.72%;">
                    <a href="/pdsold/p16/index?sort=no_surat" data-sort="no_surat">Sisa Bulan Lalu</a>
                </th>
                <th data-col-seq="2" style="width: 54.73%;">
                    Masuk
                </th>
                <th class="kartik-sheet-style kv-all-select kv-align-center kv-align-middle skip-export" style="width: 4.68%;" data-col-seq="3">
                Jumlah
                </th>
                <th class="kartik-sheet-style kv-all-select kv-align-center kv-align-middle skip-export" style="width: 4.68%;" data-col-seq="3">
                Selesai
                </th>
                <th class="kartik-sheet-style kv-all-select kv-align-center kv-align-middle skip-export" style="width: 4.68%;" data-col-seq="3">
                Sisa
                </th>
            </tr>
        </thead>
        <tbody>
		<?php 
			$data = Yii::$app->db->createCommand("select c.akronim,count(a.id_perkara) as jml
from pidum.pdm_spdp a
INNER JOIN pidum.ms_jenis_perkara b ON a.id_pk_ting_ref = b.jenis_perkara
INNER JOIN pidum.ms_jenis_pidana c ON b.kode_pidana = c.kode_pidana
group by c.akronim")->queryAll();  
			$no = 1;
			foreach($data as $key){
		?>
		
        <tr data-id="000000p16-01" data-key="000000p16-01">
            <td><?=$no?></td>
            <td><?=$key['akronim']?></td>
            <td data-col-seq="1">0</td>
            <td data-col-seq="2"><?=$key['jml']?></td>
            <td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="3">
			<?=$key['jml']?>
            </td>
            <td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="3">
			0
            </td>
            <td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="3">
			<?=$key['jml']?>
            </td>
        </tr>
			<?php } ?>
        </tbody>
        </table>
        </div>
    </div>
    </div>
    <div class="col-md-7">
       <div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
        <center><h3 class="box-title">Prosentase Berdasarkan Jenis Tindak Pidana dan Jenis Perkara </h3></center>
        </div>
        <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-6">
                 <div id='pie_tindak_pidana'>                 
                 </div>  
                </div>
                <div class="col-md-6">
                <div id='tindak_perkara'>                 
                 </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="col-md-12">
       <div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-6" style="padding: 0px;">
             <h3 class="box-title">Penyelesaian Pra Penuntutan</h3>
            </div>
        </div>
        <div class="box-header with-border">
            <div id='penyelesaian_pratut'>
                
            </div>
        </div>
    </div>
    </div>
</div>
<?php

$model = MsJenisPidana::find()->all();
$jenispidana  = array();
foreach($model AS $a)
{

    $model_a = PdmSpdp::find()->select("a.no_surat, a.id_pk_ting_ref,b.kode_pidana")->from("pidum.pdm_spdp a")->join("inner join","pidum.ms_jenis_perkara b","b.jenis_perkara = a.id_pk_ting_ref")->join("inner join","pidum.ms_jenis_pidana c","c.kode_pidana = b.kode_pidana")->where("b.kode_pidana = '".$a->kode_pidana."'")->all();
    $jenispidana[] = array('kode_pidana'=>$a->kode_pidana,'name'=>$a->akronim,'y'=>count($model_a));
    
}

$jenispidana = json_encode($jenispidana);
$js = <<< JS

   
        $('#pie_tindak_pidana').highcharts({
            credits: {
            enabled: false
            },
            chart: {
                 
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Jenis Tindak Pidana'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                   
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [
                {
                name: 'Prosentase',
                colorByPoint: true,
                data:$jenispidana,
                    point:{
                          events:{
                              click: function (event) {
                                  //alert(this.name + " " + this.kode_pidana);
									var categories = ['satu','dua','tiga'];
									var data = [ 
              { "name"  : "Sisa", "data" :[44936.0,50752.0,50752.0] },
              { "name"  : "Masuk", "data" : [200679.0,226838.0,226838.0] },
              { "name"  : "Diselesaikan","data" : [288993.0,289126.0,289126.0] }
            ];
                                     $('#tindak_perkara').highcharts({
                                                     credits: {
                                                        enabled: false
                                                        },
                                                    chart: {
                                                        type: 'column'
                                                    },
                                                    title: {
                                                        text: 'Jenis Perkara'
                                                    },
                                                    // subtitle: {
                                                    //     text: 'Source: WorldClimate.com'
                                                    // },
                                                    xAxis: {
                                                        categories: categories,
                                                        crosshair: true
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: ''
                                                        }
                                                    },
                                                    tooltip: {
                                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                                                        footerFormat: '</table>',
                                                        shared: true,
                                                        useHTML: true
                                                    },
                                                    plotOptions: {
                                                        column: {
                                                            pointPadding: 0.2,
                                                            borderWidth: 0
                                                        }
                                                    },
                                                    series: data
                                                });
                                    

                              }
                    }
                }
            }]
        });




    // $('#tindak_perkara').highcharts({
    //      credits: {
    //         enabled: false
    //         },
    //     chart: {
    //         type: 'column'
    //     },
    //     title: {
    //         text: 'Jenis Perkara'
    //     },
    //     // subtitle: {
    //     //     text: 'Source: WorldClimate.com'
    //     // },
    //     xAxis: {
    //         categories: [
    //             'Jan',
    //             'Feb',
    //             'Mar',
    //             'Apr',
    //             'May',
    //             'Jun',
    //             'Jul',
    //             'Aug',
    //             'Sep',
    //             'Oct',
    //             'Nov',
    //             'Dec'
    //         ],
    //         crosshair: true
    //     },
    //     yAxis: {
    //         min: 0,
    //         title: {
    //             text: 'Rainfall (mm)'
    //         }
    //     },
    //     tooltip: {
    //         headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    //         pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
    //             '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
    //         footerFormat: '</table>',
    //         shared: true,
    //         useHTML: true
    //     },
    //     plotOptions: {
    //         column: {
    //             pointPadding: 0.2,
    //             borderWidth: 0
    //         }
    //     },
    //     series: [{
    //         name: 'Tokyo',
    //         data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

    //     }, {
    //         name: 'New York',
    //         data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

    //     }, {
    //         name: 'London',
    //         data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

    //     }, {
    //         name: 'Berlin',
    //         data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

    //     }]
    // });



    $('#penyelesaian_pratut').highcharts({
        credits: {
            enabled: false
            },
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Penyelesaian Pra Penuntutan'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                },
                showInLegend: true
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Dilanjutkan Ke TUT', 45.0],
                ['SP3', 26.8],
                ['Diversi', 8.5],
                ['Optimal', 6.2],
                ['SPDP/Berkas Dikembalikan', 0.7]
            ]
        }]
    });

JS;
$this->registerJs($js);
?>
