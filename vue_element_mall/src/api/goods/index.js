import base from "@/api/base";
import axios from "@/utils/http";
// import qs from "qs"

const BASE_URL = base.baseRequestUrl + "/index";

export default {
    pageSearch($page, $limit, $query) {
        return axios.post(
            `${BASE_URL}/goods/pageSearch?page=${$page}&limit=${$limit}`,
            $query
        )
    },
    detail(id) {
        return axios.post(`${BASE_URL}/goods/goodsDetail?id=${id}`)
    },
    getSpecKvInfoByGoodsId(goodsId) {
        return axios.get(`${BASE_URL}/spec/getSpecKvInfoByGoodsId?goodsId=${goodsId}`)
    },
    getGoodsInfoBySpecKv(specKv,gid) {
        return axios.post(
            `${BASE_URL}/spec/getGoodsInfoBySpecKv?goodsId=${gid}`,
            {specKv}
        )
    },
    getKVByInfoId(info_id){
        return axios.post(`${BASE_URL}/spec/getKVByInfoId?id=${info_id}`)
    }


}

