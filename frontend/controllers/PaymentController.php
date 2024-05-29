<?php
require_once 'controllers/Controller.php';
require_once 'models/Order.php';
require_once 'models/OrderDetail.php';
require_once 'helpers/Helper.php';

class PaymentController extends Controller
{
	public function index() {
		// Xử lý lưu đơn hàng
		if (isset($_POST['submit'])) {
			$fullname = $_POST['fullname'];
			$mobile = $_POST['mobile'];
			$address = $_POST['address'];
			$email = $_POST['email'];
			$note = $_POST['note'];
			// Validate
			if (empty($this->error)) {
				$order_model = new Order();
				// Mặc định đơn hàng là chưa thanh toán
				$payment_status = 0;
				// Tính tổng giá trị đơn hàng
				$price_total = 0;
				foreach ($_SESSION['cart'] AS $cart_item) {
					$price_total +=
					$cart_item['price'] * $cart_item['quantity'];
				}
				$order_id = $order_model->insertOrder($fullname,
				$address, $mobile, $email, $note, $price_total,
				$payment_status);
				// Lưu tiếp vào bảng order_details: order_id,
				//product_name, product_price, quantity
				foreach ($_SESSION['cart'] AS $cart_item) {
					$detail_model = new OrderDetail();
					$is_insert =
					$detail_model->insert($order_id,
					$cart_item['name'], $cart_item['price'],
					$cart_item['quantity']);
				}
				// Gửi mail xác nhận đơn hàng:
				Helper::sendMail($email, 'Xác nhận đơn hàng',
				'Cảm ơn đã mua hàng, truy cập để xem');
				// Nếu là thanh toán trực tuyến
				if ($_POST['method'] == 0) {
					header('Location: index.php?controller=payment&action=online');
					exit();
				}
				// Xóa session giỏ hàng
//				unset($_SESSION['cart']);
			}
		}
		$this->page_title = 'Trang thanh toán';
		$this->content =
		$this->render('views/payments/index.php');
		require_once 'views/layouts/main.php';
	}

	public function online() {
		if (isset($_POST['submit'])) {
			require_once 'libraries/vnpay_php/vnpay_create_payment.php';
		}
		$view_vnpay = $this->render('libraries/vnpay_php/vnpay_pay.php');
		echo $view_vnpay;
	}
}
