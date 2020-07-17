import Axios from "axios";
import router from "../router";
import { BaseUrl } from "../../config";

const login = {
  state: () => ({
    userToken: null,
    allData: null,
    status: null,
    error: null,
  }),
  mutations: {
    setUser(state, payload) {
      state.userToken = payload;
    },

    removeUser(state) {
      state.userToken = null;
    },

    setStatus(state, payload) {
      state.status = payload;
    },

    setError(state, payload) {
      state.error = payload;
    },
  },
  actions: {
    signInAction({ commit }, payload) {
      Axios.create({ baseURL: BaseUrl })
        .post("login_check", {
          username: payload.username,
          password: payload.password,
        })
        .then((response) => {
          let x = response.data;
          commit("setUser", x.token);
          commit("setStatus", "success");
          commit("setError", null);
          localStorage.setItem("token", x.token);
          router.push("/");
        })
        .catch((error) => {
          alert(error);
        });
    },
  },

  getters: {
    status(state) {
      return state.status;
    },

    user(state) {
      return state.userToken;
    },

    error(state) {
      return state.error;
    },
  },
};

export default login;
