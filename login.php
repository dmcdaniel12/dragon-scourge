<?php // login.php :: Handles user logins and logouts.

//	Dragon Scourge
//
//	Program authors: Jamin Blount
//	Copyright (C) 2007 by renderse7en
//	Script Version 1.0 Beta 5 Build 20

//	You may not distribute this program in any manner, modified or
//	otherwise, without the express, written consent from
//	renderse7en.
//
//	You may make modifications, but only for your own use and
//	within the confines of the Dragon Scourge License Agreement
//	(see our website for that).

    require 'vendor/autoload.php';

    include("lib.php");


if (isset($_GET["do"])) { $do = $_GET["do"]; } else { $do = ""; }

switch($do) {
    case "logout":
        logout();
        break;
    default:
        login();
}

function login() {

    $controlRow = control::getControl(1);

    if (isset($_POST["submit"])) {
        
        // Setup.
        include("config.php");
        extract($_POST);

        // get username info here
        $account = new Account();
        $loggedIn = $account->login($username, $password);

        // Set Cookie.
        $newcookie = $loggedIn->id . " " . $username . " " . md5($loggedIn->password . "--" . $dbsettings["secretword"]);
        
        if (isset($remember)) { $expiretime = time()+31536000; $newcookie .= " 1"; } else { $expiretime = 0; $newcookie .= " 0"; }
        setcookie($controlRow->cookiename, $newcookie, $expiretime, "/", $controlRow->cookiedomain, 0);

        die(header("Location: index.php"));
        
    } else {
        display("Log In", gettemplate("login"), false, 0);
        
    }
    
}

// @TODO Move to Accounts
function logout() {
    
    include("globals.php");
    setcookie($controlrow["cookiename"], "", (time()-3600), "/", $controlrow["cookiedomain"], 0);
    die(header("Location: login.php?do=login"));
}

?>
