<?php	require_once ("\../lib\\common\\dao\\VO.class.php");	class Menu extends VO {		private $menuid;		private $parentid;		private $serialindex;		private $menutype;		private $menuname;		private $menutext;		private $url;		public function setMenuid($menuid){			$this->menuid=$menuid;		}		public function getMenuid(){			return $this->menuid;		}		public function setParentid($parentid){			$this->parentid=$parentid;		}		public function getParentid(){			return $this->parentid;		}		public function setSerialindex($serialindex){			$this->serialindex=$serialindex;		}		public function getSerialindex(){			return $this->serialindex;		}		public function setMenutype($menutype){			$this->menutype=$menutype;		}		public function getMenutype(){			return $this->menutype;		}		public function setMenuname($menuname){			$this->menuname=$menuname;		}		public function getMenuname(){			return $this->menuname;		}		public function setMenutext($menutext){			$this->menutext=$menutext;		}		public function getMenutext(){			return $this->menutext;		}		public function setUrl($url){			$this->url=$url;		}		public function getUrl(){			return $this->url;		}		public function __toString(){			return "menuid=".$this->menuid.", parentid=".$this->parentid.", serialindex=".$this->serialindex.", menutype=".$this->menutype.", menuname=".$this->menuname.", menutext=".$this->menutext.", url=".$this->url;		}	}?>