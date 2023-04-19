import api from "../http-common";
class CategorieDataService {
    async getAll() {
        return await api.get("/category");
    }
}
export default new CategorieDataService();
