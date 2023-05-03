import apiClient from "../http-common";

class CelierDataService {
    async getAll() {
        return await apiClient.get(`/celier`);
    }

    async create(data) {
        return await apiClient.post("/celier", data);
    }

    async getCellierById(id) {
        return await apiClient.get(`/cellier/${id}`);
    }

    async delete(id) {
        return await apiClient.delete(`/celier/${id}`);
    }

    async update(id, data) {
        return await apiClient.put(`/celier/${id}`, data);
    }
}

export default new CelierDataService();
