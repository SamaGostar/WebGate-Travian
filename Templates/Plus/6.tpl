<?php
if($_POST){
	$uid = $session->uid;
	$exgold = intval($_POST['gold']);
	if($exgold<0) $exgold=0;if($exgold>$session->gold) $exgold=$session->gold;
	$exsilver = intval($_POST['silver']);
	if($exsilver<0) $exsilver=0;if($exsilver>$session->silver) $exsilver=$session->silver;
	$golds = '';
	$silvers = '';
	if($exgold==0 && $exsilver>=200){
		$silvers = "- ".(floor($exsilver/200)*200)."";
		$golds = "+ ".(floor($exsilver/200));
	}elseif($exgold>=1 && $exsilver==0){
		$silvers = "+ ".$exgold*100;
		$golds = "- ".$exgold;
	}
	if($golds || $silvers){
		mysql_query("UPDATE ".TB_PREFIX."users SET gold = gold ".$golds." WHERE id = '".$uid."'");
		mysql_query("UPDATE ".TB_PREFIX."users SET silver = silver ".$silvers." WHERE id = '".$uid."'");
	}
	header("Location: plus.php?id=6");
}
?>

<div id="silverExchange">
	
	<h3>صرافی</h3>
	<p>مقدار سکه طلای تراوین و یا سکه نقره تراوین که میخواهید مبادله 
کنید را وارد کنید.</p>

	<h4>نسبت مبادله</h4>
	<p>1 سکه طلای تراوین : 100 سکه نقره تراوین<br>200 سکه نقره تراوین : 1 سکه طلای تراوین	</p>
<?php $id = $_SESSION['id']; ?>
<form action="plus.php?id=6" method="post">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
	<div class="boxes boxesColor gray exchange"><div class="boxes-tl"></div><div class="boxes-tr"></div><div class="boxes-tc"></div><div class="boxes-ml"></div><div class="boxes-mr"></div><div class="boxes-mc"></div><div class="boxes-bl"></div><div class="boxes-br"></div><div class="boxes-bc"></div><div class="boxes-contents">		<table cellpadding="1" cellspacing="1" class="exchangeOffice transparent">
			<tbody>
				<tr>
					<td>
						<img src="img/x.gif" class="gold" alt="سکه طلای تراوین">
						<?php echo $session->gold; ?>
                        </td>
					<td>
						<img src="img/x.gif" class="silver" alt="سکه نقره تراوین">
						<?php echo $session->silver; ?>
                        </td>
				</tr>

				<tr>
					<td>
						<input name="gold" id="goldInput" type="text" class="text" value="">
					</td>
					<td>
						<input name="silver" id="silverInput" type="text" class="text" value="">
					</td>
				</tr>
			</tbody>
		</table>
			</div>
				</div>
		<p>
			<input type="hidden" name="a" value="84">
			<input type="hidden" name="c" value="18a">

			<button type="submit" value="انجام مبادله"><div class="button-container"><div class="button-position"><div class="btl"><div class="btr"><div class="btc"></div></div></div><div class="bml"><div class="bmr"><div class="bmc"></div></div></div><div class="bbl"><div class="bbr"><div class="bbc"></div></div></div></div><div class="button-contents">انجام مبادله</div></div></button>
            
            </p>


		<div class="boxes boxesColor gray exchange"><div class="boxes-tl"></div><div class="boxes-tr"></div><div class="boxes-tc"></div><div class="boxes-ml"></div><div class="boxes-mr"></div><div class="boxes-mc"></div><div class="boxes-bl"></div><div class="boxes-br"></div><div class="boxes-bc"></div><div class="boxes-contents">
        <table cellpadding="1" cellspacing="1" class="exchangeOffice transparent">
			<tbody>
				<tr>
					<td>
						<img src="img/x.gif" class="gold" alt="سکه طلای تراوین">
						<span id="goldResult">0</span>
					</td>
					<td>
						<img src="img/x.gif" class="silver" alt="سکه نقره تراوین">
						<span id="silverResult">0</span>
					</td>
				</tr>
			</tbody>
		</table>
			</div>
				</div>	</form>
                
</div>
<script type="text/javascript">
	window.addEvent('domready', function(){
		new Travian.Game.GoldToSilver({
			elementInputGold: 'goldInput',
			elementInputSilver: 'silverInput',
			elementResultGold: 'goldResult',
			elementResultSilver: 'silverResult',
			gold: <?php echo $session->gold; ?>,
			silver: <?php echo $session->silver; ?>,
			rateGoldToSilver: 100,
			rateSilverToGold: 200
		});
	});
</script>
