import http from "../http-common";

class AuthDataService {
    async connexion(data) {
        return await http.post("/connexion", data);
    }
    async deconnecter() {
        return await http.get("/deconnextion");
    }
}

export default new AuthDataService();
