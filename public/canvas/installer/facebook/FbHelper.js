define(['js/core/Base', 'flow'], function (Base, flow) {

    var singleton = null,
        FbHelper = Base.inherit({

            ctor: function (FB) {
                this.FB = FB;
            },

            api: function () {

                var args = Array.prototype.slice.call(arguments);
                var callback = args.pop();

                args.push(function (response) {

                    if (response.error) {
                        callback(response.error);
                    } else {
                        callback(null, response);
                    }
                });

                this.FB.api.apply(this, args);
            },

            ui: function () {

                var args = Array.prototype.slice.call(arguments);
                var callback = args.pop();

                args.push(function (response) {

                    if (response.error) {
                        callback(response.error);
                    } else {
                        callback(null, response);
                    }
                });

                this.FB.ui.apply(this, args);
            }

        }, {

            getFB: function () {

                if (!singleton) {
                    singleton = new FbHelper(window['FB']);
                }

                return singleton;
            },

            authenticate: function (options, callback) {

                if (typeof window === "undefined") {
                    callback(new Error("Not in a browser"));
                    return;
                }

                var FB = window['FB'];

                if (!FB) {
                    callback("FB not available");
                } else {

                    FB.getLoginStatus(function (response) {

                        if (response.status !== "connected") {
                            FB.login(function (response) {
                                if (response.authResponse) {
                                    callback(null);
                                } else {
                                    callback("User cancel login");
                                }
                            }, options);
                        } else {
                            callback();
                        }
                    });

                }
            },

            authenticateWithPermissions: function (permissions, callback) {
                permissions = permissions || [];

                var scope = permissions.join(",");

                this.authenticate({
                    scope: scope
                }, function (err) {
                    if (err) {
                        callback(err);
                    } else {
                        // TODO: check permissions:
                        var fb = FbHelper.getFB();
                        flow()
                            .seq("permissions", function (cb) {
                                fb.api("/me/permissions", cb);
                            })
                            .seq(function (cb) {

                                if (!hasAllPermissions(this.vars['permissions'].data[0])) {
                                    // request permissions

                                    fb.ui({
                                        method: "permissions.request",
                                        perms: scope,
                                        display: "popup"
                                    }, function(err, res) {
                                        if (err) {
                                            cb(err);
                                        } else {
                                            if (hasAllPermissions(res.perms.split(","))) {
                                                cb();
                                            } else {
                                                cb("Not all permissions granted");
                                            }
                                        }

                                    });
                                } else {
                                    cb();
                                }

                            })
                            .exec(callback);
                    }
                });

                function hasAllPermissions(userPermissions) {

                    for (var i = 0; i < permissions.length; i++) {
                        if (userPermissions instanceof Array) {
                            if (userPermissions.indexOf(permissions[i]) === -1) {
                                return false;
                            }
                        } else {
                            if (!(permissions[i] in (userPermissions))) {
                                return false;
                            }
                        }

                    }

                    return true;
                }
            },


        });

    return FbHelper;
});