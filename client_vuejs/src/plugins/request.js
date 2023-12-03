import { AUTHENTICATED_KEY } from "@/common/constant";
import axios from "axios";
const apiUrl = 'http://127.0.0.1:8000' + '/api/';

export default {
    getHeader() {
        let token = window.localStorage.getItem(AUTHENTICATED_KEY);
        if (token == null) {
            localStorage.clear();
        }
        return axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    },

    get(url) {
        return axios.get(apiUrl + url, this.getHeader());
    },

    post(url, data) {
        return axios.post(apiUrl + url, data, {
            headers: {
                'Authorization': this.getHeader(),
                'content-type': 'multipart/form-data'
            }
        });
    },
    put(url, data, params) {
        return axios.put(apiUrl + url, data, { headers: this.getHeader(), params: params });
    },
    delete(url) {
        return axios.delete(apiUrl + url, this.getHeader());
    },

    checkLogin() {
        let token = window.localStorage.getItem(AUTHENTICATED_KEY);
        if (token == null) {
            return false;
        } else return true;
    }


}