import base from "../../api/base";
import axios from "../../utils/http";


const BASE_URL = base.baseRequestUrl + "/index";

export default {
    allCartItem(){
        return axios.post(`${BASE_URL}/cart/all`)
    },
    deleteCartItem($id){
        return axios.post(`${BASE_URL}/cart/deleteCartItem?id=${$id}`)
    },
    changeNumber($id,$number)
    {
        return axios.post(`${BASE_URL}/cart/changeNumber?id=${$id}&number=${$number}`)
    },
    showCartItem($cart_id){
        return axios.post(`${BASE_URL}/cart/showCartItem?cart_id=${$cart_id}`)
    },
    createOrder(){
        return axios.post(`${BASE_URL}/order/create`)
    }

}