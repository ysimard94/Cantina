import apiClient from "../http-common";

class CellierDataService {
    async getAll() {
        return await apiClient.get(`/celliers`);
    }
    async ajouter(data) {
        return await apiClient.post("/celliers", data);
    }

    async details(id) {
        return await apiClient.get(`/celliers/${id}`);
    }

    async supprimer(id) {
        return await apiClient.delete(`/celliers/${id}`);
    }

    async modifier(id, data) {
        return await apiClient.put(`/celliers/${id}`, data);
    }
    async BouteillesCellier(cellierId) {
        return await apiClient.get(`/celliers/${cellierId}/bouteilles`);
    }
    async supprimerBouteilleCellier(cellierId, bouteilleId) {
        return await apiClient.delete(
            `/celliers/${cellierId}/bouteilles/${bouteilleId}`
        );
    }
}

export default new CellierDataService();
