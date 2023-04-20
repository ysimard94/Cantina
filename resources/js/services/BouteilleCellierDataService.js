import http from "../http-common";

class BouteilleCellierDataService {
    async getAll(bouteilleId) {
        return await http.get(`/celliers/${bouteilleId}/celliers`);
    }
    async ajouterBouteilleAuCellier(cellierId,bouteilleId) {
        return await http.post(`/celliers/${cellierId}/bouteilles/${bouteilleId}`);
    }

    async get(id) {
        return await http.get(`/celliers/${id}`);
    }

    async delete(id) {
        return await http.delete(`/bouteilles/{bouteilleId}/celliers/${id}`);
    }
}

export default new BouteilleCellierDataService();
