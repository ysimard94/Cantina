import http from "../http-common";
class CategorieDataService {
    async getAll() {
        return await http.get("/category");
    }
}
export default new CategorieDataService();
