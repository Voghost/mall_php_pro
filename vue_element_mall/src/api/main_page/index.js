import base from "@/api/base";
import axios from "axios";
// import qs from "qs"

const BASE_URL = base.baseRequestUrl + "/index";

export default {
    allCategory() {
        return axios.get(`${BASE_URL}/goods/categoriesList`);
    },
    floor() {
        return axios.get(`${BASE_URL}/home/floorList`);
    },
    search(name) {
        return axios.get(`${BASE_URL}/goods/search?query=${name}`)
    },
    getPics(){
        return axios.get(`${BASE_URL}/home/swiperList`)
    }

}

