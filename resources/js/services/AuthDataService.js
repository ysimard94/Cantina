import api from "../http-common";

class AuthDataService {
    async connexion(data) {
        return await api.post("/connexion", data);
    }
    async deconnecter() {
        return await api.post("/deconnexion");
    }
    async creation(data) {
        return await api.post("/enregistrer", data);
    }
}

export default new AuthDataService();
