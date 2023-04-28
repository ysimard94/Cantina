import apiClient from "../http-common";

class SaqProduitsDataService {
    async getAll() {
        return await apiClient.get("/saq-produits");
    }

    async getBouteilles(produit) {
        return await apiClient.get(`/saq-produits/${produit}`);
    }
}
export default new SaqProduitsDataService();
