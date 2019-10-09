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
    $users->getUserById($userrow['id']);
    $online = $users->whosOnline();

    // town maps
    $towns = new towns();
    $townMaps = $towns->getWorldMaps($userrow["world"]);
    $userMaps = $users->getOwnedMaps();

    foreach ($userMaps as $userMap) {
        unset($townMaps[$userMap]);
    }

    // remove bought maps

    // End data passed to template

    $page = 'maps.html';
    $pageTitle = 'Buy Maps';

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
            'rested' => isset($rested) ? $rested : false,
            'maps' => $townMaps
        ]
    );
