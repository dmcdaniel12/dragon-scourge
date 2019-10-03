<?php

    require_once('database.php');

    class Towns extends Illuminate\Database\Eloquent\Model
    {

        protected $table = 'towns';

        public function getWorldMaps($worldId) {
            $towns = Towns::where('world', $worldId)->get();
            return $towns;
        }

        public function getMap($id) {
            return Towns::find($id)->first();
        }

        public function buyMap($id, $userGold = 0){
            $mapInfo = $this->getMap($id);

            if ($userGold < $mapInfo->mapprice) {
                err("You do not have enough gold to buy this map. Please <a href=\"index.php\">go back</a> and try again.");
            }
        }

        public function getTravelToList($ids) {
            $townslist = explode(",", $ids);

            return Towns::whereIn('id', $townslist)->get();

        }

    }
