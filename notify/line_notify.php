<?php
	// ในส่วนนี้คือโค้ดการทำงานให้ส่งข้อควมผ่านไลน์
    function line_notify ($username, $price_value, $slip) {
        ini_set('display_errors', 1);
	    ini_set('display_startup_errors', 1);
	    error_reporting(E_ALL);
	    date_default_timezone_set("Asia/Bangkok");
    
		
	    $sToken = "KT9T9s6ozniDMhbpCBvY5JIVR6iMUx1NBsn9Vx9P53m"; // ในส่วนนี้คือ การเอา Token ของไลน์
	    $sMessage = " ได้ทำรายการชำระเงินโปรดตรวจสอบ"; // ในส่วนนี้คือ ข้อความที่จะส่ง

		// ในส่วนนี้คือ จะคำนวณตาม ค่า ว่า เป็น พัน หมื่น แสน ล้าน
		if ($price_value >= 1000000) {
            $User = 'User : ' . $username . ':     ราคา ' . $price_value/1000000 . 'ล้าน บาท';
        }
        elseif ($price_value >= 100000) {
            $User = 'User : ' . $username . ':     ราคา ' . $price_value/100000 . 'แสน บาท';
        }
        elseif ($price_value >= 10000) {
            $User = 'User : ' . $username . ':     ราคา ' . $price_value/10000 . 'หมื่น บาท';
        }
        elseif ($price_value >= 1000) {
            $User = 'User : ' . $username . ':     ราคา ' . $price_value/1000 . 'พัน บาท';
        }
		else {
			$User = 'User : ' . $username . ':     ราคา ' . $price_value . ' บาท';
		}
    
        // ในส่วนนี้คือ การเอาภาพที่ได้จากการอัพโหลด คือในส่วนนี้ จะส่งเข้าไปในไลน์
		$imageFile = new CURLFile($slip);
		$data = array(
			'message' => $User . $sMessage,
			'imageFile' => $imageFile
		);

        
	    
	    $chOne = curl_init(); 
	    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	    curl_setopt( $chOne, CURLOPT_POST, 1); 
	    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $data); 
	    $headers = array( 'Content-type: multipart/form-data', 'Authorization: Bearer '.$sToken.'', );
	    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	    $result = curl_exec( $chOne ); 
    
	    //Result error 
	    if(curl_error($chOne)) 
	    { 
	    	echo 'error:' . curl_error($chOne); 
	    } 
	    else { 
	    	$result_ = json_decode($result, true); 
	    	echo "status : ".$result_['status']; echo "message : ". $result_['message'];
	    } 
	    curl_close( $chOne );
    }

?>