<pre><?php

$date = date('Y-m-d', strtotime('-8 hour'));
if (false === file_exists("$date.txt")) {
    $domains = file_get_contents('https://www.dns.pl/deleted_domains.txt');
    file_put_contents("$date.txt", $domains);
} else {
    $domains = file_get_contents("$date.txt");
}
$domains = explode("\n", $domains);

$sorted_domains = [];

foreach ($domains as $domain) {
    $domain = trim($domain);
    if (empty($domain)) {
        continue;
    }

    $length = strlen($domain);

    $sorted_domains[$length][] = $domain;
}

foreach ($sorted_domains as $length => $domains) {
    sort($domains);
}
ksort($sorted_domains);

foreach ($sorted_domains as $length => $domains) {
    foreach ($domains as $domain) {
        if (php_sapi_name() === 'cli') {
            echo "$domain\n";
        } else {
            echo "$domain<br>";
        }
    }
}
?></pre>