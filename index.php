<?php

    require 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader(['views']);
    $twig = new \Twig\Environment($loader, [
        'cache' => false,
    ]);

    include("lib.php");
    include("globals.php");

    global $userrow, $townrow, $worldrow;

    // Build the data to be passed to the template
    $messages = new messages();
    $newMessages = $messages->getUserMessages($userrow['id'], 0);

    if (count($newMessages) > 0) {
        $row["unread"] = "(" . count($newMessages) . " new)";
    } else {
        $row["unread"] = "";
    }

    // Location handling.
    if ($userrow["latitude"] < 0) {
        $latitude = ($userrow["latitude"] * -1) . "S";
    } else {
        $latitude = $userrow["latitude"] . "N";
    }

    if ($userrow["longitude"] < 0) {
        $longitude = ($userrow["longitude"] * -1) . "W";
    } else {
        $longitude = $userrow["longitude"] . "E";
    }

    // get travel to towns
    $townsClass = new towns();
    $travel = $townsClass->getTravelToList($userrow['townslist']);

    // Users online
    $users = new users();
    $online = $users->whosOnline();
    // End data passed to template

    if (isset($_GET["do"])) {
        $do = explode(":", $_GET["do"]);
        switch ($do[0]) {

            // Exploring.
            case "explore":
                include("explore.php");
                move();
                break;
            case "travel":
                include("explore.php");
                travel($do[1]);
                break;
            case "quickheal":
                include("explore.php");
                quickheal();
                break;
            case "itemdrop":
                include("explore.php");
                itemdrop();
                break;
            case "humanity":
                include("explore.php");
                botkillah();
                break;
            // Towns.
            case "inn":
                $page = 'inn.html';
                $pageTitle = 'Inn';

                include("town.php");
                $rested = inn();
                break;
            case "maps":
                include("town.php");
                map();
                break;
            case "duel":
                include("town.php");
                duel();
                break;
            case "challenge":
                include("town.php");
                duelchallenge();
                break;
            case "buy":
                include("town.php");
                buy();
                break;
            case "gamble":
                include("town.php");
                gamble();
                break;
            case "bank":
                $page = 'bank.html';
                $pageTitle = 'Bank';
                break;
            case "top10":
                include("town.php");
                halloffame();
                break;
            // Mailbox.
            case "mailbox":
                include("mailbox.php");
                mailbox();
                break;
            case "mailview":
                include("mailbox.php");
                letter();
                break;
            case "maildelete":
                include("mailbox.php");
                maildelete();
                break;
            case "mailnew":
                include("mailbox.php");
                mailnew();
                break;
            case "mailreply":
                include("mailbox.php");
                mailreply();
                break;
            case "mailsent":
                include("mailbox.php");
                outbox();
                break;
            case "mailviewsent":
                include("mailbox.php");
                letterout();
                break;
            // Fights.
            // Guilds.
            case "guilds":
                include("guilds.php");
                guildmain();
                break;
            case "guildhome":
                include("guilds.php");
                guildhome();
                break;
            case "guildcreate":
                include("guilds.php");
                guildcreate();
                break;
            case "guildapp":
                include("guilds.php");
                guildapp();
                break;
            case "guildmembers":
                include("guilds.php");
                guildmembers();
                break;
            case "guildbank":
                include("guilds.php");
                guildbank();
                break;
            case "guildpromote":
                include("guilds.php");
                guildpromote();
                break;
            case "guildremove":
                include("guilds.php");
                guildremove();
                break;
            case "guildapprove":
                include("guilds.php");
                guildapprove();
                break;
            case "guildnews":
                include("guilds.php");
                guildnews();
                break;
            case "guilddisband":
                include("guilds.php");
                guilddisband();
                break;
            case "guildedit":
                include("guilds.php");
                guildedit();
                break;
            case "guildleave":
                include("guilds.php");
                guildleave();
                break;
            case "guildupdate":
                include("guilds.php");
                guildupdate();
                break;
            // Misc.
            case "babblebox":
                include("misc.php");
                babblebox2();
                break;
            case "showmap":
                include("misc.php");
                showmap();
                break;
            case "version":
                include("misc.php");
                version();
                break;
            case "iddqd":
                include("misc.php");
                iddqd();
                break;
            default:
                donothing($twig);

        }
    } else {
        if ($userrow["story"] != "0" && $userrow["storylat"] == $userrow["latitude"] && $userrow["storylon"] == $userrow["longitude"]) {
            die(header("Location: story.php"));
        }
        if ($userrow["currentpvp"] != 0) {
            die(header("Location: pvp.php"));
        }

        if ($userrow["currentaction"] == "In Town") {
            $page = 'town.html';
            $pageTitle = 'In Town';
        }

        if ($userrow["currentaction"] == "Exploring") {
            $page = 'explore.html';
            $pageTitle = 'Exploring';
        }
        if ($userrow["currentaction"] == "Fighting") {
            die(header("Location: fight.php"));
        }
        if ($userrow["currentaction"] == "PVP") {
            die(header("Location: pvp.php"));
        }
    }

    echo $twig->render($page,
        [
            'pagetitle' => $pageTitle,
            'townInfo' => $townrow,
            'worldInfo' => $worldrow,
            'unread' => $row['unread'],
            'userinfo' => $userrow,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'travelTo' => $travel,
            'online' => $online,
            'rested' => isset($rested) ? $rested : false
        ]
    );
?>
