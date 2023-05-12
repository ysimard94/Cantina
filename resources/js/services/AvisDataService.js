import apiClient from "../http-common";

class AvisDataService {
    async avisBouteille(bouteilleId) {
        return await apiClient.get(`/avis/${bouteilleId}`);
    }

    async sendAvisBouteille(data) {
        return await apiClient.post("/avis", data);
    }
}

export default new AvisDataService();
