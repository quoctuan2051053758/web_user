<?php
require_once 'models/Model.php';
class Order extends Model {
	
	public function insertOrder($fullname, $address, $mobile, $email, $note, $price_total, $payment_status) {
		$sql_insert = "INSERT INTO orders(fullname, address, mobile, email, note, price_total, payment_status)
    VALUES (:fullname, :address, :mobile, :email, :note, :price_total, :payment_status)";
		$obj_insert = $this->connection->prepare($sql_insert);
		$arr_insert = [
			':fullname' => $fullname,
			':address' => $address,
			':mobile' => $mobile,
			':email' => $email,
			':note' => $note,
			':price_total' => $price_total,
			':payment_status' => $payment_status,
		];
		$obj_insert->execute($arr_insert);
		// Trả về id của order vừa mới insert thành công
		$order_id = $this->connection->lastInsertId();
		
		return $order_id;
//    return $obj_insert->execute($arr_insert);
	}
	
	public function updatePaymentStatus($id, $payment_status) {
		$sql_update = "UPDATE orders SET payment_status=:payment_status WHERE id=:id";

		$obj_update = $this->connection->prepare($sql_update);
		$updates = [
			':payment_status' => $payment_status, // 0 - Chưa thanh toán, 1 = Đã thanh toán
			':id' => $id
		];
		return $obj_update->execute($updates);
	}
	
}
