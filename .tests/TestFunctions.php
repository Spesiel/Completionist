<?php namespace Completionist\Tests;

class Functions
{
    public static function run($title, $list, $quiet = false)
    {
        $result = true;
        $assertResults = array();

        // Performs each test
        foreach ($list as $assert) {
            $assertion = ($assert[1]===$assert[2]);
            $result = ($result && $assertion);
            $assertResults[] = array($assert[0], $assertion);
        }

        // Building the output
        $html = "<details>".
                    "<summary>$title: ".(
                        $result? "&#9989;" : "&#10060;"
                    )."</summary>";
        // For each test
        foreach ($assertResults as $value) {
            $html .= $value[0].": ".(
                $value[1]? "&#9989;" : "&#10060;"
            )."<br/>";
        }
        $html .= "</details>";

        // Output to page
        if (!$quiet) {
            printf($html);
        }
    }
}
