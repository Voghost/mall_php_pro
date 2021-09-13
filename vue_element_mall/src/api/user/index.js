import base from "@/api/base";
import axios from "axios";
import qs from "qs"

const user = {
    login(params) {
        return axios.post(`${base.baseRequesUrl}/login`, qs.stringify(params));
    }
}

export default user;
