<?php

include("Templates/Plus/pmenu.tpl");$extragoud="0";

$Id = 0;

?>

<script type="text/javascript">

		<!--

		function loadProductGroup(group_id) {

		    if (group_id.length == 0){

		        path='';

		    } else {

		        path='?group='+group_id;

		    }



		    location.href=path;

		}

		//-->

		</script>





<div class="whatToDo lang_rtl">بسته ای انتخاب کنید:</div>

<div class="clear"></div>

<div id="products">



        <?php foreach($Prices as $x) { ?>





            <div class="productBackground lang_rtl lang_fa">

			    <table class="transparent product lang_rtl lang_fa " cellpadding="1" cellspacing="1">

					<thead>

						<tr>

							<th><div class="boxes boxesColor orange">

                            <div class="boxes-tl"></div><div class="boxes-tr"></div>

                            <div class="boxes-tc"></div><div class="boxes-ml"></div><div class="boxes-mr"></div>

                            <div class="boxes-mc"></div><div class="boxes-bl"></div><div class="boxes-br"></div>

                            <div class="boxes-bc"></div><div class="boxes-contents"><?php echo $x[0] ?></div>

				</div></th>

						</tr>

					</thead>

					<tbody>



						<tr>

							<td class="pic">

								<img src="img/products/A.jpg" style="width:100px; height:100px;" alt="<?php echo $x[0] ?>">

							</td>

						</tr>

						<tr>

							<td class="units" style="font-family:tahoma"><?php echo $x[1] ?>&nbsp;سکۀ طلا</td>

						</tr>

						<tr>

							<td class="price" style="font-family:tahoma"><?php echo $x[2] ?>&nbsp;تومان</td>



						</tr>

					</tbody>

				</table>

				<a class="bookProduct" href="?buy=<?php echo $Id++ ?>"><img src="img/x.gif" alt=""></a>

			</div>





        <?php } ?>







						<div class="productBackground lang_rtl lang_fa">

			    <table class="transparent product lang_rtl lang_fa " cellpadding="1" cellspacing="1">

						<tr>

							<th><div class="boxes boxesColor orange"><div class="boxes-tl"></div><div class="boxes-tr"></div><div class="boxes-tc"></div><div class="boxes-ml"></div><div class="boxes-mr"></div><div class="boxes-mc"></div><div class="boxes-bl"></div><div class="boxes-br"></div><div class="boxes-bc"></div><div class="boxes-contents">سفارشی	</div>

				</div></th>

						</tr>

					</thead>

					<tbody>

						<tr>

							<td class="pic">

								<img src="img/products/Travian_voucher_a.jpg" style="width:100px; height:100px;" alt="Voucher">

							</td>

						</tr>

						<tr>

							<td class="voucher">انتقال سکه</td>

						</tr>

						<tr>

							<td class="voucher">به ادمین پیام بدین</td>

						</tr>

					</tbody>

				</table>

				<a class="voucher" href="ymsgr:sendim?mostafavi_esi"<?php echo SALES_ID ?>"><img src="img/x.gif" alt=""></a>

			</div>

					<div class="clear"></div>

	</div>

    <span class="final_sales_amounts_text">در صورتی که امکان پرداخت آنلاین ندارید, مبلغ مورد نظر را به حساب 5022,2910,2843,6994 بانک پاسارگاد به نام علیرضا احمدی واریز کرده و تراکنش آن را به مولتی هانتر ارسال کنید.</span>

    <div class="clear">&nbsp;</div>