import base from "@/api/base";
// import axios from "axios";
import axios from "@/utils/http";
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
    },
    pageSearch($page, $limit, $goods_id) {
        return axios.get(
            `${BASE_URL}/comment/pageSearch?page=${$page}&limit=${$limit}&goods_id=${$goods_id}`,

        )
    },
    getUserName(id){
        return axios.post(
            'http://mall.php.test/controller/getUserById',
            {id:id}
        )
    },
    getAllOrder(type){
        return axios.get(
            `${BASE_URL}/order/allOrder?type=${type}`,

        )
    }


}


// export default user;
