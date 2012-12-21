define(["js/core/Application", "js/core/List", "flow"], function (Application, List, flow) {

        return Application.inherit({

            defaults: {
                user: null,
                languages: List,
                regions: List,
                region: null
            },

            ctor: function() {
                this.callBase();
                this.$.languages.add(["de"]);
                this.$.regions.add(["na", "eu"]);
            },

            start:function (parameter, callback) {

                parameter.region && this.set("region", parameter.region);

                var self = this;

                flow()
                    .seq(function(cb) {
                        self.$.i18n.loadLocale(self.$.i18n.$.locale, cb);
                    })
                    .seq(function(cb) {
                        self.$.fb.init({}, cb);
                    })
                    .exec(function(err) {
                        if (err) {
                            callback(err);
                        } else {
                            self.start.baseImplementation.call(self, parameter, callback);
                        }
                    });
            },

            login: function() {

            }
        });
    }
);