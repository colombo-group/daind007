<?php

/**
 * @category Class Token
 * @description processing operations with Token
 * @author Nguyen Duc Dai
 */
	class Token {
		/**
		 * @return mixed
		 */
		public static function generate() {
			return Session::put(Config::get('session/tokenName'), md5(uniqid()));
		}

		/**
		 * Kiểm tra token
		 * @param $token giá trị token 
		 * @return bool
		 */

		public static function check($token) {
			$tokenName = Config::get('session/tokenName');

			if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
				Session::delete($tokenName);
				return true;
			} else {
				return false;
			}
		}
	}
?>