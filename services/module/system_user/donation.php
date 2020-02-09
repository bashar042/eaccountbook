<?php
	$userId   = $_SESSION['user_srl_id'];
	if(isset($_POST['btnConfirmDonation'])){
		$sendingAmount  = $_POST['sendingAmount'];
		$senderBikashNo = $_POST['senderBikashNo'];
		$transactionId  = $_POST['transactionId'];
		$confirmByEmail = $_POST['confirmByEmail'];
		
		if($sendingAmount=="" || $senderBikashNo=="" || $transactionId==""){
			$_SESSION['userMsg'] = "Required fileds can not be blank !";
			$_SESSION['alert'] = "danger";
			header("location:?module=system_user&page=donate");
			exit;
		}		
		$data=array(
			'user_id'       => $userId,
			'send_amount'   => $sendingAmount,
			'sender_no'     => $senderBikashNo,
			'tran_id'       => $transactionId,
			'email_confirm' => $confirmByEmail
		);
		$isInsertData = insertData("tbl_donations",$data);
		if($isInsertData){
			$_SESSION['userMsg'] = "Your transaction information is waiting for approval !";
			$_SESSION['alert']   = "success";
			header("location:?module=system_user&page=donate");
			exit;			
		}
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Donate | eAccount Book</title>       
    </head>
    <body>
        <div style="text-align: left;">
            <ol class="breadcrumb">
                <li><?=$reqPage['module_title']?></li>
                <li class="active"><a href="?module=<?=$reqPage['module_value']?>&page=<?=$reqPage['page_value']?>"><?=$reqPage['page_title']?></a></li>
            </ol>
        </div>

        <div class="panel panel-default input_form_inner_content">
            <div class="panel-heading">
                <h3 class="panel-title page_title"><?=$reqPage['page_title']?></h3>
            </div>
            <div class="panel-body">							 
                <div class="input_field_content input_form">
                    <div class="row">									
						<form method="post">
						 <div class="row">
						    <div class="col-lg-1"></div>
						    <div class="col-lg-10" style="text-align:justify">
							 This account system is supporting you to save and calculate your personal / business data without any charge. 
							 So you have to support us to continue the system for you / your business.<br/><br/>
							 You can support us to donate any amount by your bKash number.
							 <br/><br/>							 
							</div>
						    <div class="col-lg-1"></div>
						 </div>
						 <div class="row">
						    <div class="col-lg-1"></div>
						    <div class="col-lg-10" style="text-align:justify">
								<div class="title_div">Donation Information</div>
							    
							    <div class="col-lg-5" style="background-color:#F2F7FC;">
									<?php
										if($_SESSION['userMsg'] != "" )
										{
									?>
										<div class="row">
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
									<div class="donation_header">
										<b>Sent money to the bKash number:</b><br/>
										<span class="donate_cell">01718 792 556</span>
									</div>
									<div style="padding:10px">
										Sending Amount(Tk)<br/>
										<input type="text" name="sendingAmount" style="width:100px" class="form-control"><br/>
										Sender bKash Number<br/>
										<input type="text" name="senderBikashNo" style="width:175px" class="form-control"><br/>
										Transaction ID<br/>
										<input type="text" name="transactionId" style="width:175px" class="form-control"><br/>
										<input type="checkbox" name="confirmByEmail" checked >&nbsp; Email me about the donation.
										<br/><br/>
										<button type="submit" name="btnConfirmDonation" class="btn btn-success" >Confirm the Donation</button>
									</div>	
								</div>
								<div class="col-lg-1"></div>
								<div class="col-lg-6" style="background-color:#F2F7FC;">
									 <div class="donation_header">
										<b>Your Donations</b><br/>
									</div>
									<div style="padding:10px 2px;font-size:13px">
										<table class="table table-bordered">
										    <tr>
										        <th style="text-align:center;">Sl</th>
										        <th style="text-align:center;">Tran. Info</th>
										        <th style="text-align:center;">Tran. Amount</th>
										        <th style="text-align:center;">Status</th>
										    </tr>
											<?php
											$sl=1;
											$sql = "select * from `tbl_donations` where user_id='$userId' order by id Desc";
											$arrDonation = selectAllRows($sql);
                                            $len = count($arrDonation);
                                            if($len > 0){   											
												foreach($arrDonation as $row)
												{
												?>
												<tr>
													<th style="text-align:center"><?=$sl++?></th>
													<td>
														<?=$row['sender_no']?><br/>
														TID: <?=$row['tran_id']?>
													</td>
													<td style="text-align:center;"><?=$row['send_amount']?></td>
													<th style="text-align:center;">
													 <?=($row['donation_status']==1)?"Success":"Pending"?>
													</th>
												</tr>
												<?php											
												}
											}
											else{
											?>
											   <tr><td colspan="4" style="text-align:center;color:#D32826">You have not donated any amount yet !</td></tr>
                                            <?php  											
											}
											?>											
										</table>
									</div>							 						 
								</div>						    
							</div>
							<div class="col-lg-1"></div>
						 </div>	
						</form>                    
					</div>					
				</div>
			</div>
		</div>	
    </body>
</html>