import axios from "axios";

const config = {
    baseURL: 'http://laravel-notes.local/api/',
}

const httpService = axios.create(config);

httpService.interceptors.request.use(
    config => {
        const token = localStorage.getItem('api-token');
        if (token) {
            config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config;
    },
    error => {
        Promise.reject(error)
    });

export default httpService;
