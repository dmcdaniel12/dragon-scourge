<?php

    require_once('F:\xampp2\htdocs\dragon-scourge\src/database/database.php');

    class Users extends Illuminate\Database\Eloquent\Model
    {

        public function getUserById($id) {
            return Users::find($id);
        }
    }
