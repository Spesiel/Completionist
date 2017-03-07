<?php namespace Completionist\Tests;

class Functions
{
    public static $assertResults;

    public static function assertion($expected, $value, $message = "", $quiet = true)
    {
        $result = ($expected === $value);

        // Output required?
        if (!$quiet && (!empty($message) || !$result)) {
            printf("$message: ".($result? "&#9989;":"&#10060;")."<br/>");
        }

        return $result;
    }

    public static function assertions($list, $quiet = true)
    {
        $result = true;

        $assertResults = array();
        foreach ($list as $assert) {
            switch (count($assert)) {
                case 2:
                    $result = ($result && self::assertion($assert[0], $assert[1], "", false));
                    break;
                case 3:
                    $result = ($result && self::assertion($assert[1], $assert[2], $assert[0]));
                    if (!empty($assert[0]) || !$result) {
                        printf($assert[0].": ".($result? "&#9989;":"&#10060;")."<br/>");
                    }
                    break;
            }
        }

        if (!$quiet) {
            $result? printf("&#9989; Passed") : printf("&#10060; Failed");
        }
    }
}
