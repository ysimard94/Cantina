import api from "../http-common";

class SaqProduitsDataService {
    async getAll() {
        return await api.get("/saq-produits");
    }
}
export default new SaqProduitsDataService();
