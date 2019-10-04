<?php

    require_once('database.php');

    class messages extends Illuminate\Database\Eloquent\Model
    {

        protected $table = 'messages';

        public function getUserMessages($id, $status = 0) {
            return messages::where('recipientid', $id)->where('status', $status)->get();
        }

    }
