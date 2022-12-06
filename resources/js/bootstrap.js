window._ = require("lodash");

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Echo from "laravel-echo";

const token = $(".show-token").val();
window.Echo = new Echo({
    broadcaster: "socket.io",
    host: `${window.location.protocol}//${window.location.hostname}:6001`,
    withCredentials: true,
    auth: {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    },
});
