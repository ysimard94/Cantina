import apiClient from "../http-common";
class CategorieDataService {
    async getAll() {
        return await apiClient.get("/categorie");
    }
}
export default new CategorieDataService();
