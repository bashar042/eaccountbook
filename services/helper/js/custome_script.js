function printDiv(divId) 
{    
   var divToPrint = document.getElementById(divId);
   var popupWin = window.open('', '_blank', 'width=700,height=600');
   popupWin.document.open();
   popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
   popupWin.document.close(); 
}
function deleteRequest(request_url)
{
    //alert(request_url)   ;
    var r = confirm('Are you sure ?');
    if(r==true)
        {
        window.location.href = request_url;
    }
}
///////////////////////////////////////////////////////
function editRequest(request_url)
{
 window.location.href = request_url;
}
/////////////////////////////////////////////////
function selectAccDetails(id)
{
    var arr = id.split('/'); //alert(arr[0]);
    document.getElementById('accName').value=arr[1]; 
    document.getElementById('accType').value=arr[2];
}
function setBankName(id)
{
    // alert(id);
    var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("idBankInfo").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/bank_info.php?id="+id,true);
    xmlhttp.send();
}
function setVendorBankName(id)
{
    // alert(id);
    var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("idBankInfo").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/vendor_bank_info.php?id="+id,true);
    xmlhttp.send();
}
function SelectLevel(id)
{   //alert(id);
    var server = id.split("/");
    var serverId = server[0];//alert(serverId)
    var name = server[1];
    var type =server[2]; //alert(type);
    var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("levelContent").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("levelContent").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/server_level.php?id="+serverId,true);
    xmlhttp.send();
}
function selectServerType(id)
{       
    var TypeInfo = id.split("/");
    var levelId = TypeInfo[0];

    var serverInfo = document.getElementById("serverId").value;
    var server = serverInfo.split("/");
    var serverId = server[0];
    var retailUserType = server[3];
    //alert(serverId+levelId)

    var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("UserContent").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("UserContent").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/user_list.php?serverId="+serverId+"&levelId="+levelId+"&retailUserType="+retailUserType,true);
    xmlhttp.send();
}
function selectRetailUsers(id)
{
	var TypeInfo = id.split("/");
    var levelId = TypeInfo[0];

    var customerId = document.getElementById("customerId").value;
    var serverInfo = document.getElementById("serverId").value;
    var server = serverInfo.split("/");
    var serverId = server[0];
    var serverType = server[3];

    var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("UserContent").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("UserContent").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/retail_user_for_static_server.php?serverId="+serverId+"&levelId="+levelId+"&serverType="+serverType+"&customerId="+customerId,true);
    xmlhttp.send();
}
function assingReseller(id)
{
    var TypeInfo = id.split("/");
    var levelId = TypeInfo[0];
	
	var productInfo = document.getElementById("productInfo").value;
    var product = productInfo.split("/");
    var proType = product[0];
    var proId   = product[0];
    var proName = product[0];
	
	var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("UserContent").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("UserContent").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/display_resller_user_list.php?proType="+proType+"&proId="+proId+"&levelId="+levelId,true);
    xmlhttp.send();
}
function setAccInfo()
{    //alert('dd')
    var tps_bank_name = document.getElementById("tps_bank_name").value;     //alert(tps_bank_name)
    var openingBalance = document.getElementById("openingBalance").value;   //alert(openingBalance)
    var currenctType = document.getElementById("currenctType").value;       //alert(currenctType)    

    var accInfo = tps_bank_name+"-"+currenctType+"-"+openingBalance;
    window.location.href = 'model/model_user.php?accInfo='+accInfo;
}
//======================================================================================
function  addmoredataontable()
{
    var serverInfo = document.getElementById("serverId").value;
    if(serverInfo == "") {alert('Please, Select Server.'); return false;}
    var server = serverInfo.split("/");
    var serverId = server[0];
    var serverName = server[1];
    var retailUserType = server[3];

    var levelInfo = document.getElementById("serverLevel").value;
    if(levelInfo == "") {alert('Please, Select Level.'); return false;}
    var level = levelInfo.split("/");
    var levelId = level[0];
    var levelName = level[1]; 
	
    if(retailUserType == "auto")
	{	
		var userInfo = document.getElementById("userId").value;
		if(userInfo == "") {alert('Please, Select Retails User.'); return false;}
		var user = userInfo.split("/"); 
		var userId = user[0];
		var userName = user[1]; 
	}
	if(retailUserType == "static_user")
	{	
		var userName = document.getElementById("userId").value;
		if(userName == "") {alert('Please, Select Retails User.'); return false;}
		var userId = retailUserType;
	}

    var currencyInfo = document.getElementById("userCurrency").value;
    if(currencyInfo == "") {alert('Please, Select Currency.'); return false;}
    var currency =  currencyInfo.split("/");
    var currencyId = currency[0];
    var currencyName = currency[1];

    addRow(serverName,levelName,userName,currencyName,serverId,levelId,userId,currencyId);  
}
///
var testi=0;
function addRow(serverName,levelName,userName,currencyName,serverId,levelId,userId,currencyId)
{
    var table=document.getElementById("mytb");
    table.style.width=="80%";
    var tb=document.getElementById("mytbd");
    //=========================================================================================
    var r;
    var len=document.getElementById("mytb").rows.length;
    for(r=1;r<len; r++)
    {
        var cell_0 = document.getElementById('mytb').rows[r].cells[0].innerHTML;
        var cell_1 = document.getElementById('mytb').rows[r].cells[1].innerHTML;
        var cell_2 = document.getElementById('mytb').rows[r].cells[2].innerHTML;
        var cell_3 = document.getElementById('mytb').rows[r].cells[3].innerHTML;        
        var cell_4 = document.getElementById('mytb').rows[r].cells[4].innerHTML;        
        var cell_5 = document.getElementById('mytb').rows[r].cells[5].innerHTML;            



        var allIDs = serverId+"/"+levelId+"/"+userId+"/"+currencyId;
        if(cell_5 == allIDs)
            {
            alert("Duplicate-entry # already added in the list.");
            return false;
        }          
    }
    //========================================================================================== 
    if(table.style.visibility=="hidden")		
        {
        table.style.visibility='visible';
        var tr=document.createElement('TR');
        testi++;

        tr.id='tr'+testi+'tr';
        tr.style.backgroundColor = "#EEEEEE"; 
        tb.appendChild(tr);

        //window.alert(td);
        var td1=document.createElement('TD');
        tr.appendChild(td1);
        td1.innerHTML=testi;
        td1.style.border="1px solid #fff";
        td1.style.textAlign = "center";

        var td2=document.createElement('TD');
        tr.appendChild(td2);
        td2.innerHTML=serverName;
        td2.style.border="1px solid #fff";
        td2.style.paddingLeft="5px";

        var td3=document.createElement('TD');
        tr.appendChild(td3);
        td3.innerHTML=levelName; 
        td3.style.border="1px solid #fff";
        td3.style.paddingLeft="5px";

        var td31=document.createElement('TD');
        tr.appendChild(td31);
        td31.innerHTML=userName; 
        td31.style.border="1px solid #fff";
        td31.style.paddingLeft="5px";

        var td32=document.createElement('TD');
        tr.appendChild(td32);
        td32.innerHTML=currencyName; 
        td32.style.border="1px solid #fff";
        td32.style.paddingLeft="5px";	

        var td5=document.createElement('TD');
        tr.appendChild(td5);
        td5.innerHTML=serverId+"/"+levelId+"/"+userId+"/"+currencyId;
        td5.style.border="1px solid #fff";
        td5.style.paddingLeft="5px";        

        var td4=document.createElement('TD');
        tr.appendChild(td4);
        td4.style.textAlign = "center";
        td4.style.border="1px solid #fff";
        td4.innerHTML="<img src='images/del3.png' onclick='removeRow1(this)' alt='Delete'/>"; 	         

    }
    else if(table.style.visibility=='visible')
        {

        //var tb=document.getElementById("tt");
        var tr=document.createElement('TR');
        testi++;
        //window.alert(tb);
        tr.id='tr'+testi+'tr';
        tb.appendChild(tr);
        tr.style.backgroundColor = "#EEEEEE"; 

        var td1=document.createElement('TD');
        tr.appendChild(td1);
        td1.innerHTML=testi;
        td1.style.border="1px solid #fff";
        td1.style.textAlign = "center";

        var td2=document.createElement('TD');
        tr.appendChild(td2);
        td2.innerHTML=serverName;
        td2.style.border="1px solid #fff";
        td2.style.paddingLeft="5px";

        var td3=document.createElement('TD');
        tr.appendChild(td3);
        td3.innerHTML=levelName; 
        td3.style.border="1px solid #fff";
        td3.style.paddingLeft="5px";

        var td31=document.createElement('TD');
        tr.appendChild(td31);
        td31.innerHTML=userName; 
        td31.style.border="1px solid #fff";
        td31.style.paddingLeft="5px";

        var td32=document.createElement('TD');
        tr.appendChild(td32);
        td32.innerHTML=currencyName; 
        td32.style.border="1px solid #fff";
        td32.style.paddingLeft="5px";    

        var td5=document.createElement('TD');
        tr.appendChild(td5);
        td5.innerHTML=serverId+"/"+levelId+"/"+userId+"/"+currencyId;
        td5.style.border="1px solid #fff";
        td5.style.paddingLeft="5px";   

        var td4=document.createElement('TD');
        tr.appendChild(td4);
        td4.style.textAlign = "center";
        td4.style.border="1px solid #fff";
        td4.innerHTML="<img src='images/del3.png' onclick='removeRow1(this)' alt='Delete'/>";


    }

}
//************ Remove row by click Delete button *********************//
function removeRow1(src)
{	   
    //window.alert(src.date);
    var oRow = src.parentNode.parentNode; 
    var tb=document.getElementById("mytbd").deleteRow(oRow.rowIndex);
    testi--;
    /* if(testi==0)
    {
    var table=document.getElementById("mytb");//when all row delete, table invisible.

    table.style.visibility='hidden';

    }   */

}
function  addMulVendorTable()
{
    var serverInfo = document.getElementById("serverId").value;
    if(serverInfo == "") {alert('Please, Select Server.'); return false;}
    var server = serverInfo.split("/");
    var serverId = server[0];
    var serverName = server[1];
    var retailUserType = server[3];//alert(retailUserType)
	
    if(retailUserType == "auto")
	{	
		var userInfo = document.getElementById("userId").value;
		if(userInfo == "") {alert('Please, Select Retails User.'); return false;}
		var user = userInfo.split("/"); 
		var userId = user[0];
		var userName = user[1]; 
	}
	if(retailUserType == "static_user")
	{	
		var userName = document.getElementById("userId").value;
		if(userName == "") {alert('Please, Select Retails User.'); return false;}
		var userId = retailUserType;
	}

    var currencyInfo = document.getElementById("userCurrency").value;
    if(currencyInfo == "") {alert('Please, Select Currency.'); return false;}
    var currency =  currencyInfo.split("/");
    var currencyId = currency[0];
    var currencyName = currency[1];

    addRow(serverName,userName,currencyName,serverId,userId,currencyId);  
}
///
var testi=0;
function addRow(serverName,userName,currencyName,serverId,userId,currencyId)
{
    var table=document.getElementById("mytb");
    table.style.width=="80%";
    var tb=document.getElementById("mytbd");
    //=========================================================================================
    var r;
    var len=document.getElementById("mytb").rows.length;
    for(r=1;r<len; r++)
    {
        var cell_0 = document.getElementById('mytb').rows[r].cells[0].innerHTML;
        var cell_1 = document.getElementById('mytb').rows[r].cells[1].innerHTML;
        var cell_2 = document.getElementById('mytb').rows[r].cells[2].innerHTML;
        var cell_3 = document.getElementById('mytb').rows[r].cells[3].innerHTML;        
        var cell_4 = document.getElementById('mytb').rows[r].cells[4].innerHTML;        



        var allIDs = serverId+"/"+userId+"/"+currencyId;
        if(cell_4 == allIDs)
            {
            alert("Duplicate-entry # already added in the list.");
            return false;
        }          
    }
    //========================================================================================== 
    if(table.style.visibility=="hidden")		
        {
        table.style.visibility='visible';
        var tr=document.createElement('TR');
        testi++;

        tr.id='tr'+testi+'tr';
        tr.style.backgroundColor = "#EEEEEE"; 
        tb.appendChild(tr);

        //window.alert(td);
        var td1=document.createElement('TD');
        tr.appendChild(td1);
        td1.innerHTML=testi;
        td1.style.border="1px solid #fff";
        td1.style.textAlign = "center";

        var td2=document.createElement('TD');
        tr.appendChild(td2);
        td2.innerHTML=serverName;
        td2.style.border="1px solid #fff";
        td2.style.paddingLeft="5px";
        
        var td31=document.createElement('TD');
        tr.appendChild(td31);
        td31.innerHTML=userName; 
        td31.style.border="1px solid #fff";
        td31.style.paddingLeft="5px";

        var td32=document.createElement('TD');
        tr.appendChild(td32);
        td32.innerHTML=currencyName; 
        td32.style.border="1px solid #fff";
        td32.style.paddingLeft="5px";	

        var td5=document.createElement('TD');
        tr.appendChild(td5);
        td5.innerHTML=serverId+"/"+userId+"/"+currencyId;
        td5.style.border="1px solid #fff";
        td5.style.paddingLeft="5px";        

        var td4=document.createElement('TD');
        tr.appendChild(td4);
        td4.style.textAlign = "center";
        td4.style.border="1px solid #fff";
        td4.innerHTML="<img src='images/del3.png' onclick='removeRow2(this)' alt='Delete'/>"; 	         

    }
    else if(table.style.visibility=='visible')
        {

        //var tb=document.getElementById("tt");
        var tr=document.createElement('TR');
        testi++;
        //window.alert(tb);
        tr.id='tr'+testi+'tr';
        tb.appendChild(tr);
        tr.style.backgroundColor = "#EEEEEE"; 

        var td1=document.createElement('TD');
        tr.appendChild(td1);
        td1.innerHTML=testi;
        td1.style.border="1px solid #fff";
        td1.style.textAlign = "center";

        var td2=document.createElement('TD');
        tr.appendChild(td2);
        td2.innerHTML=serverName;
        td2.style.border="1px solid #fff";
        td2.style.paddingLeft="5px";

        var td31=document.createElement('TD');
        tr.appendChild(td31);
        td31.innerHTML=userName; 
        td31.style.border="1px solid #fff";
        td31.style.paddingLeft="5px";

        var td32=document.createElement('TD');
        tr.appendChild(td32);
        td32.innerHTML=currencyName; 
        td32.style.border="1px solid #fff";
        td32.style.paddingLeft="5px";    

        var td5=document.createElement('TD');
        tr.appendChild(td5);
        td5.innerHTML=serverId+"/"+userId+"/"+currencyId;
        td5.style.border="1px solid #fff";
        td5.style.paddingLeft="5px";   

        var td4=document.createElement('TD');
        tr.appendChild(td4);
        td4.style.textAlign = "center";
        td4.style.border="1px solid #fff";
        td4.innerHTML="<img src='images/del3.png' onclick='removeRow2(this)' alt='Delete'/>";


    }

}
//************ Remove row by click Delete button *********************//
function removeRow2(src)
{	   
    //window.alert(src.date);
    var oRow = src.parentNode.parentNode; 
    var tb=document.getElementById("mytbd").deleteRow(oRow.rowIndex);
    testi--;   
}
//=================================================================================================
function saveServerAssignData(userType)
{
    var mainUserId = document.getElementById("mainUserId").value;
    
    if(mainUserId == "")
    {
        alert("Please, select user.");
        return false;
    }
    var r;      
    var table=document.getElementById("mytb");
    var tb=document.getElementById("mytbd");

    var len = document.getElementById("mytb").rows.length;
    for(r=1; r <len; r++)
    {
        var cell_0 = document.getElementById('mytb').rows[r].cells[0].innerHTML;
        var cell_1 = document.getElementById('mytb').rows[r].cells[1].innerHTML;
        var cell_2 = document.getElementById('mytb').rows[r].cells[2].innerHTML;
        var cell_3 = document.getElementById('mytb').rows[r].cells[3].innerHTML;        
        var cell_4 = document.getElementById('mytb').rows[r].cells[4].innerHTML;        
        var cell_5 = document.getElementById('mytb').rows[r].cells[5].innerHTML; 

        var myInfo = cell_5.split("/");
        var serverId = myInfo[0];
        var levelId = myInfo[1];
        var userId = myInfo[2];
        var currencyId = myInfo[3];
        
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var responseMSG = xmlhttp.responseText;        alert(responseMSG);
                window.location = '?module=user&page=assign_server';
            }
        }
        xmlhttp.open("GET","toggle/save_server_assigned_info.php?mainUserId="+mainUserId+"&serverId="+serverId+"&levelId="+levelId+"&userId="+userId+"&currencyId="+currencyId+"&loginuser="+cell_3+"&levelName="+cell_2+"&userType="+userType,true);
        xmlhttp.send();                      
                                                                                             
    }
}
function saveGatewayAssignData(userType)
{
    var mainUserId = document.getElementById("mainUserId").value;
    
    if(mainUserId == "")
    {
        alert("Please, select user.");
        return false;
    }
    var r;      
    var table=document.getElementById("mytb");
    var tb=document.getElementById("mytbd");

    var len = document.getElementById("mytb").rows.length;
    for(r=1; r <len; r++)
    {
        var cell_0 = document.getElementById('mytb').rows[r].cells[0].innerHTML;
        var cell_1 = document.getElementById('mytb').rows[r].cells[1].innerHTML;
        var cell_2 = document.getElementById('mytb').rows[r].cells[2].innerHTML;
        var cell_3 = document.getElementById('mytb').rows[r].cells[3].innerHTML;        
        var cell_4 = document.getElementById('mytb').rows[r].cells[4].innerHTML;        

        var myInfo = cell_4.split("/");
        var serverId = myInfo[0];
        var userId = myInfo[1];
        var currencyId = myInfo[2];
        
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var responseMSG = xmlhttp.responseText;        alert(responseMSG);
                window.location = '?module=vendor&page=assign_gateway';
            }
        }
        xmlhttp.open("GET","toggle/save_server_assigned_info.php?mainUserId="+mainUserId+"&serverId="+serverId+"&userId="+userId+"&currencyId="+currencyId+"&loginuser="+cell_2+"&userType="+userType,true);
        xmlhttp.send();                      
                                                                                             
    }
}
//=======================================================================================
function syncronize_data(serverId)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("syncronizedData"+serverId).innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("syncronizedData"+serverId).innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/select_syncronize_data.php?serverId="+serverId,true);
    xmlhttp.send();
}
////////////////////////////////////////////
function synGateWayData(serverId)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("synGateWayData"+serverId).innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("synGateWayData"+serverId).innerHTML=xmlhttp.responseText;
        }
    }
	//alert(serverId);
    xmlhttp.open("GET","toggle/syncronize_gateway_data.php?serverId="+serverId,true);
    xmlhttp.send();
}
//////////////////////////////////////////////////////////////////////////////////////////////////
function displayReseller(id)
{
//alert(id);
 var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
   // document.getElementById("resellerView").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("resellerView").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/show_reseller.php?id="+id,true);
    xmlhttp.send();
}
function displayGateways(id)
{
//alert(id);
 var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
   // document.getElementById("resellerView").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("gatewaysView").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/show_vendor_wise_gateways.php?id="+id,true);
    xmlhttp.send();
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
function viewAccounts(id)
{
  var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
   // document.getElementById("resellerView").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("resellerView").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/show_reseller_user_acc.php?id="+id,true);
    xmlhttp.send();
}
//////////////////////////////////////////////////////////////////
function checkstatus(id,divId)
{
var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById(divId).innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById(divId).innerHTML=xmlhttp.responseText;
        }
    }     
    xmlhttp.open("GET","toggle/check_connection.php?id="+id,true);
    xmlhttp.send();
}
//////////////////////////////////////////////////////////////////
function setServerInfo(productType)
{   
    	var xmlhttp;
		if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
			{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		document.getElementById("serverContent").innerHTML="<img src='images/loading.gif' alt='loading..'>";
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				document.getElementById("serverContent").innerHTML=xmlhttp.responseText;
			}
		}     
		xmlhttp.open("GET","toggle/setup_server_info.php?productType="+productType,true);
		xmlhttp.send();
	
}
//==============================================================================
function  addMoreProductOnList()
{
    var vendorInfo = document.getElementById("vendorInfo").value;
	if(vendorInfo == "") {alert('Please, Select a vendor.'); return false;}
    var vendor = vendorInfo.split("/");
    var vendorId = vendor[0];
    var vendorName = vendor[1];
	
    var productInfo = document.getElementById("productInfo").value;
    if(productInfo == "") {alert('Please, Select a product.'); return false;}
    var product = productInfo.split("/");
	
	var productType = product[0];
    var productId = product[1];
    var productName = product[2];
    
    addNewRow(vendorName,productType,productName,vendorId,productId);  
}
var testi=0;
function addNewRow(vendorName,productType,productName,vendorId,productId)
{
    var table=document.getElementById("mytb");
    table.style.width=="80%";
    var tb=document.getElementById("mytbd");
    //=========================================================================================
    var r;
    var len=document.getElementById("mytb").rows.length;
    for(r=1;r<len; r++)
    {
        var cell_0 = document.getElementById('mytb').rows[r].cells[0].innerHTML;
        var cell_1 = document.getElementById('mytb').rows[r].cells[1].innerHTML;
        var cell_2 = document.getElementById('mytb').rows[r].cells[2].innerHTML;
        var cell_3 = document.getElementById('mytb').rows[r].cells[3].innerHTML;        
        var cell_4 = document.getElementById('mytb').rows[r].cells[4].innerHTML; 
		
        var allIDs = vendorId+"/"+productId;
        if(cell_4 == allIDs)
            {
            alert("Duplicate-entry # already added in the list.");
            return false;
        }          
    }
    //========================================================================================== 
    if(table.style.visibility=="hidden")		
        {
        table.style.visibility='visible';
        var tr=document.createElement('TR');
        testi++;

        tr.id='tr'+testi+'tr';
        tr.style.backgroundColor = "#EEEEEE"; 
        tb.appendChild(tr);

        //window.alert(td);
        var td1=document.createElement('TD');
        tr.appendChild(td1);
        td1.innerHTML=testi;
        td1.style.border="1px solid #fff";
        td1.style.textAlign = "center";

        var td2=document.createElement('TD');
        tr.appendChild(td2);
        td2.innerHTML=vendorName;
        td2.style.border="1px solid #fff";
        td2.style.paddingLeft="5px";

        var td3=document.createElement('TD');
        tr.appendChild(td3);
        td3.innerHTML=productName; 
        td3.style.border="1px solid #fff";
        td3.style.paddingLeft="5px";

        var td4=document.createElement('TD');
        tr.appendChild(td4);
        td4.innerHTML=productType; 
        td4.style.border="1px solid #fff";
        td4.style.textAlign="center";

       
        var td5=document.createElement('TD');
        tr.appendChild(td5);
        td5.innerHTML=vendorId+"/"+productId;
        td5.style.border="1px solid #fff";
        td5.style.textAlign="center";        

        var td6=document.createElement('TD');
        tr.appendChild(td6);
        td6.style.textAlign = "center";
        td6.style.border="1px solid #fff";
        td6.innerHTML="<img src='images/del3.png' onclick='removeRow(this)' alt='Delete'/>"; 	         

    }
    else if(table.style.visibility=='visible')
        {

        //var tb=document.getElementById("tt");
        var tr=document.createElement('TR');
        testi++;
        //window.alert(tb);
        tr.id='tr'+testi+'tr';
        tb.appendChild(tr);
        tr.style.backgroundColor = "#EEEEEE"; 

        var td1=document.createElement('TD');
        tr.appendChild(td1);
        td1.innerHTML=testi;
        td1.style.border="1px solid #fff";
        td1.style.textAlign = "center";

        var td2=document.createElement('TD');
        tr.appendChild(td2);
        td2.innerHTML=vendorName;
        td2.style.border="1px solid #fff";
        td2.style.paddingLeft="5px";

        var td3=document.createElement('TD');
        tr.appendChild(td3);
        td3.innerHTML=productName; 
        td3.style.border="1px solid #fff";
        td3.style.paddingLeft="5px";

        var td4=document.createElement('TD');
        tr.appendChild(td4);
        td4.innerHTML=productType; 
        td4.style.border="1px solid #fff";
        td4.style.textAlign="center";

       
        var td5=document.createElement('TD');
        tr.appendChild(td5);
        td5.innerHTML=vendorId+"/"+productId;
        td5.style.border="1px solid #fff";
        td5.style.textAlign="center";        

        var td6=document.createElement('TD');
        tr.appendChild(td6);
        td6.style.textAlign = "center";
        td6.style.border="1px solid #fff";
        td6.innerHTML="<img src='images/del3.png' onclick='removeRow(this)' alt='Delete'/>"; 

    }

}
//************ Remove row by click Delete button *********************//
function removeRow(src)
{	   
    //window.alert(src.date);
    var oRow = src.parentNode.parentNode; 
    var tb=document.getElementById("mytbd").deleteRow(oRow.rowIndex);
    testi--;
    /* if(testi==0)
    {
    var table=document.getElementById("mytb");//when all row delete, table invisible.

    table.style.visibility='hidden';

    }   */

}
function saveAssignedProduct()
{    
    var r;      
    var table=document.getElementById("mytb");
    var tb=document.getElementById("mytbd");

    var len = document.getElementById("mytb").rows.length;
    for(r=1; r <len; r++)
    {
        var cell_0 = document.getElementById('mytb').rows[r].cells[0].innerHTML;
        var cell_1 = document.getElementById('mytb').rows[r].cells[1].innerHTML;
        var cell_2 = document.getElementById('mytb').rows[r].cells[2].innerHTML;
        var cell_3 = document.getElementById('mytb').rows[r].cells[3].innerHTML;        
        var cell_4 = document.getElementById('mytb').rows[r].cells[4].innerHTML;        
        

        var myInfo = cell_4.split("/");
        var vendorId = myInfo[0];
        var productId = myInfo[1];
        
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var responseMSG = xmlhttp.responseText;
                window.location = '?module=vendor&page=assign_product';
            }
        }
        xmlhttp.open("GET","toggle/save_product_assigned_info.php?vendorId="+vendorId+"&productId="+productId,true);
        xmlhttp.send();                      
                                                                                             
    }
}
function addProductDataWithTable()
{
  var mainUserId = document.getElementById("mainUserId").value;
  var userInfo = mainUserId.split("/");
  var cusId = userInfo[0];
  var cusName = userInfo[1];
  
  var productInfo = document.getElementById("productInfo").value;
  var proInfo  = productInfo.split("/");
  var proType  = proInfo[0];
  var proId    = proInfo[1];
  var proName  = proInfo[2];
  
  var serverLevel = document.getElementById("serverLevel").value;
  var levelInfo   = serverLevel.split("/");
  var levelId = levelInfo[0];
  var levelName = levelInfo[1];
  
  if(proType == "Server")
  {
    var userId = document.getElementById("userId").value;
	var userInfo = userId.split("/");
	var usrId = userInfo[0];
	var usrName = userInfo[1];
  }
  if(proType == "Dialer")
  {
    var usrId = "Dialer";
    var usrName = document.getElementById("userId").value;
  }
  var userCurrency = document.getElementById("userCurrency").value;
  var currInfo = userCurrency.split("/");
  var currId = currInfo[0];
  var currName = currInfo[1];
  var allId = cusId+"#"+proId+"#"+levelId+"#"+usrId+"#"+currId;
  
  addRowForProinfo(cusName,proName,levelName,usrName,currName,allId);
}
var testi=0;
function addRowForProinfo(cusName,proName,levelName,usrName,currName,allId)
{
    var table=document.getElementById("mytb");
    table.style.width=="80%";
    var tb=document.getElementById("mytbd");
    //=========================================================================================
    var r;
    var len=document.getElementById("mytb").rows.length;
    for(r=1;r<len; r++)
    {
        var cell_0 = document.getElementById('mytb').rows[r].cells[0].innerHTML;
        var cell_1 = document.getElementById('mytb').rows[r].cells[1].innerHTML;
        var cell_2 = document.getElementById('mytb').rows[r].cells[2].innerHTML;
        var cell_3 = document.getElementById('mytb').rows[r].cells[3].innerHTML;        
        var cell_4 = document.getElementById('mytb').rows[r].cells[4].innerHTML; 
        var cell_5 = document.getElementById('mytb').rows[r].cells[5].innerHTML; 
		
        
        if(cell_5 == allId)
            {
            alert("Duplicate-entry # already added in the list.");
            return false;
        }          
    }
    //========================================================================================== 
    if(table.style.visibility=="hidden")		
        {
        table.style.visibility='visible';
        var tr=document.createElement('TR');
        testi++;

        tr.id='tr'+testi+'tr';
        tr.style.backgroundColor = "#EEEEEE"; 
        tb.appendChild(tr);

        //window.alert(td);
        var td1=document.createElement('TD');
        tr.appendChild(td1);
        td1.innerHTML=testi;
        td1.style.border="1px solid #fff";
        td1.style.textAlign = "center";

        var td2=document.createElement('TD');
        tr.appendChild(td2);
        td2.innerHTML=proName;
        td2.style.border="1px solid #fff";
        td2.style.paddingLeft="5px";

        var td3=document.createElement('TD');
        tr.appendChild(td3);
        td3.innerHTML=levelName; 
        td3.style.border="1px solid #fff";
        td3.style.paddingLeft="5px";

        var td4=document.createElement('TD');
        tr.appendChild(td4);
        td4.innerHTML=usrName; 
        td4.style.border="1px solid #fff";
        td4.style.textAlign="center";

       
        var td5=document.createElement('TD');
        tr.appendChild(td5);
        td5.innerHTML=currName;
        td5.style.border="1px solid #fff";
        td5.style.textAlign="center";
		
		var td51=document.createElement('TD');
        tr.appendChild(td51);
        td51.innerHTML=allId;
        td51.style.border="1px solid #fff";
        td51.style.textAlign="center";        

        var td6=document.createElement('TD');
        tr.appendChild(td6);
        td6.style.textAlign = "center";
        td6.style.border="1px solid #fff";
        td6.innerHTML="<img src='images/del3.png' onclick='removeRow(this)' alt='Delete'/>"; 	         

    }
    else if(table.style.visibility=='visible')
        {

        //var tb=document.getElementById("tt");
        var tr=document.createElement('TR');
        testi++;
        //window.alert(tb);
        tr.id='tr'+testi+'tr';
        tb.appendChild(tr);
        tr.style.backgroundColor = "#EEEEEE"; 

        var td1=document.createElement('TD');
        tr.appendChild(td1);
        td1.innerHTML=testi;
        td1.style.border="1px solid #fff";
        td1.style.textAlign = "center";

		var td2=document.createElement('TD');
        tr.appendChild(td2);
        td2.innerHTML=proName;
        td2.style.border="1px solid #fff";
        td2.style.paddingLeft="5px";

        var td3=document.createElement('TD');
        tr.appendChild(td3);
        td3.innerHTML=levelName; 
        td3.style.border="1px solid #fff";
        td3.style.paddingLeft="5px";

        var td4=document.createElement('TD');
        tr.appendChild(td4);
        td4.innerHTML=usrName; 
        td4.style.border="1px solid #fff";
        td4.style.textAlign="center";
       
        var td5=document.createElement('TD');
        tr.appendChild(td5);
        td5.innerHTML=currName;
        td5.style.border="1px solid #fff";
        td5.style.textAlign="center";
		
		var td51=document.createElement('TD');
        tr.appendChild(td51);
        td51.innerHTML=allId;
        td51.style.border="1px solid #fff";
        td51.style.textAlign="center";

        var td6=document.createElement('TD');
        tr.appendChild(td6);
        td6.style.textAlign = "center";
        td6.style.border="1px solid #fff";
        td6.innerHTML="<img src='images/del3.png' onclick='removeRow(this)' alt='Delete'/>"; 

    }

}
//************ Remove row by click Delete button *********************//
function removeRow(src)
{	   
    //window.alert(src.date);
    var oRow = src.parentNode.parentNode; 
    var tb=document.getElementById("mytbd").deleteRow(oRow.rowIndex);
    testi--;
    /* if(testi==0)
    {
    var table=document.getElementById("mytb");//when all row delete, table invisible.

    table.style.visibility='hidden';

    }   */

}
function saveProductWiseResellerInfo()
{    
    var r;      
    var table=document.getElementById("mytb");
    var tb=document.getElementById("mytbd");

    var len = document.getElementById("mytb").rows.length;
    for(r=1; r <len; r++)
    {
        var cell_0 = document.getElementById('mytb').rows[r].cells[0].innerHTML;
        var cell_1 = document.getElementById('mytb').rows[r].cells[1].innerHTML;
        var cell_2 = document.getElementById('mytb').rows[r].cells[2].innerHTML;
        var cell_3 = document.getElementById('mytb').rows[r].cells[3].innerHTML;        
        var cell_4 = document.getElementById('mytb').rows[r].cells[4].innerHTML;        
        var cell_5 = document.getElementById('mytb').rows[r].cells[5].innerHTML;        
        
        //var allId = cusId+"#"+proId+"#"+levelId+"#"+usrId+"#"+currId;alert(allId);   
               
	    var myInfo  = cell_5.split("#");
        var cusId   = myInfo[0];
        var proId   = myInfo[1];
        var levelId = myInfo[2];
        var usrId   = myInfo[3];
        var currId  = myInfo[4];
        
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
		
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var responseMSG = xmlhttp.responseText;
				alert(responseMSG);
                window.location = "?module=user&page=assign_product";
            }
        } //alert(cell_5);
        xmlhttp.open("GET","toggle/save_product_wise_reseller_info.php?resellerName="+cell_3+"&cusId="+cusId+"&proId="+proId+"&levelId="+levelId+"&usrId="+usrId+"&currId="+currId,true);
        xmlhttp.send();                      
                                                                                             
    }
}
function changeAccess(id)
{
 if(id == 'manual')
 {
  document.getElementById("serverIP").disabled=true;
  document.getElementById("serverIP").value="";
  document.getElementById("dbName").disabled=true;
  document.getElementById("dbName").value="";
  document.getElementById("dbUser").disabled=true;
  document.getElementById("dbUser").value="";
  document.getElementById("dbPassword").disabled=true;
  document.getElementById("dbPassword").value="";
 }
 if(id == 'auto')
 {
  document.getElementById("serverIP").disabled=false;
  document.getElementById("dbName").disabled=false;
  document.getElementById("dbUser").disabled=false;
  document.getElementById("dbPassword").disabled=false;
 }
}
function toggleServerList(id)
{
    if(id=='manual')
	{
		window.location.href = "?module=initialise&page=add_server&access=manual";
	}
	else{
		window.location.href = "?module=initialise&page=add_server";
	}
} 
function toggleBankName(typeId)
{
	var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("showAccDetails").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("showAccDetails").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/show_account_details.php?typeId="+typeId,true);
    xmlhttp.send();
}
function SelecGateways(serverId)
{
	var xmlhttp;
    if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("GatewaysContent").innerHTML="<img src='images/loading.gif' alt='loading..'>";
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("GatewaysContent").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","toggle/show_gateways.php?serverId="+serverId,true);
    xmlhttp.send();
}