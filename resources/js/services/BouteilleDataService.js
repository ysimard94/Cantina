import http from "../http-common";

class BouteilleDataService {
    async getAll(nombre, page) {
        return await http.get(`/bouteille/${nombre}/${page}`);
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
