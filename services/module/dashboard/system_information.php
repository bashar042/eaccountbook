<?php
$userId   = $_SESSION['user_srl_id'];
function getCrAmount($userId,$fromDt,$toDt)
{	
	
	$sql_cr    = "SELECT sum(amount) as amount FROM `tbl_voucher_details` 
	WHERE user_id='$userId' AND item_dt BETWEEN '$fromDt' AND '$toDt' AND head_type='Cr'";
	$arrCr = selectAllRows($sql_cr);
	foreach($arrCr as $cr)
	{
	 $crAmount = $cr['amount'];
	}
	$crAmount=sprintf("%.2f",$crAmount);
	
	return $crAmount;
}
function getDrAmount($userId,$fromDt,$toDt)
{
	$sql_dr    = "SELECT sum(amount) as amount FROM `tbl_voucher_details` 
	WHERE user_id='$userId' AND item_dt BETWEEN '$fromDt' AND '$toDt' AND head_type='Dr'";
	$arrDr = selectAllRows($sql_dr);
	foreach($arrDr as $dr)
	{
	 $drAmount = $dr['amount'];
	}
	$drAmount=sprintf("%.2f",$drAmount);
	
	return $drAmount;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Dashboard</title>
    </head>
    <body>        
		<div class="panel panel-default input_form_inner_content">
			<div class="panel-heading">
				<h3 class="panel-title page_title"><?=$reqPage['page_title']?></h3>
			</div>
			<div class="panel-body">			 
				<div class="row less_rgt_mar_dash">
					<div class="col-lg-5 less_rgt_pad">
						<div class="row table-responsive dashboard_content">
						   <div class="col-lg-12 dashboard_tbl">
								<div class="title_div">Income Vs Cost</div>
								<table class="table table-bordered">
									<thead class="rpt_thead">
										<tr>
											<th style="text-align:center;width:40%">Period</th>
											<th style="text-align:center;width:20%">Income</th>
											<th style="text-align:center;width:20%">Cost</th>
											<th style="text-align:center;width:20%">Balance</th>
										</tr>
									</thead>
									<?php
									$ym = $currentYearMonth = date('Y-m');
									$fromDt1 = date('Y-m-d')." 00:00";
									$toDt1   = date('Y-m-d')." 23:59";
									$fromDt2 = Date('Y-m-d', strtotime("-7 days"))." 00:00"; 
									$fromDt3 = Date('Y-m-d', strtotime("-30 days"))." 00:00"; 
									$fromDt4 = Date('Y-m-d', strtotime("-3 Months"))." 00:00"; 
									$fromDt5 = Date('Y-m-d', strtotime("-6 Months"))." 00:00"; 
									$fromDt6 = Date('Y-m-d', strtotime("-12 Months"))." 00:00";
									
                                    $run22   = mysql_query("SELECT min(item_dt) as item_dt FROM `tbl_voucher_details` where user_id='$userId'");
                                    $row22   = mysql_fetch_array($run22);
									$fromDt7 = $row22['item_dt'];								
									?>
									<tbody>										
										<tr>
											<td>Today</td>
											<td style="text-align:right">
												<?php
													echo $crAmount1 = getCrAmount($userId,$fromDt1,$toDt1);
												?>
											</td>
											<td style="text-align:right">
												<?php
													echo $drAmount1 = getDrAmount($userId,$fromDt1,$toDt1);
												?>
											</td>
											<td style="text-align:right">
											<?php
												$cash_in_hand1 = $crAmount1-$drAmount1;
												$cash_in_hand1 = sprintf("%.2f",$cash_in_hand1);
												echo $cash_in_hand1;
											?>
											</td>
										</tr>
										<tr style='background-color:#F3F4F5'>
											<td>Last 7 Days</td>
											<td style="text-align:right">
												<?php
													echo $crAmount2 = getCrAmount($userId,$fromDt2,$toDt1);
												?>
											</td>
											<td style="text-align:right">
												<?php
													echo $drAmount2 = getDrAmount($userId,$fromDt2,$toDt1);
												?>
											</td>
											<td style="text-align:right">
											<?php
												$cash_in_hand2 = $crAmount2-$drAmount2;
												$cash_in_hand2 = sprintf("%.2f",$cash_in_hand2);
												echo $cash_in_hand2;
											?>
											</td>
										</tr>
										<tr>
											<td>Last 30 Days</td>
											<td style="text-align:right">
												<?php
													echo $crAmount3 = getCrAmount($userId,$fromDt3,$toDt1);
												?>
											</td>
											<td style="text-align:right">
												<?php
													echo $drAmount3 = getDrAmount($userId,$fromDt3,$toDt1);
												?>
											</td>
											<td style="text-align:right">
											<?php
												$cash_in_hand3 = $crAmount3-$drAmount3;
												$cash_in_hand3 = sprintf("%.2f",$cash_in_hand3);
												echo $cash_in_hand3;
											?>
											</td>
										</tr>
										<tr style='background-color:#F3F4F5'>
											<td>Last 3 Months</td>
											<td style="text-align:right">
												<?php
													echo $crAmount4 = getCrAmount($userId,$fromDt4,$toDt1);
												?>
											</td>
											<td style="text-align:right">
												<?php
													echo $drAmount4 = getDrAmount($userId,$fromDt4,$toDt1);
												?>
											</td>
											<td style="text-align:right">
											<?php
												$cash_in_hand4 = $crAmount4-$drAmount4;
												$cash_in_hand4 = sprintf("%.2f",$cash_in_hand4);
												echo $cash_in_hand4;
											?>
											</td>
										</tr>
										<tr>
											<td>Last 6 Months</td>
											<td style="text-align:right">
												<?php
													echo $crAmount5 = getCrAmount($userId,$fromDt5,$toDt1);
												?>
											</td>
											<td style="text-align:right">
												<?php
													echo $drAmount5 = getDrAmount($userId,$fromDt5,$toDt1);
												?>
											</td>
											<td style="text-align:right">
											<?php
												$cash_in_hand5 = $crAmount5-$drAmount5;
												$cash_in_hand5 = sprintf("%.2f",$cash_in_hand5);
												echo $cash_in_hand5;
											?>
											</td>
										</tr>
										<tr style='background-color:#F3F4F5'>
											<td>Last 1 Year</td>
											<td style="text-align:right">
												<?php
													echo $crAmount6 = getCrAmount($userId,$fromDt6,$toDt1);
												?>
											</td>
											<td style="text-align:right">
												<?php
													echo $drAmount6 = getDrAmount($userId,$fromDt6,$toDt1);
												?>
											</td>
											<td style="text-align:right">
											<?php
												$cash_in_hand6 = $crAmount6-$drAmount6;
												$cash_in_hand6 = sprintf("%.2f",$cash_in_hand6);
												echo $cash_in_hand6;
											?>
											</td>
										</tr>
										<tr>
											<td>First to Last</td>
											<td style="text-align:right">
												<?php
													echo $crAmount7 = getCrAmount($userId,$fromDt7,$toDt1);
												?>
											</td>
											<td style="text-align:right">
												<?php
													echo $drAmount7 = getDrAmount($userId,$fromDt7,$toDt1);
												?>
											</td>
											<td style="text-align:right">
											<?php
												$cash_in_hand7 = $crAmount7-$drAmount7;
												$cash_in_hand7 = sprintf("%.2f",$cash_in_hand7);
												echo $cash_in_hand7;
											?>
											</td>
										</tr>
									</tbody>
								</table>								
							</div>
						</div>						
					</div>
					<div class="col-lg-7 less_rgt_pad">
						<div class="row table-responsive dashboard_content">
							<div class="col-lg-12 dashboard_tbl">
							<div class="title_div">Recent Transactions</div>
								<table class="table table-bordered">
									<thead class="rpt_thead">
										<tr>
											<th style="text-align:center;width:5%">#</th>
											<th style="text-align:center;width:35%">Date</th>
											<th style="text-align:center;width:40%">Head Name</th>
											<th style="text-align:center;width:8%">Type</th>
											<th style="text-align:center;width:12%">Amount</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$sl=1;
									$run33 = mysql_query("SELECT * FROM `tbl_voucher_details` where user_id='$userId' order by id desc limit 7");
									while($row5 = mysql_fetch_array($run33))
									{
										if($sl%2==0){
											$bg = "style='background-color:#F3F4F5'";
										}
										else{
											$bg = "style='background-color:#FFFFF'";
										}
									?>
										<tr <?=$bg?>>
											<td><?=$sl++?></td>
											<td><?=getFormatedDt("Y-m-d H:i",$row5['item_dt'])?></td>
											<td><?=get_row("name","tbl_account_heads","id=".$row5['head_name_id'])?></td>
											<td>
                                                                                            <?php
                                                                                                if($row5['head_type']=='Cr') { echo 'Income'; }
                                                                                                if($row5['head_type']=='Dr') { echo 'Cost'; }
                                                                                            ?>
                                                                                        </td>
											<td><?=$row5['amount']?></td>
										</tr>
                                    <?php 									
									}
									?>
									</tbody>
								</table>	
							</div>
						</div>					
					</div>
				</div>	
			</div>
		</div>
    </body>
</html>
