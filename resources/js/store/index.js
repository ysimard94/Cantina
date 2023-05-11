import { createStore } from "vuex";

const store = createStore({
    state: {
        isLoading: false,
        session: JSON.parse(sessionStorage.getItem("session")) || {},
        cellierFiltreValeurs: {},
        archiveFiltreValeurs: {},
        cellierActif: false,
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

        setArchiveFiltreValeurs(state, value) {
            state.archiveFiltreValeurs = value;
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
        setArchiveFiltreValeurs({ commit }, value) {
            commit("setArchiveFiltreValeurs", value);
        },
        resetSession({ commit }) {
            commit("resetSession");
        },
    },
    getters: {
        isLoading: (state) => state.isLoading,
        session: (state) => state.session,
        cellierFiltreValeurs: (state) => state.cellierFiltreValeurs,
        archiveFiltreValeurs: (state) => state.archiveFiltreValeurs,
        cellierActif: (state) => state.cellierActif,
    },
});

export default store;
