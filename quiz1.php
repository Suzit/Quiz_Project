<?php


error_reporting(0);

require_once '../_lib/helper.inc';


$conn = helper_login('gp');
if ($conn) {
    //echo "DB Connection OK";
    // helper_logout($conn);
}
else {
    echo "DB Connection FAILED";
}


$MOBNO=$_REQUEST['msisdn'];
//echo $MOBNO;
/*
$date=date("Ymdhis");
//echo $date;
 /* 
//echo "Created date is " . date("Y-m-d h:i:s");
$dt =  strtotime(trim(str_replace('-', '', str_replace(':', '', $date))));
$final_date = date('Y m d h i s',$dt);
//echo $d;
//echo $dt;
*/
$today_datetime_int = date("YmdHis");
//echo $today_datetime_int;

$table1="SELECT SERVICE, SEQ, QTYPE, CATEGORY,STATUS FROM QUIZ_CONTEST_CONTENT WHERE SEQ='12'";
$res       = helper_exec_select_query($conn, $table1);
if($res){
     $i = 0;
    while($res['SEQ'][$i]){
        $seq=$res['SEQ'][$i];
        $service=$res['SERVICE'][$i];
        $qtype=$res['QTYPE'][$i];
        $category=$res['CATEGORY'][$i];
        $status=$res['STATUS'][$i];
        $i++;
      //  print_r($seq);
         
    }
}
// print_r($seq);



//$quiz_query="INSERT INTO QUIZ_CONTEST_LOG(SEQ,SERVICE,MOBILENO,QUES_NUM,ANSERED,POINT,STATUS,QTYPE,CATEGORY) VALUES ('1002','GK','" .  $_GET['MSISDN'] . "','2','B','5','0','Regular','Bangladesh')";
$quiz_query="INSERT INTO QUIZ_CONTEST_LOG(SEQ,SERVICE,MOBILENO,QUES_NUM,ANSERED,POINT,STATUS,QTYPE,CATEGORY) VALUES ('1012','".  $service  ."','" .  $MOBNO . "','".  $seq  ."','B','0','".  $status  ."','".  $qtype  ."','".  $category  ."')";
//echo"====>".$quiz_query;
$result = helper_exec_update_query($conn, $quiz_query);
//print_r($result);
if($result){
    //echo "successfully inserted";
}


$msg = trim($_REQUEST['msg']);
//echo $msg;
$ans1= trim($_REQUEST['ans1']);
//echo $ans1;
$ans2= trim($_REQUEST['ans2']);
//echo $ans2;
$score= trim($_REQUEST['score']);
//echo $point;
//$current_date = date('d-M-y');
//echo  "====>>> ".$current_date;

 if($msg == 'Q')
 {   
    $first_ques = "SELECT QUESTION FROM (SELECT QUESTION FROM QUIZ_CONTEST_CONTENT WHERE TO_DATE(QDATE,'DD-MM-YY') = TO_DATE('13-APR-17', 'DD-MM-YY') ORDER BY QUESTION ASC) WHERE ROWNUM=1";
    $res       = helper_exec_select_query($conn, $first_ques);
    if($res){
     $i = 0;
     while($res['SEQ'][$i]){
        $seq=$res['SEQ'][$i];
        $service=$res['SERVICE'][$i];
        $qtype=$res['QTYPE'][$i];
        $question=$res['QUESTION'][$i];
        $correct_ans=$res['CORRECT'][$i];
        $i++;
      //  print_r($seq);
         
    }
}
  } 
  
if($msg == 'Q')
 {
 $random_question=
"SELECT * FROM  
(SELECT * FROM QUIZ_CONTEST_CONTENT LEFT JOIN QUIZ_CONTEST_LOG ON 
QUIZ_CONTEST_CONTENT.SEQ = QUIZ_CONTEST_LOG.QUES_NUM 
WHERE TO_DATE(QUIZ_CONTEST_LOG.EDATE,'DD-MM-YY') = TO_DATE('13-APR-17', 'DD-MM-YY')
ORDER BY QUIZ_CONTEST_LOG.SEQ DESC ) 
WHERE ROWNUM =1";
  $res       = helper_exec_select_query($conn, $random_question);
 if($res){
     $i = 0;
    while($res['SEQ'][$i]){
        $seq1=$res['SEQ'][$i];
        $service1=$res['SERVICE'][$i];
        $qtype1=$res['QTYPE'][$i];
        $question1=$res['QUESTION'][$i];
        //echo $question;
        $correct_ans1=$res['CORRECT'][$i];
        $i++;
      //  print_r($seq);
         
    }
}
}


