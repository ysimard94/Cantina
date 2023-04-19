import http from "../http-common";

class AuthDataService {
    async connexion(data) {
        return await http.post("/connexion", data);
    }
    async deconnecter() {
        return await http.get("/deconnexion");
    }
    async creation(data) {
        return await http.post("/enregistrer", data);
    }
}

export default new AuthDataService();
