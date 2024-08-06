<?php
require_once __DIR__ . '/config/init.php';
$Template = realpath(__DIR__ . '/templates/' . TEMPLATE);
$request_uri = getURL();
$request_path = $request_uri;
$ADS_NETWORK = 'DEFAULT';
if ($Ads = $db->where('ads_url', $request_path)->getOne('adschanger', 'ads_network')) {
    if ($Ads['ads_network'] != 'OFF') {
        $ADS_NETWORK = $Ads['ads_network'];
    }
} else {
    $ADS_NETWORK = DEFAULT_ADS;
}
$AppProtocol = (APP_HTTPS == 1) ? 'https://' : 'http://';
$endRoute  = '';
$AdsPath = __DIR__ . '/templates/ads/' . $ADS_NETWORK;

$categoryExp = '/\/category\/([a-z0-9-]+)' . $endRoute . '$/'; // category Expression
$catExp_page = '/\/category\/([0-9]+)\/([a-z0-9-]+)' . $endRoute . '$/';

$starExp = '/\/star\/([a-z0-9-]+)' . $endRoute . '$/i';
$starExp_page = '/star\/([0-9]+)\/([a-z0-9-]+)' . $endRoute . '$/';

$genreExp = '/\/genre\/([a-z0-9-]+)' . $endRoute . '$/';
$genreExp_page = '/\/genre\/([0-9]+)\/([a-z0-9-]+)' . $endRoute . '$/';

$directorExp = '/\/director\/([a-z0-9-]+)' . $endRoute . '$/';
$directorExp_page = '/\/director\/([0-9]+)\/([a-z0-9-]+)' . $endRoute . '$/';

$allcollectionlist = '/\/(genres|directors|stars)\/([0-9]+)\/([a-z0-9-]+)' . $endRoute . '$/';

$fileExp = '/\/movie\/([a-z0-9-]+)' . $endRoute . '$/';
$downloadPageExp = "/\/download\/([a-z0-9-]+)$/"; // Download Page Lang Code;
$searchPageExp = "/\/search\/list$/"; // Download Page Lang Code;
$PageExp = "/\/page\/([a-z0-9-]+)$/"; // Page Lang Code;

$speExp_page = '/\/movies\/([0-9]+)\/([a-z0-9-]+)' . $endRoute . '$/';
$homeExp = '/' . BASE_URL . '$/i';
$output= array();
$output2 = array();
if (preg_match($homeExp, $request_path, $output)) {
    require __DIR__ . '/controller/Home.php';
} else if (preg_match($categoryExp, $request_path, $output) || preg_match($catExp_page, $request_path, $output2)) {
    require __DIR__ . '/controller/Category.php';
} else if (preg_match($fileExp, $request_path, $output)) {
    require __DIR__ . '/controller/File.php';
} else if (preg_match($starExp, $request_path, $output) || preg_match($starExp_page, $request_path, $output2)) {
    require __DIR__ . '/controller/Star.php';
} 
else if (preg_match($genreExp, $request_path, $output) || preg_match($genreExp_page, $request_path, $output2)) {
    require __DIR__ . '/controller/Genre.php';
} 
else if (preg_match($directorExp, $request_path, $output) || preg_match($directorExp_page, $request_path, $output2)) {
    require __DIR__ . '/controller/Director.php';
}
else if (preg_match($speExp_page, $request_path, $output)) {
    require __DIR__ . '/controller/AllMovies.php';
}
else if (preg_match($allcollectionlist, $request_path, $output)) {
    require __DIR__ . '/controller/AllCollection.php';
}
else if (preg_match($searchPageExp, $request_path, $output)) {
    require __DIR__ . '/controller/Search.php';
} else if (preg_match($downloadPageExp, $request_path, $output)) {
    require __DIR__ . '/controller/DownloadFile.php';
} else if (preg_match($PageExp, $request_path, $output)) {
    require __DIR__ . '/controller/Page.php';
} else {
    if (ERROR_PAGE == true) {
        require __DIR__ . '/controller/ErrorPage.php';
    } else {
        Redirect(APP_URL);
    }
}
$db->disconnect();