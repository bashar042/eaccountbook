<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Income History | eAccount Book</title>       
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
								header("Location:?module=accounts&page=cr_history&headName=$headId&from_dt=$dt1&to_dt=$dt2&step=$step");
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
								header("Location:?module=accounts&page=cr_history&headName=$headId&from_dt=$dt1&to_dt=$dt2&step=$step");
								exit;
							}
							if($fromDt > $toDt)
							{
								$_SESSION['userMsg'] = "Sorry, From-date cann't be greater than To-date !";
								$_SESSION['alert']   = "danger";
								header("Location:?module=accounts&page=cr_history&headName=$headId&from_dt=$dt1&to_dt=$dt2&step=$step");
								exit;
							}						
								
							// start setting for pagination
							$sl=1;
							$step = $_GET['step']; 
							$table = 'tbl_voucher_details';
							$where = "user_id='$userId' $head AND item_dt BETWEEN '$fromDt' AND '$toDt' AND head_type='Cr'";
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
								
							$sql = "SELECT * FROM `tbl_voucher_details` 
							WHERE $where ORDER BY item_dt ASC LIMIT $offset, $limit";
							
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
								    <div class="rpt_header">
								    	<span class="rpt_name">Income History Report</span><br/>
								    	<?php
									    	if($_POST['from_dt'] != '' && $_POST['to_dt'] != '')
									    	{
									    		echo "<span class='rpt_date'>From ".$_POST['from_dt']." to ".$_POST['to_dt']."</span>";
									    	}
								    	?>
								    </div>
									<table class="table table-bordered">
										<thead class="rpt_thead">
											<tr>
												<th style="text-align:center;width:6%">#</th>
												<th style="text-align:center;width:20%">Date</th>
												<th style="text-align:center;width:25%">Head Name</th>
												<th style="text-align:center;width:34%">Particulars Desc.</th>												
												<th style="text-align:center;width:15%">Amount</th>												
											</tr>
										</thead>	
											<?php
											$sl=1;
											$totalAmount=0;
											if(count($arr) > 0)
											{
												foreach($arr as $row)
												{
													$totalAmount+=$row['amount'];
													$totalAmount = sprintf("%.2f",$totalAmount);
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
														<td style="text-align:right;"><?=$row['amount']?></td>												
													</tr>												
											<?php
													
												}
												?>
													<tr style="font-weight:bold;">
														<td style="text-align:left;" colspan="4">Total Income</td>
														<td style="text-align:right"><?=$totalAmount?></td>
													</tr>
												<?php
											}
											else
											{
											?>
											<tr>
												<td style="text-align:center;color:#D32826;padding:10px" colspan="5">Data not found !</td>																						
											</tr>
											<?php
											}
											?>									
									</table>
									<div style="padding-bottom:5px">
									<?php									  
									    $redirect="?module=accounts&page=cr_history&headName=$headId&from_dt=$dt1&to_dt=$dt2&step";
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