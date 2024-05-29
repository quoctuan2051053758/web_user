<?php
//frontend/controllers/CartController.php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';

class CartController extends Controller
{
	public function add() {
		$id = $_GET['id'];
		$product_model = new Product();
		$product = $product_model->getById($id);
		$cart_item = [
			'name' => $product['title'],
			'price' => $product['price'],
			'avatar' => $product['avatar'],
			'quantity' => 1
		];
		// Logic tạo giỏ hàng
		// Nếu giỏ hàng chưa từng tồn tại
		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'][$id] = $cart_item;
		} else {
			// Sp thêm đã tồn tại trong giỏ
			if (isset($_SESSION['cart'][$id])) {
				$_SESSION['cart'][$id]['quantity']++;
			} else {
				// Sp thêm chưa tồn tại
				$_SESSION['cart'][$id] = $cart_item;
			}
		}
		echo '<pre>';
		print_r($_SESSION['cart']);
		echo '</pre>';
	}

	//frontend/controllers/CartController.php
	public function index() {
		// Xử lý form khi submit Cập nhật lại giá
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		if (isset($_POST['submit'])) {
			foreach ($_SESSION['cart'] AS $id => $cart_item) {
				$_SESSION['cart'][$id]['quantity'] = $_POST[$id];
			}
			$_SESSION['success'] = 'Cập nhật giỏ hàng thành công';
		}

		$this->page_title = 'Giỏ hàng của bạn';
		$this->content =
		$this->render('views/carts/index.php');
		require_once 'views/layouts/main.php';
	}
	public function delete() {
		$id = $_GET['id'];
		unset($_SESSION['cart'][$id]);
		if (empty($_SESSION['cart'])) {
			unset($_SESSION['cart']);
		}
		$_SESSION['success'] = 'Xóa sp khỏi giỏ thành công';
		header('Location: gio-hang-cua-ban.html');
		exit();
	}
}
