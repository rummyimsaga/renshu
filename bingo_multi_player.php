<?php
bingo_start();

function bingo_start($player = 4, $draw = 30){
	$bingo_sheet = [];
	for ($cnt = 0; $cnt < $player; $cnt++){
		$bingo_sheet[] = bingo_determine();
	}

	$bingo_number = [];
	for ($cnt = 0; $cnt < $draw; $cnt++){
		$rand = rand(1, 50);
		while (array_search($rand, $bingo_number, TRUE) !== FALSE){
			$rand = rand(1, 50);
		}
		$bingo_number[] = $rand;
	}
	
	$bingo_judge = FALSE;
	$bingo_pattern = [];
	$bingo_index = 0;
	$bingo_indexes = [];
	
	for ($cnt1=0; $cnt1<$player; $cnt1++){
		while ($bingo_judge === FALSE){
			for ($cnt2=0; $cnt2<count($bingo_sheet[$cnt1]); $cnt2++){
				if (array_search($bingo_number[$bingo_index], $bingo_sheet[$cnt1][$cnt2], TRUE) !== FALSE){
					$bingo_sheet[$cnt1][$cnt2][1] = TRUE;
					break;
				}
			}
			$bingo_index++;

			if($bingo_sheet[$cnt1][0][1]&&$bingo_sheet[$cnt1][1][1]&&$bingo_sheet[$cnt1][2][1]&&$bingo_sheet[$cnt1][3][1]&&$bingo_sheet[$cnt1][4][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=0;}
			if($bingo_sheet[$cnt1][5][1]&&$bingo_sheet[$cnt1][6][1]&&$bingo_sheet[$cnt1][7][1]&&$bingo_sheet[$cnt1][8][1]&&$bingo_sheet[$cnt1][9][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=1;}
			if($bingo_sheet[$cnt1][10][1]&&$bingo_sheet[$cnt1][11][1]&&$bingo_sheet[$cnt1][12][1]&&$bingo_sheet[$cnt1][13][1]&&$bingo_sheet[$cnt1][14][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=2;}
			if($bingo_sheet[$cnt1][15][1]&&$bingo_sheet[$cnt1][16][1]&&$bingo_sheet[$cnt1][17][1]&&$bingo_sheet[$cnt1][18][1]&&$bingo_sheet[$cnt1][19][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=3;}
			if($bingo_sheet[$cnt1][20][1]&&$bingo_sheet[$cnt1][21][1]&&$bingo_sheet[$cnt1][22][1]&&$bingo_sheet[$cnt1][23][1]&&$bingo_sheet[$cnt1][24][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=4;}
			if($bingo_sheet[$cnt1][0][1]&&$bingo_sheet[$cnt1][5][1]&&$bingo_sheet[$cnt1][10][1]&&$bingo_sheet[$cnt1][15][1]&&$bingo_sheet[$cnt1][20][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=5;}
			if($bingo_sheet[$cnt1][1][1]&&$bingo_sheet[$cnt1][6][1]&&$bingo_sheet[$cnt1][11][1]&&$bingo_sheet[$cnt1][16][1]&&$bingo_sheet[$cnt1][21][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=6;}
			if($bingo_sheet[$cnt1][2][1]&&$bingo_sheet[$cnt1][7][1]&&$bingo_sheet[$cnt1][12][1]&&$bingo_sheet[$cnt1][17][1]&&$bingo_sheet[$cnt1][22][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=7;}
			if($bingo_sheet[$cnt1][3][1]&&$bingo_sheet[$cnt1][8][1]&&$bingo_sheet[$cnt1][13][1]&&$bingo_sheet[$cnt1][18][1]&&$bingo_sheet[$cnt1][23][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=8;}
			if($bingo_sheet[$cnt1][4][1]&&$bingo_sheet[$cnt1][9][1]&&$bingo_sheet[$cnt1][14][1]&&$bingo_sheet[$cnt1][19][1]&&$bingo_sheet[$cnt1][24][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=9;}
			if($bingo_sheet[$cnt1][0][1]&&$bingo_sheet[$cnt1][6][1]&&$bingo_sheet[$cnt1][12][1]&&$bingo_sheet[$cnt1][18][1]&&$bingo_sheet[$cnt1][24][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=10;}
			if($bingo_sheet[$cnt1][4][1]&&$bingo_sheet[$cnt1][8][1]&&$bingo_sheet[$cnt1][12][1]&&$bingo_sheet[$cnt1][16][1]&&$bingo_sheet[$cnt1][20][1]){$bingo_judge=TRUE;$bingo_pattern[$cnt1][]=11;}
				
			if(!empty($bingo_pattern[$cnt1])){break;}
			if($bingo_index>=count($bingo_number)){break;}
		}

		$bingo_indexes[] = ($bingo_judge === TRUE ? $bingo_index : -1);
		$bingo_judge = FALSE;
		$bingo_index = 0;
	}
	echo '', PHP_EOL;
	
	/* For debug
	for ($cnt1=0;$cnt1<$player;$cnt1++){
		echo 'Player' . $cnt1 .  ':', PHP_EOL;
		for ($cnt2=0;$cnt2<count($bingo_sheet[$cnt1]);$cnt2++){
			if ($bingo_sheet[$cnt1][$cnt2][0] < 10){
				echo '0';
			}
			echo $bingo_sheet[$cnt1][$cnt2][0];

			if ($cnt2%5 ===4){
				echo "\n";
			}
			else {
				echo ' ';
			}
		}
		echo "\n";
	}
	for ($cnt1=0;$cnt1<count($bingo_number);$cnt1++){
		if ($bingo_number[$cnt1] < 10){
			echo '0';
		}
		echo $bingo_number[$cnt1];

		if ($cnt1%10 === 9){
			echo "\n";
		}
		else {
			echo ' ';
		}
	}
	*/

	for ($cnt = 0; $cnt < $player; $cnt++){
		echo 'Player' . $cnt . ':', PHP_EOL;
		echo empty($bingo_pattern[$cnt])?bingo_fail($bingo_sheet[$cnt]):bingo_success($bingo_pattern[$cnt], $bingo_sheet[$cnt]);
		echo '=> ' . $bingo_indexes[$cnt] . "\n", PHP_EOL;
	}

	for ($cnt = 0; $cnt < count($bingo_number); $cnt++){
		if ($bingo_number[$cnt] < 10){
			echo '0';
		}
		echo $bingo_number[$cnt];
		if ($cnt % 10 === 9){
			echo "\n";
		}
		else {
			echo ' ';
		}
	}
}

function bingo_determine(){
	$bingo_sheet = [];
	$rand_list = [];
	for ($cnt = 0; $cnt < 25; $cnt++){
		$rand = rand(1, 50);
		while (array_search($rand, $rand_list, TRUE) !== FALSE){
			$rand = rand(1, 50);
		}
		$bingo_sheet[] = [$rand, FALSE];
		$rand_list[] = $rand;
	}
	return $bingo_sheet;
}

function bingo_success($bingo_ptn, $bingo_sheet){
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

function bingo_fail($bingo_sheet){
	$str=NULL;
	for($cnt=0;$cnt<count($bingo_sheet);$cnt++){
		if($bingo_sheet[$cnt][1]!==FALSE){
			if($bingo_sheet[$cnt][0]<10){$str=$str.sprintf("\033[46m%s\033[m",'0'.$bingo_sheet[$cnt][0]);}
			else{$str=$str.sprintf("\033[46m%s\033[m",$bingo_sheet[$cnt][0]);}
		}
		else{
			if($bingo_sheet[$cnt][0]<10){$str=$str.sprintf("%s",'0'.$bingo_sheet[$cnt][0]);}
			else{$str=$str.sprintf("%s",$bingo_sheet[$cnt][0]);}
		}

		if(($cnt!==0)&&($cnt%5===4)){$str=$str."\n";}
		else{$str=$str.' ';}
	}
	return $str;
}
?>
