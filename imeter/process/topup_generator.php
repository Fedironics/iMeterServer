<?php
require_once("../includes/initialize.php");
$successfull=true;
//do some admin validation here
$peak_cards=1000;
function positive($value)
{
if($value<0)
{
$value=0;
}
return $value;
}
function rand_int()
{
    $random_number=rand(10,100).rand(10,100).rand(10,100).rand(10,100).rand(10,100).  rand(10, 100);
    return $random_number;
    
}

function count_remaining($price)
{
global $peak_cards,$database;
$counter="SELECT COUNT(*) FROM imeter_topup_code WHERE amount='$price' AND used='0'";
$data_result=$database->query($counter);
	while($res=$data_result->fetch_array())
	{
		$number=$res[0];
	}
	return positive($peak_cards-$number);
}

function create_card($price)
{
static $repeated;
$card=$num=count_remaining($price);
global $mysqli,$session;
$insert_qq="INSERT INTO imeter_topup_code (pin,amount,used) VALUES";
$cards=array();
	while ($num >= 1)
	 {
		$new_digit=rand_int();
		//we can perform an array search to check if the rand_int exists before putting it
		$cards[]="('$new_digit','$price','0')";
		$num--;	
	}
$insert_qq.=join($cards,',');
	if(!empty($cards))
	{
		$mysqli->query($insert_qq);
		if($mysqli->errno==1062)
			{
				if($repeated<50)
					{
						$repeated++;
						create_card($price);
					}
				else
					{
						$session->message("$card N$price refill aborted due to reccurrent duplicate entries",true);
					}
			
			}
			else
				{
					$session->message("Successfully refilled $card N$price topup codes");
				}
	}
	else 
	{
			$session->message("N$price topup categories have reached their peak");
	}
	
}

create_card(1000);
create_card(2000);
create_card(5000);
create_card(10000);
 
redirect_to("../admin.php");

	






