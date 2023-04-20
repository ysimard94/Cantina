import apiClient from "../http-common";

class UtilisateurDataService {
    async editUtilisateur(id, data) {
        return await apiClient.put(`/utilisateur-edit/${id}`, data);
    }
    async getUtilisateur(id) {
        return await apiClient.get(`/utilisateur-show/${id}`);
    }
}

export default new UtilisateurDataService();
