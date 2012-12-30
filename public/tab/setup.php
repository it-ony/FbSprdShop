<?php
if (!defined("INDEX")) {
    die();
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

    <link rel="stylesheet" href="installer/app/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="installer/app/css/installer.css"/>

    <script type="text/javascript" src="installer/js/lib/require.js"
            data-usage="lib"></script>
    <script type="text/javascript" src="installer/js/lib/rAppid.js"
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
    rAppid.bootStrap("app/FbInstaller.xml", document.body, {
        language: "<?php echo $user->getLanguage(); ?>",
        platform: "<?php echo $user->getRegion(); ?>",
        pageId: "<?php echo $tab->getPage()->getId(); ?>"
    }, {
        baseUrl: "installer",
        loadConfiguration: "config.json"
    });
</script>
</body>
</html>