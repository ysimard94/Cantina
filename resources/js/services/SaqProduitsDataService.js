import http from "../http-common";

class SaqProduitsDataService {
    async getAll() {
        return await http.get("/saq-produits");
    }
}
export default new SaqProduitsDataService();
