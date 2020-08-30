<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * Use the great »emoji-data« library to build the chart
 *
 * Source: https://github.com/iamcal/emoji-data
 */

// Prepare input files manually
// http --download --output emoji.json https://raw.githubusercontent.com/iamcal/emoji-data/master/emoji_pretty.json
// http --download --output emoji.json categories.json https://raw.githubusercontent.com/iamcal/emoji-data/master/categories.json

// pretty var_export https://gist.github.com/ajcastro/e906922f737d0aa63dfd05b29bfe2f1d
function var_export_pretty($expression, bool $return = false)
{
    $export = var_export($expression, true);
    $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
    $array = preg_split("/\r\n|\n|\r/", $export);
    $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [null, ']$1', ' => ['], $array);
    $export = implode(PHP_EOL, array_filter(["["] + $array));

    if ($return) {
        return $export;
    }
    echo $export;
}

$categoryDataJson = json_decode(file_get_contents(__DIR__ . '/categories.json'), true);
$categories = [];

$emojiDataJson = json_decode(file_get_contents(__DIR__ . '/emoji.json'), true);
$emoji = [];

// Parse categories
$i = 0;
foreach ($categoryDataJson as $categoryKey => $categoryData) {
    $i++;
    $categories[$i] = [
        'category' => $i,
        'name' => $categoryKey,
    ];
}

file_put_contents(__DIR__ . '/categories.php', var_export_pretty($categories, true));

// Parse emoji

// echo "\u{1F602}"; // outputs 😂
// echo "\u{$variable} // outputs \u{1F602} → use workaround to parse to UTF-8

foreach ($emojiDataJson as $emojiData) {
    $character = shell_exec('php -r \'echo "\u{' . $emojiData['unified'] . '}";\'');

    // ignore invalid UTF-8 conversions
    if ($character === null) {
        continue;
    }

    $emoji[] = [
        'character' => $character,
        'unicode' => $emojiData['unified'],
        'name' => strtolower($emojiData['name']),
        'shortname' => strtolower($emojiData['short_name']),
        'category' => (int) array_search($emojiData['category'], array_column($categories, 'name'), true) + 1
    ];
}

file_put_contents(__DIR__ . '/emoji.php', var_export_pretty($emoji, true));
