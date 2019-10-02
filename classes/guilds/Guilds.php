<?php

    require_once('F:\xampp2\htdocs\dragon-scourge\src/database/database.php');

    class Guilds extends Illuminate\Database\Eloquent\Model
    {
        protected $table = 'guilds';

        public function getAllGuilds() {
            return Guilds::where('active', 1)->orderBy('honor')->get();
        }

        public function getGuild($id) {
            return Guilds::find($id);
        }

        public function users($guid) {
            return Users::where('guild', $guid)->orderBy('guildrank')->get();
        }

        /**
         * Creates the basic homepage for the guild
         *
         * @TODO Cleanup functionality
         *
         * @param $userrow
         * @param $controlrow
         */
        public function home($userrow, $controlrow) {
            if ($userrow["guild"] == 0) {
                err("You are not yet a member of any Guild. Please <a href=\"index.php\">go back</a> and try again.");
            }

            $guild = $this->getGuild($userrow['guild']);

            if ($guild->lastupdate <= (time() - ($controlrow["guildupdate"] * 3600))) {
                $guild = guildupdate();
            }

            switch ($userrow["guildrank"]) {
                case 1:
                    $template = "guild_homelow";
                    break;
                case 2:
                    $template = "guild_homelow";
                    break;
                case 3:
                    $template = "guild_homelow";
                    break;
                case 4:
                    $template = "guild_homemid";
                    break;
                case 5:
                    $template = "guild_homehigh";
                    break;
                default:
                    $template = "guild_homelow";
                    break;
            }

            // Setup Babblebox.
            $pagerow["babblebox"] = "<div class=\"big\"><b>Guild Babblebox</b></div>\n<iframe src=\"index.php?do=babblebox&g=" . $userrow["guild"] . "\" name=\"sbox\" width=\"100%\" height=\"200\" frameborder=\"0\" id=\"bbox\">Your browser does not support inline frames! The Babble Box will not be available until you upgrade to a newer <a href=\"http://www.mozilla.org\" target=\"_new\">browser</a>.</iframe>";

            // Setup Bank.
            $pagerow["bank"] = number_format($guild->bank);

            // Pull memberslist for select box.
            $members = $this->users($guild->id);
            $pagerow["memberselect"] = "<select name=\"charid\" style=\"font: 10px Arial;\">";
            foreach ($members as $a => $b) {
                $pagerow["memberselect"] .= "<option value=\"" . $b["id"] . "\">" . $b["charname"] . " (Rank " . $b["guildrank"] . ")</option>\n";
            }
            $pagerow["memberselect"] .= "</select>";

            // Pull applications for selectbox.
            $gapps = new GuildApplications();
            $apps = $gapps->getGuildApplications($guild->id);

            if ($apps != false) {
                $pagerow["appselect"] = "<select name=\"charid\" style=\"font: 10px Arial;\">";
                foreach ($apps as $a => $b) {
                    $pagerow["appselect"] .= "<option value=\"" . $b["charid"] . "\">" . $b["charname"] . "</option>\n";
                }
                $pagerow["appselect"] .= "</select><br /><input type=\"submit\" name=\"approve\" value=\"Approve\" /> <input type=\"submit\" name=\"deny\" value=\"Deny\" />";
            } else {
                $pagerow["appselect"] = "No new applications.";
            }

            // Set up everything else.
            if (trim($guild["news"]) != "") {
                $pagerow["news"] = nl2br($guild["news"]);
            } else {
                $pagerow["news"] = "No news yet.";
            }

            $title = "[" . $guild->tagline . "] " . $guild->name . " (Honor: " . $guild->honor . ")";
            display($title, parsetemplate(gettemplate($template), $pagerow), true, $userrow['id']);
        }

        public function validateGuildInfo($postInfo) {
            extract($postInfo);

            // Errors.
            $errors = 0;
            $errorlist = "";
            if (preg_match("/[^A-z\ 0-9_\-]/", $name) == 1) {
                $errors++;
                $errorlist .= "Guild names can only contain letters, numbers, spaces and hyphens.<br />";
            } // Thanks to "Carlos Pires" from php.net!
            if (preg_match("/[^A-z\ 0-9_\-]/", $rank1) == 1) {
                $errors++;
                $errorlist .= "Rank 1 can only contain letters, numbers, spaces and hyphens.<br />";
            } // Thanks to "Carlos Pires" from php.net!
            if (preg_match("/[^A-z\ 0-9_\-]/", $rank2) == 1) {
                $errors++;
                $errorlist .= "Rank 2 can only contain letters, numbers, spaces and hyphens.<br />";
            } // Thanks to "Carlos Pires" from php.net!
            if (preg_match("/[^A-z\ 0-9_\-]/", $rank3) == 1) {
                $errors++;
                $errorlist .= "Rank 3 can only contain letters, numbers, spaces and hyphens.<br />";
            } // Thanks to "Carlos Pires" from php.net!
            if (preg_match("/[^A-z\ 0-9_\-]/", $rank4) == 1) {
                $errors++;
                $errorlist .= "Rank 4 can only contain letters, numbers, spaces and hyphens.<br />";
            } // Thanks to "Carlos Pires" from php.net!
            if (preg_match("/[^A-z\ 0-9_\-]/", $rank5) == 1) {
                $errors++;
                $errorlist .= "Rank 5 can only contain letters, numbers, spaces and hyphens.<br />";
            } // Thanks to "Carlos Pires" from php.net!
            if (preg_match("/[^A-z0-9_\-]/", $tagline) == 1) {
                $errors++;
                $errorlist .= "Guild taglines must be alphanumeric.<br />";
            } // Thanks to "Carlos Pires" from php.net!
            if (trim($name) == "") {
                $errors++;
                $errorlist .= "Guild name is required.<br />";
            }
            if (trim($tagline) == "") {
                $errors++;
                $errorlist .= "Tagline is required.<br />";
            }
            if (trim($color1) == "#") {
                $errors++;
                $errorlist .= "Tagline color is required.<br />";
            }
            if (strlen($color1) < 7) {
                $errors++;
                $errorlist .= "Tagline color must be 7 characters long.<br />";
            }
            if (trim($color2) == "#") {
                $errors++;
                $errorlist .= "Name color is required.<br />";
            }
            if (strlen($color2) < 7) {
                $errors++;
                $errorlist .= "Name color must be 7 characters long.<br />";
            }
            if (trim($joincost) == "") {
                $errors++;
                $errorlist .= "Cost to join is required.<br />";
            }
            if (!is_numeric($joincost)) {
                $errors++;
                $errorlist .= "Cost to join must be a number.<br />";
            }
            if (trim($rank1) == "") {
                $errors++;
                $errorlist .= "Rank 1 is required.<br />";
            }
            if (trim($rank2) == "") {
                $errors++;
                $errorlist .= "Rank 2 is required.<br />";
            }
            if (trim($rank3) == "") {
                $errors++;
                $errorlist .= "Rank 3 is required.<br />";
            }
            if (trim($rank4) == "") {
                $errors++;
                $errorlist .= "Rank 4 is required.<br />";
            }
            if (trim($rank5) == "") {
                $errors++;
                $errorlist .= "Rank 5 is required.<br />";
            }

            return ['errors' => $errors, 'errorList' => $errorlist];
        }
    }
