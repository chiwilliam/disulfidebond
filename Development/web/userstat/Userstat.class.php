<?php	require_once ("\../lib\\common\\dao\\VO.class.php");	class Userstat extends VO {		private $categoryVO;		private $timedimensionVO;		private $username;		private $categoryid;		private $timeid;		private $statdata;		public function setCategory($categoryVO){			$this->categoryVO=$categoryVO;		}		public function getCategory(){			return $this->categoryVO;		}		public function setTimedimension($timedimensionVO){			$this->timedimensionVO=$timedimensionVO;		}		public function getTimedimension(){			return $this->timedimensionVO;		}		public function setUsername($username){			$this->username=$username;		}		public function getUsername(){			return $this->username;		}		public function setCategoryid($categoryid){			$this->categoryid=$categoryid;		}		public function getCategoryid(){			return $this->categoryid;		}		public function setTimeid($timeid){			$this->timeid=$timeid;		}		public function getTimeid(){			return $this->timeid;		}		public function setStatdata($statdata){			$this->statdata=$statdata;		}		public function getStatdata(){			return $this->statdata;		}		public function __toString(){			return "username=".$this->username.", categoryid=".$this->categoryid."(".$this->categoryVO.")".", timeid=".$this->timeid."(".$this->timedimensionVO.")".", statdata=".$this->statdata;		}	}?>