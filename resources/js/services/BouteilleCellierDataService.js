import http from "../http-common";

class BouteilleCellierDataService {
    async getAll(bouteilleId) {
        return await http.get(`/celiers/${bouteilleId}/celiers`);
    }
    async ajouterBouteilleAuCellier(bouteilleId) {
        return await http.post(`/celliers/1/bouteilles/${bouteilleId}`);
    }

    async get(id) {
        return await http.get(`/celiers/${id}`);
    }

    async delete(id) {
        return await http.delete(`/bouteilles/{bouteilleId}/celiers/${id}`);
    }
}



export default new BouteilleCellierDataService();


