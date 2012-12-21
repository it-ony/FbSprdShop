define(['require', 'js/ui/View', "underscore"], function (require, View, _) {

    return View.inherit('facebook.Sdk', {

        defaults: {

            $tagName: "div",
            id: "fb-root",

            appId: null,
            channelUrl: null,
            status: true,
            cookie: true,
            xfbml: true,

            debug: false,

            initialisationCompleteCallback: null
        },

        init: function(data, callback) {

            callback = callback || function(){};

            var self = this;

            if (this.runsInBrowser()) {

                var initFacebook = function (data) {

                    var FB = self.$stage.$window['FB'];

                    FB.init(_.defaults({}, data, {
                        appId: self.$.appId,
                        channelUrl: self.$.channelUrl,
                        status: self.$.status,
                        cookie: self.$.cookie,
                        xfbml: self.$.xfbml
                    }));

                    callback();
                };

                if (this.$loadError) {
                    callback(this.$loadError);
                } else if (this.$loaded) {
                    initFacebook(data);
                } else {
                    this.$fbLoadComplete = function(err) {

                        if (err) {
                            callback(err);
                        } else {
                            initFacebook(data);
                        }
                    }
                }
            } else {
                callback();
            }

        },

        initialize: function () {

            var self = this;

            if (!this.$.appId) {
                this.log("AppId not defined.", "warn");
            }

            if (this.runsInBrowser()) {

                var window = this.$stage.$window;

                // only initialize facebook if we run inside a browser

                var url = "//connect.facebook.net/en_US/all";
                if (this.$.debug) {
                    url += "/debug"
                }

                url += ".js";

                require([url], function () {
                    self.$loaded = true;
                    self.$fbLoadComplete && self.$fbLoadComplete();
                }, function(err) {
                    self.$loadError = err;
                    self.$fbLoadComplete && self.$fbLoadComplete(err);
                });
            }

            this.callBase();
        }
    });

});