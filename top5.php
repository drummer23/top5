<?php
/**
 * Created by PhpStorm.
 * User: drummer23
 * Date: 12.10.17
 * Time: 09:41
 */

 // Report simple running errors
 error_reporting(E_ERROR | E_WARNING | E_PARSE);

 $blacklist =
"you but and have yes some how for are not lol can that your just like
this want with the now don when know will too get good its time still one about
she okay see was only need gonna really got from maybe there said sure dont
tell they right talk make back more today say much take did mean feel should
something never then other again him because first had ask try before always
better already let later very after actually call long didnt would then than
told same also many yet who even come cuz find where which doing them change
probably photo";

function WriteLine($msg) {
    print($msg . PHP_EOL);
}


//read input file
$inpFileName = __DIR__ . '/test.txt';

if(array_key_exists(1,$argv)) {
  $inpFileName = $argv[1];
}

$handle = fopen($inpFileName, "r");
$contents = fread($handle, filesize($inpFileName));
fclose($handle);


//remove special chars
$contents = preg_replace ( '/[^a-z0-9 ]/i', ' ', $contents );


//generate wordlist
$wordlist = array();

$tok = strtok($contents, " \n\t");

while ($tok !== false) {

    $tok = strtolower($tok);

    //ignore numbers
    if (is_numeric($tok)) {
      $tok = strtok(" \n\t");
      continue;
    }

    //ignore conjunction/small words
    if (strlen($tok) < 3) {
      $tok = strtok(" \n\t");
      continue;
    }

    //ignore blacklisted words
    if (false !== strpos($blacklist, $tok)) {
      $tok = strtok(" \n\t");
      continue;
    }

    $wordlist[$tok] += 1;
    //WriteLine($tok);

    $tok = strtok(" \n\t");
}

arsort($wordlist);

//Output result
WriteLine('');
WriteLine('Top 5 Used Words');
WriteLine('================');

$index = 0;

foreach ($wordlist as $word => $count) {
    $index++;

    WriteLine(sprintf('%d. %s (%d times)', $index, $word, $count));

    if ($index >= 5) {
      break;
    }
}
WriteLine('');
WriteLine('In the Hunt');
WriteLine('===========');

$index = 0;

foreach ($wordlist as $word => $count) {
    $index++;

    if($index <= 5) {
      continue;
    }

    WriteLine(sprintf('%s (%d times)', $word, $count));

    if ($index >= 40) {
      break;
    }
}
