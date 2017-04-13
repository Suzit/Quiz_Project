<?php

error_reporting(0);

require_once '../_lib/helper.inc';


$conn = helper_login('gp');
if ($conn) {
    echo "DB Connection OK";
    // helper_logout($conn);
}
else {
    echo "DB Connection FAILED";
}

$query_sel = "select * from QUIZ_CONTEST_CONTENT";
//echo $query_sel;
$res       = helper_exec_select_query($conn, $query_sel);
if ($res) {
    echo "<table style='font-size:13px;' align='center' width='75%'><tr align='center' bgcolor='#999999'>
		
		<td><b> SERVICE </b></td>
                <td><b> CATEGORY </b></td>
                <td><b> QTYPE </b></td>
		<td><b> QUESTION </b></td>
                <td><b> OPTION1 </b></td>
                <td><b> OPTION2 </b></td>
                <td><b> APPEND </b></td>
                <td><b> CORRECT </b></td>
                <td><b> QDATE </b></td>
                <td><b> STATUS </b></td>
               
	</tr>";
    $i = 0;
    while ($res['SERVICE'][$i]) {
        if ($i % 2 == 0)
            echo "<tr align='center' valign='middle'>";
        else
            echo "<tr align='center' valign='middle' bgcolor='#CCCCCC'>";
        $j = $i + 1;
        echo "<td>" . $res['SERVICE'][$i] . "</td>
			<td>" . $res['CATEGORY'][$i] . "</td>
                        <td>" . $res['QTYPE'][$i] . "</td>
                        <td>" . $res['QUESTION'][$i] . "</td>
			<td>" . $res['OPTION1'][$i] . "</td>
                        <td>" . $res['OPTION2'][$i] . "</td>
                        <td>" . $res['APPEND'][$i] . "</td>
                        <td>" . $res['CORRECT'][$i] . "</td>
                        <td>" . $res['QDATE'][$i] . "</td>
                        <td>" . $res['STATUS'][$i] . "</td>
                            
                       
                       
		</tr>";
        $i++;
    }
    echo '</table>';
}
?>
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
echo '<br>';
$log_query="SELECT * FROM QUIZ_CONTEST_LOG";
echo '<a href="quiz1.php?msisdn=1875685600&msg=Q&ans1=A&ans2=B&score=Score ">link to page2</a>';

?>
<br>
