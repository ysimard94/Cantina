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
        return await apiClient.delete(`/bouteille/${bouteilleId}/${cellierId}`);
    }

    async update(bouteilleId, cellierId, data) {
        return await apiClient.postWithFormData(
            `/bouteille/${bouteilleId}/${cellierId}`,
            data
        );
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
    // Archiver une bouteille
    async archiverBouteille(cellierId, bouteilleId) {
        return await apiClient.post(`/archives/${cellierId}/${bouteilleId}`);
    }
    // Obtenir les archives d'un utilisateur
    async obtenirArchivesUtilisateur(utilisateurId) {
        return await apiClient.get(`/archives/${utilisateurId}`);
    }

    // Obtenir les bouteilles de la recherche
    async getResultatsBouteilles(valeur) {
        return await apiClient.get(`/resultats/${valeur}`);
    }

    // Obtenir les bouteilles de la liste d'achats
    async getListeBouteilles(utilisateurId) {
        return await apiClient.get(`/liste-achats/${utilisateurId}`);
    }
}

export default new BouteilleDataService();
