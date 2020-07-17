import Vue from "vue";
import Axios from "axios";
import { BaseUrl } from "../store/constants";

Vue.use(Axios);
Vue.use({
  install(Vue) {
    Vue.prototype.$api = Axios.create({ baseURL: BaseUrl });
  },
});

export default new Axios({});
