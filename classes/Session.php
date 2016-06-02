<?php

/**
 * @category Class Session
 * @description processing operations with Session
 * @author Nguyen Duc Dai
 */
	class Session {
		/**
		 * kiểm tra sự tồn tại của Sesion
		 * @param $name tên session cần kiểm tra
		 * @return bool nếu tồn tại trả về True không tồn tại trả về False
		 */
		public static function exists($name) {
			return (isset($_SESSION[$name])) ? true : false;
		}

		/**
		 * Set S
		 * @param $nameession tên Session
		 * @param $value giá trị set
		 * @return mixed
		 */

		public static function put($name, $value) {
			return $_SESSION[$name] = $value;
		}

		/**
		 * lấy dữ liệu từ Session
		 * @param $name tên Session
		 * @return mixed
		 */

		public static function get($name) {
			return $_SESSION[$name];
		}

		/**
		 * xóa S
		 * @param $nameession tên Session
		 */

		public static function delete($name) {
			if (self::exists($name)) {
				unset($_SESSION[$name]);
			}
		}

		/**
		 * tạo Session cho flash
		 * @param $name tên session
		 * @param string $string chuỗi 
		 * @return mixed
		 */

		public static function flash($name, $string = '') {
			if (self::exists($name)) {
				$session = self::get($name);
				self::delete($name);
				return $session;
			} else {
				self::put($name, $string);
			}
		}
	}	
?>