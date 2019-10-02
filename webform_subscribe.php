<?php
session_name("fancyform");
session_start();
error_reporting(E_ALL ^ E_NOTICE);

$_SESSION['n1'] = rand(1,20);
$_SESSION['n2'] = rand(1,20);
$_SESSION['expect'] = $_SESSION['n1']+$_SESSION['n2'];


$str='';
if(isset($_SESSION['errStr']))
{
	$str='<div class="error">'.$_SESSION['errStr'].'</div>';
	unset($_SESSION['errStr']);
}

$success='';
if(isset($_SESSION['sent']))
{
	$success='<h1>Thank you!</h1>';
	
	$css='<style type="text/css">#contact-form{display:none;}</style>';
	
	unset($_SESSION['sent']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>County Email Registration</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>

  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


<?php if(isset($css)) { ?>
<?=$css?>
<?php } ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="https://web.company.com/subbackup/help/jqtransformplugin/jquery.jqtransform.js"></script>
<script type="text/javascript" src="https://web.company.com/help/formValidator/jquery.validationEngine.js"></script>

<script type="text/javascript" src="https://web.company.com/subbackup/help/script.js"></script>

  

<style type="text/css">
      .error, .error1 { background: white; color: #d33; padding: 0.2em;  width:480px; font-family:Arial, Helvetica, sans-serif; font-size:small}

</style>
<script>
  $(function() {
    $( document ).tooltip();
  });
  </script>
  <style>
  label {
    display: inline-block;
    width: 15em;
	font-size:small
  }
  </style>

</head>
<body  style="margin:20px">
<div id="main-container">

	<div id="form-container">
	<!--<img src="logo.png" style="width:370px;"/> -->

 
    
<?php

if ( isset( $_POST["submitButton"] ) ) {

foreach($_POST as $k=>$v)
{ 

	if(ini_get('magic_quotes_gpc'))
	$_POST[$k]=sanitizeString($_POST[$k]);
	
	
}

    processForm();
   } 
else {
  displayForm( array() );
}

function validateField( $fieldName, $missingFields ) {
  if ( in_array( $fieldName, $missingFields ) ) {
    echo ' class="error"';
	}
		  }

function setValue( $fieldName ) {
  if ( isset( $_POST[$fieldName] ) ) {
      echo $_POST[$fieldName];
	
  }
}

function setChecked( $fieldName, $fieldValue ) {
 if ( isset( $_POST[$fieldName] ) and $_POST[$fieldName] == $fieldValue ) {
 echo ' checked="checked"';
  }
  
}
function checkEmail($email) {
  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])
  â&#8224;ª*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",
               $email)){
    list($username,$domain)=split('@',$email);
    if(!checkdnsrr($domain,'MX')) {
      return false;
    }
    return true;
  }
  return false;
}

