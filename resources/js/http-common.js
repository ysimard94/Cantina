import axios from "axios";
import { router } from "@/router/index";

const apiClient = axios.create({
    baseURL: "http://localhost:8000/api",
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
    },
});

apiClient.interceptors.request.use(
    (config) => {
        // Récupération du token dans le localStorage
        const token = localStorage.getItem("jwt-token");

        // Si le token existe, on l'ajoute dans les headers de la requête
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        // On retourne la configuration de la requête
        return config;
    },
    (error) => {
        // En cas d'erreur lors de la requête, on rejette la promesse avec l'erreur
        return Promise.reject(error);
    }
);

apiClient.interceptors.response.use(
    (response) => {
        // Si la réponse est réussie, on n'a rien à faire. On retourne simplement la réponse.
        return response;
    },
    (error) => {
        // Ici, on gère toute erreur.
        if (error.response.status === 403 || error.response.status === 404) {
            // Si le statut est 403 ou 404, on peut rediriger l'utilisateur vers la page not found.
            router.push({
                name: "NotFound",
                params: {
                    errorType: error.response.status,
                },
            });
        } else if (error.response.status === 401) {
            // Rediriger l'utilisateur vers la page de connexion avec un message 'Session expirée, veillez vous reconnecter.'
            router.push({
                name: "deconnexion",
                params: {
                    message: "Session expirée, veillez vous reconnecter.",
                },
            });
        }

        // rejeter la promesse avec l'erreur afin de la capturer dans le code de la requête si nécessaire.
        return Promise.reject(error);
    }
);

apiClient.postWithFormData = function (url, data) {
    const config = {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    };

    return this.post(url, data, config);
};

export default apiClient;
