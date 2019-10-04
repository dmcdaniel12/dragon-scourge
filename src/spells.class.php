<?php

    require_once('database.php');

    class spells extends Illuminate\Database\Eloquent\Model
    {

        protected $table = 'spells';

        public function getAllSpells() {
            return spells::all();
        }

    }
