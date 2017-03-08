<?php namespace Completionist\Tests;

class Functions
{
    public static function run($title, $list)
    {
        $result = true;
        $assertResults = array();

        // Performs each test
        foreach ($list as $assert) {
            $result = ($result && ($assert[1]===$assert[2]));
            $assertResults[] = array($assert[0], $result);
        }

        // Building the output
        $html = "<hr/><details>".
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
        printf($html);
    }
}
