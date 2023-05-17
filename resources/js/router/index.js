import { createRouter, createWebHistory } from "vue-router";
import AccueilView from "@/views/AccueilView.vue";
import SuccessView from "@/views/SuccessView.vue";
import NewUserView from "@/views/NewUserView.vue";
import LoginView from "@/views/LoginView.vue";
import CellierView from "@/views/CellierView.vue";
import ModifierUtilView from "@/views/ModifierUtilView.vue";
import AjouterBouteilleView from "@/views/AjouterBouteilleView.vue";
import PageNonTrouveView from "@/views/PageNonTrouveView.vue";
import ModifierBouteilleView from "@/views/ModifierBouteilleView.vue";
import DetailsBouteilleView from "@/views/DetailsBouteilleView.vue";
import ArchiveView from "@/views/ArchiveView.vue";
import ListeAchatsView from "@/views/ListeAchatsView.vue";
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
        meta: {
            requiresAuth: true,
        },
        beforeEnter: logout,
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
    {
        path: "/utilisateur/modifier",
        name: "modifier-utilisateur",
        component: ModifierUtilView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/ajouter-bouteille",
        name: "ajouter-bouteille",
        component: AjouterBouteilleView,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/archives/utilisateur/:utilisateurId",
        name: "archive-bouteille",
        component: ArchiveView,
        meta: {
            requiresAuth: true,
        },
        beforeEnter: (to, from, next) => {
            const utilisateurId = to.params.utilisateurId; // id de l'utilisateur
            if (utilisateurId == store.getters.session.utilisateur_id) {
                // Si l'utilisateur est le même que celui connecté
                next();
            } else {
                // Sinon, on le redirige vers la page d'accueil
                next({ name: "accueil" });
            }
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
        component: DetailsBouteilleView,
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
        path: "/liste-achats/:utilisateurId",
        name: "liste-achats",
        component: ListeAchatsView,
        props: true,
        meta: {
            requiresAuth: true,
        },
        beforeEnter: (to, from, next) => {
            const utilisateurId = to.params.utilisateurId; // id de l'utilisateur
            if (utilisateurId == store.getters.session.utilisateur_id) {
                // Si l'utilisateur est le même que celui connecté
                next();
            } else {
                // Sinon, on le redirige vers la page d'accueil
                next({ name: "accueil" });
            }
        },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: PageNonTrouveView,
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
        const token = localStorage.getItem("jwt-token");
        let utilisateurId = null;
        if (store.getters.session.utilisateur_id) {
            utilisateurId = store.getters.session.utilisateur_id;
        }
        if (!token || !utilisateurId) {
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
    sessionStorage.removeItem("session");

    // Effacer le session state in Vuex
    store.commit("resetSession");

    console.log(store.getters.session);

    // Redirigé vers la page de connexion
    next();
}

export { router };
