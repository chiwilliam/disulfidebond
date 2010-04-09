<?php        require_once (dirname(__FILE__)."/../lib/common/dao/SearchDAO.class.php");	require_once (dirname(__FILE__)."/../lib/common/dao/DAO.class.php");	require_once (dirname(__FILE__)."/../lib/common/Manager.class.php");	require_once (dirname(__FILE__)."/./Userorgaccesscontrol.class.php");	/*	 * Manager class of USERORGACCESSCONTROL table	 */	class UserorgaccesscontrolManager extends Manager {		//hold a single instance of the manager class		protected static $manager;		/**		 * singleton pattern method		 * get the single instance of the manager class		 * @return <OrganizationManager>		 */		public static function getInstance(){			if (!isset(self::$manager)) {				$c = __CLASS__;				self::$manager = new $c;			}			return self::$manager;		}		/**		 * get an array of Userorgaccesscontrol instances		 * query condition is stored in value object		 * @param <Userorgaccesscontrol> $vo		 * @param <string> $orderby		 * @return Array<Userorgaccesscontrol>		 */		public function getUserorgaccesscontrols($vo, $orderby){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->query($vo, $orderby);			$this->closeConnection($conn);			return $vos;		}		/**		 * get an array of Userorgaccesscontrol instances by where clause		 * @param <Userorgaccesscontrol> $vo		 * @param <string> $orderby		 * @param <string> $where		 * @return Array<Userorgaccesscontrol>		 */		public function getUserorgaccesscontrolsByWhere($vo, $where, $orderby){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->queryByWhere($vo, $where, $orderby);			$this->closeConnection($conn);			return $vos;		}		/**		 * get an array of Userorgaccesscontrol instances by SQL		 * @param <Userorgaccesscontrol> $vo		 * @param <string> $sql		 * @return Array<Userorgaccesscontrol>		 */		public function getUserorgaccesscontrolsBySQL($vo, $sql){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->queryBySQL($vo, $sql);			$this->closeConnection($conn);			return $vos;		}		/**		 * add a Userorgaccesscontrol record to database		 * @param <Userorgaccesscontrol> $vo		 * @return <Userorgaccesscontrol> $vo		 */		public function addUserorgaccesscontrol($vo){			$conn = $this->getConnection();			$dao = new DAO();			$vo = $dao->insert($vo);			$this->closeConnection($conn);			return $vo;		}		/**		 * update a batch of Userorgaccesscontrol records in database		 * @param <string> $sql		 * @return <int> affected row number		 */		public function updateUserorgaccesscontrolBySQL($sql){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->updateBySQL($sql);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a batch of Userorgaccesscontrol records in database		 * @param <Userorgaccesscontrol> $vo		 * @return <int> affected row number		 */		public function deleteUserorgaccesscontrols($vo){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->batchDelete($vo);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a batch of Userorgaccesscontrol records in database		 * @param <string> $sql		 * @return <int> affected row number		 */		public function deleteUserorgaccesscontrolsBySQL($sql){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->deleteBySQL($sql);			$this->closeConnection($conn);			return $num;		}	}?>