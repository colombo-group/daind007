<?php

/**
 * @category Class Input
 * @description processing operations with Input
 * @author Nguyen Duc Dai
 */
	class Input {
		/**
		 * xử lý POST và GET
		 * @param string $type
		 * @return bool
		 */
		public static function exists($type = 'post') {
			switch ($type) {
				case 'post':
					return (!empty($_POST)) ? true : false;
					break;
				case 'get':
					return (!empty($_GET)) ? true : false;
					break;
				default:
					return false;
					break;
			}
		}

		/**
		 * lấy dữ liệu của biến 
		 * @param $item ên biến trong POST hoặc GET
		 * @return string
		 */
		public static function get($item) {
			if (isset($_POST[$item])) {
				return $_POST[$item];
			} else if (isset($_GET[$item])) {
				return $_GET[$item];
			}
			return '';
		}
	}
?>