<?php

/**
 * @category Class Validate
 * @description processing operations with Validate
 * @author Nguyen Duc Dai
 */
	class Validate {
		/**
		 * Khởi tạo biến
		 * @var bool
		 */
		private $_passed = false,
				$_errors = array(),
				$_db = null;

		/**
		 * Validate constructor.
		 */
		public function __construct() {
			$this->_db = Database::getInstance();
		}

		/**
		 * Kiểm tra dữ liệu vào
		 * @param $source Nguồn cần kiểm tra
		 * @param array $items mảng chứa các option cần kiểm tra
		 * @return $this biến gọi trong class
		 */
		public function check($source, $items = array()) {
			foreach ($items as $item => $rules) {
				foreach ($rules as $rule => $rule_value) {
					$value 	= trim($source[$item]);
					$item 	= escape($item);
					
					if ($rule === 'required' && empty($value)) {
						$this->addError("{$item} is required");	//ToDo: Pick up 'name' value
					} else if (!empty($value)) {
						switch ($rule) {
							case 'min':
								if (strlen($value) < $rule_value) {
									$this->addError("{item} must be a minimum of {$rule_value} characters");
								}
								break;
							case 'max':
								if (strlen($value) > $rule_value) {
									$this->addError("{item} must be no longer than {$rule_value} characters");
								}
								break;
							case 'matches':
								if ($value != $source[$rule_value]) {
									$this->addError("{$rule_value} must match {$item}");
								}
								break;
							case 'unique':
								$check = $this->_db->get($rule_value,array($item, '=' , $value));
								if ($check->count()) {
									$this->addError("{$item} already exists");
								}
								break;
						}
					}
				}
			}

			if (empty($this->_errors)) {
				$this->_passed = true;
			}

			return $this;
		}

		/**
		 * Thao tác thêm lỗi
		 * @param $error Lỗi
		 */

		private function addError($error) {
			$this->_errors[] = $error;
		}

		/**
		 * Lấy các lỗi 
		 * @return bool
		 */
		public function errors() {
			return $this->_errors;
		}

		/**
		 * Kiểm tra vi phạm l
		 * @return bool 
		 */
		public function passed() {
			return $this->_passed;
		}
	}
?>