<?php	require_once ("../lib/common/dao/VO.class.php");	class Projectorg extends VO {		private $configurationVO;		private $projectVO;		private $organizationVO;		private $configurationid;		private $projectid;		private $organizationid;		public function setConfiguration($configurationVO){			$this->configurationVO=$configurationVO;		}		public function getConfiguration(){			return $this->configurationVO;		}		public function setProject($projectVO){			$this->projectVO=$projectVO;		}		public function getProject(){			return $this->projectVO;		}		public function setOrganization($organizationVO){			$this->organizationVO=$organizationVO;		}		public function getOrganization(){			return $this->organizationVO;		}		public function setConfigurationid($configurationid){			$this->configurationid=$configurationid;		}		public function getConfigurationid(){			return $this->configurationid;		}		public function setProjectid($projectid){			$this->projectid=$projectid;		}		public function getProjectid(){			return $this->projectid;		}		public function setOrganizationid($organizationid){			$this->organizationid=$organizationid;		}		public function getOrganizationid(){			return $this->organizationid;		}		public function __toString(){			return "configurationid=".$this->configurationid."(".$this->configurationVO.")".", projectid=".$this->projectid."(".$this->projectVO.")".", organizationid=".$this->organizationid."(".$this->organizationVO.")";		}	}?>