<?php

/**
 * @category Class Cookie
 * @description processing operations with Cookie
 * @author Nguyen Duc Dai
 */
	class Cookie {
		/**
		 * Kiểm tra sự tồn tại của cookie
		 * @param string $name tên của cookie cần kiểm tra
		 * @return bool nếu tồn tại trả về True, nếu không tả về False
		 */
		public static function exists($name) {
			return (isset($_COOKIE[$name])) ? true : false;
		}

		/**
		 * Hàm lấy dữ liệu từ cookie
		 * @param $name tên Cookie cần lấy dữ liệu
		 * @return mixed
		 */
		public static function get($name) {
			return $_COOKIE[$name];
		}

		/**
		 * Thiết lập dữ liệu cho Cookie
		 * @param $name tên cookie
		 * @param $value giá trị của cookie
		 * @param $expiry thời gian tồn tại của cookie
		 * @return bool trả về True khi set xong dữ liệu, nếu không trả về false
		 */

		public static function put($name, $value, $expiry) {
			if (setcookie($name, $value, time()+$expiry, '/')) {
				return true;
			}
			return false;
		}

		/**
		 * Xóa cookie 
		 * @param $name tên của cookie xóa
		 */

		public static function delete($name) {
			self::put($name, '', time()-1);
		}
	}
?>