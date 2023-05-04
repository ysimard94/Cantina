import { createStore } from "vuex";

const store = createStore({
    state: {
        isLoading: false,
        session: JSON.parse(sessionStorage.getItem("session")) || {},
        cellierFiltreValeurs: {},
        cellierActif: { id: 0, nom: "Aucun cellier" },
    },
    mutations: {
        setLoading(state, value) {
            state.isLoading = value;
        },
        setCellierActif(state, value) {
            state.cellierActif = value;
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
        setCellierActif({ commit }, key, value) {
            commit("setCellierActif", key, value);
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
        cellierActif: (state) => state.cellierActif,
    },
});

export default store;
