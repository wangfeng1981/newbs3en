<?php
	//Create
	$user = new User();
	$user->set('username','user');
	$user->set('password','password');
	$user->create();
	$uid=$user->get('uid');

	//Update
	$user->set('password','newpassword');
	$user->update();

	//Retrieve, Delete, Exists
	$user = new User();
	$user->retrieve($uid);
	if ($user->exists())
	  $user->delete();

	//Retrieve based on other criteria than the PK
	$user = new User();
	$user->retrieve_one("username=?",'erickoh');
	$user->retrieve_one("username=? AND password=? AND status='enabled'",array('erickoh','123456'));

	//Return an array of Model objects
	$user = new User();
	$user_array = $user->retrieve_many("username LIKE ?",'eric%');
	foreach ($user_array as $user)
	  $user->delete();
	  

	//Return selected fields as array
	$user = new User();
	$result_array = $user->select("username,email","username LIKE ?",'eric%');
	print_r($result_array);
?>