// store/index.js
import { createStore } from "vuex";
import { validate } from "@/core/validation";

const store = createStore({
    state: {
        isLoading: false,
        formData: {},
        formIndices: {},
        isFormValid: {},
    },
    mutations: {
        incrementFormIndex(state, formName) {
            if (!state.formIndices[formName]) {
                state.formIndices[formName] = 0;
            }
            state.formIndices[formName] += 1;
        },
        decrementFormIndex(state, formName) {
            if (!state.formIndices[formName]) {
                return;
            }
            state.formIndices[formName] -= 1;
        },
        setLoading(state, value) {
            state.isLoading = value;
        },
        setFormValue(state, { formName, key, value }) {
            console.log(state.isFormValid);
            const isValid = validate(key, value);
            if (isValid) {
                if (!state.formData[formName]) {
                    state.formData[formName] = {};
                }
                state.formData[formName][key] = value;
                console.log(Object.keys(state.formData[formName]).length);
                if (
                    Object.keys(state.formData[formName]).length ===
                    state.formIndices[formName]
                ) {
                    state.isFormValid[formName] = true;
                } else {
                    console.log(state.isFormValid);
                    state.isFormValid[formName] = false;
                }
            } else {
                if (state.formData[formName]) {
                    delete state.formData[formName][key];
                }
            }
        },
        addFormKey(state, formName) {
            if (!state.formData[formName]) {
                state.formData[formName] = {};
            }
        },
    },
    actions: {
        setLoading({ commit }, value) {
            commit("setLoading", value);
            if (value) {
                setTimeout(() => {
                    commit("setLoading", false);
                }, 10000); // 10 seconds timeout
            }
        },
    },
    getters: {
        isLoading: (state) => state.isLoading,
        formData: (state) => state.formData,
        formIndices: (state) => state.formIndices,
        isFormValid: (state) => (name) => state.isFormValid[name],
    },
});

export default store;
