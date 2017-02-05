<?php

$template = <<<END
You have Level Points to spend. Different character classes get extra bonuses to certain stats from level points. Your stat bonuses are listed below. Note that any fractions are rounded down, so it's in your best interest to make sure you're getting the most out of your level points.<br /><br />
Class: {{classname}}<br />
Damage Per Strength: {{damageperstrength}}<br />
HP Per Dexterity: {{hpperdexterity}}<br />
MP Per Energy: {{mpperenergy}}<br /><br />
You have <b>{{levelup}} point(s)</b> to spend.<br /><br />
<form action="users.php?do=levelup" method="post">
{{dropdowns}}
<input type="submit" name="submit" value="Submit" />
</form>
END;

?>