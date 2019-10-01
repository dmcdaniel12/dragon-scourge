<?php

    require_once('F:\xampp2\htdocs\dragon-scourge\src/database/database.php');

    class Account extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'accounts';

        public function login($username, $password) {
            $user = Account::where('username', $username)
                ->where('password', md5($password)) // Password
                ->first();

            if (!$user) {
                err("Invalid username or password. Please <a href=\"index.php\">go back</a> and try again.", false, false);
            }

            if ($user->verifycode != 1) {
                err("You have not yet verified your account. Please click the link found in your Account Verification email before continuing. 
                If you never received the email, please check your spam filter settings or contact the game administrator for further assistance.",
                    false, false);
            }

            return $user;

        }

    }
