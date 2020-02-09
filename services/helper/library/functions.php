<?php
	ob_start();
    function get_row($col,$table,$whereClause)
    {              
        $is_sel = mysql_query("SELECT $col FROM $table WHERE $whereClause");
        $selArr=mysql_fetch_array($is_sel);
        return $selArr[$col];
    }
   
    function get_current_date_time()
    {
        $offset=6*60*60; //converting 6 hours to seconds. 6 fro BD
        $dateFormat="Y-m-j H:i:s";
        $upload_at = gmdate($dateFormat, time()+$offset);
        return $upload_at;
    }
	function getFormatedDt($dateFormat,$dateNtime){
	//return gmdate($dateFormat, strtotime($dateNtime));
	$date = date_create($dateNtime);
	return date_format($date, $dateFormat);
	}
    function getIp() {

        $ip = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
        {  
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
        { 
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip;
    }
    function getCountryFromIP($ip)
    {        
        $type = "Country"; // take type="Country"; if you want country else take type="City"; 
        $url = "http://www.codetrip.info/iframe/getcountry-city.php?ip=".$ip."&type=".$type;
        $var = file_get_contents($url);
        return $var;
    }
    
    function changeTRbg($i)
    {
        if($i%2==0)
        {
            return $bgc='background-color: #F7F7F9'; 
        }
        else
        {
            return $bgc='background-color: #FFFFFF';
        }
    }
    function getPagination($tbl_name,$where_cond,$currentPage,$limit,$total)
    {
        if($tbl_name != "")
        {
            $total = 0; //echo "SELECT COUNT(*) AS count_data FROM $tbl_name WHERE $where_cond";exit;
            $result = mysql_query("SELECT COUNT(*) AS count_data FROM $tbl_name WHERE $where_cond");
            $total = mysql_result($result, 0, "count_data");   
        }

        $pager  = Pager::getPagerData($total, $limit, $currentPage);
        $ret['total'] = $total;
        $ret['offset'] = $pager->offset;
        $ret['limit']  = $pager->limit;
        $ret['numPages'] = $pager->numPages;
        $ret['page']   = $pager->page;

        return $ret;
    }
    class Pager 
    {
        function getPagerData($numHits, $limit, $page) 
        {
            $numHits = (int) $numHits;
            $limit = max((int) $limit, 1);
            $page = (int) $page;
            $numPages = ceil($numHits / $limit);

            $page = max($page, 1);
            $page = min($page, $numPages);

            $offset = ($page - 1) * $limit;

            $ret = new stdClass;

            $ret->offset = $offset;
            $ret->limit = $limit;
            $ret->numPages = $numPages;
            $ret->page = $page;

            return $ret;
        }
    }
    function paginationOfThePage($pagination,$redirect)
    {
        //print_r($pagination);
        $total =  $pagination['total'];
        $numPages = $pagination['numPages'];
        $page = $pagination['page'];
        $strPag = '';
        if ($total > 0) 
        {
            if ($page == 1) 
            { 

                $strPag .= "<a href='' class='btn btn-default btn-sm'>Prev</a>&nbsp;&nbsp;";
                //$strPag .= "First&nbsp;&nbsp;";

            }
            else 
            {
                $pre = $page - 1;
                $strPag .= "<a href='$redirect=1' class='btn btn-default btn-sm'><i class='fa fa-angle-double-left'></i> &nbsp; First</a>&nbsp;&nbsp;";
                $strPag .= "<a href='$redirect=$pre' class='btn btn-default btn-sm'><i class='fa fa-angle-left'></i> &nbsp; Prev</a>&nbsp;&nbsp;";

            }
            $display = 11;  // how many nnumber shown
            $mid = floor($display/2);
            $restPages = $numPages - $page;
            if($restPages > $display)
            {
                if($page > $mid)
                {
                    $start = $page - $mid;
                    $end = $page + $mid; 
                }
                else
                {
                    $start = 1;
                    $end = $start + ($display-1);  
                }

            }
            else
            {
                if($page > $mid)
                {
                    $start = $page - $mid;
                    $end = $page + $mid;
                    if($end > $numPages)
                    {
                        $end = $numPages;
                    } 
                }
                else
                {
                    $start = 1;
                    $end = $start + ($display-1); 
                    if($end > $numPages)
                    {
                        $end = $numPages;
                    } 
                }                        
            }
            for ($i=$start;$i<=$end;$i++) 
            {
                if ($i != $page) 
                {
                    $strPag .= "<a href='$redirect=$i' class='btn btn-default btn-sm'>$i</a>&nbsp;&nbsp;";                                    
                } 
                else 
                {
                    $strPag .= "<a href='' class='btn btn-primary btn-sm'>" . $i . "</a>" . "&nbsp;&nbsp;";
                }
            }
            if ($page == $numPages) 
            { 
                $strPag .= "<a href='' class='btn btn-default btn-sm'> Next </a>&nbsp;&nbsp;";
                //$strPag .= "Last";
            } 
            else 
            {
                $next = $page + 1;
                $strPag .= "<a href='$redirect=$next' class='btn btn-default btn-sm'>Next &nbsp; <i class='fa fa-angle-right'></i></a>&nbsp;&nbsp;"; 
                $strPag .= "<a href='$redirect=$numPages' class='btn btn-default btn-sm'>Last &nbsp; <i class='fa fa-angle-double-right'></i></a>&nbsp;&nbsp;"; 
            } 
        }
        //echo $strPag;
        return $strPag;
    }
    //////////////////////////////////////////////////////////////////////////////////
    function country_box($sel=""){
        $coun="";
        $country=array("United States","Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antartica","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Botswana","Bouvet Island","Brazil","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde Islands","Cayman Islands","Chad","Chile","China","Christmas Island","Colombia","Comoros","Cook Islands","Costa Rica","Cote d Ivoire","Croatia/Hrvatska","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Ireland","Isle of Man","Israel","Italy", "Jamaica", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte Island", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn Island", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion Island", "Romania", "Russian Federation", "Rwanda", "Saint Helena", "Saint Lucia", "San Marino", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovak Republic", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia", "Spain", "Sri Lanka", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tokelau", "Tonga Islands", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Western Sahara", "Western Samoa", "Yemen", "Yugoslavia", "Zambia","Zimbabwe");
        for($i=0;$i<count($country);$i++)
        {
            if($sel==$country[$i])
                $coun .="<option value='$country[$i]' selected>$country[$i]</option>";
            else
                $coun .="<option value='$country[$i]'>$country[$i]</option>";
        }
        return $coun;
    }    
	/////////////////////////////////////////////////////////////////
	 function safe($str){
        //return $value = mysql_real_escape_string($value);
        
                
        if (get_magic_quotes_gpc()) $str=stripslashes($str);
        
	if (function_exists('mysql_real_escape_string')) {
		return mysql_real_escape_string($str);
	} else return addslashes($str);
    }    
    function insertData($table,$arr)
    {
        $len = count($arr);
        $c=0;
        $columns = '';
        $values = '';
        foreach($arr as $key => $value)
        {            
            if($c++ == ($len-1))
            {
                $columns .= $key;
                $values .= "'".safe($value)."'";
            }
            else
            {
                $columns .=  $key . ",";
                $values .=  "'".safe($value)."'" . ","; 
            }
        }
        $sql = "INSERT INTO $table ($columns) VALUES ($values)"; //echo $sql; exit;
        $result = mysql_query($sql);        
        if($result)
        {
            return 1; 
            exit; 
        } 
        else
        {
            return 0;  
            exit;
        }
	
    } 
	function updateData($table,$arr,$arr_id)
	{
		$len = count($arr);
        $c=0;
        $set = '';
        foreach($arr as $key => $value)
        {            
            if($c++ == ($len-1))
            {
			    $set .=  " $key = " . "'".safe($value)."'";               
            }
            else
            {
			    $set .=  " $key = " . "'".safe($value)."'" . ",";              
            }
        }
		
		$len2 = count($arr_id);
		$k=0;
		$where = '';
		foreach($arr_id as $key => $value)
		{
		   if($k++ == ($len2-1))
            {
			    $where .=  " $key = " . "'".safe($value)."'";               
            }
            else
            {
			    $where .=  " $key = " . "'".safe($value)."'" . " AND";              
            }
		}
        $sql = "UPDATE $table SET $set WHERE $where"; //echo $sql; exit;
        $result = mysql_query($sql);
        if($result)
        {
            return 1; 
            exit; 
        } 
        else
        {
            return 0;  
            exit;
        }
	}
	function deleteAnItem($table,$whereClause)
	{
	    $id = safe($reqId);
		$isRemove = mysql_query("DELETE FROM $table WHERE $whereClause");
		if($isRemove)
        {
            return 1;
            exit;
        }
        else
        {
            return 0;
            exit;
        }
	}
	function selectAllRows($sql){
	    $run = mysql_query($sql); //echo $sql;
        while($row=mysql_fetch_array($run)){
			$arr[] = $row;
        }
	    return $arr;   		
	}
	function numOfExistedData($tbl,$WHERE){
	   $run = mysql_query("SELECT * FROM $tbl WHERE $WHERE");
	   $NUM = mysql_num_rows($run);
	   return $NUM;
	}
	function needExeTime($time_start,$time_end)
	{
		$time = $time_end - $time_start;
		return gmdate("H:i:s", $time);		
	}
	function secToMin($seconds)
	{
	 $min = (int)($seconds/60);
	 $sec = $seconds % 60;
	 return $min.".".$sec;
	}
	function ImageResize($nImage,$tempImage, $width, $height,$destination,$ImageName)
	{
		$extension = explode('.', $nImage);
		$extension = end($extension);
		$extension = strtolower($extension);
		$error = "";
		if (($extension != "jpg") && ($extension != "jpeg") 

			&& ($extension != "png") && ($extension != "gif")) 
		{                                                                   
			$error = 'Unknown Image extension (Only jpg,jpeg,png & gif are accepted)';
			return $error;
		}
		else
		{
			/* Get original file size */
			list($w, $h) = getimagesize($tempImage);
			
			/* Calculate new image size */
			$ratio = max($width/$w, $height/$h);
			$h = ceil($height / $ratio);
			$x = ($w - $width / $ratio) / 2;
			$w = ceil($width / $ratio);
			/* set new file name */
			$imgName = $ImageName.'.'.$extension;
			$path = $destination.$imgName;


			/* Save image */
			if($extension=="jpg" || $extension=='jpeg')
			{
				/* Get binary data from image */
				$imgString = file_get_contents($tempImage);
				/* create image from string */
				$image = imagecreatefromstring($imgString);
				$tmp = imagecreatetruecolor($width, $height);
				imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h);
				imagejpeg($tmp, $path, 100);
			}
			else if($extension=='png')
			{
				$image = imagecreatefrompng($tempImage);
				$tmp = imagecreatetruecolor($width,$height);
				imagealphablending($tmp, false);
				imagesavealpha($tmp, true);
				imagecopyresampled($tmp, $image,0,0,$x,0,$width,$height,$w, $h);
				imagepng($tmp, $path, 0);
			}
			else if($extension=='gif')
			{
				$image = imagecreatefromgif($tempImage);

				$tmp = imagecreatetruecolor($width,$height);
				$transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
				imagefill($tmp, 0, 0, $transparent);
				imagealphablending($tmp, true); 

				imagecopyresampled($tmp, $image,0,0,0,0,$width,$height,$w, $h);
				imagegif($tmp, $path);
			}
			else
			{
				return "error:".$error;
			}

			return "success:".$path;
			imagedestroy($image);
			imagedestroy($tmp);
		}
	}	
	function sentEmail($to,$subject,$message){
		$to      = 'nobody@example.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: info@eaccountbook.com' . "\r\n" .
			'Reply-To: no-reply' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
	}
	function getTotalSum($sql)
	{
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		return $row['totalSum'];
	}
	function get2DegRoundNumber($n){
		return sprintf("%.2f",$n);
	}
    //ob_flush();   
?>