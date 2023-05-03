import axios from "axios";

const apiClient = axios.create({
    baseURL: "http://localhost:8000/api",
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
    },
});

apiClient.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("jwt-token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

apiClient.postWithFormData = function (url, data) {
    console.log("URL: ", url);
    console.log("Data: ", data);
    const config = {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    };

    return this.post(url, data, config);
};

// apiClient.putWithFormData = function (url, data) {
//     console.log("URL: ", url);
//     console.log("Data: ", data);
//     const config = {
//         headers: {
//             "Content-Type": "multipart/form-data",
//         },
//     };

//     return this.put(url, data, config);
// };

export default apiClient;
