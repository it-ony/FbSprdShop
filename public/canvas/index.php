<!DOCTYPE HTML>
<html>
<head>
    <title>Add SprdShop to your page</title>
</head>
<body>
    <div id='fb-root'></div>
    <script src='//connect.facebook.net/en_US/all.js'></script>

    <div id="step1">
        <h1>Install SprdShop to your page</h1>
        <a href="javascript:addToPage();">Add</a>
    </div>

    <div id="step2" style="display: none">
        <h1>Installed on your page.</h1>
    </div>

    <script>

        var appId = "206748646126990";

        FB.init({
            appId: appId,
            status: true,
            cookie: true
        });

        function addToPage() {

            FB.ui({
                method: 'pagetab'
            }, function(response) {

                if (response && response.tabs_added ) {
                    for (var key in response.tabs_added) {
                        if (key in response.tabs_added) {
                            // redirect to page
                            var url = "//www.facebook.com/" + key + "?sk=app_" + appId;

                            document.getElementById("step1").style.display = "none";
                            document.getElementById("step2").style.display = "block";

                            window.open(url, "", "resizable=yes,scrollbars=yes,status=yes", true);

                        }
                    }
                }
            });
        }

    </script>
</body>
</html>