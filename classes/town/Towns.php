<?php

    require_once('F:\xampp2\htdocs\dragon-scourge\src/database/database.php');

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

    }
