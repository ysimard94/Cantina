import apiClient from "../http-common";

class SaqProduitsDataService {
    async getAll() {
        return await apiClient.get("/saq-produits");
    }
}
export default new SaqProduitsDataService();
