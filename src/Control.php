<?php


    require_once('database.php');

    class Control extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'control';

        public static function getControl($id) {
            return Control::find($id);
        }

    }
