<?php session_start();?>
<?php include('../calc/condb.php');?>
<?php header('Content-type: text/html; charset=utf-8');?>
<?php
//Получаем данные
$data1 = $_POST['mydata'];
$data2 = $_POST['myload'];
$base = $_SESSION['brk'];
	
for($e = 0; $e < count($base); $e++){
	$massive[$e] = explode(':|:',$base[$e]);
	$massive2[$e] = $massive[$e];
	
}
$buffer=array();
$buffer2=array();
for($i=0; $i<count($base);$i++){
	if($massive[$i][5] == $data1 and $massive[$i][2] == $data2){
		$buffer[]=$massive[$i][1];
		$buffer2[]=$massive[$i][3];
	}
} 
$result1=$buffer;
$result1 = array_unique($result1);
$result2=$buffer2;
$result2 = array_unique($result2);
foreach ($massive2 as $key => $row) {
    $name_m[$key]  = $row[0];
	$step_m[$key] = $row[3]; 	
	$span_m[$key] = $row[4]; 
}




if($_POST['sortt'] == 'name_s'){
	
	$d_span = 1;
	$d_step = 1;
	if($_POST['name_up'] == ''){
		array_multisort($name_m, SORT_ASC, $massive2);
	
	}else{
		array_multisort($name_m, SORT_DESC, $massive2);
		
	}
}elseif($_POST['sortt'] == 'step_s'){
	$d_name = 1;
	$d_span = 1;
	if($_POST['step_up'] == ''){
		array_multisort($step_m, SORT_ASC, $massive2);
		
	}else{
		array_multisort($step_m, SORT_DESC, $massive2);
		
	}
	
}elseif($_POST['sortt'] == 'span_s'){
	$d_step = 1;
	$d_name = 1;
	if($_POST['span_up'] == ''){	
		array_multisort($span_m, SORT_ASC, $massive2);
		
	}else{
		array_multisort($span_m, SORT_DESC, $massive2);
		
	}
}

$z=0;$x=0;
?>
<div style=" width:275px; float:left;">Высота балки (мм)</div>
<div style=" width:275px; float:left;margin-left:10px;">Шаг (мм)</div>
<div style=" clear:left;"></div>
<div style=" width:275px; height:90px; float:left; border:#333 1px solid; padding:3px;">
<?php 
if($_SESSION['dataone'] != $data1 or $_SESSION['datatwo'] != $data2){
	for($l = 0; $l <= 100; $l++){
		unset($_POST["height_".$l]);
		unset($_POST["step_".$l]);	
	}
}?>

<?php foreach($result1 as $desc) {

		if($_POST["height_".$z]==$desc or $_SESSION['dataone'] != $data1 or $_SESSION['datatwo'] != $data2){
			$ddd = $desc;
		}else{
			$ddd = '';
		}
?>
<label><input type="checkbox" <?php if($ddd == $desc){echo 'checked';}?> name="height_<?php echo $z;?>" value="<?php echo $desc;?>" onChange="send();"><?php echo $desc;?></label>
<?php 
if($ddd == $desc){
	$_POST["height_".$z] = $desc;
	$descarr[$z] = $desc;
}
$z++;}?>
<input name="i_height" type="hidden" value="<?php echo $z; ?>"><br><br>
</div><div style=" width:275px; height:90px; float:left; border:#333 1px solid; padding:3px; margin-left:4px;">
<?php foreach($result2 as $st) {
		if($_POST["step_".$x]==$st or $_SESSION['dataone'] != $data1 or $_SESSION['datatwo'] != $data2){
			$ddd1 = $st;
		}else{
			$ddd1 = '';
		}	
?>
<label><input type="checkbox" <?php if($ddd1 == $st){echo 'checked';}?> name="step_<?php echo $x;?>" value="<?php echo $st;?>" onChange="send();"><?php echo $st;?></label>
<?php 
if($ddd1 == $st){
	$_POST["step_".$x] = $st;
	$starr[$x] = $st; 
}
$x++;}?>
<input name="i_step" type="hidden" value="<?php echo $x; ?>">
</div>
<div style=" clear:left;"></div>
<div style=" margin-top:10px;">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" style="cursor:pointer; padding:2px 0px 2px 0px;"><label style="float:right;"><input name="name_up" type="checkbox"<?php if($_POST[name_up]=='up'){echo ' checked';}?> value="up" onClick="send();" checked style="display:none;"></label><label><strong style="text-decoration:underline">Наименование</strong><input type="radio" <?php if($_POST['sortt'] == 'name_s'){echo 'checked';}?> name="sortt" value="name_s" id="sortt_0" onClick="send();"></label></td>
		<td align="center"><strong>Длина балки (мм)</strong></td>
		<td align="center" style="cursor:pointer; padding:2px 0px 2px 0px;"><label style="float:right;"><input name="span_up" type="checkbox"<?php if($_POST[span_up]=='up'){echo ' checked';}?> value="up" onClick="send();" checked style="display:none;"></label><label><strong style="text-decoration:underline">Макс. пролет (мм)</strong><input type="radio" <?php if($_POST['sortt'] == 'span_s'){echo 'checked';}?> name="sortt" value="span_s" id="sortt_1" onClick="send();"></label></td>
		<td align="center" style="cursor:pointer; padding:2px 0px 2px 0px;"><label style="float:right;"><input name="step_up" type="checkbox"<?php if($_POST[step_up]=='up'){echo ' checked';}?> value="up" onClick="send();" checked style="display:none;"></label><label><strong style="text-decoration:underline">Шаг (мм)</strong><input type="radio" <?php if($_POST['sortt'] == 'step_s'){echo 'checked';}?> name="sortt" value="step_s" id="sortt_2" onClick="send();"></label></td>
	</tr>
<?php 
for($i=0; $i < count($base);$i++){
	
	if($massive2[$i][5] == $data1 and $massive2[$i][2] == $data2){
		?>
	<?php 
		for($o = 0; $o < $z; $o++){
			//if($_POST['height_'.$o] != '' and $_POST['height_'.$o] == $massive2[$i][1]){
			if($descarr[$o] != '' and $descarr[$o] == $massive2[$i][1]){
				for($m = 0; $m < $x; $m++){
					//if($_POST['step_'.$m] != '' and $_POST['step_'.$m] == $massive2[$i][3]){
						if($starr[$m] != '' and $starr[$m] == $massive2[$i][3]){
		?><tr>
			<td  style="padding-left:3px;"><div style="float:left; width:18px; padding:1px"><img src="../calc/beam.png"></div><div><?php echo $massive2[$i][0];?></div></td>
			<td align="center"><?php echo $massive2[$i][5];?></td>
			<td align="center"><?php echo $massive2[$i][4];?></td>
			<td align="center"><?php echo $massive2[$i][3];?></td>
		</tr>
		<?php			}
					}
				}
			}
		}
	}	
?>
		
	<?php ?>	
</table>
</div>
<?php 
unset($_SESSION['dataone']);
unset($_SESSION['datatwo']);
$_SESSION['dataone']=$data1;
$_SESSION['datatwo']=$data2;
?>