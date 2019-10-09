<?php

    require_once('database.php');

    class users extends Illuminate\Database\Eloquent\Model
    {

        public $user;
        public $timestamps = false;

        public function getUserById($id) {
            $this->user = users::find($id);
            return $this->user;
        }

        public function getOwnedMaps() {
            return explode(',',$this->user['townslist']);
        }

        public function buyMap() {

        }

        public function whosOnline() {
            $onlineTimestamp = (time()-600);

            $whosOnline = users::where('onlinetime', '>=', $onlineTimestamp)->get();

            return $whosOnline;
        }


        public function restAtInn($id, $innCost) {
            $user = $this->getUserById($id);
            $user->currenthp = $user->maxhp;
            $user->currentmp = $user->maxmp;
            $user->currenttp = $user->maxtp;
            $user->gold = $user->gold - $innCost;
            $user->save();
        }
    }
