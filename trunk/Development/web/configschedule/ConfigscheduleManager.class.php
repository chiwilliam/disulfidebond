<?php	require_once ("../lib/common/dao/DAO.class.php");	require_once ("../lib/common/Manager.class.php");	require_once ("Configschedule.class.php");	/*	 * Manager class of CONFIGSCHEDULE table	 */	class ConfigscheduleManager extends Manager {		//hold a single instance of the manager class		protected static $manager;		/**		 * singleton pattern method		 * get the single instance of the manager class		 * @return <OrganizationManager>		 */		public static function getInstance(){			if (!isset(self::$manager)) {				$c = __CLASS__;				self::$manager = new $c;			}			return self::$manager;		}		/**		 * get a Configschedule instance by primary key		 * @param <int> $scheduleid		 * @return <Configschedule> $vo		 */		public function getConfigscheduleByID($scheduleid){			$conn = $this->getConnection();			$dao = new DAO();			$vo = new Configschedule();			$vo->setScheduleid($scheduleid);			$vo = $dao->queryByPK($vo);			$this->closeConnection($conn);			return $vo;		}		/**		 * get a Configschedule instance by primary key		 * primary key value in $vo (value object) must not be null		 * @param <Configschedule> $vo		 * @return <Configschedule> $vo		 */		public function getConfigschedule($vo){			$conn = $this->getConnection();			$dao = new DAO();			$vo = $dao->queryByPK($vo);			$this->closeConnection($conn);			return $vo;		}		/**		 * get an array of scheduleid=>Configschedule map		 * @param <Configschedule> $vo		 * @return Array<key<int>=>value<Configschedule>> $voMap		 */		public function getConfigscheduleMap($vo){			$conn = $this->getConnection();			$voMap = array();			$dao = new DAO();			$vos = $dao->query($vo);			for($i=0; $i<count($vos); $i++){				$curr_vo = $vos[$i];				$voMap[$curr_vo->getScheduleid()] = $curr_vo;			}			$this->closeConnection($conn);			return $voMap;		}		/**		 * get an array of Configschedule instances		 * query condition is stored in value object		 * @param <Configschedule> $vo		 * @param <string> $orderby		 * @return Array<Configschedule>		 */		public function getConfigschedules($vo, $orderby){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->query($vo, $orderby);			$this->closeConnection($conn);			return $vos;		}		/**		 * get an array of Configschedule instances by where clause		 * @param <Configschedule> $vo		 * @param <string> $orderby		 * @param <string> $where		 * @return Array<Configschedule>		 */		public function getConfigschedulesByWhere($vo, $where, $orderby){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->queryByWhere($vo, $where, $orderby);			$this->closeConnection($conn);			return $vos;		}		/**		 * get an array of Configschedule instances by SQL		 * @param <Configschedule> $vo		 * @param <string> $sql		 * @return Array<Configschedule>		 */		public function getConfigschedulesBySQL($vo, $sql){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->queryBySQL($vo, $sql);			$this->closeConnection($conn);			return $vos;		}		/**		 * add a Configschedule record to database		 * @param <Configschedule> $vo		 * @return <Configschedule> $vo - a Configschedule instance with primary key value		 */		public function addConfigschedule($vo){			$conn = $this->getConnection();			$dao = new DAO();			$vo = $dao->insert($vo);			$this->closeConnection($conn);			return $vo;		}		/**		 * update a Configschedule record in database		 * primary key value in $vo (value object) must not be null		 * @param <Configschedule> $vo		 * @return <int> affected row number (0 or 1)		 */		public function updateConfigschedule($vo){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->update($vo);			$this->closeConnection($conn);			return $num;		}		/**		 * update a batch of Configschedule records in database		 * @param <string> $sql		 * @return <int> affected row number		 */		public function updateConfigscheduleBySQL($sql){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->updateBySQL($sql);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a Configschedule record in database		 * primary key value in $vo (value object) must not be null		 * @param <Configschedule> $vo		 * @return <int> affected row number (0 or 1)		 */		public function deleteConfigschedule($vo){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->delete($vo);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a batch of Configschedule records in database		 * @param <Configschedule> $vo		 * @return <int> affected row number		 */		public function deleteConfigschedules($vo){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->batchDelete($vo);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a batch of Configschedule records in database		 * @param <string> $sql		 * @return <int> affected row number		 */		public function deleteConfigschedulesBySQL($sql){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->deleteBySQL($sql);			$this->closeConnection($conn);			return $num;		}	}?>