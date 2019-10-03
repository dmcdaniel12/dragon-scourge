<?php

    require_once('database.php');


    class GuildApplications extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'guildapps';


        public function getGuildApplications($guid) {
            return GuildApplications::where('guild', $guid)->get();
        }

        public function getUserGuildApplications($userId) {
            return GuildApplications::where('charid', $userId)->get();
        }

    }
