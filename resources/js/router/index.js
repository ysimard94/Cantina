import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import SuccessView from "@/views/SuccessView.vue";
import NewUserView from "@/views/NewUserView.vue";
import store from "@/store";

const routes = [
    {
        path: "/",
        name: "home",
        component: HomeView,
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
