<?php
include './OrgManager.class.php';

$manager = OrgManager::getInstance();
$orgs = $manager->getRootOrgs();

print ("<br>");
foreach ($orgs as $org) {
    print ($org->toString()." <br>");
}

?>
