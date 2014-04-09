<?php
ob_start();
include("GameEngine/Village.php");
$start = $generator->pageLoadTimeStart();
if(isset($_GET['ok'])){
	$database->updateUserField($session->username,'ok','0','0'); $_SESSION['ok'] = '0'; }
if(isset($_GET['newdid'])) {
	$_SESSION['wid'] = $_GET['newdid'];
	header("Location: ".$_SERVER['PHP_SELF']);
}
else {
	$building->procBuild($_GET);
}
include "Templates/html.tpl";
// Set Your Setting This Part
$MerchantID = 'xxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxx';


$Prices=array(

    array("بسته A","100","1000"),
    array("بسته B","250","2000"),
    array("بسته C","1000","6000"),
    array("بسته D","2000","10000"),
    array("بسته E","3000","13000"),
    array("بسته F","10000","35000"),


    );

// Develop By www.parspal.com

?>

<body class="v35 webkit chrome plus">
	<div id="wrapper"> 
		<img id="staticElements" src="img/x.gif" alt="" /> 
		<div id="logoutContainer"> 
			<a id="logout" href="logout.php" title="<?php echo LOGOUT; ?>">&nbsp;</a> 
		</div> 
		<div class="bodyWrapper"> 
			<img style="filter:chroma();" src="img/x.gif" id="msfilter" alt="" /> 
			<div id="header"> 
				<div id="mtop">
					<a id="logo" href="<?php echo HOMEPAGE; ?>" target="_blank" title="<?php echo SERVER_NAME ?>"></a>
					<ul id="navigation">
						<li id="n1" class="resources">
							<a class="" href="dorf1.php" accesskey="1" title="<?php echo HEADER_DORF1; ?>"></a>
						</li>
						<li id="n2" class="village">
							<a class="" href="dorf2.php" accesskey="2" title="<?php echo HEADER_DORF2; ?>"></a>
						</li>
						<li id="n3" class="map">
							<a class="" href="karte.php" accesskey="3" title="<?php echo HEADER_MAP; ?>"></a>
						</li>
						<li id="n4" class="stats">
							<a class="" href="statistiken.php" accesskey="4" title="<?php echo HEADER_STATS; ?>"></a>
						</li>

<?php
    	if(count($database->getMessage($session->uid,7)) >= 1000) {
			$unmsg = "+1000";
		} else { $unmsg = count($database->getMessage($session->uid,7)); }
		
    	if(count($database->getMessage($session->uid,8)) >= 1000) {
			$unnotice = "+1000";
		} else { $unnotice = count($database->getMessage($session->uid,8)); }
?>
<li id="n5" class="reports"> 
<a href="berichte.php" accesskey="5" title="<?php echo HEADER_NOTICES; ?><?php if($message->nunread){ echo' ('.count($database->getMessage($session->uid,8)).')'; } ?>"></a>
<?php
if($message->nunread){
	echo "<div class=\"ltr bubble\" title=\"".$unnotice." ".HEADER_NOTICES_NEW."\" style=\"display:block\">
			<div class=\"bubble-background-l\"></div>
			<div class=\"bubble-background-r\"></div>
			<div class=\"bubble-content\">".$unnotice."</div></div>";
}
?>
</li>
<li id="n6" class="messages"> 
<a href="nachrichten.php" accesskey="6" title="<?php echo HEADER_MESSAGES; ?><?php if($message->unread){ echo' ('.count($database->getMessage($session->uid,7)).')'; } ?>"></a> 
<?php
if($message->unread) {
	echo "<div class=\"ltr bubble\" title=\"".$unmsg." ".HEADER_MESSAGES_NEW."\" style=\"display:block\">
			<div class=\"bubble-background-l\"></div>
			<div class=\"bubble-background-r\"></div>
			<div class=\"bubble-content\">".$unmsg."</div></div>";
}
?>
</li>

</ul>
<div class="clear"></div> 
</div> 
</div>
					<div id="mid"> 
<?php include("Templates/menu.tpl"); ?>
 
												<div class="clear"></div> 
						<div id="contentOuterContainer"> 
							<div class="contentTitle">&nbsp;</div> 
							<div class="contentContainer"> 
						<div id="content" class="plus">


<?php
if(isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	$id = "";
}

