<?php
class MeterMessage {
    public $message;
    public $state;
    public $data;
    public $output;
    public $response=[];
  

    public static function collector($message,$collector=true)
    {
        
        $collected=new MeterMessage();
         if(json_decode($message))
                    {
                        $collected->data=json_decode($_POST['Password']);
                        $collected->process($collector);
                    }
                else
                    {
                    die("not JSON");
                     }
    return    $collected;
    }
 
    public function  process($collector=true)
        {
        global $database,$meter_no;
        $meter_no=$this->data->meter_no;
        if(empty($this->data->message_type) && $collector)
            {
            $this->state=99;
            } 
		if(empty($this->data->key))
            {
            $this->state=15;
            }
         else if(empty($this->data->meter_no))
         {
             $this->state=14;
             
         }
        else if($database->query("SELECT id FROM user_informations WHERE meter_no='$meter_no'")->num_rows!=1)
        {
             $this->state=14;
         }
        else if(empty ($this->data->meter_SIM_no))
        {
            $this->state=13;
        }
        else if(!$this->_compare_no())
        {
             $this->state=13;
        }
        else if(empty($this->data->time_sent))
        {
            //can be redifined later for time errors for now just 9999
            $this->state=99;
        }
        else if(strtotime($this->data->time_sent)=='')
        {
            $this->state=99;
        }
        else 
        {
             $collector?$this->distribute_tasks(): $this->refresh();
        }
   
        $this->refresh();
    }
    private function _compare_no()
    {
        $gotten=  $this->_match_no($this->data->meter_SIM_no);
        $known= $this->_match_no(eselect($this->data->meter_no,'meter_sim','meter_no'));
        return $gotten==$known? true : false;
    }

    private function _match_no($phone)
{
    $phone=trim($phone);
if(substr($phone,0,1)=='+')
        {
            $l3n=strlen($phone);
            $phone=substr($phone,1,$l3n);
        }
        return $phone;
}   
public function distribute_tasks()
{
    switch ($this->data->message_type)
    {
    case 1 :
        //if it is regular meter readings
        $this->meter_readings();
        break;
    case 2 :
        //if it is query
        
        break;
    case 3 :
        //it it is topup code
        $this->recharge_meter();
        break;
    case 4 :
        //if it is a theft flag
        $this->flag_theft();
        break;
    case 5 :
        //boot setup
    //    $this->boot_setup();
        break;
    default :
        //
        $this->state=99;
    }   
}
        
public function meter_readings()
    {
    global $database;
    $meter_no=$this->data->meter_no;
    if(empty($this->data->meter_readings))
         {
            $this->state=11;
         }
     else if(empty($this->data->available_amount))
         {
             $this->state=11;
         }
      else if(count($this->data->meter_readings)!=12)
         {
             $this->state=11;
         }
       else
            {
                $dater=trim(substr($this->data->time_sent, 0,10));
                $no_bef=$database->query("SELECT id,dater FROM meter_informations WHERE dater='$dater' AND meter_no='$meter_no'")->num_rows;
               if($no_bef<12)
                    {

                         $this->state=20;
                        $this->_insert_readings(1);
                    //meaning it is the first set of values
                    }
                else if($no_bef<24)
                     {
                     //for the second set
                     
                         $this->state=20;
                    $this->_insert_readings(13);
                     }
                else 
                    {
                         $this->state=12;
                    }
               }      
    }
private function _insert_readings($set)
    {
    global $database,$price;
    $dater=trim($this->data->time_sent);
    $meter_no=$this->data->meter_no;
    $e_bal=$this->data->available_amount;
    $insert_query="INSERT INTO meter_informations(meter_no,energy_consumed,hour,dater,time_recieved,price,energy_balance) VALUES";
                    $insert_array=array();
                    foreach ($this->data->meter_readings as $raw_hour=>$useage)
                        {
                        $hour=$raw_hour+$set;
                        $insert_array[]="('$meter_no','$useage','$hour','$dater',NOW(),'$price','$e_bal')";
                                
                        }
     $insert_query.=join($insert_array, ',');
     $database->query($insert_query);
                            
    }
    
