<?php
####### db config ##########
$db_username = 'd01b6068';
$db_password = 'qAD5VvafuSFxhaCN';
$db_name = 'd01b6068';
$db_host = '';
$txt_fehler_db = 'Kann die Datenbank nicht finden.';
$txt_fehler_header = 'Du hast bereits abgestimmt.';
####### db config end ##########

if($_POST)
{
    ### connect to mySql
    $sql_con = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die($txt_fehler_db);

    //get type of vote from client
    $user_vote_type = trim($_POST["vote"]);
    
    //get unique content ID and sanitize it (cos we never know).
    $unique_content_id = filter_var(trim($_POST["unique_id"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    
    //Convert content ID to MD5 hash (optional)
    //$unique_content_id = hash('md5', $unique_content_id);
    
    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        die();
    } 
    
    //check if user has already voted, determined by unique content cookie
    if (isset($_COOKIE["voted_".$unique_content_id]))
    {
       $status = true;
    }
    
    switch ($user_vote_type)
    {           
        
        ##### User liked the content #########
        case 'up': 
            
            //check if user has already voted, determined by unique content cookie
            if ($status == true) { $voteup = 0; } else { $voteup = 1; }
            
            //get vote_up value from db using unique_content_id
            $result = mysqli_query($sql_con,"SELECT vote_up,vote_down FROM voting_count WHERE unique_content_id='$unique_content_id' LIMIT 1");
            $get_total_rows = mysqli_fetch_assoc($result);
            
            if($get_total_rows)
            {
            // found record, update vote_up the value
               mysqli_query($sql_con,"UPDATE voting_count SET vote_up=vote_up+".$voteup." WHERE unique_content_id='$unique_content_id'");
            }
            else
            {
                //no record found, insert new record in db
                mysqli_query($sql_con,"INSERT INTO voting_count (unique_content_id, vote_up) value('$unique_content_id',1)");
            }
            
            if ($status != true) { setcookie("voted_".$unique_content_id, 1, time()+7200); } // set cookie that expires in 2 hour "time()+7200"
            
            $antwort_up =   $get_total_rows["vote_up"]+$voteup;
            $antwort_down = $get_total_rows["vote_down"];
            $antwort = $antwort_up.";".$antwort_down.";up";
            
            if ($status == true)
            { 
               $antwort = $antwort_up.";".$antwort_down.";up;".$txt_fehler_header;
            }
            
            echo ($antwort); //display total liked votes
            break;  
        
        ##### User disliked the content #########
        case 'down': 
            
            //check if user has already voted, determined by unique content cookie
            if ($status == true) { $votedown = 0; } else { $votedown = 1; }

            //get vote_up value from db using unique_content_id
            $result = mysqli_query($sql_con,"SELECT vote_down,vote_up FROM voting_count WHERE unique_content_id='$unique_content_id' LIMIT 1");
            $get_total_rows = mysqli_fetch_assoc($result);
            
            if($get_total_rows)
            {
                //found record, update vote_down the value
                mysqli_query($sql_con,"UPDATE voting_count SET vote_down=vote_down+".$votedown." WHERE unique_content_id='$unique_content_id'");
            }else{
                
                //no record found, insert new record in db
                mysqli_query($sql_con,"INSERT INTO voting_count (unique_content_id, vote_down) value('$unique_content_id',1)");
            }
            
            if ($status != true) { setcookie("voted_".$unique_content_id, 1, time()+7200); } // set cookie that expires in 2 hour "time()+7200".
            
            $antwort_up =   $get_total_rows["vote_up"];
            $antwort_down = $get_total_rows["vote_down"]+$votedown;
            $antwort = $antwort_up.";".$antwort_down.";down";
            
            if ($status == true)
            { 
               $antwort = $antwort_up.";".$antwort_down.";down;".$txt_fehler_header;
            }
            
            echo ($antwort);//display total disliked votes
            break;  
        
        ##### respond votes for each content #########      
        case 'fetch':
            //get vote_up and vote_down value from db using unique_content_id
            $result = mysqli_query($sql_con,"SELECT vote_up,vote_down FROM voting_count WHERE unique_content_id='$unique_content_id' LIMIT 1");
            $row = mysqli_fetch_assoc($result);
            
            //making sure value is not empty.
            $vote_up    = ($row["vote_up"])?$row["vote_up"]:0; 
            $vote_down  = ($row["vote_down"])?$row["vote_down"]:0;
            
            //build array for php json
            $send_response = array('vote_up'=>$vote_up, 'vote_down'=>$vote_down);
            echo json_encode($send_response); //display json encoded values
            break;
    }
}
?>