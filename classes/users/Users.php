<?php

    require_once('F:\xampp2\htdocs\dragon-scourge\src/database/database.php');

    class Users extends Illuminate\Database\Eloquent\Model
    {

        public $user;

        public function getUserById($id) {
            $this->user = Users::find($id);
            return $this->user;
        }

        public function getMaps() {

        }

        public function BuyMap() {

        }
    }
