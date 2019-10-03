<?php

    require_once('database.php');

    class Babblebox extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'babblebox';
        public $timestamps = false;

        /**
         * Get all babbles
         * @return mixed
         */
        public function getBabbles() {
            return Babblebox::where('guild', 0)->take(30)->get();
        }

        /**
         * Get guild babble
         *
         * @param $guid
         * @return mixed
         */
        public function getGuildBabble($guid) {
            return Babblebox::where('guild', $guid)->take(20)->get();
        }

        /**
         * Adds to babblebox
         *
         * @param $id
         * @param $username
         * @param $babbleText
         */
        public function add($id, $username, $babbleText) {
            $babble = new Babblebox;
            $babble->posttime = date('Y-m-d H:i:s');
            $babble->charid = $id;
            $babble->charname = $username;
            $babble->content = "$babbleText";
            $babble->save();
        }



    }
