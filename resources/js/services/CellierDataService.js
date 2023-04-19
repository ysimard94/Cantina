import http from "../http-common";

class CellierDataService {
    async getAll() {
        return await http.get(`/celiers`);
    }
    async create(data) {
        return await http.post("/celiers", data);
    }

    async get(id) {
        return await http.get(`/celiers/${id}`);
    }

    async delete(id) {
        return await http.delete(`/celiers/${id}`);
    }

    async update(id, data) {
        return await http.put(`/celiers/${id}`, data);
    }
    async BouteillesCellier(cellierId) {
        return await http.get(`/celliers/${cellierId}/bouteilles`);
    }
    async supprimerBouteilleCellier(cellierId, bouteilleId) {
        return await http.delete(
            `/celliers/${cellierId}/bouteilles/${bouteilleId}`
        );
    }
}

export default new CellierDataService();