function setSelected( $fieldName, $fieldValue ) {
  if ( isset( $_POST[$fieldName] ) and $_POST[$fieldName] == $fieldValue ) {
    echo ' selected="selected"';
  }
}
function sanitizeString($var)
{

    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
	   return $var;
}
function processForm() {
  
  $requiredFields = array( "name", "email", "Gender_","list","Street_Address","City_","Zip_");
     $missingFields = array();

  foreach ( $requiredFields as $requiredField ) 
  {
    if ( !isset( $_POST[$requiredField] ) or !$_POST[$requiredField] ) 
	{
      $missingFields[] = $requiredField;
    }
  }

  if ( $missingFields ) {
    displayForm( $missingFields );
	print_r ($missingfields);
  } 
  else
 {
  print_r ($missingfields);
 
 // print_r ($requiredfields);
 emailthis($requiredfields);
 subscribetolyris($requiredFields);
 
  }
}
function displayForm( $missingFields ) {
?>
    
    <?php if ( $missingFields ) { ?>
    <p class="error">Not all the required fields were completed. 
	Please complete the fields highlighted below and then resubmit the form..</p>

    <?php } else { ?>
    
    <?php } ?>
     
<div align="left" style="font-family: Arial; font-size: 13px">
<h2 style="font-family: Arial, Helvetica sans serif;">Join the County Parks E-Club</h2>

    		
	 
    <table border="0" cellpadding="4px" width="490" cellspacing="4px" style="font-family: Arial; font-size: 13px">
	 <form action="parkssubscribeM.php" method="post" target="_top" onsubmit="return processform()">
        <tr>
            <td align="left" width="490" height="30"><label for="email"<?php validateField( "email", $missingFields ) ?>><br /><b>
			E-mail address:</b> <font color="#FF0000">*</font></label>
        <input type="text" name="email" title="Your complete email address" id="email" value="<?php if ( isset( $_POST['email'] ) )  echo sanitizeString($_POST['email']) ?>" SIZE="50" maxlength="100"  /></td>
        </tr>
    <tr>
	<td align="left" width="490" height="30"><label for="firstName"<?php validateField( "name", $missingFields ) ?>><b>
	Your full name: <font color="#FF0000">*</font></b></label>
        <input type="text" name="name" id="name" value="<?php if ( isset( $_POST['name'] ) )  echo sanitizeString($_POST['name']) ?>" SIZE="50" maxlength="100" /></td>
    </tr>
	
	 <tr>
	<td align="left" width="490" height="30">
	
	
		
    <label for="Zip_"<?php validateField( "Zip_", $missingFields ) ?>><b>
	ZIP Code: <font color="#FF0000">*</font></b></label>
        <input type="text" name="Zip_" id="Zip_" value="<?php if ( isset( $_POST['Zip_'] ) )  echo sanitizeString($_POST['Zip_']) ?>" SIZE="10" maxlength="10" /></td>
    </tr>
	
	<tr>
<td align="left" width="490" height="30">
<label for="Party_Affiliation_"<?php validateField( "Party_Affiliation_", $missingFields ) ?>><b>
	Date of birth:</b> </label>
        <input type="text" name="Party_Affiliation_" id="Party_Affiliation_" value="<?php if ( isset( $_POST['Party_Affiliation_'] ) )  echo sanitizeString($_POST['Party_Affiliation_']) ?>" SIZE="20" maxlength="20" />
		
	
</td>
</tr>
    <tr>
	 <td align="left" width="490" height="30"><label for="Gender_"<?php validateField( "Gender_", $missingFields ) ?>><b>
		Gender: <font color="#FF0000">*</font></b></label>
         <select name="Gender_" id="Gender_" size="1" style="width:115px">
        <option value="">Choose below</option>
          <option value="M" <?php if ((isset($_POST['Gender_']))&&(sanitizeString($_POST['Gender_'] == "M"))) { echo "selected=\"selected\""; } ?>>Male</option>
            <option value="F" <?php if ((isset($_POST['Gender_']))&&(sanitizeString($_POST['Gender_'] == "F"))) { echo "selected=\"selected\""; } ?>>Female</option>
         <option value="O" <?php if ((isset($_POST['Gender_']))&&(sanitizeString($_POST['Gender_'] == "O"))) { echo "selected=\"selected\""; } ?>>Other</option>
                
	</select>
       </td>
      </tr>
	  
	  <tr>
	<td align="left" width="490" height="30"><label for="Street_Address"<?php validateField( "Street_Address", $missingFields ) ?>><b>
	Number of people living in your household: <font color="#FF0000">*</font></b></label>
        <input type="text" name="Street_Address" id="Street_Address" value="<?php if ( isset( $_POST['Street_Address'] ) )  echo sanitizeString($_POST['Street_Address']) ?>" SIZE="15" maxlength="20" /></td>
    </tr>
	
<tr>
	 <td align="left" width="490" height="30"><label for="City_"<?php validateField( "City_", $missingFields ) ?>><b>
		Are you interested in volunteering at the parks?: <font color="#FF0000">*</font></b></label>
         <select name="City_" size="1" style="width:115px">
        <option value="">Choose below</option>
         <option value="Yes to Volunteer" <?php if ((isset($_POST['City_']))&&(sanitizeString($_POST['City_'] == "Yes to Volunteer"))) { echo "selected=\"selected\""; } ?>>Yes</option>
            <option value="Not interested in Volunteer" <?php if ((isset($_POST['City_']))&&(sanitizeString($_POST['City_'] == "Not interested in Volunteer"))) { echo "selected=\"selected\""; } ?>>No</option>
            </select>
       </td>
      </tr>	
		
	
	<tr><td><input type="hidden" name="input_string" id="" value="" /> </td></tr>
        <tr>
            <td><label for="list"<?php validateField( "list", $missingFields ) ?>>
             If interested, select a newsletter:</label></td>

   <tr>
          <td style="font-weight:bold;">(Hold down the CTRL key to select more than one topic.)<br/>
        <label for="list"<?php validateField( "list", $missingFields ) ?>> </label> <br/>
          &nbsp; &nbsp; &nbsp; &nbsp;
          <select name="list[]"  multiple="multiple" size="10" style="width: 300px">
            <option value="parks_nature"  <?php sanitizeString( "list[]", "parks_nature" )?> <?php setChecked( "list[]", "parks_nature" )?>>Conservation/Nature Study</option>
			<option value="parks_county_center"  <?php sanitizeString( "list[]", "parks_county_center" )?> <?php setChecked( "list[]", "parks_county_center" )?>>
			County Center Events</option>
            <option value="parks_childrenscamp" <?php sanitizeString( "list[]", "parks_county_center" )?> <?php setChecked( "list[]", "parks_childrenscamp" )?>>
			Children's Camp</option>
            <option value="parks_entertainment" <?php sanitizeString( "list[]", "parks_entertainment" )?> <?php setChecked( "list[]", "parks_entertainment" )?>>
			Entertainment</option>
            <option value="parks_golf" <?php sanitizeString( "list[]", "parks_golf" )?> <?php setChecked( "list[]", "parks_golf" )?>>
			Golf</option>
            <option value="parks_horticulture" <?php sanitizeString( "list[]", "parks_horticulture" )?> <?php setChecked( "list[]", "parks_horticulture" )?>>
			Horticultural Programs</option>
            <option value="parks_playland" <?php sanitizeString( "list[]", "parks_playland" )?> <?php setChecked( "list[]", "parks_playland" )?>>
			Playland</option>
            <option value="parks_rec_sports" <?php sanitizeString( "list[]", "parks_rec_sports" )?> <?php setChecked( "list[]", "parks_rec_sports" )?>>
			Recreational Programs/Sports</option>
            <option value="parks_seniors" <?php sanitizeString( "list[]", "parks_seniors" )?> <?php setChecked( "list[]", "parks_seniors" )?>>
			Senior Citizen Programs</option>
            <option value="parks_trails" <?php sanitizeString( "list[]", "parks_trails" )?> <?php setChecked( "list[]", "parks_trails" )?>>
			Trailways/Hiking/Bicycling</option>
             </select>
        </td>
      </tr>				  
           
        <tr>
            <td>
        <p align="left">
        <font face="Verdana"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="hidden" name="demographics" value="City_ Gender_ Street_Address Zip_  Party_Affiliation_"/>  

	<tr>
<td colspan="2">	
<br/>
<br/>
    <input type="hidden" name="name_required" value="T"/>
   <!-- <input type="hidden" name="confirm" value="many_hello"/> -->
    <input type="hidden" name="showconfirm" value="T"/> 
 <input type="submit" name="submitButton" id="submitButton" value="Submit Form"  />
 <input type="reset" name="resetButton" id="resetButton" value="Reset Form" style="margin-right: 20px;" /></font>
         </td>
        </tr>
      </table>
   

</form></p></tr></div>
<?php
}

