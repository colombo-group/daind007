<?php

/**
 * @category Class Database
 * @description processing operations with DataBase
 * @author Nguyen Duc Dai
 */
	class Database {
		/**
		 * Khởi tạo biến ban đầu trước khi liên kết với cơ sở dữ liệu
		 * @var $_instance = null
		 */
		private static $_instance = null;
		/**
		 * @var $_pdo
		 * @var $_query
		 * @var $_error = false
		 * @var $_results
		 * @var $_count = 0
		 */
		private $_pdo,
				$_query,
				$_error = false,
				$_results,
				$_count = 0;

		/**
		 * Database constructor.
		 * Liên kết cơ sở dữ liệu
		 */
		private function __construct() {
			try {
				$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		/**
		 * @return Database|null
		 */

		public static function getInstance() {
			if (!isset(self::$_instance)) {
				self::$_instance = new Database();
			}
			return self::$_instance;
		}

		/**
		 *
		 * @param $sql biến chứa kết nối database
		 * @param array $paramsass mảng chứa tham số
		 * @return $this biến gọi trong class
		 */
		public function query($sql, $params = array()) {
			$this->_error = false;
			if ($this->_query = $this->_pdo->prepare($sql)) {
				$x = 1;
				if (count($params)) {
					foreach ($params as $param) {
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}

				if ($this->_query->execute()) {
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count	= $this->_query->rowCount();
				} else {
					$this->_error = true;
				}
			}

			return $this;
		}

		/**
		 * Truy vấn database
		 * @param $action biến hành dồng
		 * @param $table biến bảng
		 * @param array $where mảng chứa option điều kiện
		 * @return $this|bool
		 */
		public function action($action, $table, $where = array()) {
			if (count($where) === 3) {	//Allow for no where
				$operators = array('=','>','<','>=','<=','<>');

				$field		= $where[0];
				$operator	= $where[1];
				$value		= $where[2];

				if (in_array($operator, $operators)) {
					$sql = "{$action} FROM {$table} WHERE ${field} {$operator} ?";
					if (!$this->query($sql, array($value))->error()) {
						return $this;
					}
				}
			}
			return false;
		}

		/**
		 * Thực hiện lấy dữ liệu trong bảng 
		 * @param $table tên bảng chọn
		 * @param $where mảng chứa option điều kiện
		 * @return bool|Database
		 */
		public function get($table, $where) {
			return $this->action('SELECT *', $table, $where); //ToDo: Allow for specific SELECT (SELECT username)
		}

		/**
		 * Thực hiện xóa dữ liệu trong bảng
		 * @param $table tên bảng
		 * @param $where mảng chứa option điều kiện
		 * @return bool|Database
		 */

		public function delete($table, $where) {
			return $this->action('DELETE', $table, $where);
		}

		/**
		 * Thực hiện thêm trường dữ liệu 
		 * @param $table tên bảng 
		 * @param array $fields danh sách trường thêm mới
		 * @return bool
		 */
		public function insert($table, $fields = array()) {
			if (count($fields)) {
				$keys 	= array_keys($fields);
				$values = null;
				$x 		= 1;

				foreach ($fields as $field) {
					$values .= '?';
					if ($x<count($fields)) {
						$values .= ', ';
					}
					$x++;
				}

				$sql = "INSERT INTO {$table} (`".implode('`,`', $keys)."`) VALUES({$values})";

				if (!$this->query($sql, $fields)->error()) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Thao tác cập nhật 
		 * @param $table tên bảng
		 * @param $id tên id 
		 * @param array $fields các trường cập nhật 
		 * @return bool
		 */
		public function update($table, $id, $fields = array()) {
			$set 	= '';
			$x		= 1;

			foreach ($fields as $name => $value) {
				$set .= "{$name} = ?";
				if ($x<count($fields)) {
					$set .= ', ';
				}
				$x++;
			}

			$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
			
			if (!$this->query($sql, $fields)->error()) {
				return true;
			}
			return false;
		}

		public function results() {
			return $this->_results;
		}

		public function first() {
			return $this->_results[0];
		}

		public function error() {
			return $this->_error;
		}

		public function count() {
			return $this->_count;
		}
	}
?>