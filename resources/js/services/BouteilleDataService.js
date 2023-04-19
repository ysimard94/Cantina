import http from "../http-common";

class BouteilleDataService {
    async getAll() {
        return await http.get(`/bouteilles`);
    }

    async create(data) {
        return await http.post("/bouteille", data);
    }

    async get(id) {
        return await http.get(`/bouteille/${id}`);
    }

    async delete(id) {
        return await http.delete(`/bouteille/${id}`);
    }

    async update(id, data) {
        return await http.put(`/bouteille/${id}`, data);
    }
}

export default new BouteilleDataService();
