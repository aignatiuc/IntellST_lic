import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import vuetify from "./plugins/vuetify";
import store from "./store";
import "./assets/main.scss";
import i18n from "./plugins/i18n";
import FlagIcon from "vue-flag-icon";

Vue.config.productionTip = false;
Vue.use(FlagIcon);

new Vue({
  router,
  vuetify,
  i18n,
  store,
  render: (h) => h(App),
}).$mount("#app");
