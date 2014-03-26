<?php session_start();?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>СК-Калькулятор подбора балок</title>
</head>

<body>
<div class="title-calc">
    <h4>Калькулятор подбора балок</h4>
</div>
<?php include('../calc/condb.php');?>
<?php $calc = mysql_query("SELECT * FROM `".PREFIX."stat` WHERE 1 ORDER BY name DESC");
	$brk=array();
	$iii=0;
	while($buf = mysql_fetch_array($calc)){
		$brk[$iii] = $buf[name].':|:'.$buf[height].':|:'.$buf[load].':|:'.$buf[step].':|:'.$buf[span].':|:'.$buf[length];
		$brk[$iii] = iconv('windows-1251', 'utf-8', $brk[$iii]); 
		$iii++;
	}
	unset($_SESSION['brk']);
	unset($_POST['mydata']);
	unset($_POST['myload']);
	unset($_SESSION['data1']);
	unset($_SESSION['data2']);
	
	$_SESSION['brk'] = $brk;

?>
<script src="http://<?php echo $_SERVER['HTTP_HOST']?>/calc/jq.js"></script>

<script>
	function send(){
		$.ajax({
			type: "POST",
			url: "http://<?php echo $_SERVER['HTTP_HOST']?>/calc/SendData.php",
			data: $("#myform").serialize(),
			success: function(html) {
				$("#result").empty();
				$("#result").append(html);
			}
		});
	}
</script>
<?php 
	$_SESSION['dataone']='6000';
	$_SESSION['datatwo']='1.5';?>
<form action="" id="myform">
	<div style=" width:250px; float:left">
	Длина изделия (мм): <select name="mydata" id="mydata" onChange="send();">
		<option value="6000" selected>6000</option>
		<option value="6500">6500</option>
		<option value="7000">7000</option>
		<option value="7500">7500</option>
		<option value="8000">8000</option>
	</select></div>
	<div style=" width:250px; float:left">
	Нагрузка (кН/м2): <select name="myload" id="myload" onChange="send();">
		<option value="1.5" selected>1.5</option>
		<option value="2.0">2.0</option>
	</select></div>
<div style=" clear:left;"></div>	
<div id="result"><?php $i=0; $x=0;
	$buffer=array();
	$buffer2=array();
	mysql_data_seek($calc,0);
	while ($row = mysql_fetch_array($calc)){
		if($row[length] == '6000' and $row[load] == '1.5'){
			$buffer[]=$row[height];
			$buffer2[]=$row[step];
		}
	} 
	$result1=$buffer;
	$result1 = array_unique($result1);
	$result2=$buffer2;
	$result2 = array_unique($result2);?>
<div style=" width:275px; float:left;">Высота балки (мм)</div>
<div style=" width:275px; float:left;margin-left:10px;">Шаг (мм)</div>
<div style=" clear:left;"></div>
<div style=" width:275px; height:90px; float:left; border:#333 1px solid; padding:3px;">	
<?php foreach($result1 as $desc) {?>
<label><input type="checkbox" checked name="height_<?php echo $i;?>" value="<?php echo $desc;?>" onChange="send();"><?php echo $desc;?></label>
	<?php $i++;
	}?>
<input name="i_height" type="hidden" value="<?php echo $i; ?>">
</div><div style=" width:275px; height:90px; float:left; border:#333 1px solid; padding:3px; margin-left:4px;">	
	<?php 
foreach($result2 as $st) {?>
<label><input type="checkbox" checked name="step_<?php echo $x;?>" value="<?php echo $st;?>" onChange="send();"><?php echo $st;?></label>
	<?php $x++;
	}?>
<input name="i_step" type="hidden" value="<?php echo $x; ?>">
</div>
<div style=" clear:left;"></div>
<div style=" margin-top:10px;">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" style="cursor:pointer; padding:2px 0px 2px 0px;"><label style="float:right;cursor:pointer;"><input name="name_up" type="checkbox" checked value="up" onClick="send();" style="display:none;"></label><label style="display:block"><strong style="text-decoration:underline;cursor:pointer;">Наименование</strong><input checked type="radio" name="sortt" value="name_s" id="sortt_0" onClick="send();"></label></td>
		<td align="center"><strong>Длина балки (мм)</strong></td>
		<td align="center" style="cursor:pointer; padding:2px 0px 2px 0px;"><label style="float:right;cursor:pointer;"><input name="span_up" type="checkbox" checked value="up" onClick="send();" style="display:none;"></label><label style="display:block"><strong style="text-decoration:underline;cursor:pointer;">Макс. пролет (мм)</strong><input type="radio" name="sortt" value="span_s" id="sortt_1" onClick="send();"></label></td>
		<td align="center" style="cursor:pointer; padding:2px 0px 2px 0px;"><label style="float:right;cursor:pointer;"><input name="step_up" type="checkbox" checked value="up" onClick="send();" style="display:none;"></label><label style="display:block"><strong style="text-decoration:underline;cursor:pointer;">Шаг (мм)</strong><input type="radio" name="sortt" value="step_s" id="sortt_2" onClick="send();"></label></td>
	</tr>
<?php
mysql_data_seek($calc,0);
while($resk = mysql_fetch_array($calc)){	?>
	<?php if($resk[length] == '6000' and $resk[load] == '1.5' and isset($desc) and isset($st)){?>
	<tr>
		<td style="padding-left:3px;"><div style="float:left; width:18px; padding:1px"><img src="../calc/beam.png"></div><div><?php echo $resk[name];?></div></td>
		<td align="center"><?php echo $resk[length];?></td>
		<td align="center"><?php echo $resk[span];?></td>
		<td align="center"><?php echo $resk[step];?></td>
	</tr>
	<?php }?>
<?php }?>	
</table>
</div>
</div>
</form>


</body>
</html>