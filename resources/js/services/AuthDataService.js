import apiClient from "../http-common";

class AuthDataService {
    async connexion(data) {
        return await apiClient.post("/connexion", data);
    }
    async deconnecter() {
        return await apiClient.post("/deconnexion");
    }
    async creation(data) {
        return await apiClient.post("/enregistrer", data);
    }
}

export default new AuthDataService();
