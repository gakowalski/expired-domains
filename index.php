<form>
    <input id="date" type="date" name="date" value="<?php echo $_GET['date'] ?? date('Y-m-d', strtotime('-30 day')); ?>">
    <input type="submit" value="Submit">
    <input type="button" onclick="document.getElementById('date').value=''" value="Clear">
</form>
<pre><?php

$config = [
    'domains_folder' => 'domains',
    'deleted_domains_txt' => 'https://www.dns.pl/deleted_domains.txt',
    'domain_check_url' => 'https://seohost.pl/domeny/szukaj?q=',
];

if ($_GET['date'] === null) {
    $date = date('Y-m-d', strtotime('-8 hour'));
    $current_output_file = $config['domains_folder'] . '/' . $date . '.txt';

    if (false === file_exists($current_output_file)) {
        $domains = file_get_contents($config['deleted_domains_txt']);
        file_put_contents($current_output_file, $domains);
    } else {
        $domains = file_get_contents($current_output_file);
    }
} else {
    $date = $_GET['date'];
    $current_output_file = $config['domains_folder'] . '/' . $date . '.txt';

    if (false === file_exists($current_output_file)) {
        $domains = [];
    } else {
        $domains = file_get_contents($current_output_file);
    }
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
            echo "<a href='{$config['domain_check_url']}$domain' target='_blank'>$domain</a><br>";
        }
    }
}
?></pre>