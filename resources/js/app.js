import { createApp } from "vue";
import App from "./App.vue";
import { router } from "./router";
import store from "./store";
import VueSession from "vue-session";

import "../css/app.css";

createApp(App).use(router).use(store).mount("#app");
