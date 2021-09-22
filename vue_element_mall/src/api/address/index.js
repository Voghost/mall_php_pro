import base from "../../api/base";
import axios from "../../utils/http";



const BASE_URL = base.baseRequestUrl + "/index";

export default {
    getAddress(){
        return axios.post(`${BASE_URL}/Address/getById`)
    },
    getUsername(){
        return axios.post(`${BASE_URL}/Address/getUsernameById`)
    }
}
