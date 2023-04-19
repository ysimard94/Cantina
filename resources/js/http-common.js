import axios from "axios";

const token = localStorage.getItem("AuthToken");
export default axios.create({
    baseURL: "http://localhost:8000/api",
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`, // Add the Authorization header with the token
    },
});
