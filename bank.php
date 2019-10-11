<?php

    require 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader(['views']);
    $twig = new \Twig\Environment($loader, [
        'cache' => false,
    ]);

    include("lib.php");
    include("globals.php");

    global $userrow, $townrow, $worldrow;

    $users = new users();
    $userinfo = $users->getUserById($userrow['id']);
    $messages = new messages();
    $townsClass = new towns();

    if ($_POST) {
        $users->saveBank($_POST['amount'], $_POST['type']);
    }

    // Build the data to be passed to the template
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
    $travel = $townsClass->getTravelToList($userrow['townslist']);

    // Users online
    $online = $users->whosOnline();

    // town maps
    $townMaps = $townsClass->getWorldMaps($userrow["world"]);

    // Bank information

    // End data passed to template

    $page = 'bank.html';
    $pageTitle = 'Bank';

    echo $twig->render($page,
        [
            'pagetitle' => $pageTitle,
            'townInfo' => $townrow,
            'worldInfo' => $worldrow,
            'unread' => $row['unread'],
            'userinfo' => $userinfo,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'travelTo' => $travel,
            'online' => $online,
            'rested' => isset($rested) ? $rested : false
        ]
    );
