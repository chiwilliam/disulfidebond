<?php	require_once ("../lib/common/dao/VO.class.php");	class Item extends VO {		private $categoryVO;		private $itemid;		private $categoryid;		private $guid;		private $username;		private $createdate;		public function setCategory($categoryVO){			$this->categoryVO=$categoryVO;		}		public function getCategory(){			return $this->categoryVO;		}		public function setItemid($itemid){			$this->itemid=$itemid;		}		public function getItemid(){			return $this->itemid;		}		public function setCategoryid($categoryid){			$this->categoryid=$categoryid;		}		public function getCategoryid(){			return $this->categoryid;		}		public function setGuid($guid){			$this->guid=$guid;		}		public function getGuid(){			return $this->guid;		}		public function setUsername($username){			$this->username=$username;		}		public function getUsername(){			return $this->username;		}		public function setCreatedate($createdate){			$this->createdate=$createdate;		}		public function getCreatedate(){			return $this->createdate;		}		public function __toString(){			return "itemid=".$this->itemid.", categoryid=".$this->categoryid."(".$this->categoryVO.")".", guid=".$this->guid.", username=".$this->username.", createdate=".$this->createdate;		}	}?>