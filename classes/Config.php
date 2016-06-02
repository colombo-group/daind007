<?php

/**
 * @category Class Config
 * @description: create new Config and handling this Config
 * @author : Nguyen Duc Dai
 */
	class Config {
		/**
		 * @param string $path Tên index lần lượt của giá trị trong mảng config cần lấy ra.
		 * @return string|false Nếu tồn tại index trả về giá trị của nó, nếu không tồn tại trả về là false.
		 */
		public static function get($path = null) {
			if ($path) {
				$config = $GLOBALS['config'];
				/*
				$GLOBALS là biến siêu toàn cục, được sử dụng để truy cập các biến toàn cục từ bất cứ nơi nào trong đoạn mã PHP (bao gồm cả trong hàm và phương thức)
				PHP lưu trữ tất cả các biến toàn cục trong mảng là $GLOBALS[index]. Chỉ số index nắm giữ thông tin tên của biến.
				 */

				$path	= explode('/', $path);
				/*
				 * Tách chuỗi gốc thành nhiều chuỗi con dựa vào dấu '/'
				 */

				foreach ($path as $bit) {
					if (isset($config[$bit])) {
						$config = $config[$bit];
					}
				}

				return $config;
			}
			
			return false;
		}
	}
?>