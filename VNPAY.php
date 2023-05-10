<?php
require_once("config.php"); 
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
$vnp_TmnCode = "W6G1T0A9";//Mã website tại VNPAY 
$vnp_HashSecret = "AWFAOWWAXDYWZFATFWRQYCPXMIMQNPLY"; //Chuỗi bí mật

$vnp_TxnRef = rand(00,9999); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
$vnp_OrderInfo = 'Noi Dung Thanh Toan';
$vnp_OrderType = 'billpayment';
$vnp_Amount = $_SESSION['total_price'] * 100000;
$vnp_Locale = 'vn';
$vnp_BankCode = 'NCB';
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
//Add Params of 2.0.1 Version
// $vnp_ExpireDate = $_POST['txtexpire'];
//Billing

$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef
    
    // "vnp_ExpireDate"=>$vnp_ExpireDate,
    // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
    // "vnp_Bill_Email"=>$vnp_Bill_Email,
    // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
    // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
    // "vnp_Bill_Address"=>$vnp_Bill_Address,
    // "vnp_Bill_City"=>$vnp_Bill_City,
    // "vnp_Bill_Country"=>$vnp_Bill_Country,
    // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
    // "vnp_Inv_Email"=>$vnp_Inv_Email,
    // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
    // "vnp_Inv_Address"=>$vnp_Inv_Address,
    // "vnp_Inv_Company"=>$vnp_Inv_Company,
    // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
    // "vnp_Inv_Type"=>$vnp_Inv_Type
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}
// if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
//     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
// }

//var_dump($inputData);
ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
$returnData = array('code' => '00'
    , 'message' => 'success'
    , 'data' => $vnp_Url);
    // if (isset($_POST['pay_type'])) {
        header('Location: ' . $vnp_Url);
        die();
    // } else {
    //     echo 1;
    // }