<?php


    require_once('database.php');

    class control extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'control';
        public $timestamps = false;

        public static function getControl($id) {
            return control::find($id);
        }

    }