    public function recharge_meter($code='',$meter_no='')
        {
            global $database,$session;
            $code=empty($code)?$this->data->top_up_code:$code;
            $meter_no=empty($meter_no)?$this->data->meter_no:$meter_no;
            $done=empty($meter_no)?1:0;
            if(empty($code))
                {
                    $this->state=11;
                }
             else if($database->query("SELECT id,amount,used FROM imeter_topup_code where pin='$code' ")->num_rows!=1)
                {
                	 $session->message("the topup code you entered does not exist, please check and try again",true);
                    $this->state=11;
                }
              else 
                {
                  $check=$database->query("SELECT id,amount,used FROM imeter_topup_code where pin='$code' ");
                   while($info=$check->fetch_array())
                                {
                                                $recharge_amount=$info['amount'];
                                                $id=$info['id']	;
                                                $used=$info['used'];		
                                }
                 if($used!=0)
                        {
                            if($used==$meter_no)
                                {
                                    
                                    	$session->message("this code has already been used by you",true);
			$this->state=121;
                                }
                             else {	$session->message("already used topup code",true);
				
                                    $this->state=122;
                                     }
                         }
                   else
                        {
                            //another place you need to work on and check every database insert worked or just database
                            $update=$database->query("UPDATE imeter_topup_code SET used='$meter_no' WHERE id='$id'")	;
                            $record=$database->query("INSERT INTO user_queries (meter_no,energy_budget,topup_code,payment_method,amount_paid,query_code,done,time_requested) VALUES ('$meter_no','','$id','','$recharge_amount','2','$done',NOW())");
                            $uid=$database->last_id();
                            $know=$database->query("INSERT INTO meter_topup (method,value,meter_no,time) VALUES ('topup_code','$recharge_amount','$meter_no',NOW())")	;
                            //here the code to send the message to the meter will be ---+++***davidity---+++***
                            $this->message= "$recharge_amount";
                            $this->state=20;	$session->message("topupcode succesfully inserted you will be credited soon",false);
		
                            empty($meter_no)?null:Response::record($this->display(3200),$uid);
                        }

                }
         }
         
public function flag_theft()
    {
    global $database;
    if(empty($this->data->theft_type))
        {
        $this->state=11;
        }
      else
        {
          $occurence_time=$this->data->time_sent;
          $meter_no=$this->data->meter_no;
          $theft_type=$this->data->theft_type;
          $duplicate=$database->query("SELECT id FROM energy_theft WHERE meter_no='$meter_no' AND time='$occurence_time' AND active='1'")->num_rows;
          if($duplicate!=0)
                {
                    $this->state=12;
                }
           else 
                {
                    $flag=$database->query("INSERT INTO energy_theft (meter_no,time,active,type,time_recieved) VALUES('$meter_no','$occurence_time','1','$theft_type',NOW())");
                    $this->state=20;     
                }
        }
    }
    
public function output()
{
   if(empty($this->state))
                {
                    $this-> display('8888');
                }
            else 
                {
                    $detailation=  strlen($this->state);
                    if($this->state==99)
                        {
                        $this->display("9999");
                        }
                    else if($detailation==2)
                        {
                            $this-> display($this->data->message_type.$this->state.'0');
                        }
                     else if($detailation==3)
                        {
                            $this-> display($this->data->message_type.$this->state);
                        }
                        else
                            {
                               $this->  display($this->state);
                            }
                }
             
         return $this->output; 
      }
public function display($value)
{
    $this->response['response']=$value;
    empty($this->message)?null:$this->response['data']=$this->message;
    empty($this->data->key)?null:$this->response['key']=$this->data->key;
    return $this->output=json_encode($this->response);
}
public function show($value)
{
    $content_length=strlen($value);
    header("Content-Length: $content_length");
    return $value; 
} 
public function refresh()
{
    global $user,$database,$meter_no;
       $get_id=$database->query("SELECT id FROM user_informations WHERE meter_no='$meter_no'");
       $id_array=fetch_as_array($get_id);
       $this->user_id=$id_array['id'];
       $user=  User::find_by_id($this->user_id);
     
}
}

