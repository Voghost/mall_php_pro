import base from "@/api/base";
import axios from "axios";


const BASE_URL = base.baseRequestUrl + "/index";

export default {
    getAddress($id){
        return axios.post(`${BASE_URL}/Address/getById?id=${$id}`)
    },
    getUsername($id){
        return axios.post(`${BASE_URL}/Address/getUsernameById?id=${$id}`)
    }
}
