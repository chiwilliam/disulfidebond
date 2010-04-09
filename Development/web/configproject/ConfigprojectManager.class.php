<?php	require_once ("../lib/common/dao/DAO.class.php");	require_once ("../lib/common/Manager.class.php");	require_once ("Configproject.class.php");	/*	 * Manager class of CONFIGPROJECT table	 */	class ConfigprojectManager extends Manager {		//hold a single instance of the manager class		protected static $manager;		/**		 * singleton pattern method		 * get the single instance of the manager class		 * @return <OrganizationManager>		 */		public static function getInstance(){			if (!isset(self::$manager)) {				$c = __CLASS__;				self::$manager = new $c;			}			return self::$manager;		}		/**		 * get an array of Configproject instances		 * query condition is stored in value object		 * @param <Configproject> $vo		 * @param <string> $orderby		 * @return Array<Configproject>		 */		public function getConfigprojects($vo, $orderby){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->query($vo, $orderby);			$this->closeConnection($conn);			return $vos;		}		/**		 * get an array of Configproject instances by where clause		 * @param <Configproject> $vo		 * @param <string> $orderby		 * @param <string> $where		 * @return Array<Configproject>		 */		public function getConfigprojectsByWhere($vo, $where, $orderby){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->queryByWhere($vo, $where, $orderby);			$this->closeConnection($conn);			return $vos;		}		/**		 * get an array of Configproject instances by SQL		 * @param <Configproject> $vo		 * @param <string> $sql		 * @return Array<Configproject>		 */		public function getConfigprojectsBySQL($vo, $sql){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->queryBySQL($vo, $sql);			$this->closeConnection($conn);			return $vos;		}		/**		 * add a Configproject record to database		 * @param <Configproject> $vo		 * @return <Configproject> $vo		 */		public function addConfigproject($vo){			$conn = $this->getConnection();			$dao = new DAO();			$vo = $dao->insert($vo);			$this->closeConnection($conn);			return $vo;		}		/**		 * update a batch of Configproject records in database		 * @param <string> $sql		 * @return <int> affected row number		 */		public function updateConfigprojectBySQL($sql){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->updateBySQL($sql);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a batch of Configproject records in database		 * @param <Configproject> $vo		 * @return <int> affected row number		 */		public function deleteConfigprojects($vo){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->batchDelete($vo);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a batch of Configproject records in database		 * @param <string> $sql		 * @return <int> affected row number		 */		public function deleteConfigprojectsBySQL($sql){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->deleteBySQL($sql);			$this->closeConnection($conn);			return $num;		}	}?>