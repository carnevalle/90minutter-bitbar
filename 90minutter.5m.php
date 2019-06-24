#!/usr/bin/php

<?php

/*
<bitbar.title>90minutter.dk</bitbar.title>
<bitbar.version>v0.1.0</bitbar.version>
<bitbar.author>Troels Johnsen</bitbar.author>
<bitbar.author.github>carnevalle</bitbar.author.github>
<bitbar.desc>90minutter.dk is a news aggregator for the danish football club Brøndby IF. This plugin shows the latest 15 articles.</bitbar.desc>
<bitbar.image></bitbar.image>
<bitbar.dependencies>php</bitbar.dependencies>
<bitbar.abouturl>https://github.com/carnevalle/90minutter-bitbar</bitbar.abouturl>
*/

/**
 * BitBar display
 */
class BitBar
{
    public function divider()
    {
        echo "---\n";
    }

    public function icon($icon, $text = '')
    {
        if ($text) {
            echo "{$text} ";
        }
        echo "| size=10 templateImage={$icon}\n";
    }

    public function url($text, $href)
    {
        echo "{$text}";
        echo "| href=$href";
        echo "\n";
    }

    public function println($text)
    {
        echo "{$text}";
        echo "\n";
    }

    public function items($items)
    {
        if (empty($items)) {
            return false;
        }

        foreach ($items as $item) {

            if($item->clickcount > 200){
              echo "★ ";
            }

            echo str_replace("|", "-", $item->title);
            echo "| href=$item->forward_url";
            echo "\n";
            echo "$item->timeago - ".$item->provider->name."| size=12";
            echo "\n";
            $this->divider();
        };
    }

    public function refresh()
    {
        echo "Refresh | refresh=true";
        echo "\n";
    }
}

$logo = "AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAABILAAASCwAAAAAAAAAAAAD///8AAAAAAAAAAAAAAAAANxcQQDcXEK83FxD/NxcQ/zcXEP83FxD/NxcQrzcXEEAAAAAAAAAAAAAAAAD///8A////AAAAAAAAAAAANxcQnzcXEP83FxD/NxcQzzcXEK83FxCvNxcQ3zcXEP83FxD/NxcQnwAAAAAAAAAA////AP///wAAAAAANxcQnzcXEP83FxDfNxcQYDcXEJ83FxC/NxcQvzcXEJ83FxBwNxcQ3zcXEP83FxCfAAAAAP///wD///8ANxcQQDcXEP83FxDfNxcQcDcXEP83FxD/NxcQ/zcXEP83FxD/NxcQ/zcXEHA3FxDfNxcQ/zcXEFD///8A////ADcXEK83FxD/NxcQYDcXEP83FxD/NxcQ/zcXEP83FxD/NxcQ/zcXEP83FxD/NxcQcDcXEP83FxCv////AP///wA3FxD/NxcQzzcXEI83FxD/NxcQ/zcXEP83FxD/NxcQ/zcXEP83FxD/NxcQ/zcXEJ83FxDfNxcQ/////wD///8ANxcQ/zcXEK83FxC/NxcQ/zcXEP83FxD/NxcQ/zcXEP83FxD/NxcQ/zcXEP83FxC/NxcQvzcXEP////8A////ADcXEP83FxC/AAAAAAAAAAAAAAAAAAAAAAAAAAA3FxD/NxcQ/zcXEP83FxD/NxcQvzcXEL83FxD/////AP///wA3FxD/NxcQ3wAAAAAAAAAAAAAAAAAAAAAAAAAANxcQ/zcXEP83FxD/NxcQ/zcXEI83FxDfNxcQ/////wD///8ANxcQrzcXEP83FxBgAAAAAAAAAAAAAAAAAAAAADcXEP83FxD/NxcQ/zcXEO83FxCANxcQ/zcXEK////8A////ADcXEDA3FxD/NxcQ7zcXEDAAAAAAAAAAAAAAAAA3FxD/NxcQ/zcXEO83FxBgNxcQ7zcXEP83FxAw////AP///wAAAAAANxcQYDcXEP83FxDvNxcQcDcXEBAAAAAANxcQgDcXEIA3FxCANxcQ7zcXEP83FxBgAAAAAP///wD///8AAAAAAAAAAAA3FxBgNxcQ7zcXEP83FxD/NxcQvzcXEL83FxD/NxcQ/zcXEP83FxBgAAAAAAAAAAD///8A////AAAAAAAAAAAAAAAAADcXEIA3FxCfNxcQvzcXEP83FxD/NxcQvzcXEJ83FxCPAAAAAAAAAAAAAAAA////AP///wAAAAAAAAAAADcXECA3FxD/NxcQ/wAAAAAAAAAAAAAAAAAAAAA3FxDvNxcQ/zcXEEAAAAAAAAAAAP///wD///8AAAAAAAAAAAA3FxBQNxcQ7zcXEJ8AAAAAAAAAAAAAAAAAAAAANxcQgDcXEO83FxBQAAAAAAAAAAD///8A8A8AAOAHAADAAwAAgAEAAIABAACAAQAAgAEAAJ8BAACfAQAAjwEAAIcBAADBAwAA4AcAAPAPAADjxwAA48cAAA==";

$bb = new BitBar();

try {
    $content = file_get_contents('https://90minutter.dk/api/v1/articles');

    if ($content === false) {
      $bb->icon($logo);
      $bb->divider();
      $bb->println("¯\_(ツ)_/¯");
      $bb->println("Something went wrong");
      $bb->divider();
      $bb->refresh();
      $bb->url("90minutter.dk", "https://90minutter.dk");
    }

    $items = json_decode($content)->data;

    $items = array_slice($items, 0, 15);

    $bb->icon($logo, $items[0]->timeago);
    $bb->divider();
    $bb->items($items);
    $bb->divider();
    $bb->refresh();
    $bb->url("90minutter.dk", "https://90minutter.dk");

} catch (Exception $e) {

    $bb->icon($logo);
    $bb->divider();
    $bb->println("¯\_(ツ)_/¯");
    $bb->println("No connection to 90minutter.dk");
    $bb->divider();
    $bb->refresh();
    $bb->url("90minutter.dk", "https://90minutter.dk");
}
