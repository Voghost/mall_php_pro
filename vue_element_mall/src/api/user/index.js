import base from "@/api/base";
import axios from "axios";
import qs from "qs"

const BASE_URL = base.baseRequestUrl + "/index";

// const user = {
//     login(params) {
//         return axios.post(`${base.baseRequesUrl}/login`, qs.stringify(params));
//     },
//    allComment(){
//        return axios.get(`${BASE_URL}/goods/usersList`);
//    }
// }
export default {
    login(params) {
        return axios.post(`${base.baseRequesUrl}/login`, qs.stringify(params));
    },
    allComment(){
        return axios.post(`${BASE_URL}/comment/commentList`);
    },
    loginAuth(param) {
        return axios.post(`${BASE_URL}/user/loginAuthen`,param);
    },
    registerAuth(param) {
        return axios.post(`${BASE_URL}/user/registerAuthen`,param);
    }
}


// export default user;
