<?php

    // Get all babblebox messages here

    require 'vendor/autoload.php';


    include("lib.php");
    include("globals.php");

    global $userrow;

    $babble = new Babblebox();

    echo $babble->getBabbles();


