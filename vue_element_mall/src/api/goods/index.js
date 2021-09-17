import base from "@/api/base";
import axios from "axios";
// import qs from "qs"

const BASE_URL = base.baseRequestUrl + "/index";

export default {
    pageSearch($page, $limit, $query) {
        return axios.post(
            `${BASE_URL}/goods/pageSearch?page=${$page}&limit=${$limit}`,
            {params: $query}
        )
    },
    detail(id) {
        return axios.post(`${BASE_URL}/goods/goodsDetail?id=${id}`)
    },

}

