<?php

    require_once('database.php');

    class world extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'worlds';

        public function getWorld($id) {
            return world::find($id);
        }
    }
