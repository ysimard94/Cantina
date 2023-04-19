import { createRouter, createWebHistory } from "vue-router";
import AccueilView from "@/views/AccueilView.vue";
import SuccessView from "@/views/SuccessView.vue";
import NewUserView from "@/views/NewUserView.vue";
import LoginView from "@/views/LoginView.vue";
import CellierView from "@/views/CellierView.vue";
import CatalogueView from "@/views/CatalogueView.vue";
import AuthDataService from "@/services/AuthDataService";
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
        path: "/deconnexion",
        name: "deconnexion",
        component: LoginView,
        beforeEnter: logout,
    },
    {
        path: "/nouvutil",
        name: "nouvel-utilisateur",
        component: NewUserView,
    },
    {
        path: "/monCellier",
        name: "monCellier",
        component: CellierView,
    },
    {
        path: "/saq-produits",
        name: "saq-produits",
        component: SuccessView,
    },
    {
        path: "/catalogue",
        name: "catalogue.index",
        component: CatalogueView,
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

// Effacer le token de session
function logout(to, from, next) {
    console.log("logout");
    // Effacer le token de local storage
    localStorage.removeItem("authToken");

    // Effacer le token de session
    store.commit("resetSession");

    try {
        const reponse = AuthDataService.deconnecter();
    } catch (error) {
        console.error("Error fetching data:", error);
    } finally {
        console.log("finally");
    }

    // Redirigé vers la page de connexion
    next();
}

export { router };