function subscribetolyris() {
$post_data= array(); //initialize the arrays
  $post_items= array();
  
  // foreach ($_POST as $key => $value){
 // $_POST[$KEY]=htmlentities(mysql_real_escape_string($value));
 // }

   $name = htmlentities($_POST['name']);
  $email = htmlentities($_POST['email']);
   $City_ = htmlentities($_POST['City_']);
    $Gender_ = htmlentities($_POST['Gender_']);
   $Party_Affiliation_ = htmlentities($_POST['Party_Affiliation_']);
   $Street_Address = htmlentities($_POST['Street_Address']);
      $Zip_ = htmlentities($_POST['Zip_']);
	//  echo $Gender_;
  //if more than one list to subscribe then add another entry to the array with &list= at the end
   if ( isset( $_POST['list'] ) ) 
   {
   foreach ( $_POST['list'] as $list1 ) 
   {
    $list .= $list1 . "&list=";
     }
	   }
	   
  //create an associative array of input data to pass onto CURL
  
  $post_data['name'] = "$name";
  $post_data['email'] = "$email";
  $post_data['City_'] = "$City_";
   $post_data['Gender_'] = "$Gender_";
   $post_data['Party_Affiliation_'] = "$Party_Affiliation_";
  $post_data['Street_Address'] = "$Street_Address";
   $post_data['Zip_'] = "$Zip_";
  // $post_data['$Gender_'] = "$Gender_";
 //remove the trailing &list= once done with appending all the list names to subscribe
  $post_data['list'] = substr($list, 0, strlen($list) - 6);
 
  $CURLOPT_SSL_VERIFYPEER= false;
  $CURLOPT_SSL_VERIFYHOST = false;

foreach ( $post_data as $key => $value) 
{   
  $post_items[] = $key . '=' . $value; }  
 
//create the final string to be posted using implode()
$post_string = implode ('&', $post_items);
$post_string1 .= $post_string . "&confirm=none&showconfirm=F&demographics=City_ Gender_ Party_Affiliation_ Street_Address Zip_";
//  print_r($post_string);
// print_r($post_string1);
//create cURL connection
$curl_connection =  curl_init('https://web.company.com/subscribe/subscribe.tml');
 
//set options
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl_connection, CURLOPT_USERAGENT,
  "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
 
//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string1);
 
//perform our request
$result = curl_exec($curl_connection);
 //print_r($result);
//show information regarding the request
//print_r(curl_getinfo($curl_connection));
print_r("Thank you. We have received your information.");
//echo curl_errno($curl_connection) . '-' .  curl_error($curl_connection);
 
//close the connection
curl_close($curl_connection);
exit();

}

