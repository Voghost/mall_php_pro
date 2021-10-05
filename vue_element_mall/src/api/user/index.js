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
    allComment() {
        return axios.post(`${BASE_URL}/comment/commentList`);
    },
    loginAuth(param) {
        return axios.post(`${BASE_URL}/user/loginAuthen`, param);
    },
    registerAuth(param) {
        return axios.post(`${BASE_URL}/user/registerAuthen`, param);
    },
    pageSearch($page, $limit, $goods_id) {
        return axios.get(
            `${BASE_URL}/comment/pageSearch?page=${$page}&limit=${$limit}&goods_id=${$goods_id}`,
        )
    },
    getUserName(id) {
        return axios.post(
            'http://mall.php.test/controller/getUserById',
            {id: id}
        )
    },
    updateUser(userInfo) {
        return axios.post(
            `${BASE_URL}/user/updateUser`,
            {userInfo}
        )
    },
    // getAllOrder(type) {
    //     return axios.get(
    //         `${BASE_URL}/order/allOrder?type=${type}`,
    //     )
    // },
    returnOrder(orderNum) {
        return axios.post(
            `${BASE_URL}/order/returnOrder`,
            {"orderNum": orderNum}
        )
    },
    getAllOrder(type, refund) {
        return axios.get(
            `${BASE_URL}/order/allOrder?type=${type}&refund=${refund}`,
        )
    },
    refund(id, content) {
        return axios.post(
            `${BASE_URL}/order/refund?id=${id}`,
            {"content": content}
        )
    },
    finish(id) {
        return axios.post(
            `${BASE_URL}/order/finish?id=${id}`,
        )
    },
    addComment(map) {
        return axios.post(
            `${BASE_URL}/comment/addComment`,
            map
        )
    },
    getLog(id) {
        return axios.post(
            `${BASE_URL}/order/getLog?id=${id}`
        )
    },


}


// export default user;
