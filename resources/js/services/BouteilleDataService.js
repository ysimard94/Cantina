import apiClient from "../http-common";

class BouteilleDataService {
    async getAll() {
        return await apiClient.get(`/bouteilles`);
    }

    async create(id, data) {
        return await apiClient.postWithFormData(`/bouteille/${id}`, data);
    }

    async get(id) {
        return await apiClient.get(`/bouteille/${id}`);
    }

    async delete(id) {
        return await apiClient.delete(`/bouteille/${id}`);
    }

    async update(id, data) {
        return await apiClient.put(`/bouteille/${id}`, data);
    }
    async getBouteillesByCellierId(cellierId) {
        return await apiClient.get(`/bouteilles/cellier/${cellierId}`);
    }
    async getAllBouteilleCellier(bouteilleId) {
        return await apiClient.get(`/celliers/${bouteilleId}/celliers`);
    }
    async ajouterBouteilleAuCellier(cellierId, bouteilleId, quantite) {
        return await apiClient.post(
            `/celliers/${cellierId}/bouteilles/${bouteilleId}+${quantite}`
        );
    }
    // Détacher la bouteille du cellier
    async supprimerBouteilleDansCellier(cellierId, bouteilleId) {
        return await apiClient.delete(`/celliers/${cellierId}/${bouteilleId}`);
    }
    async getResultatsBouteilles(valeur) {
        return await apiClient.get(`/resultats/${valeur}`);
    }
}

export default new BouteilleDataService();
