import http from "../http-common";

class CellierDataService {
    async getAll() {
        return await http.get(`/celliers`);
    }
    async create(data) {
        return await http.post("/celliers", data);
    }

    async get(id) {
        return await http.get(`/celliers/${id}`);
    }

    async delete(id) {
        return await http.delete(`/celliers/${id}`);
    }

    async update(id, data) {
        return await http.put(`/celliers/${id}`, data);
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
