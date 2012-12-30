<?php
if (!defined("INDEX") || !isset($tab)) {
    header('HTTP/1.1 403 Forbidden');
    die();
}


$page = $tab->getPage();
$page->fetch();
$version = getVersion();

function getVersion() {
    $versions = parse_ini_file('shop/versions.txt');

    if ($versions) {
        return $versions["main"];
    }

    return null;
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <!--
    Created with rAppid.js - a declarative RIA MVC JS Framework developed by Tony Findeisen and Marcus Krejpowicz
    Visit http://rappidjs.com for more Information.
    -->
    <title>Spreadshirt</title>

    <link rel="stylesheet" href="shop/<?php echo $version; ?>/app/css/bootstrap.min.css"/>
    <link rel="stylesheet"
          href="shop/<?php echo $version; ?>/app/css/bootstrap-responsive.css"/>
    <link rel="stylesheet" href="shop/<?php echo $version; ?>/app/css/style.css"/>

    <script type="text/javascript" src="shop/<?php echo $version; ?>/js/lib/require.js"
            data-usage="lib"></script>
    <script type="text/javascript" src="shop/<?php echo $version; ?>/app/SprdShop.js"
            data-usage="lib"></script>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="fragment" content="!">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
<script type="text/javascript" data-usage="bootstrap">
    rAppid.bootStrap("app/SprdShop.xml", document.body, {
        shopId: "<?php echo $page->getShopId(); ?>",
        platform: "<?php echo $page->getPlatform(); ?>",
        gateway: "<?php echo $GLOBALS["WWW"]["gateway"][$page->getPlatform()]; ?>"
    }, {
        baseUrl: "shop/<?php echo $version; ?>",
        loadConfiguration: "config.json"
    });
</script>
</body>
</html>