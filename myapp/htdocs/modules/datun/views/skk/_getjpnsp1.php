<?php 
	if(count($model) == 0)
		echo '<tr><td colspan="4">JPN tidak ditemukan</td></tr>';
	else{
		foreach($model as $idx1=>$data1){
			$nom = ($idx1 + 1);
			$nip = $data1['nip'];
			$nmp = $data1['nama'];
			$gol = $data1['pangkat_jpn']." (".$data1['gol_jpn'].")";
			$wow = $nip."#".$nmp."#".$gol."#".$data1['gol_jpn']."#".$data1['pangkat_jpn']."#".$data1['jabatan_jpn'];

			echo '<tr data-id="'.$nip.'">
				<td class="text-center">
					<span class="frmnojpn" data-row-count="'.$nom.'">'.$nom.'</span>
					<input type="hidden" name="jpnid[]" value="'.$wow.'" />
				</td>
				<td>'.$nip.'<br>'.$nmp.'</td>
				<td>'.$gol.'</td>
				<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'.$nom.'" class="hRowJpn" value="'.$nip.'" /></td>
			</tr>';
		}
	}
?>
<script type="text/javascript">
$(document).ready(function(){
	$(".hRowJpn").iCheck({checkboxClass: 'icheckbox_square-blue'});
	var formValues = {};
	$("tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValues[idnya] = idnya;
	});
	localStorage.setItem("formValues", JSON.stringify(formValues));

});
</script>
