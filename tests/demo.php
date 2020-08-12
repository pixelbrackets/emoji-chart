<?php

require __DIR__ . '/../vendor/autoload.php';

$emojiChart = new \Pixelbrackets\EmojiChart\EmojiChart();

echo PHP_EOL . '*List*' . PHP_EOL;
$emojis = $emojiChart->getEmojis();
foreach ($emojis as $emoji) {
    echo 'Emoji: ' . $emoji['character'] . ' Category: ' . $emoji['category'] . ' Name: ' . $emoji['name'] . PHP_EOL;
}

echo PHP_EOL . '*List grouped by category*' . PHP_EOL;
$emojiGroups = $emojiChart->getEmojisGroupedByCategory();
ksort($emojiGroups);
$categories = $emojiChart->getCategories();
foreach ($emojiGroups as $emojiIndex => $emojiGroup) {
    echo 'Category ' . $emojiIndex . ': ' . $categories[$emojiIndex]['name'] . PHP_EOL;
    foreach ($emojiGroup as $emoji) {
        echo '  Emoji: ' . $emoji['character'] . ' Category: ' . $emoji['category'] . ' Name: ' . $emoji['name'] . PHP_EOL;
    }
}

echo PHP_EOL . '*Single emoji, as JSON data*' . PHP_EOL;
$emoji = \Pixelbrackets\EmojiChart\EmojiChart::getEmoji('rocket');
echo json_encode($emoji, JSON_PRETTY_PRINT);
