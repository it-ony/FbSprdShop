define(["js/core/Application", "js/core/List", "flow", "facebook/FbHelper", "sprd/model/Session"], function (Application, List, flow, FbHelper, Session) {

        var undefined,
            config = {
                EU: {
                    endPoint: "http://api.spreadshirt.net/api/v1",
                    gateway: "../api-eu/v1",
                    apiKey: "2b065dd3-88b7-44a8-87fe-e564ed27f904",
                    secret: "51616615-0bb1-471e-93f5-fe19022049ef"
                },
                NA: {
                    endPoint: "http://api.spreadshirt.com/api/v1",
                    gateway: "../api-na/v1",
                    apiKey: "707cddfb-844e-4a81-b9c9-b78b4df1d2f4",
                    secret: "d9d4d49d-4672-468e-8c39-5dee736938bd"
                }
            };

        return Application.inherit("app.FbInstallerClass", {

            defaults: {
                languages: List,
                platforms: List,
                platform: null,
                session: null,
                isLogin: true,

                pages: List,
                selectedShop: null,

                hasError: false,
                succeed: false
            },

            ctor: function () {
                this.callBase();

                this.$.languages.add(["de"]);
                this.$.platforms.add(["NA", "EU"]);

            },

            start: function (parameter, callback) {

                parameter.platform && this.set("platform", parameter.platform);
                var session = this.$.api.createEntity(Session);
                this.set("session", session);

                var self = this;

                flow()
                    .seq(function (cb) {
                        self.$.i18n.loadLocale(self.$.i18n.$.locale, cb);
                    })
                    .seq(function (cb) {
                        self.$.fb.init({}, cb);
                    })
                    .exec(function (err) {
                        if (err) {
                            callback(err);
                        } else {
                            self.start.baseImplementation.call(self, parameter, callback);
                        }
                    });
            },

            login: function () {
                // configure api
                var self = this,
                    api = this.$.api,
                    session = this.$.session;

                flow()
                    .seq(function (cb) {
                        api.set(config[self.$.platform]);
                        session.login(cb);
                    })
                    .seq(function (cb) {
                        session.$.user.$.shops.fetch({
                            fullData: true
                        }, cb);
                    })
                    .exec(function (err) {
                        if (err) {
                            // TODO: show message
                            console.error(err);
                        } else {
                            self.set('isLogin', false);
                        }
                    });
            },

            install: function () {

                if (!this.$.selectedShop) {
                    return;
                }

                var self = this;

                flow()
                    .seq("xhr", function (cb) {
                        self.$stage.$applicationContext.ajax("ajax.php", {
                            queryParameter: {
                                platform: self.$.platform,
                                shopId: self.$.selectedShop.$.id
                            }
                        }, cb);
                    })
                    .seq(function () {
                        var xhr = this.vars["xhr"];

                        if (xhr.status !== 200) {
                            throw new Error("Got status" + xhr.status);
                        }
                    })
                    .exec(function (err) {
                        self.set('hasError', !!err);

                        if (!err) {
                            window.location = ".";
                        }
                    });

            }
        });
    }
);