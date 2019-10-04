<?php // globals.php :: Storage for lots of super important arrays we're probably going to need eventually.

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

    // Config.php.

    // Control row.
    $control = new Control();
    $controlrow = $control->getControl(1);

    // Account row.
    include("cookies.php");
    $acctrow = checkcookies();
    if ($acctrow == false && substr($_SERVER["REQUEST_URI"], -21) != "users.php?do=register") {
        die(header("Location: login.php?do=login"));
    }
    if ($acctrow != false && $acctrow["characters"] == 0 && substr($_SERVER["REQUEST_URI"],
            -20) != "users.php?do=charnew") {
        die(header("Location: users.php?do=charnew"));
    }

    // User row.
    if (substr($_SERVER["REQUEST_URI"], -19) != "login.php?do=logout") {
        $online = doquery("UPDATE users SET onlinetime=NOW() WHERE id='" . $acctrow["activechar"] . "' LIMIT 1");
    } else {
        $online = doquery("UPDATE users SET onlinetime = DATE_SUB(onlinetime, INTERVAL 11 MINUTE) WHERE id='" . $acctrow["activechar"] . "' LIMIT 1");
    }

    $user = new Users();
    $userrow = $user->getUserById($acctrow["activechar"]);

    // World row.
    $world = new World();
    $worldrow = $world->getWorld($userrow["world"]);

    // Town row.
    if ($userrow["currentaction"] == "In Town") {
        $town = new towns();
        $townrow = $town->getUserTown($userrow["world"], $userrow["longitude"], $userrow["latitude"]);
    } else {
        $townrow = false;
    }

    // Spells.
    $s = new Spells();
    $spells = $s->getAllSpells();

    // Global fightrow.
    $fightrow = [
        "playerphysdamage" => 0,
        "playermagicdamage" => 0,
        "playerfiredamage" => 0,
        "playerlightdamage" => 0,
        "monsterphysdamage" => 0,
        "monstermagicdamage" => 0,
        "monsterfiredamage" => 0,
        "monsterlightdamage" => 0,
        "track" => "",
        "message" => ""
    ];

?>
