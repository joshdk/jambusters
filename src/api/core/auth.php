<?php
session_start();


	class auth{
		private $db;
		private $name;
		private $id;


		public function __construct(){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/api/core/config.inc.php');
			$this->db=new PDO(
				'mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['db'],
				$config['user'],
				$config['pass']
			);
		}


		private function salt($length=32){
			$letters=str_split('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789');
			$salt='';
			for($n=0;$n<$length;$n++){
				$salt.=$letters[array_rand($letters,1)];
			}
			return $salt;
		}


		public function name(){
			if(!isset($this->name)){
				return NULL;
			}
			return $this->name;
		}


		public function id(){
			if(!isset($this->id)){
				return NULL;
			}
			return $this->id;
		}


		public function register($user, $pass){
			$res=$this->db->prepare(
				'INSERT INTO `users` '.
				'(`name`, `hash`, `salt`) '.
				'VALUES '.
				'(?, ?, ?);'
			);
			$salt=$this->salt();
			$hash=hash('sha512', $salt.$pass);
			$res->execute(array($user, $hash, $salt));
			return $res->rowCount()==1;
		}


		public function login($user, $pass){
			$res=$this->db->prepare('SELECT * FROM `users` WHERE `name` = ?;');
			$res->execute(array($user));
			$row=$res->fetch(PDO::FETCH_ASSOC);

			if(hash('sha512', $row['salt'].$pass) == $row['hash']){
				$this->name=$user;
				$this->id=$row['user_id'];
				$_SESSION['authenticated']=true;
				$_SESSION['user_id']=$row['user_id'];
				$_SESSION['name']=$row['name'];
				return true;
			}
			return false;
		}


		public function logout(){
			//var_dump($_SESSION);
			session_unset();
			unset($this->name);
			unset($this->id);
			return true;
		}


		public function is_login(){
			if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true){
				return true;
			}
			return false;
		}


	}


?>
