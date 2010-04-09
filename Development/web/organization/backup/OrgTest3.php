<?php
include './OrgManager.class.php';

$manager = OrgManager::getInstance();
$orgs = $manager->getOrgs(10);

print ("<br>");
foreach ($orgs as $org) {
    print ($org." <br>");
}

$org = $orgs[0];
$orgname = $org->__call("getOrgname");
print ("before orgname = ".$orgname."<br>");

$org->__call("setOrgname", array("abc"));

$orgname = $org->__call("getOrgname");
print ("after orgname = ".$orgname."<br>");
?>
