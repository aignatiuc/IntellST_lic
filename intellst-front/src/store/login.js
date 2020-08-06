import Axios from "axios";
import router from "../router";

const login = {
  namespaced: true,
  state: () => ({
    userToken: null,
    allData: null,
    status: null,
    error: null,
    userData: null,
  }),
  mutations: {
    setToken(state, payload) {
      state.userToken = payload;
    },

    removeToken(state) {
      state.userToken = null;
    },

    setStatus(state, payload) {
      state.status = payload;
    },

    setError(state, payload) {
      state.error = payload;
    },

    setUser(state, payload) {
      state.userData = payload;
    },

    removeUser(state) {
      state.userData = null;
    },
  },
  actions: {
    signInAction({ commit, dispatch }, payload) {
      Axios.create({ baseURL: process.env.VUE_APP_BASE_API })
        .post("login_check", {
          username: payload.username,
          password: payload.password,
        })
        .then(({ data: { token } }) => {
          commit("setToken", token);
          commit("setStatus", "success");

          localStorage.setItem("token", token);
          dispatch("getUserInfo");
          router.push("/");
          dispatch(
            "snackbar/showSnack",
            {
              message: "You've succesfully logged in!",
              type: "success",
            },
            { root: true }
          );
        })
        .catch((e) => {
          commit("setError", e);
        });
    },
    getUserInfo({ commit, state }) {
      commit("setToken", localStorage.getItem("token"));

      Axios.get(`${process.env.VUE_APP_BASE_API}/api/user`, {
        headers: { Authorization: `Bearer ${state.userToken}` },
      })
        .then(({ data }) => {
          commit("setUser", { ...data[0] });
        })
        .catch(() => {
          localStorage.removeItem("token");
          router.push("/login");
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
