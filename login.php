<?php session_start();

/********************************
	 DATABASE & FUNCTIONS
********************************/
require('config/config.php');
require('model/functions.fn.php');


/********************************
			PROCESS
********************************/

if(isset($_POST['email']) && isset($_POST['password'])){
	if(!empty($_POST['email']) && !empty($_POST['password'])){

		$email = htmlspecialchars($_POST["email"]);
	  $password = htmlspecialchars($_POST["password"]);
	  $request = $db->prepare("SELECT id, is_admin FROM members WHERE email
	    LIKE :email AND password = :password");
	    $request->execute(
	    array(
	      "email" => $email,
	      "password" => $password
	    )
	  );
	  $members = $request->fetchAll();
		if(sizeof($members) > 0){
	    $id_member = $members[0]["id"];
	    $_SESSION["id_member"] = $id_member;

		// TODO

		// Force user connection to access dashboard
		userConnection($db, 'git@initiation.com', 'password');

		header('Location: dashboard.php');

	}else{
		$error = 'Champs requis !';
	}
}

/********************************
			VIEW
********************************/
include 'view/_header.php';
include 'view/login.php';
include 'view/_footer.php';
