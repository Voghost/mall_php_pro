import base from "@/api/base";
import axios from "axios";


const BASE_URL = base.baseRequestUrl + "/index";

export default {
    allCartItem(){
        return axios.post(`${BASE_URL}/cart/all`)
    }
}