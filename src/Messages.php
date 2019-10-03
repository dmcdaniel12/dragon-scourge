<?php

    require_once('database.php');

    class Messages extends Illuminate\Database\Eloquent\Model
    {

        protected $table = 'messages';

        public function getUserMessages($id, $status = 0) {
            return Messages::where('recipientid', $id)->where('status', $status)->get();
        }

    }
