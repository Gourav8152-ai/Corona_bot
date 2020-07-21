<?php
 
$botToken = "<TOKEN>";   # TAKE IT FROM BOTFATHER
#Make sure you webhook it and upload it any hosting to run it 
$website = "https://api.telegram.org/bot".$botToken;
error_reporting(0);
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
 $e = print_r($update);
 
 
$chatId = $update["message"]["chat"]["id"];   #To get the chatId of the group or chat 
$userId = $update["message"]["from"]["id"];   #To know the userId who is typing the command
$firstname = $update["message"]["from"]["first_name"];   #to know the name
$username = $update["message"]["from"]["username"];    #to know the username
$message = $update["message"]["text"];                #the text you message
$message_id = $update["message"]["message_id"];       #Your message Id
$r_userId = $update["message"]["reply_to_message"]["from"]["id"];    #If you want to know which user Has did this it will let u know his ID 
$r_firstname = $update["message"]["reply_to_message"]["from"]["first_name"]; 
$r_username = $update["message"]["reply_to_message"]["from"]["username"];
$r_msg_id = $update["message"]["reply_to_message"]["message_id"];
$info ="<b>ID : </b>$userId\n<b>First Name: </b>$firstname\n<b>Username : </b>@$username\n<b>Permanent Link : </b><a href='tg://user?id=$userId'>$firstname</a>";
$info1 = urlencode($info);
$info2 ="<b>ID : </b>$r_userId\n<b>First Name: </b>$r_firstname\n<b>Username : </b>@$r_username\n<b>Permanent Link : </b><a href='tg://user?id=$r_userId'>$r_firstname</a>";
$info3 = urlencode($info2);
$cmds11 = "<b>FOR KNOWING STATUS FOR CORONA </b>%0A<b>YOU CAN USE THIS COMMAND</b>%0A<b>TO KNOW GLOBAL STATUS : </b><u>/global</u>%0A<b>TO KNOW STATUS OF YOUR COUNTRY : </b><u>/country country-name</u>%0A<b>TO KNOW STATUS OF YOUR CONTINENT : </b><u>/continent continent-name</u>";

switch($message) {
       
        case "/start":
                sendMessage($chatId, "<b>Type /cmd to know the command! </b>");
                break;
        case "/cmd":
                sendMessage($chatId,"This are the command %0A$cmds11");
                break;
        case "/info":
          #Here is the info r_userId Id is null then it it will print the userID which mean the person who is typing the command
            if($r_userId ===null)
            {
               sendMessage($chatId,$info1);
            }
            else
           {
                sendMessage($chatId,$info3);
            }
            break;
        case "/status";
            # TO check whether the bot is dead or alive
              sendMessage($chatId, "<b>ALIVE</b>");
              break;
        case "Pin";
          #Used to pin a something if it has been right to pin n promoted as admin
              pinChatMessage($chatId,$r_msg_id);
              deleteMessage($chatId, $message_id);
              break;
        case "Unpin";
        #To unpin the statement 
              unpinChatMessage($chatId);
               deleteMessage($chatId, $message_id);
              break;
        case "del";
        #To delete the statement 
              deleteMessage($chatId, $r_msg_id);
              deleteMessage($chatId, $message_id);
              break;
}
#here is the going to take the deatils of continent using a api resource (https://corona.lmao.ninja) 
if (strpos($message, "/continent") === 0) {
  $coron = substr($message, 11);
    $coro = urlencode($coron);
        if(strlen($message)<12){
            sendMessage($chatId, 'No continent Inputted');
        }
        else{
            error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');

function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}

            $result1 = file_get_contents('https://corona.lmao.ninja/v2/continents/'.$coro.'');
            $result = json_decode($result1, true);
            $totalcases = $result['cases'];
            $totaldeath = $result['deaths'];
            $todaycases = $result ['todayCases'];
            $todaydeath = $result['todayDeaths'];
            $recovered = $result['recovered'];
            $todayrecoverd = $result['todayRecovered'];
            $Activecases = $result['active'];
            $criticalcases = $result['critical'];
            $response = '<b>Total No of cases : </b>'.$totalcases.'%0A<b>Total No of Death : </b>'.$totaldeath.'%0A<b>Todays Cases : </b>'.$todaycases.'%0A<b>Today Death : </b>'.$todaydeath.'%0A<b>Total Recovered : </b>'.$recovered.'%0A<b>Total Person Recovered Today : </b>'.$todayrecoverd.'%0A<b>Active Cases : </b>'.$Activecases.'%0A<b>Critical cases : </b>'.$criticalcases.'';

           if(strpos($result,"Continent not found"))
            {
                  sendMessage($chatId,"CONTINENT NOT FOUND");
              }
              else
              {
                  sendMessage($chatId,$response);
              }
          }


        curl_close($ch);
        ob_flush();
}
#here is the going to take the deatils of country using a api resource (https://corona.lmao.ninja) 

