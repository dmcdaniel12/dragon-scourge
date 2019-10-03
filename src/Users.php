<?php

    require_once('database.php');

    class Users extends Illuminate\Database\Eloquent\Model
    {

        public $user;

        public function getUserById($id) {
            $this->user = Users::find($id);
            return $this->user;
        }

        public function getMaps() {

        }

        public function buyMap() {

        }

        public function whosOnline() {
            $onlineTimestamp = (time()-600);

            $whosOnline = Users::where('onlinetime', '>=', $onlineTimestamp)->get();

            return $whosOnline;
        }
    }
