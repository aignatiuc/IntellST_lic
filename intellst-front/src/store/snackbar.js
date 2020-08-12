const snackbar = {
  namespaced: true,
  state: () => ({
    showSnack: false,
    snackMessage: "",
    snackType: "",
  }),

  mutations: {
    setSnack(state, snack) {
      state.showSnack = snack;
    },
    setMessage(state, message) {
      state.snackMessage = message;
    },
    setType(state, type) {
      state.snackType = type;
    },
  },

  actions: {
    showSnack({ commit }, { message, type }) {
      commit("setMessage", message);
      commit("setType", type);
      commit("setSnack", true);
    },
    hideSnack({ commit }) {
      commit("setSnack", false);
    },
  },
};

export default snackbar;
