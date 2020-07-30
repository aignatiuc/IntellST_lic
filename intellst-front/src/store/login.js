import Axios from "axios";
import router from "../router";

const login = {
  namespaced: true,
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
    signInAction({ commit, dispatch }, payload) {
      Axios.create({ baseURL: process.env.VUE_APP_BASE_API })
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
          dispatch(
            "snackbar/showSnack",
            {
              message: "You've succesfully logged in!",
              type: "error",
            },
            { root: true }
          );
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