function emailthis(){
if (!$_POST) exit();
// now let's send and email
// we need the to from and body from the config file
	
// we need the to from and body from the config file
//$row=getEmail($conn,'RFP');




$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$Zip_ = filter_var($_POST['Zip_'], FILTER_SANITIZE_NUMBER_INT);
$Party_Affiliation_= filter_var($_POST['Party_Affiliation_'], FILTER_SANITIZE_STRING);
$Gender_= filter_var($_POST['Gender_'], FILTER_SANITIZE_STRING);
$Street_Address= filter_var($_POST['Street_Address'], FILTER_SANITIZE_STRING);
$City_ = filter_var($_POST['City_'], FILTER_SANITIZE_STRING);
if ( isset( $_POST['list'] ) ) 
   {
   foreach ( $_POST['list'] as $list1 ) 
   {
    $list .= $list1 . ",";
     }
	   }






$REPLYTO="webmaster@company.com";
$TITLE="New Parks List Subscriber";
$NOTIFY="webmaster@company.com";
$BODY=$body;
$TO="pqp4@company.com";
$subject="New Parks List Subscriber";
$body="New user has subscribed to the Parks List.<br/>\r\n".

"<b>Submitted From: </b>".$name."<br>".
"<b>Email Address: </b>".$email . "<br>" . 
"<b>Zip Code: </b>".$Zip_. "<br>" .
"<b>Address: </b>".$Street_Address. "<br>" .
"<b>Gender: </b>".$Gender_. "<br>" .  
"<b>list Subscribed: </b>".$list. "<br>" . 
"<b>Date of Birth: </b>".$Party_Affiliation_. "<br>" . 
"<b>Interested in Volunteering?: </b>".$City_. "<br>" ;



/*foreach ($_POST as $key=>$value) {
	$key=strtoupper($key);
	$body.="$key: $value<br/>\r\n";
} */


send_WCemail($NOTIFY,$REPLYTO,$subject,$body,$uploadfile) ;

// send the thank you to the person who submitted the request
send_WCemail($TO,$REPLYTO,$TITLE,$BODY) ;
}

// see if it works.





//to send email:

function send_WCemail($to,$from,$subject,$body) {
	require_once('class.phpmailer.php');
	$mail = new PHPMailer(); // defaults to using php "mail()"
	$mail->IsSMTP(); // telling the class to use SMTP transport
	$mail->IsHTML(true);
	$mail->AddReplyTo($from);
	$mail->SetFrom($from);
	$mail->AddAddress($to);
	//$mail->AddBCC($bcc);
	

	$mail->Subject= $subject;

	$mail->AltBody=$body;

	$mail->Body=$body;

	$sendmail = '/usr/sbin/sendmail';
	$smtpauth = '0';
	$smtpsecure = 'none';
	$smtpport = '25';
	$smtpuser = '';
	$smtppass = '';
	$smtphost = 'smtp2.company.com';

	$mail->SMTPAuth = $smtpauth;
	$mail->Host 	= $smtphost;
	$mail->Username = $smtpuser;
	$mail->Password = $smtppass;
	$mail->Port     = $smtpport;
	return $mail->send();

}
?>
</body>
</html>
