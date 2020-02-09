<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Income Vs Cost History | eAccount Book</title>       
    </head>
    <body>
        <div class="panel panel-default input_form_inner_content">
            <div class="panel-heading">
                <h3 class="panel-title page_title"><?=$reqPage['page_title']?>
					<ol class="breadcrumb">
						<li><?=$reqPage['module_title']?></li>
						<li class="active"><a href="?module=<?=$reqPage['module_value']?>&page=<?=$reqPage['page_value']?>"><?=$reqPage['page_title']?></a></li>
					</ol>
				</h3>
            </div>
            <div class="panel-body">							 
                <div class="input_field_content">				    	
                    <div class="row">
						<?php
						    $userId   = $_SESSION['user_srl_id'];
							$headId   = '';
							$dt1      = date('Y-m-d');
							$dt2      = date('Y-m-d');    
							$arr      = array();
							if(isset($_POST['btnShowCrReport']))
							{ 								
								$headId = $_POST['headName'];
								$dt1    = $_POST['from_dt'];
								$dt2    = $_POST['to_dt'];
								$step   = 1;
								header("Location:?module=accounts&page=cr_dr_history&headName=$headId&from_dt=$dt1&to_dt=$dt2&step=$step");
								exit;
							}
							if(isset($_GET['headName']) && isset($_GET['from_dt']) && isset($_GET['to_dt']))
							{
								$headId = $_GET['headName'];
								$dt1    = $_GET['from_dt'];
								$dt2    = $_GET['to_dt'];
								$step   = $_GET['step'];
							}
							
							if($headId=='all'){
								$head = "";
							}
							else{																
								$head = " AND head_name_id='$headId'";
							}
							
							$fromDt = $dt1." 00:00:00";
							$toDt   = $dt2." 23:59:00"; 
							
							if($fromDt == '' || $toDt == '')
							{
								$_SESSION['userMsg'] = "Sorry, you have submitted blank field !";
								$_SESSION['alert']   = "danger";
								header("Location:?module=accounts&page=cr_dr_history&headName=$headId&from_dt=$dt1&to_dt=$dt2&step=$step");
								exit;
							}
							if($fromDt > $toDt)
							{
								$_SESSION['userMsg'] = "Sorry, From-date cann't be greater than To-date !";
								$_SESSION['alert']   = "danger";
								header("Location:?module=accounts&page=cr_dr_history&headName=$headId&from_dt=$dt1&to_dt=$dt2&step=$step");
								exit;
							}						
								
							// start setting for pagination
							$sl=1;
							$step = $_GET['step']; 
							$table = 'tbl_voucher_details';
							$where = "user_id='$userId' $head AND item_dt BETWEEN '$fromDt' AND '$toDt'";
							$dataDisplay = 20;
							$totalRows = 0; // its 0 when table name is pass
							$pagination = getPagination($table,$where,$step,$dataDisplay,$totalRows);                     
							$offset = $pagination['offset'];
							$limit = $pagination['limit'];
							if($step > 1)
							{
								$sl = 0;
								$sl = ($step-1) * $dataDisplay + 1;
							}
							// end setting for pagination									
							
							$totalCr = getTotalSum("SELECT SUM(amount) as totalSum FROM `tbl_voucher_details` WHERE $where AND head_type='Cr'");
							$totalDr = getTotalSum("SELECT SUM(amount) as totalSum FROM `tbl_voucher_details` WHERE $where AND head_type='Dr'");
							$totalCr = get2DegRoundNumber($totalCr);
							$totalDr = get2DegRoundNumber($totalDr);
							$balance = get2DegRoundNumber(($totalCr-$totalDr));
							
							$sql = "SELECT * FROM `tbl_voucher_details` 
							WHERE $where ORDER BY item_dt DESC LIMIT $offset, $limit";
							$arr = selectAllRows($sql);
							
							/////////////////////////////////////////////////
							if($_SESSION['userMsg'] != "" )
							{
							?>
							<div class="row" style="padding:0px 15px">
								<div class="alert alert-<?=$_SESSION['alert']?>">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php
										echo "\t".$_SESSION['userMsg'];
										$_SESSION['userMsg']='';
									?>
								</div>
							</div>
							<?php
							}              
						?>						
						
						 <div class="row" style="padding:15px;">
						    <div class="col-lg-12 rpt_filter">
								<form method="post">
								    <div class="row">
									<div class="col-lg-4">
									    Account Head:<br/>
										<select name="headName" class="tcal form-control">
										    <option value="">-Select-</option>
										    <option value="all" <?=($headId=='all') ? "selected='selected'" : ""?>>All</option>
											<?php
											$headSrl=1;
											$sqlAH = "SELECT id,name FROM `tbl_account_heads` where user_id='$userId' and head_status=1 order by name";
											$arrAH = selectAllRows($sqlAH);
											if(count($arrAH)>0)
											{
												foreach($arrAH as $row3){
													$id = $row3['id'];
													$hName = $row3['name'];
													if($headId==$id){
														echo "<option value='$id' selected='selected'>$headSrl. $hName</option>";
													}
													else{
														echo "<option value='$id'>$headSrl. $hName</option>";
													}
													$headSrl++;
												}
											}
											?>
										</select>
									</div>
									<div class="col-lg-2">From:<br/><input type="text"  name="from_dt" value="<?=($dt1 != '') ? $dt1 : date('Y-m-d')?>" class="tcal form-control"></div>
									<div class="col-lg-2">To:<br/><input type="text"  name="to_dt" value="<?=($dt2 != '') ? $dt2 : date('Y-m-d')?>" class="tcal form-control"></div>
									<div class="col-lg-2"><br/><input type="submit" name="btnShowCrReport" class="btn btn-primary" value="Show Report"></div>
									<?php 
										if(count($arr) > 0){
										?>
										<div class="col-lg-2" style='text-align:right;color:#038CC6;margin-left:-10px;margin-bottom:-10px;'><br/>
											<img src="<?=$base_url?>images/print_32.png" alt="Print" title="Print the Report" style="cursor: pointer" onclick="printDiv('printDivId')">
										</div>
										<?php										
										}
									?>
									</div>
								</form>							
							</div>
						 </div>
						 <div class="row">
							<div class="col-lg-12">								
								<div class="table-responsive" id="printDivId">
								    <div class="rpt_header" style="border-bottom:2px solid #EDEDED">
								    	<span class="rpt_name">Income Vs Cost History Report</span><br/>
								    	<?php
									    	if($fromDt != '' && $toDt != '')
									    	{
									    		echo "<span class='rpt_date'>From ".date("Y-m-d", strtotime($fromDt))." to ".date("Y-m-d", strtotime($toDt))."</span>";
									    	}
								    	?>
								    </div>
									<div class="row">
										<div class="col-lg-6" style="text-align:left;vertical-align:bottom;font-size:13px">
											<br/>Report Gen. Date:<br/> <?=date('Y-m-d H:i:s');?>
										</div>
										<div class="col-lg-6" style="text-align:right;margin-left:-5px">
										    <table style="float:right">
												<tr style="color:#0091EA">
													<td style="text-align:left">Total Income:</td>
													<td style="text-align:right"><?=$totalCr;?></td>
												</tr>
												<tr style="color:#FFA500">
													<td style="text-align:left">Total Cost:</td>
													<td style="text-align:right"><?=$totalDr;?></td>
												</tr>
												<tr style="color:#22B24C">
													<td style="text-align:left">Balance:</td>
													<td style="text-align:right"><?=$balance;?></td>
												</tr>											   
										    </table>										
										</div>
									</div>
									<table class="table table-bordered">
										<thead class="rpt_thead">
											<tr>
											    
												<td style="text-align:center;width:6%">#</td> 
												<td style="text-align:center;width:15%">Date</td> 
												<td style="text-align:center;width:22%">Head Name</td> 
												<td style="text-align:center;width:27%">Particulars Desc.</td> 												
												<td style="text-align:center;width:15%"> Income Amount</td> 												
												<td style="text-align:center;width:15%"> Cost Amount</td> 												
											</tr>
										</thead>	
											<?php
											
											$totalAmountCr=0;
											$totalAmountDr=0;
											if(count($arr) > 0)
											{
												foreach($arr as $row)
												{
													$crAmount = $drAmount = sprintf("%.2f",0);
													
													if($row['head_type']=='Cr')
													{
														$crAmount = $row['amount'];
														$totalAmountCr+=$row['amount'];
														$totalAmountCr = sprintf("%.2f",$totalAmountCr);
													}
													if($row['head_type']=='Dr')
													{
														$drAmount = $row['amount'];
														$totalAmountDr+=$row['amount'];
														$totalAmountDr = sprintf("%.2f",$totalAmountDr);
													}
													
													if($sl%2==0){
													  $cl="class='row_color'";
													}
													else{
													  $cl="";
													}
											?>
													<tr <?=$cl?>>
														<td style="text-align:center"><?=$sl++?></td>
														<td style="text-align:center"><?=getFormatedDt("Y-m-d H:i",$row['item_dt'])?></td>
														<td style="text-align:left"><?=get_row("name","tbl_account_heads","id=".$row['head_name_id'])?></td>
														<td style="text-align:left"><?=$row['description']?></td>														
														<td style="text-align:right;"><?=$crAmount?></td>												
														<td style="text-align:right;"><?=$drAmount?></td>												
													</tr>												
											<?php														
												}
												?>
													<tr style="font-weight:bold;">
														<td style="text-align:left;" colspan="4">Total Income</td>
														<td style="text-align:right"><?=$totalAmountCr?></td>
														<td style="text-align:right"><?=$totalAmountDr?></td>
													</tr>
												<?php
											}
											else
											{
											?>
											<tr>
												<td style="text-align:center;color:#D32826;padding:10px" colspan="6">Data not found !</td>																						
											</tr>
											<?php
											}
											?>									
									</table>
									<div style="padding-bottom:5px">
									<?php									  
									    $redirect="?module=accounts&page=cr_dr_history&headName=$headId&from_dt=$dt1&to_dt=$dt2&step";
										echo paginationOfThePage($pagination,$redirect);
									?> 
                                    </div>									
								</div>
							</div>						
						</div>						
                    </div>
                </div>					
            </div>
        </div>
    </body>
</html>