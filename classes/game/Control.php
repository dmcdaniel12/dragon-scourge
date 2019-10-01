<?php


    require_once('F:\xampp2\htdocs\dragon-scourge\src/database/database.php');

    class Control extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'control';

        public static function getControl($id) {
            return Control::find($id);
        }

    }