if ($id == "") {

    $id = $session->username;

    $rest=mysql_query("SELECT * FROM ".TB_PREFIX."users where `username`='$id' " );
    $row = mysql_fetch_assoc($rest);
    $Paymenter=$row['username'];
    $Email=$row['email'];

    if(isset($_GET['buy']))
    {

        $package = intval($_GET['buy']);
        if($package < 0 || $package >= count($Prices))
        {
              echo 'پکيج مورد نظر شما يافت نشد !';
        }else{
        $Price = intval($Prices[$package][2]);
        $ReturnPath = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?verify='.$package;
        $Description = 'خريد '.$Prices[$package][0] .' کاربر : ' . $Paymenter ;

       	$client = new SoapClient('https://de.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8')); 

	$result = $client->PaymentRequest(
						array(
								'MerchantID' 	=> $MerchantID,
								'Amount' 	=> $Price,
								'Description' 	=> $Description,
								'Email' 	=> $Email,
								'Mobile' 	=> '',
								'CallbackURL' 	=> $ReturnPath
							)
	);

       	
		
		
        
        $Status = $result->Status ;
		$PayPath = 'https://www.zarinpal.com/pg/StartPay/'.$result->Authority ;
        if ($Status == 100)
        {
            echo '<h1 class="titleInHeader">اتصال به درگاه</h1>
                  <div style="text-align:center; font-family:tahoma" >
                  <img src="/admin/loading.gif" />   <br><br>
                  در حال اتصال به درگاه پرداخت زرین پال ، لطفا منتظر بمانيد ...</div>
                  <script>
                   window.addEvent("load", function()
					{
						window.location = "'.$PayPath.'"
					});
                    </script>

                  ' ;
             
        }else{
            echo 'در اتصال به درگاه خطایی رخ داده است ! '.$Status ;
        }
        }
     
    }
    else if(isset($_GET['verify']))
    {
        $package = intval($_GET['verify']);
        if($package < 0 || $package >= count($Prices))
        {
              echo 'پکيج مورد نظر شما يافت نشد !';
        }else{

        echo '<h1 class="titleInHeader">نتيجه پرداخت</h1>';


        if(isset($_GET['Status']) && $_GET['Status'] == 'OK'){


              $Price = intval($Prices[$package][2]);
              $Authority = $_GET['Authority'];



           //   require_once ('Templates/Plus/nusoapp.php');
		   
		   
		   $client = new SoapClient('https://de.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8')); 

		$result = $client->PaymentVerification(
						  	array(
									'MerchantID'	 => $MerchantID,
									'Authority' 	 => $Authority,
									'Amount'	 => $Price
								)
												);


        			if($result->Status == 100)// Your Peyment Code Only This Event
        			{

                        $gold = $Prices[$package][1];
        			    $query = mysql_query("UPDATE ".TB_PREFIX."users SET gold = gold + '".$gold."' WHERE username = '".$id."'");

        				echo '<div style="color:green; font-family:tahoma; direction:rtl; text-align:right">
                            کاربر گرامی ، پرداخت با موفقیت انجام گردید . جزئیات خرید شما به شرح زیر می باشد : <br><br>
                            بسته خریداری شده :'.$Prices[$package][0].'<br><br>
                            تعداد سکه : '.$gold.'<br><br>
                            مبلغ : '.intval($Price).'تومان<br><br> شماره تارکنش : ' . $result->Status . '
        				<br /></div>';

                        $subject="خريد موفقيت آميز";
                        $sendsms="کاربر گرامی ، خرید  ".$Prices[$package][0]." با موفقیت به شماره رسید ".$Refnumber." انجام و تعداد ".$gold." سکه به حساب کاربری شما افزوده گردید .";
                        $uid = $row['id'];

                        mysql_query("INSERT INTO `".TB_PREFIX."mdata` (`target`, `owner`, `topic`, `message`, `viewed`, `archived`, `send`, `time`  ) VALUES( $uid  , 4       , '$subject', '$sendsms', 0   , 0 , 0,  now())");


        			}else
                	{
        				echo '<div style="color:green; font-family:tahoma; direction:rtl; text-align:center">
	        			خطا در پردازش عملیات پرداخت ، نتیجه پرداخت : ';
                        
                            echo '<br><br><b style="color:red">کد خطا : ' . $result->Status . '</b>';
                        
                        echo ' <br /></div>';
        			}



        }else{
            echo '<div style="color:red; font-family:tahoma; direction:rtl; text-align:center">
		            بازگشت از عمليات پرداخت، خطا در انجام عملیات پرداخت ( پرداخت ناموق ) !
            		<br /></div>';
        }

        }
    }
    else
    {
        ?>

              <script type="text/javascript">
					window.addEvent('domready', function()
					{
						$$('.subNavi').each(function(element)
						{
							new Travian.Game.Menu(element);
						});
					});
				</script>

<?php
        include("Templates/Plus/newplus.tpl");
    }

}else{

            ?>

              <script type="text/javascript">
					window.addEvent('domready', function()
					{
						$$('.subNavi').each(function(element)
						{
							new Travian.Game.Menu(element);
						});
					});
				</script>

<?php

	if($id<=6){
		include("Templates/Plus/".$id.".tpl");
	}else{
		$golds = $database->getUserArray($session->username, 0);
		if($id == 7){
			if($session->gold >= 2) {
				$MyVilId = mysql_query("SELECT * FROM ".TB_PREFIX."bdata WHERE `wid` = '".$village->wid."'");
				$uuVilid = mysql_fetch_array($MyVilId);
				$MyVilId2 = mysql_query("SELECT * FROM ".TB_PREFIX."research WHERE `vref` = '".$village->wid."'");
				$uuVilid2 = mysql_fetch_array($MyVilId2);
				if (mysql_num_rows($MyVilId) || mysql_num_rows($MyVilId2)) {
					mysql_query("UPDATE ".TB_PREFIX."bdata set timestamp = '1' where wid = ".$village->wid." AND type != '25' OR type != '26'");
					mysql_query("UPDATE ".TB_PREFIX."research set timestamp = '1' where vref = '".$village->wid."'");
					mysql_query("UPDATE ".TB_PREFIX."users set gold = gold - 2 where `username` = '".$session->username."'");
					header("Location: plus.php?id=3&g");
				}
			}
		}elseif($id == 8){
			if($session->gold >= 10) {
				if($golds['plus'] == 0) {
					mysql_query("UPDATE ".TB_PREFIX."users set plus = ".time()."+".PLUS_TIME." where `username`='".$session->username."'");
				} else {
					mysql_query("UPDATE ".TB_PREFIX."users set plus = plus + ".PLUS_TIME." where `username`='".$session->username."'");
				}
				mysql_query("UPDATE ".TB_PREFIX."users set gold = gold - 10 where `username` = '".$session->username."'");
			}	
		}elseif($id == 9){
			if($session->gold >= 5) {
				if($golds['b1'] == 0) {
					mysql_query("UPDATE ".TB_PREFIX."users set b1 = ".time()."+".PLUS_PRODUCTION." where `username`='".$session->username."'");
				} else {
					mysql_query("UPDATE ".TB_PREFIX."users set b1 = b1 + ".PLUS_PRODUCTION." where `username`='".$session->username."'");
				}
				mysql_query("UPDATE ".TB_PREFIX."users set gold = gold - 5 where `username` = '".$session->username."'");
			}
		}elseif($id == 10){
			if($session->gold >= 5) {
				if($golds['b2'] == 0) {
					mysql_query("UPDATE ".TB_PREFIX."users set b2 = ".time()."+".PLUS_PRODUCTION." where `username`='".$session->username."'");
				} else {
					mysql_query("UPDATE ".TB_PREFIX."users set b2 = b2 + ".PLUS_PRODUCTION." where `username`='".$session->username."'");
				}
				mysql_query("UPDATE ".TB_PREFIX."users set gold = gold - 5 where `username` = '".$session->username."'");
			}
		}elseif($id == 11){
			if($session->gold >= 5) {
				if($golds['b3'] == 0) {
					mysql_query("UPDATE ".TB_PREFIX."users set b3 = ".time()."+".PLUS_PRODUCTION." where `username`='".$session->username."'");
				} else {
					mysql_query("UPDATE ".TB_PREFIX."users set b3 = b3 + ".PLUS_PRODUCTION." where `username`='".$session->username."'");
				}
				mysql_query("UPDATE ".TB_PREFIX."users set gold = gold - 5 where `username` = '".$session->username."'");
			}
		}elseif($id == 12){
			if($session->gold >= 5) {
				if($golds['b4'] == 0) {
					mysql_query("UPDATE ".TB_PREFIX."users set b4 = ".time()."+".PLUS_PRODUCTION." where `username`='".$session->username."'");
				} else {
					mysql_query("UPDATE ".TB_PREFIX."users set b4 = b4 + ".PLUS_PRODUCTION." where `username`='".$session->username."'");
				}
				mysql_query("UPDATE ".TB_PREFIX."users set gold = gold - 5 where `username` = '".$session->username."'");
			}
		}elseif($id == 13){
			
		}elseif($id == 14){
			
		}elseif($id == 15){
			if($session->gold >= 100) {
				mysql_query("UPDATE ".TB_PREFIX."users set goldclub = 1, gold = gold - 100 where `username`='".$session->username."'");

			}
		}
		header("Location: plus.php?id=3");
	}
}
?>
</div>
<div class="clear"></div>
</div>
<div class="contentFooter">&nbsp;</div>
					</div>
                 
<?php
include("Templates/sideinfo.tpl");
include("Templates/footer.tpl");
include("Templates/header.tpl");
include("Templates/res.tpl");
include("Templates/vname.tpl");

?>
</div>
<div id="ce"></div>
</div>
</body>
</html>
