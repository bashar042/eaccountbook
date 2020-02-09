<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Client List | eAccount Book</title>       
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
                <div class="admin_rpt_content">				    	
                    <div class="row" style="margin-top:-15px">
						<?php							
							// start setting for pagination
							$sl=1;
							$step = $_GET['step']; 
							$table = 'tbl_user';
							$where =" id != '' ";//"user_id='$userId' AND voucher_dt BETWEEN '$fromDt' AND '$toDt' AND voucher_status=1";
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
							//$whereExt = "WHERE id != '' AND ".$where;								
							$sql = "SELECT * FROM `tbl_user` 
							WHERE $where ORDER BY id DESC LIMIT $offset, $limit";
								
							//$arr = selectAllRows($sql);
							
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
						    <div class="col-lg-12 rpt_filter" style="text-align:left">
								<form method="post">
                                                                    <div class="row" style="margin-bottom:-8px;margin-top:5px">
									<div class="col-lg-4"><input type="text"  name="userName" value="" Placeholder="Search by user name..." class="form-control"></div>									
									<div class="col-lg-2"><input type="submit" name="btnShowCrReport" class="btn btn-primary" value="Search"></div>
									</div>
								</form>							
							</div>
						 </div>
						 <div class="row">
							<div class="col-lg-12">
								<div class="table-responsive">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<table class="table table-bordered">
										<thead class="rpt_thead">
											<tr style="text-align: center;">
												<th style="width:20px;text-align:center">#</th>
												<th style="width:120px;text-align:center">User Id</th>
												<th style="width:150px;text-align:center">Picture</th>
												<th style="width:150px;text-align:center">Contact Info</th>
												<th style="width:80px;text-align:center">Acc Create</th>
												<th style="width:90px;text-align:center">Last Login</th>		
											</tr>
										</thead>
										<?php
										//$sl=1;
										//echo $sql;
										$arr = selectAllRows($sql);
										if(count($arr) > 0) 
										{
											foreach($arr as $row)
											{
												$userImg = $row['user_image'];
											?>
											    <tr>
													<td><?=$sl++?></td>
													<td><?=$row['user_id']?></td>
													<td style='text-align:center'><?=($userImg != '') ? "<img src='$userImg' width='60' height='60'>":'-'?></td>
													<td>
														<?php 
															if($row['phone_mob'])
															{
																echo $row['phone_mob']."<br/>";
															}
															if($row['email'])
															{
																echo $row['email'];
															}																
															?>
													</td>													
													<td style='text-align:center'><?=($row['create_at'] != '') ? getFormatedDt("Y-m-d H:i",$row['create_at']):'-'?></td>
													<td style='text-align:center'><?=($row['last_login'] != '') ? getFormatedDt("Y-m-d H:i",$row['last_login']):'-'?></td>
											    </tr>														
											<?php
											}
										}
										else
										{
											echo "<tr><td style='text-align:center;color:#D32826;padding:10px;text-align:center;border:1px solid #ddd' colspan='6'>Data not found !</td></tr>";
										}
										?>
									</table>								
								</div>
								<div style="padding:10px 1px 5px 1px">
								<?php									  
									$redirect="?module=admin_reports&page=user_list&step";
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