elseif (strpos($message, "/country") === 0) {
    $coron = substr($message, 9);
      $coro = urlencode($coron);
          if(strlen($message)<10){
              sendMessage($chatId, 'No Country inputted');
          }
          else{
              error_reporting(0);
  set_time_limit(0);
  error_reporting(0);
  date_default_timezone_set('Asia/Kolkata');
  
  function GetStr($string, $start, $end)
  {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
  }
  
              $result1 = file_get_contents('https://corona.lmao.ninja/v2/countries/'.$coro.'');
              $result = json_decode($result1, true);
              $totalcases = $result['cases'];
              $totaldeath = $result['deaths'];
              $todaycases = $result ['todayCases'];
              $todaydeath = $result['todayDeaths'];
              $recovered = $result['recovered'];
              $todayrecoverd = $result['todayRecovered'];
              $Activecases = $result['active'];
              $criticalcases = $result['critical'];
              $response = "<b>Total No of cases : </b>$totalcases%0A<b>Total No of Death : </b>$totaldeath%0A<b>Todays's Cases : </b>$todaycases%0A<b>Today's Death : </b>$todaydeath%0A<b>Total Recovered : </b>$recovered%0A<b>Total Person Recovered Today : </b>$todayrecoverd%0A<b>Active Cases : </b>$Activecases%0A<b>Critical cases : </b>$criticalcases";
  
              if(strpos($result,"Country not found"))
              {
                  sendMessage($chatId,"COUNTRY NOT FOUND");
              }
              else
              {
                  sendMessage($chatId,$response);
              }
          }
          curl_close($ch);
  }
#here is the going to take the deatils of global  using a api resource (https://corona.lmao.ninja) 

  elseif(strpos($message, "/global") !== false) {
     error_reporting(0);
  set_time_limit(0);
  error_reporting(0);
  date_default_timezone_set('Asia/Kolkata');
  
  function GetStr($string, $start, $end)
  {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
  }
  
              $result1 = file_get_contents('https://corona.lmao.ninja/v2/all');
              $result = json_decode($result1, true);
              $totalcases = $result['cases'];
              $totaldeath = $result['deaths'];
              $todaycases = $result ['todayCases'];
              $todaydeath = $result['todayDeaths'];
              $recovered = $result['recovered'];
              $todayrecoverd = $result['todayRecovered'];
              $Activecases = $result['active'];
              $criticalcases = $result['critical'];
              $response = "<b>Total No of cases : </b>$totalcases%0A<b>Total No of Death : </b>$totaldeath%0A<b>Todays's Cases : </b>$todaycases%0A<b>Today's Death : </b>$todaydeath%0A<b>Total Recovered : </b>$recovered%0A<b>Total Person Recovered Today : </b>$todayrecoverd%0A<b>Active Cases : </b>$Activecases%0A<b>Critical cases : </b>$criticalcases";
  
             
                  sendMessage($chatId,$response);
         
  
          curl_close($ch);
  }
function sendMessage ($chatId,$message) {
       
        $url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&reply_to_message_id=".$message_id."&parse_mode=HTML";
        file_get_contents($url);
       
}
#This function let you send the message
function pinChatMessage ($chatId,$r_msg_id) {
       
        $url = $GLOBALS[website]."/pinChatMessage?chat_id=".$chatId."&message_id=".$r_msg_id."&disable_notification=true";
        file_get_contents($url);
        
}
#This function let you pin the statment if it has been right
function  deleteMessage ($chatId, $r_msg_id) {
       
        $url = $GLOBALS[website]."/deleteMessage?chat_id=".$chatId."&message_id=".$r_msg_id."";
        file_get_contents($url);
}
#This function lets you delete a statement
function unpinChatMessage ($chatId) {
       
        $url = $GLOBALS[website]."/unpinChatMessage?chat_id=".$chatId."";
        file_get_contents($url);
}
#This function lets you unpin a message 

curl_close($ch);
ob_flush();

#COPY WITH CREDIT Gourav8152-ai
?>
