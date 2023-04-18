import { createRouter, createWebHistory } from "vue-router";
import AccueilView from "@/views/AccueilView.vue";
import SuccessView from "@/views/SuccessView.vue";
import NewUserView from "@/views/NewUserView.vue";
import LoginView from "@/views/LoginView.vue";
import store from "@/store";

const routes = [
    {
        path: "/",
        name: "accueil",
        component: AccueilView,
    },
    {
        path: "/connexion",
        name: "connexion",
        component: LoginView,
    },
    {
        path: "/nouvutil",
        name: "nouvel-utilisateur",
        component: NewUserView,
    },
    {
        path: "/saq-produits",
        name: "saq-produits",
        component: SuccessView,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL || "/"),
    routes,
});

router.beforeEach((to, from, next) => {
    store.dispatch("setLoading", true);
    next();
});

router.afterEach(() => {
    store.dispatch("setLoading", false);
});

export { router };
