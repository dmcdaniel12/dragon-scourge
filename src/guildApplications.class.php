<?php

    require_once('database.php');


    class guildApplications extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'guildapps';
        public $timestamps = false;

        public function getGuildApplications($guid) {
            return guildApplications::where('guild', $guid)->get();
        }

        public function getUserGuildApplications($userId) {
            return guildApplications::where('charid', $userId)->get();
        }

    }
