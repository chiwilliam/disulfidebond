<?php	require_once ("../lib/common/dao/VO.class.php");	class Domaincontrol extends VO {		private $domainVO;		private $userVO;		private $domainid;		private $userid;		public function setDomain($domainVO){			$this->domainVO=$domainVO;		}		public function getDomain(){			return $this->domainVO;		}		public function setUser($userVO){			$this->userVO=$userVO;		}		public function getUser(){			return $this->userVO;		}		public function setDomainid($domainid){			$this->domainid=$domainid;		}		public function getDomainid(){			return $this->domainid;		}		public function setUserid($userid){			$this->userid=$userid;		}		public function getUserid(){			return $this->userid;		}		public function __toString(){			return "domainid=".$this->domainid."(".$this->domainVO.")".", userid=".$this->userid."(".$this->userVO.")";		}	}?>