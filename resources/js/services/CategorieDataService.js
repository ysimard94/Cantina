import apiClient from "../http-common";
class CategorieDataService {
    async getAll() {
        return await apiClient.get("/category");
    }
}
export default new CategorieDataService();
