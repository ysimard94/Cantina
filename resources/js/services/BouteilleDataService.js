import api from "../http-common";

class BouteilleDataService {
    async getAll() {
        return await api.get(`/bouteilles`);
    }

    async create(data) {
        return await api.post("/bouteille", data);
    }

    async get(id) {
        return await api.get(`/bouteille/${id}`);
    }

    async delete(id) {
        return await api.delete(`/bouteille/${id}`);
    }

    async update(id, data) {
        return await api.put(`/bouteille/${id}`, data);
    }
}

export default new BouteilleDataService();
