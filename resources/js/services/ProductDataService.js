import http from "../http-common";

class ProductDataService {
    async getAll() {
        return await http.get("/product");
    }

    async create(data) {
        return await http.post("/product", data);
    }

    async get(id) {
        return await http.get(`/product/${id}`);
    }

    async delete(id) {
        return await http.delete(`/product/${id}`);
    }

    async update(id, data) {
        return await http.put(`/product/${id}`, data);
    }
}

export default new ProductDataService();
