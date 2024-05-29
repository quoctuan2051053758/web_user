<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$domain = 'http://localhost/PHP0423E2/Day31_PHP_Hosting_Payment_Online_Mail/project_demo/frontend';

$vnp_TmnCode = "HDKBN41J"; //Mã định danh merchant kết nối (Terminal Id)
$vnp_HashSecret = "BYYWYDIVSDWXBBZRVNHLYNKCWEOCFYYG"; //Secret key
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Payment = "$domain/thanh-toan.html";
$vnp_Returnurl = "$domain/libraries/vnpay_php/vnpay_return.php";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
