import http from "../http-common";
class CategoryDataService {
    async getAll() {
        return await http.get("/category");
    }
}
export default new CategoryDataService();