$Answered_Check= "SELECT *
FROM ( SELECT * FROM QUIZ_CONTEST_CONTENT LEFT JOIN QUIZ_CONTEST_LOG ON 
QUIZ_CONTEST_CONTENT.SEQ = QUIZ_CONTEST_LOG.QUES_NUM 
WHERE TO_DATE(QUIZ_CONTEST_LOG.EDATE,'DD-MM-YY') = TO_DATE('13-APR-17', 'DD-MM-YY')
ORDER BY QUIZ_CONTEST_LOG.SEQ DESC ) 
WHERE ROWNUM =1";
//echo $Answered_Check;
$res1       = helper_exec_select_query($conn, $Answered_Check);
if($res1){
     $i = 0;
    while($res1['SEQ'][$i])
        {
        $seq2=$res1['SEQ'][$i];
        //echo $seq2;
        $service2=$res1['SERVICE'][$i];
       // echo $service;
        $qtype2=$res1['QTYPE'][$i];
        // echo $qtype;
        $correct_ans2=$res1['CORRECT'][$i];
        //echo $correct_ans2;
        $Score2=$res1['POINT'][$i];
        $i++;
      //  print_r($seq);
         
    }
}

if($ans1==$correct_ans2){
   //echo 'abcd';
    
    $update="UPDATE QUIZ_CONTEST_LOG SET POINT = POINT+1, STATUS = 1, ANSERED='".  $ans1  ."', DATEINT=  $today_datetime_int   WHERE SEQ=  $seq2   AND MOBILENO= $MOBNO   AND SERVICE='".  $service2  ."' ";
    //print_r($update);
   // echo $update;
    $result = helper_exec_update_query($conn, $update);
    if($result){
        //echo 'Successfully updated';
    }
     
    
} 
 
 
else {
   //echo 'abcd';
     $negative_update="UPDATE QUIZ_CONTEST_LOG SET POINT = POINT-1, STATUS = 1, ANSERED='".  $ans1  ."', DATEINT=  $today_datetime_int   WHERE SEQ=  $seq2   AND MOBILENO= $MOBNO   AND SERVICE='".  $service2  ."' ";
     $result = helper_exec_update_query($conn, $negative_update);
    if($result){
      //echo 'Successfully updated';
    }
}

if($ans2==$correct_ans2){
    //echo 'abcd';
    
    $update="UPDATE QUIZ_CONTEST_LOG SET POINT = POINT+1, STATUS = 1, ANSERED='".  $ans2  ."', DATEINT=  $today_datetime_int   WHERE SEQ=  $seq2   AND MOBILENO= $MOBNO   AND SERVICE='".  $service2  ."' ";
    //print_r($update);
   // echo $update;
    $result = helper_exec_update_query($conn, $update);
    if($result){
        //echo 'Successfully updated';
    }
     
    
}
else{
    //echo 'abcd';
     $negative_update="UPDATE QUIZ_CONTEST_LOG SET POINT = POINT-1, STATUS = 1, ANSERED='".  $ans2  ."', DATEINT=  $today_datetime_int   WHERE SEQ=  $seq2   AND MOBILENO= $MOBNO   AND SERVICE='".  $service2  ."' ";
     $result = helper_exec_update_query($conn, $negative_update);
    if($result){
      //echo 'Successfully updated';
    }
}


if($score=='Score')
{
    
$total_point_query="SELECT  SUM(POINT) AS TOTAL_POINT
FROM QUIZ_CONTEST_LOG
WHERE MOBILENO='1875685600'
GROUP BY POINT";
//echo $total_point_query;
$res1       = helper_exec_select_query($conn, $total_point_query);
//print_r($res1);
if($res1){
     $i = 0;
    while($res1['TOTAL_POINT'][$i])
        {
        $total_point=$res1['TOTAL_POINT'][$i];
        //echo $total_point;
        
        $i++;
      //  print_r($seq);
         
    }
}

$todays_point="SELECT SUM(POINT) AS TOTAL_POINT FROM QUIZ_CONTEST_LOG WHERE MOBILENO='1875685600' AND TO_DATE(QUIZ_CONTEST_LOG.EDATE,'DD-MM-YY') = TO_DATE(SYSDATE, 'DD-MM-YY') GROUP BY POINT";
$res1       = helper_exec_select_query($conn, $todays_point);
//print_r($res1);
if($res1){
     $i = 0;
    while($res1['TOTAL_POINT'][$i])
        {
        $todays_point=$res1['TOTAL_POINT'][$i];
        //echo $todays_point;
        
        $i++;
      //  print_r($seq);
         
    }
}
}

?>
