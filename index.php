<?php
$uploadedStatus = 0;

if ( isset($_POST["submit"]) ) {
if ( isset($_FILES["file"])) {
	if ($_FILES["file"]["error"] > 0) {
echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else {

	$time = time();
  $myname = $time.'.xlsx'; 
	$storagename = "upload/$myname";
move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);

define ("DB_HOST", ""); // set database host
define ("DB_USER", ""); // set database user
define ("DB_PASS",""); // set database password
define ("DB_NAME",""); // set database name

@$link = mysql_connect("localhost", "root", "password") or die("Couldn't make connection.");
@$db = mysql_select_db("db-name", $link) or die("Couldn't select database");

$databasetable = "table-name";

/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
$inputFileName = $storagename; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

 $me = 0;
for($i=2;$i<=$arrayCount;$i++){
$ref_no = trim($allDataInSheet[$i]["A"]);
$link = trim($allDataInSheet[$i]["B"]); 
$email = trim($allDataInSheet[$i]["C"]); 
$location = trim($allDataInSheet[$i]["D"]); 
$address = trim($allDataInSheet[$i]["E"]); 
$country = trim($allDataInSheet[$i]["F"]);  
$phone = trim($allDataInSheet[$i]["G"]); 
$fax = trim($allDataInSheet[$i]["H"]); 
$contact_person = trim($allDataInSheet[$i]["I"]); 
$organization = trim($allDataInSheet[$i]["J"]);  
$notice_no	 = trim($allDataInSheet[$i]["K"]); 
$bidding_type = trim($allDataInSheet[$i]["L"]); 
$desc = trim($allDataInSheet[$i]["M"]); 
$tender_cost = trim($allDataInSheet[$i]["N"]); 
$dead_line = trim($allDataInSheet[$i]["O"]); 
$sector =  trim($allDataInSheet[$i]["P"]); 
$last_update = trim($allDataInSheet[$i]["Q"]);     
$financier = trim($allDataInSheet[$i]["R"]);   
 $added_date = date("d-M-y"); 
//$added_date = '24-Oct-16'; 
if($desc != '')  
{
$me = $me+1;
 $inssrt = "insert into s_tenders (ref_no, link, email, location, address, country, phone, fax,contact_person, organization, notice_no,bidding_type,descr,tender_cost,added_date,dead_line,sector,last_update,financier) values('".$ref_no."', '".$link."', '".$email."', '".$location."', '".$address."', '".$country."', '".$phone."', '".$fax."', '".$contact_person."', '".$organization."', '".$notice_no."','".$bidding_type."','".$desc."','".$tender_cost."','".$added_date."','".$dead_line."','".$sector."','".$last_update."','".$financier."')";
mysql_query($inssrt);
}
  }

header("Location: thankyou.php?id=$me");
//$insertTable= mysql_query("insert into YOUR_TABLE (a, n) values('".$a."', '".$n."');");



//$msg = 'Record has been added. <div style="Padding:20px 0 0 0;"><a href="">Go Back to tutorial</a></div>';
//} else {
//$msg = 'Record already exist. <div style="Padding:20px 0 0 0;"><a href="">Go Back to tutorial</a></div>';
//}
}// echo $insertTable;
//echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";
 
}
}
?> 
 
 
 
 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title> Import Excel file data in mysql database using PHP, Upload Excel file data in database</title> 
</head>
<body>



<table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:10px;">

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

<tr><td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">
 </td></tr>

<tr><td colspan="2" style="font:bold 15px arial; text-align:center; padding:0 0 5px 0;">Data Uploading System  </td></tr>

<tr>

<td width="50%" style="font:bold 12px tahoma, arial, sans-serif; text-align:right; border-bottom:1px solid #eee; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Select file</td>

<td width="50%" style="border-bottom:1px solid #eee; padding:5px;"><input type="file" name="file" id="file" /></td>

</tr>





<tr>

<td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Submit</td>

<td width="50%" style=" padding:5px;"><input type="submit" name="submit" /></td>

</tr>

</table>
<body>
</html>