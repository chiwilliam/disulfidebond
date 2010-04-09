<?php	require_once ("../lib/common/dao/DAO.class.php");	require_once ("../lib/common/Manager.class.php");	require_once ("./Unit.class.php");	/*	 * Manager class of UNIT table	 */	class UnitManager extends Manager {		/**		 * get a Unit instance by primary key		 * @param <string> $unitid		 * @return <Unit> $vo		 */		public function getUnitByID($unitid){			$conn = $this->getConnection();			$dao = new DAO();			$vo = new Unit();			$vo->setUnitid($unitid);			$vo = $dao->queryByPK($vo);			$this->closeConnection($conn);			return $vo;		}		/**		 * get a Unit instance by primary key		 * primary key value in $vo (value object) must not be null		 * @param <Unit> $vo		 * @return <Unit> $vo		 */		public function getUnit($vo){			$conn = $this->getConnection();			$dao = new DAO();			$vo = $dao->queryByPK($vo);			$this->closeConnection($conn);			return $vo;		}		/**		 * get an array of unitid=>Unit map		 * @param <Unit> $vo		 * @return Array<key<string>=>value<Unit>> $voMap		 */		public function getUnitMap($vo){			$conn = $this->getConnection();			$voMap = array();			$dao = new DAO();			$vos = $dao->query($vo);			for($i=0; $i<count($vos); $i++){				$curr_vo = $vos[$i];				$voMap[$curr_vo->getUnitid()] = $curr_vo;			}			$this->closeConnection($conn);			return $voMap;		}		/**		 * get an array of Unit instances		 * query condition is stored in value object		 * @param <Unit> $vo		 * @param <string> $orderby		 * @return Array<Unit>		 */		public function getUnits($vo, $orderby){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->query($vo, $orderby);			$this->closeConnection($conn);			return $vos;		}		/**		 * get an array of Unit instances by where clause		 * @param <Unit> $vo		 * @param <string> $orderby		 * @param <string> $where		 * @return Array<Unit>		 */		public function getUnitsByWhere($vo, $where, $orderby){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->queryByWhere($vo, $where, $orderby);			$this->closeConnection($conn);			return $vos;		}		/**		 * get an array of Unit instances by SQL		 * @param <Unit> $vo		 * @param <string> $sql		 * @return Array<Unit>		 */		public function getUnitsBySQL($vo, $sql){			$conn = $this->getConnection();			$dao = new DAO();			$vos = $dao->queryBySQL($vo, $sql);			$this->closeConnection($conn);			return $vos;		}		/**		 * add a Unit record to database		 * @param <Unit> $vo		 * @return <Unit> $vo - a Unit instance with primary key value		 */		public function addUnit($vo){			$conn = $this->getConnection();			$dao = new DAO();			$vo = $dao->insert($vo);			$this->closeConnection($conn);			return $vo;		}		/**		 * update a Unit record in database		 * primary key value in $vo (value object) must not be null		 * @param <Unit> $vo		 * @return <int> affected row number (0 or 1)		 */		public function updateUnit($vo){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->update($vo);			$this->closeConnection($conn);			return $num;		}		/**		 * update a batch of Unit records in database		 * @param <string> $sql		 * @return <int> affected row number		 */		public function updateUnitBySQL($sql){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->updateBySQL($sql);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a Unit record in database		 * primary key value in $vo (value object) must not be null		 * @param <Unit> $vo		 * @return <int> affected row number (0 or 1)		 */		public function deleteUnit($vo){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->delete($vo);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a batch of Unit records in database		 * @param <Unit> $vo		 * @return <int> affected row number		 */		public function deleteUnits($vo){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->batchDelete($vo);			$this->closeConnection($conn);			return $num;		}		/**		 * delete a batch of Unit records in database		 * @param <string> $sql		 * @return <int> affected row number		 */		public function deleteUnits($sql){			$conn = $this->getConnection();			$dao = new DAO();			$num = $dao->deleteBySQL($sql);			$this->closeConnection($conn);			return $num;		}	}?>