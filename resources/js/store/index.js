import { createStore } from "vuex";

const store = createStore({
    state: {
        isLoading: false,
        session: JSON.parse(sessionStorage.getItem("session")) || {},
        cellierFiltreValeurs: {},
    },
    mutations: {
        setLoading(state, value) {
            state.isLoading = value;
        },
        setSession(state, { key, value }) {
            state.session[key] = value;
            sessionStorage.setItem("session", JSON.stringify(state.session));
        },
        setCellierFiltreValeurs(state, value) {
            state.cellierFiltreValeurs = value;
        },
        resetSession(state) {
            state.session = {};
            sessionStorage.removeItem("session");
        },
    },
    actions: {
        setLoading({ commit }, value) {
            commit("setLoading", value);
            if (value) {
                setTimeout(() => {
                    commit("setLoading", false);
                }, 90000000);
            }
        },
        setSession({ commit }, key, value) {
            commit("setLoading", key, value);
        },
        setCellierFiltreValeurs({ commit }, value) {
            commit("setCellierFiltreValeurs", value);
        },
        resetSession({ commit }) {
            commit("resetSession");
        },
    },
    getters: {
        isLoading: (state) => state.isLoading,
        session: (state) => state.session,
        cellierFiltreValeurs: (state) => state.cellierFiltreValeurs,
    },
});

export default store;
