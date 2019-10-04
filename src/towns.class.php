<?php

    require_once('database.php');

    class towns extends Illuminate\Database\Eloquent\Model
    {

        protected $table = 'towns';

        public function getWorldMaps($worldId) {
            $towns = towns::where('world', $worldId)->get();
            return $towns;
        }

        public function getMap($id) {
            return towns::find($id)->first();
        }

        public function buyMap($id, $userGold = 0){
            $mapInfo = $this->getMap($id);

            if ($userGold < $mapInfo->mapprice) {
                err("You do not have enough gold to buy this map. Please <a href=\"index.php\">go back</a> and try again.");
            }
        }

        public function getTravelToList($ids) {
            $townslist = explode(",", $ids);

            return towns::whereIn('id', $townslist)->get();
        }

        public function getUserTown($world, $lon, $lat) {
            return towns::where('world', $world)->where('longitude', $lon)->where('latitude', $lat)->first();
        }


    }
