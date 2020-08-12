import Vue from "vue";
import Vuex from "vuex";
import login from "./login";
import snackbar from "./snackbar";

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    login,
    snackbar,
  },
});

export default store;
