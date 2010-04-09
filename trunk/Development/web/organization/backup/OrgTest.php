<?php
/**
 * PHP Template.
 */
include './OrgManager.class.php';

// This would fail because the constructor is private
//$test = new OrgManager();

// This will always retrieve a single instance of the class
$test = OrgManager::getInstance();
$test->bark();

// This will issue an E_USER_ERROR.
//$test_clone = clone $test;

?>
