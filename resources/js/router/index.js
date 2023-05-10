import { createRouter, createWebHistory } from "vue-router";
import AccueilView from "@/views/AccueilView.vue";
import SuccessView from "@/views/SuccessView.vue";
import NewUserView from "@/views/NewUserView.vue";
import LoginView from "@/views/LoginView.vue";
import CellierView from "@/views/CellierView.vue";
// import CatalogueView from "@/views/CatalogueView.vue";
import ModifierUtilView from "@/views/ModifierUtilView.vue";
import AjouterBouteilleView from "@/views/AjouterBouteilleView.vue";
import PageNonTrouveView from "@/views/PageNonTrouveView.vue";
import ModifierBouteilleView from "@/views/ModifierBouteilleView.vue";
import BouteilleDetailsView from "@/views/BouteilleDetailsView.vue";

import ResultatView from "@/views/ResultatView.vue";

import store from "@/store";

const routes = [
    {
        path: "/a-propos",
        name: "a-propos",
        component: AccueilView,
        meta: {
            requiresAuth: true,
        },
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
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/utilisateur/créer",
        name: "creer-utilisateur",
        component: NewUserView,
    },
    {
        path: "/celliers",
        name: "mes-celliers",
        component: CellierView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/",
        name: "accueil",
        component: CellierView,
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: "/saq-produits",
        name: "saq-produits",
        component: SuccessView,
    },
    // {
    //     path: "/catalogue",
    //     name: "catalogue.index",
    //     component: CatalogueView,
    //     meta: {
    //         requiresAuth: true,
    //     },
    // },
    {
        path: "/utilisateur/modifier",
        name: "modifier-utilisateur",
        component: ModifierUtilView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/ajouter-bouteille/:cellierId",
        name: "ajouter-bouteille",
        component: AjouterBouteilleView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/modifier-bouteille/:bouteilleId/:cellierId",
        name: "modifier-bouteille",
        component: ModifierBouteilleView,
        meta: {
            requiresAuth: true,
        },
        props: true,
    },
    {
        path: "/bouteilles/:id",
        name: "bouteille-details",
        component: BouteilleDetailsView,
        props: true,
    },
    {
        path: "/resultats/:valeur",
        name: "resultat-recherche",
        component: ResultatView,
        meta: {
            requiresAuth: true,
        },
        props: true,
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: PageNonTrouveView,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL || "/"),
    routes,
});

router.beforeEach((to, from, next) => {
    store.dispatch("setLoading", true);

    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!localStorage.getItem("jwt-token")) {
            next({ name: "connexion" });
        } else {
            next();
        }
    } else {
        next();
    }
});

router.afterEach(() => {
    store.dispatch("setLoading", false);
});

// Effacer le token de session
function logout(to, from, next) {
    console.log("logout");
    // Effacer le token de local storage
    localStorage.removeItem("jwt-token");

    // Effacer le token de session
    store.commit("resetSession");

    // Redirigé vers la page de connexion
    next();
}

export { router };
