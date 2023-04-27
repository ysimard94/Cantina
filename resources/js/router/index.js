import { createRouter, createWebHistory } from "vue-router";
import AccueilView from "@/views/AccueilView.vue";
import SuccessView from "@/views/SuccessView.vue";
import NewUserView from "@/views/NewUserView.vue";
import LoginView from "@/views/LoginView.vue";
import CellierView from "@/views/CellierView.vue";
import CatalogueView from "@/views/CatalogueView.vue";
import ModifierUtilView from "@/views/ModifierUtilView.vue";
import AjouterBouteilleView from "@/views/AjouterBouteilleView.vue";
import PageNonTrouveView from "@/views/PageNonTrouveView.vue";
import ModifierBouteilleView from "@/views/ModifierBouteilleView.vue";
import ModifierCellierView from "@/views/ModifierCellierView.vue";
import AjouterCellierView from "@/views/AjouterCellierView.vue"
import store from "@/store";

const routes = [
    {
        path: "/",
        name: "accueil",
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
        name: "nouvel-utilisateur",
        component: NewUserView,
    },
    {
        path: "/celliers",
        name: "monCellier",
        component: CellierView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/ajouter-cellier",
        name: "ajouter-cellier",
        component: AjouterCellierView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/modifier-cellier/:id",
        name: "modifier-cellier",
        component: ModifierCellierView,
        meta: {
            requiresAuth: true,
        },
        props: true,
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
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/modifier/:id",
        name: "modifierUtil",
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
        path: "/modifier-bouteille/:id",
        name: "modifier-bouteille",
        component: ModifierBouteilleView,
        meta: {
            requiresAuth: true,
        },
        props: true,
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
