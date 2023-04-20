import apiClient from "../http-common";

class PaysDataService {
    async getAll() {
        return await apiClient.get(`/pays`);
    }
}
export default new PaysDataService();
