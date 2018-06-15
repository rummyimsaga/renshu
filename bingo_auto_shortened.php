<?php
$sheet=[];
$list=[];

for($cnt=0;$cnt<25;$cnt++){
	$rand=rand(1,50);
	while(array_search($rand,$list,TRUE)!==FALSE){$rand=rand(1,50);}
	$sheet[]=[$rand,FALSE];
	$list[]=$rand;
}

unset($list);
$list=[];

$draw=30;
for($cnt=0;$cnt<$draw;$cnt++){
	$rand=rand(1,50);
	while(array_search($rand,$list,TRUE)!==FALSE){$rand=rand(1,50);}
	$list[]=$rand;
}
	
$bingo=FALSE;
$bingo_ptn=[];
$list_index=0;
while($bingo===FALSE){
	for($cnt=0;$cnt<count($sheet);$cnt++){
		if(($index=array_search($list[$list_index],$sheet[$cnt],TRUE))!==FALSE){$sheet[$cnt][1]=TRUE;break;}
	}

	$list_index++;

	if($sheet[0][1]&&$sheet[1][1]&&$sheet[2][1]&&$sheet[3][1]&&$sheet[4][1]){$bingo=TRUE;$bingo_ptn[]=0;}
	if($sheet[5][1]&&$sheet[6][1]&&$sheet[7][1]&&$sheet[8][1]&&$sheet[9][1]){$bingo=TRUE;$bingo_ptn[]=1;}
	if($sheet[10][1]&&$sheet[11][1]&&$sheet[12][1]&&$sheet[13][1]&&$sheet[14][1]){$bingo=TRUE;$bingo_ptn[]=2;}
	if($sheet[15][1]&&$sheet[16][1]&&$sheet[17][1]&&$sheet[18][1]&&$sheet[19][1]){$bingo=TRUE;$bingo_ptn[]=3;}
	if($sheet[20][1]&&$sheet[21][1]&&$sheet[22][1]&&$sheet[23][1]&&$sheet[24][1]){$bingo=TRUE;$bingo_ptn[]=4;}

	if($sheet[0][1]&&$sheet[5][1]&&$sheet[10][1]&&$sheet[15][1]&&$sheet[20][1]){$bingo=TRUE;$bingo_ptn[]=5;}
	if($sheet[1][1]&&$sheet[6][1]&&$sheet[11][1]&&$sheet[16][1]&&$sheet[21][1]){$bingo=TRUE;$bingo_ptn[]=6;}
	if($sheet[2][1]&&$sheet[7][1]&&$sheet[12][1]&&$sheet[17][1]&&$sheet[22][1]){$bingo=TRUE;$bingo_ptn[]=7;}
	if($sheet[3][1]&&$sheet[8][1]&&$sheet[13][1]&&$sheet[18][1]&&$sheet[23][1]){$bingo=TRUE;$bingo_ptn[]=8;}
	if($sheet[4][1]&&$sheet[9][1]&&$sheet[14][1]&&$sheet[19][1]&&$sheet[24][1]){$bingo=TRUE;$bingo_ptn[]=9;}

	if($sheet[0][1]&&$sheet[6][1]&&$sheet[12][1]&&$sheet[18][1]&&$sheet[24][1]){$bingo=TRUE;$bingo_ptn[]=10;}
	if($sheet[4][1]&&$sheet[8][1]&&$sheet[12][1]&&$sheet[16][1]&&$sheet[20][1]){$bingo=TRUE;$bingo_ptn[]=11;}

	if(!empty($bingo_ptn)){break;}
	if($list_index>=count($list)){break;}	
}

if(empty($bingo_ptn)){
	echo "\nYou couldn't achieve Bingo.\nThat's too bad.\n",PHP_EOL;
	echo "Your card:",PHP_EOL;
	$str=NULL;
	for($cnt=0;$cnt<count($sheet);$cnt++){
		if($sheet[$cnt][1]!==FALSE){
			if($sheet[$cnt][0]<10){$str=$str.sprintf("\033[46m%s\033[m",'0'.$sheet[$cnt][0]);}
			else{$str=$str.sprintf("\033[46m%s\033[m",$sheet[$cnt][0]);}
		}
		else{
			if($sheet[$cnt][0]<10){$str=$str.sprintf("%s",'0'.$sheet[$cnt][0]);}
			else{$str=$str.sprintf("%s",$sheet[$cnt][0]);}
		}

		if(($cnt!==0)&&($cnt%5===4)){$str=$str."\n";}
		else{$str=$str.' ';}
	}
	echo $str,PHP_EOL;
}
else{
	echo "\nYou achieved ".count($bingo_ptn)." Bingo".(count($bingo_ptn)>=2?"s":"")."!\nCongraturations!\n",PHP_EOL;
	echo "Your card:",PHP_EOL;
	echo bingocolor($bingo_ptn,$sheet),PHP_EOL;
}

echo "Number:",PHP_EOL;
for($cnt=0;$cnt<count($list);$cnt++){
	echo $list[$cnt];
	if(($cnt%10===9)&&($cnt!==0)){echo '',PHP_EOL;}
	else{echo ' ';}
}
echo '',PHP_EOL;
echo $list_index,PHP_EOL;

function bingocolor($bingo_ptn,$bingo_sheet){
	$ptn=[];
	$ptn[]=[0,1,2,3,4];
	$ptn[]=[5,6,7,8,9];
	$ptn[]=[10,11,12,13,14];
	$ptn[]=[15,16,17,18,19];
	$ptn[]=[20,21,22,23,24];
	$ptn[]=[0,5,10,15,20];
	$ptn[]=[1,6,11,16,21];
	$ptn[]=[2,7,12,17,22];
	$ptn[]=[3,8,13,18,23];
	$ptn[]=[4,9,14,19,24];
	$ptn[]=[0,6,12,18,24];
	$ptn[]=[4,8,12,16,20];

	$merged_ptn=[];
	for($cnt=0;$cnt<count($bingo_ptn);$cnt++){$merged_ptn=array_merge($merged_ptn,$ptn[$bingo_ptn[$cnt]]);}

	$str=NULL;
	$hit="\033[46m%s\033[m";
	$bingo="\033[42m%s\033[m";
		
	for($cnt=0;$cnt<count($bingo_sheet);$cnt++){
		if(array_search($cnt,$merged_ptn,TRUE)!==FALSE){
			if($bingo_sheet[$cnt][0]<10){$str=$str.sprintf($bingo,'0'.$bingo_sheet[$cnt][0]);}
			else{$str=$str.sprintf($bingo,$bingo_sheet[$cnt][0]);}
		}
		elseif($bingo_sheet[$cnt][1]!==FALSE){
			if($bingo_sheet[$cnt][0]<10){$str=$str.sprintf($hit,'0'.$bingo_sheet[$cnt][0]);}
			else{$str=$str.sprintf($hit,$bingo_sheet[$cnt][0]);}
		}
		else{
			if($bingo_sheet[$cnt][0]<10){$str=$str.sprintf("%s",'0'.$bingo_sheet[$cnt][0]);}
			else{$str=$str.sprintf("%s",$bingo_sheet[$cnt][0]);}
		}

		if(($cnt!==0)&&($cnt%5===4)){$str=$str."\n";}
		else {$str=$str.' ';}
	}
	return $str;
}
?>
