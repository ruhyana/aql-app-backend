<?	session_start();
require_once('database.php');
if($_POST['Submit']=="Sign In")
{	
	$Prosesnext = 0;
	$ArryCek = array("USERNAME|".$_POST['txtuse'],"PASSWORD|".$_POST['txtpwd']);	
	
	$badChar="~`!@#$%^&*()-_+={[}]|\:;\"'<,>.?/";
	
	$jumArryCek = count($ArryCek);
	for($qa=0;$qa<$jumArryCek;$qa++)
	{
		$exploArrCek = explode("|",$ArryCek[$qa]);
		$nn = $exploArrCek[1];
		for($j=0;$j<strlen($nn);$j++)
		{
			for($k=0;$k<strlen($badChar);$k++)
			{
				if($nn[$j] == $badChar[$k])
				{
					$Prosesnext = 1;
					$_SESSION['msg'] = $exploArrCek[0]." tidak boleh ada karakter aneh ".$badChar[$k];					
				}
			}
		}
	}
	
	if($Prosesnext==0) {

		//if ((isset($_POST['Username']==$Username) && ($_POST['password']==$password)){
		//	$_SESSION['Username']=$_POST['USERNAME'];
		//	$_SESSION['password']=$_POST['Password'];
		//}

	//$Query = "SELECT *FROM GROUP_SALES.M_USER WHERE M_USER_USERNAME='".$_POST['txtuse']."' AND M_USER_PASSWORD='".md5($_POST['txtpwd'])."'";
	//	$runUser = mysql_query($Query, $slscon) or die(mysql_error());
	//	$rowUser = mysql_fetch_assoc($runUser);

		//$Query = "SELECT A.*, B.M_AIRPORTS_CITY FROM GROUP_SALES.M_USER A, GROUP_SALES.M_AIRPORTS B WHERE A.M_USER_USERNAME='".$_POST['txtuse']."' AND A.M_USER_PASSWORD='".md5($_POST['txtpwd'])."'";
	//	$runUser = mysql_query($Query, $slscon) or die(mysql_error());
		//$rowUser = mysql_fetch_assoc($runUser);
	//	if($rowUser['M_USER_ID']=="")
	//	{
	//		$_SESSION['msg'] = "WRONG USERNAME OR PASSWORD";
	//	}
	//	else
	//	{		
			//declare two session variables and assign them
	// 		$GLOBALS['MM_Id'] = $rowUser['M_USER_ID'];
			//$GLOBALS['MM_ApoId'] = $rowUser['M_AIRPORTS_ID'];
			//$GLOBALS['MM_ApoCity'] = $rowUser['M_AIRPORTS_CITY'];
	//		$GLOBALS['MM_Username'] = $rowUser['M_USER_USERNAME'];
	//		$GLOBALS['MM_Name'] = $rowUser['M_USER_NAME'];
	//		$GLOBALS['MM_NRP'] = $rowUser['M_USER_NRP'];
	//		$GLOBALS['MM_Jabatan'] = $rowUser['M_USER_JABATAN'];
	//		$GLOBALS['MM_Akses'] = $rowUser['M_USER_AKSES'];
	//		$GLOBALS['MM_Divisi'] = $rowUser['M_USER_DIVISI'];
			  
			//register the session variables
	//		session_register("MM_Id");
			//session_register("MM_ApoId");
			//session_register("MM_ApoCity");
	//		session_register("MM_Username");
	//		session_register("MM_Name");
	//		session_register("MM_Nrp");
	//		session_register("MM_Jabatan");
	//		session_register("MM_Akses");
	//		session_register("MM_Divisi");
			
			header("location:kirim.php");
			exit;
		}
	}
//}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WELCOME TO SITE BACKEND ANDROID AQL</title>
<link rel="shortcut icon" href="images/indonesia.ico" />
<link rel="stylesheet" href="css/cssku.css" type="text/css" media="screen" />
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  	<td colspan="2" height="30px">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="2" align="center"> <img src="images/logo aql.png" width="120" height="124" /></td>
  </tr>
  <tr>
  	<td colspan="2" height="27" align="center"><font color="#FF0000"><?=$_SESSION['msg']?></font></td>
  </tr>
  <tr>
    <td width="124" align="center"><img src="images/kunci.jpg" width="104" height="117" /></td>
<td width="368">
        <fieldset class="tabelLengkung">
        <legend>&nbsp;<b><font color="#000099">ANDROID BACKEND SYSTEM SITE </font></b>&nbsp;</legend>	
        <form name="formlogin" method="post" action="" onsubmit="return login();">
        <table border="0" align="center" cellpadding="2" cellspacing="2">
            <tr>
                <td>Username</td>
                <td> : </td>
                <td align="left"><input name="txtuse" type="text" size="30" maxlength="50"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td> : </td>
                <td align="left"><input name="txtpwd" type="password" size="30"></td>
            </tr>				
            <tr align="center">
                <td colspan="3"><input class="tombolOK" type="submit" name="Submit" value="Sign In"></td>
            </tr>
        </table>
        </form>				
        </fieldset>    </td>
  </tr>
  <tr>
  	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="2" height="30px" bgcolor="#CCCCCC" align="center"><a onclick="window.open('profile.php', 'windowname1', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800px, height=800px')" style="cursor:pointer;"><font size="-1"><strong>IT TEAM DEVELOPMENT AQL</strong> &copy; 2014</font></a><a onclick="window.open('profile.php', 'windowname1', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800px, height=600px')" style="cursor:pointer;"></a></td>
  </tr>
</table>
<? unset($_SESSION['msg']);?>
</body>
</html>