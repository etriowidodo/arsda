<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\pidsus\models\P16;
	
	$hasil = "";
	if(count($model) > 0){
		$nom = 0;
		foreach($model as $res){
			$nom++;
			$idnya = rawurlencode($res['no_berkas'])."#".rawurlencode($res['no_pengantar']);
			$hasil .= '
			<tr data-id="'.$idnya.'">
				<td>'.$res['no_pengantar'].'<br />'.$res['tgl_pengantar'].'</td>
				<td class="text-center">'.$res['tgl_terima'].'</td>
				<td class="text-center">'.$res['tgl_selesai'].'</td>
				<td>'.$res['nama_tersangka'].'</td>
				<td>'.$res['keterangan'].'</td>
				<td class="text-center aksinya">
					<input type="radio" class="pilihPengantar" value="'.$idnya.'" id="pilihPengantar'.$nom.'" name="pilihPengantar[]" />
				</td>
			</tr>';
		}
	} else{
		$hasil = '<tr><td colspan="6">Tidak ada pengantar</td></tr>';
	}
	echo $hasil;
?>
<script type="text/javascript">
$(document).ready(function(){
    $("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
});
</script>