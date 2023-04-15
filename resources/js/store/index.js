import { createStore } from "vuex";

const store = createStore({
    state: {
        isLoading: false,
        formData: {},
    },
    mutations: {
        setLoading(state, value) {
            state.isLoading = value;
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
    },
    getters: {
        isLoading: (state) => state.isLoading,
    },
});

export default store;
