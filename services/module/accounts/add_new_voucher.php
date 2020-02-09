<?php
    $userId   = $_SESSION['user_srl_id'];
    if(isset($_POST['btnSaveInvoiceData'])){
	    $total_amount = array_sum($_POST['itemAmount']);
	    $data1 = array(
			'user_id'        => $userId,
		    'voucher_nr'     => $_POST['voucherNo'],
			'voucher_dt'     => $_POST['voucherDT'],
			'voucher_title'  => $_POST['voucherTitle'],
			'total_amout'    => $total_amount
		); 
	    $isInsert1 = insertData("tbl_voucher_list",$data1);
		$insertedId = mysql_insert_id();
	    $n = count($_POST['hType']);
		$countSavedRow=0;
		
		if($insertedId > 0){
            for($i=0;$i<$n;$i++){
    			$data2 = array(				
    				'voucher_id'   => $insertedId,
    				'head_type'    => $_POST['hType'][$i],
    				'head_name_id' => $_POST['hName'][$i],
    				'description'  => $_POST['crdrDesc'][$i],
    				'item_dt'      => $_POST['itemDate'][$i],
    				'amount'       => $_POST['itemAmount'][$i],
    				'user_id'      => $userId
    			);
    			if($_POST['itemAmount'][$i] > 0)
    			{
    				//if($insertedId)
    				$headType = $_POST['hType'][$i];
    				$desc     = $_POST['crdrDesc'][$i];
    				$amount   = $_POST['itemAmount'][$i];
    				
    				$WHERE    = "voucher_id='$insertedId' AND head_type='$headType' AND description='$desc' AND amount='$amount'";
    				
    				$alreadyInserted = numOfExistedData("tbl_voucher_details",$WHERE);	
    				if($alreadyInserted==0){
    					$isInsert2 = insertData("tbl_voucher_details",$data2);
    					if($isInsert2){
    						$countSavedRow++;				
    					}
    				}
    			}			
    		}
		}
		if($countSavedRow > 0){
			$_SESSION['alert'] = "success";
            if($countSavedRow==1){ $item = "1 item";}			
            if($countSavedRow > 1){ $item = "$countSavedRow items";}			
			$_SESSION['userMsg'] = "Your voucher data($item) saved successfully !";
			header("Location:?module=accounts&page=voucher");
			exit;
        }
		else{
			$_SESSION['alert'] = "danger"; 
			$_SESSION['userMsg'] = "Sorry, data not saved properly. Please check the voucher!";
			header("Location:?module=accounts&page=voucher");
			exit;
		}        
    }
    
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <title>Add New Voucher | eAccount Book</title>        
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
                <div class="input_field_content input_form">
                    <div class="row">
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
						<form method="post">
						<?php
						 $voucherNo = time();
						 $voucherDT = date('Y-m-d H:i');
						?>						
						<input type="hidden" name="voucherNo" value="<?=$voucherNo?>">
						<input type="hidden" name="voucherDT" value="<?=$voucherDT?>">
						<div class="row" style="margin-bottom:-20px">
							<div class="col-lg-6">						     
								Voucher Title:<span style="color:#D32826">*</span>
								<input type="text" class="form-control" required="" name="voucherTitle">						     
							</div>
							<div style="text-align:right;padding-top:20px" class="col-lg-6">
								Voucher No:&nbsp;<span style="font-style:Italic"><?=$voucherNo?></span>
								<br>
								Voucher Date:&nbsp;<span style="font-style:Italic"><?=$voucherDT?></span>
							</div>
						</div>
						<br/>
						<div class="table-responsive">
							<table class="table table-bordered" id="customFields">
								<thead class="rpt_thead">
									<tr style="text-align: center;">
										<th style="width:20px;text-align:center">#</th>										
										<th style="width:120px;text-align:center">Acc. Head</th>
										<th style="width:80px;text-align:center">Tran. Type</th>										
										<th style="width:250px;text-align:center">Particular Desc.</th>																				
										<th style="width:100px;text-align:center">Amount (Tk)</th>
										<th style="width:120px;text-align:center">Date</th>										
										<th style="width:40px;text-align:center">#</th>												
									</tr>
								</thead>
								<tbody id="voucher_entyr_list" style="text-align:center">
                                 <tr>
								  <td colspan="7">
                                     <img id="loader_img" src="services/images/eab_loader.gif" border="0">
								  </td>
								 </tr>
								</tbody>
								<tfoot>
								      <tr>
									      <td colspan="4" style="text-align:right">Total Amount (Tk)</td>
									      <td><input type="text" id="txtTotalAmount" name="txtTotalAmount" value="0.00" class="form-control"  style="text-align:right" readonly></td>
										  <td>&nbsp;</td>
									      <td style="width:40px;text-align:center">
										    <a href="javascript:voucherEntyrListNew();" id="addCF">
											 <i class="fa fa-plus-circle" style="color:#47B8D9;font-size:32px;vertical-align:middle;" title="+ Add New Item"></i>
											</a>
										  </td>
									  </tr>
								</tfoot>
							</table>
						</div>
                        <!--						
						<div style="text-align:right;margin:-7px 0px 12px 0px;" class="row">
							<a href="javascript:voucherEntyrListNew();" id="addCF" class="btn btn-info">+ Add new item</a>
						</div>
						-->
						<div class="row field_div btn_content">
							<button type="submit" name="btnSaveInvoiceData" class="btn btn-success">
								Save Invoice &nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i>
							</button>
						</div>
						</form>
                    </div>				
                    <script src="<?=$base_url?>helper/js/jquery-2.1.4.js"></script>
                    <script>
                        $(document).ready(function(){
                            voucherEntyrListNew();
                        });
                        function voucherEntyrListNew(){
                            var trFr    = $('#dd').html();
                            var trID    = makeUniqueString();
                            trFr=trFr.replace(new RegExp("{TRID}", 'g'),trID);
                            $("#loader_img").hide();
                            $("#voucher_entyr_list").append('<tr id="'+trID+'" class="voucherRow">'+trFr+'</tr>');
                            setTrSerial();
                            //loadVoucherHead('Dr',trID);
                            $('#'+trID+' .dt_c').datepicker({ dateFormat: 'yy-mm-dd',autoclose: true }).val();
                        }
                        function setTrSerial(){var tr_sl_start=1;$('.tr_sl_no').each(function(){$(this).html(tr_sl_start);tr_sl_start++;});}
                        function totalAmount(){ 
							var totalAmount=0;
							var tempAmount=0;
							var headName=0;
							var headType;
							$('.voucherRow').each(function(){
								
							var rowId = this.id;								
							tempAmount = $('#'+rowId+' .tAmount').val();
							headName = $('#'+rowId+' .voucher_head').val();
                            if(headName=='')
							{ 
								tempAmount=0;
								$('#'+rowId+' .tAmount').val('');
								$('#'+rowId+' .tAmount').attr("placeholder", "0.00");
								
								$('#'+rowId+' .hType').attr('readonly', true);
								$('#'+rowId+' .pDesc').attr('readonly', true);
								$('#'+rowId+' .tcal').attr('readonly', true);
								$('#'+rowId+' .tAmount').attr('readonly', true);
							}
							if(isNaN(tempAmount)==true)
							{
								tempAmount=0;
								//$('#'+rowId+' .tAmount').val('0.00');
								$('#'+rowId+' .tAmount').val('');
								$('#'+rowId+' .tAmount').attr("placeholder", "0.00");
							}
							headType = $('#'+rowId+' .hType').val(); 
							//alert(headType);
							if(headType=='Dr')
							{
								totalAmount = Number(totalAmount)-Number(tempAmount);
							}
							if(headType=='Cr')
							{
								totalAmount = Number(totalAmount)+Number(tempAmount);
							}
							});
							var grantTotalAmount = roundToTwo(totalAmount);
                            
							if(isNaN(grantTotalAmount)==true)
							{
								$('#txtTotalAmount').val('0.00'); 
							}
							else
							{
								$('#txtTotalAmount').val(grantTotalAmount); 
							}
							
						}
						function roundToTwo(num) {    
						return num.toFixed(2);
							//return +(Math.round(num + "e+2")  + "e-2");
						}
						function parse_int(rString){rString=parseInt(rString);if(isNaN(rString))rString=0;return rString;}
						function parse_flt(rString){rString=parse_float(rString);if(isNaN(rString))rString=0;return rString;}
                        function makeUniqueString(){var text="";var possible="abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz0123456789";for(var i=0;i<7;i++)text+=possible.charAt(Math.floor(Math.random()*possible.length));return text;}
                        function removeThisTrFromVoucherList(trID){
                            $('#'+trID).remove();
                            setTrSerial();
                        }
                        function loadVoucherHead(headType,setTr){ //
                            $('#'+setTr+' .voucher_head').html('<option value="">Loading...</option>');//alert('mm');
                            $.ajax({    
                                type: "POST",
                                //url: "index.php",
                                url: "services/helper/library/ajax_handle.php",
                                data: 'ajax_request=get_voucher_head&head_type='+headType,
                                success:function(data){
                                    if(data.status==1){
                                        var s=data.result; 
                                      
                                        var htmlString='';
										htmlString+='<option value="">'+'-Select-'+'</option>';
										var i = 0;
                                        $.each(s,function(key,val){ 
                                            var arr = val.split("/");
                                            var id = arr[0];  
                                            var hName = arr[1]; 
                                            
                                            htmlString+='<option value="'+id+'">'+(i+1)+'. '+hName+'</option>'; 
					    i++;
                                        });
                                        $('#'+setTr+' .voucher_head').html(htmlString);
                                    }
                                }
                            });
                        }
                    function toggleInputFields(headId)
					{ 	 		
						 if(headId > 0)  { 
							 $('.voucherRow').each(function(){						
								
								var rowId = this.id;	 //alert(rowId)							
								$('#'+rowId+' .tAmount').attr('readonly', false);
								$('#'+rowId+' .hType').attr('readonly', false);
								$('#'+rowId+' .pDesc').attr('readonly', false);
								$('#'+rowId+' .tcal').attr('readonly', false);
							
							});	 
						}
						/*else
						{
							$('.voucherRow').each(function()
							{
								
								var rowId = this.id;	 alert(rowId)							
								//$('#'+rowId+' .tAmount').attr('readonly', true);
								//$('#'+rowId+' .hType').attr('readonly', true);
							
							}
						} */
					} 
                    </script>
                    <div style="display: none;">
                        <table>
                            <tr valign="top" id="dd">
                                <td style="text-align:center" class="tr_sl_no"></td>                                
                                <td>
                                    <select name="hName[]"  class="form-control voucher_head" onchange="toggleInputFields(this.value);totalAmount();">
                                        <option value="">-Select-</option>
										<?php
										$sl=1;
										$sql="SELECT * FROM `tbl_account_heads` 
										WHERE user_id='$userId' AND head_status=1 ORDER BY name";
										$run = mysql_query($sql);
										$num = mysql_num_rows($run);
										if($num > 0)
										{
											while($row=mysql_fetch_array($run))
											{
											?>
											  <option value="<?=$row['id']?>"><?=$sl++.". ".$row['name']?></option>
                                            <?php    											
											}
										}	
										?>
                                    </select>
                                </td>
								<td>
                                    <select name="hType[]" class="form-control hType" onchange="totalAmount();" readonly="readonly">
                                        <option value="Dr">Cost</option>
                                        <option value="Cr">Income</option>
                                    </select>
                                </td>
                                <td><input type="text" name="crdrDesc[]" class="form-control pDesc" readonly="readonly"></td>
                                <td style="text-align:center">
                                    <input type="text" name="itemAmount[]" style="text-align:right" class="form-control tAmount" readonly="readonly" placeholder="0.00" onkeyup="totalAmount()">
                                </td>
                                <td>
                                <input type="text" name="itemDate[]" data-date-format='yyyy-mm-dd <?=date('H:i');?>' class="dt_c form-control id_1" value="<?=date('Y-m-d H:i')?>">
								<i class="fa fa-calendar calender_icon"></i>    
                                </td>
                                <td style="width:40px;text-align:center">
                                    <a href="javascript:removeThisTrFromVoucherList('{TRID}');totalAmount()" id="remCF">
                                        <i class="fa fa-minus-circle" style="color:#D32826;font-size:30px;vertical-align:middle;" title="Remove"></i>
                                    </a>
                                </td>	
                            </tr>
                        </table>
                    </div>

                </div>					
            </div>
        </div>
    </body>
</html>
<style>
.datepicker {
	/*top: 325.033px !important;*/
	left: 949.233px !important;
	display: block;
	background:#fff;
	line-height:1.2;
	padding:2px 5px;
}
.datepicker-switch{
	text-align:center !important;
}
.table-condensed thead > tr > th, .table-condensed tbody > tr > th, .table-condensed tfoot > tr > th, .table-condensed thead > tr > td, .table-condensed tbody > tr > td, .table-condensed tfoot > tr > td {
	padding: 5px;
	text-align: center;
	cursor:pointer !important;
}
.table-condensed tbody > tr > td .old{
	color: red !important;
}
.calender_icon{
	float: right;margin-top: -25px;margin-right: 8px;
}
@media screen and (max-width: 1199px) {
  .calender_icon{
	margin-right: 4px;
}
}
</style>