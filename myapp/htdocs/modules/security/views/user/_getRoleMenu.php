<?php 
	$hasil = $dataProvider['hasil'];
	echo '<p style="margin-bottom:0px"><b>'.$dataProvider['namaModul'].'</b></p>';
	echo '<p><b>ROLE '.$dataProvider['namaRole'].'</b></p>';
	echo '<div class="get-role-menu-index explorer">';
	if(count($hasil) == 0){
		echo '<p>Tidak ada menu dalam role ini</p>';
	} else{
		$hasil = $dataProvider['hasil'];
		foreach($hasil as $data){
			$marginLeft = (($data['depth'] - 1)* 20).'px';
			echo '<p style="margin-bottom:5px;"><span class="'.$data['tipe'].'" style="margin-left:'.$marginLeft.'">'.$data['name'].'</span></p>';
		}
	}
	echo '</div>';
?>