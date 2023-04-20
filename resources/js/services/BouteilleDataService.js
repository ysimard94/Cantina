import apiClient from "../http-common";

class BouteilleDataService {
    async getAll() {
        return await apiClient.get(`/bouteilles`);
    }


    async create(data) {
        return await apiClient.post("/bouteille", data);
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
}

export default new BouteilleDataService();
