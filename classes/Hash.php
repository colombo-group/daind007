<?php

/**
 * @category Class HashH
 * @description processing operations with Hash 
 * @author Nguyen Duc Dai
 */
	class Hash {
		/**
		 * xử lý chuỗi nhập vào
		 * @param $string chuỗi nhập vào 
		 * @param string $salt muối cần thêm 
		 * @return string
		 */
		public static function make($string, $salt = '') {
			return hash('sha256', $string.$salt);
		}

		/**
		 * tạo muối 
		 * @param $length độ dài của chuỗi muối 
		 * @return string
		 */
		public static function salt($length) {
			return mcrypt_create_iv($length);
		}

		/**
		 * @return string
		 */
		public static function unique() {
			return self::make(uniqid());
		}
	}
?>