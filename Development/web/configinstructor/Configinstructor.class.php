<?php	require_once ("../lib/common/dao/VO.class.php");	class Configinstructor extends VO {		private $userVO;		private $configurationVO;		private $userid;		private $configurationid;		public function setUser($userVO){			$this->userVO=$userVO;		}		public function getUser(){			return $this->userVO;		}		public function setConfiguration($configurationVO){			$this->configurationVO=$configurationVO;		}		public function getConfiguration(){			return $this->configurationVO;		}		public function setUserid($userid){			$this->userid=$userid;		}		public function getUserid(){			return $this->userid;		}		public function setConfigurationid($configurationid){			$this->configurationid=$configurationid;		}		public function getConfigurationid(){			return $this->configurationid;		}		public function __toString(){			return "userid=".$this->userid."(".$this->userVO.")".", configurationid=".$this->configurationid."(".$this->configurationVO.")";		}	}?>