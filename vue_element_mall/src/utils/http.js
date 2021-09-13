/**
 * @author 刘凌峰
 * idea from: https://www.jianshu.com/p/cac8e979e437
 */


/**
 * axios 封装
 * 请求拦截、响应拦截、错误统一处理
 */
import axios from "axios";
import router from "@/router/index";
import store from '@/store/index'
import {Message} from "element-ui";

/**
 * 提示函数
 */
const tip = msg => {
    Message({
        message: msg,
        type: 'warning',
        duration: 3 * 1000
    })
}


/**
 * 跳转登陆页
 * 携带当前页面路由，以及在登陆页面完成登陆后返回当前页面
 */
const toLogin = () => {
    router.replace({
        path: '/login',
        query: {
            redirect: router.currentRoute.fullPath
        }
    });
}


/**
 * 失败后统一处理错误
 * @param {Number} status 请求失败的状态码
 */
const errorHandle = (status, other) => {
    switch (status) {
        case 401:
            toLogin();
            break
        case 403:
            tip('登陆过期，请重新登陆');
            localStorage.removeItem('token');
            store.commit('LOGIN_SUCCESS', null)
            // 1秒后跳转登陆页面
            setTimeout(() => {
                toLogin();
            }, 1000);
            break;
        case 404:
            tip('请求的资源不存在');
            break;
        default:
            console.log(other)
    }
}


// 创建axios实例
let instance = axios.create({timeout: 1000 * 12});
// 设置post请求头
instance.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';


/**
 * 每次请求拦截
 * 每次请求前， 如果存在token则在请求头中携带token
 */
instance.interceptors.request.use(
    config => {
        const token = store.state.token;
        if (token != null && token !== '') {
            config.headers.Authorization = token
        }
        return config;
    },
    error => Promise.error(error)
)

/**
 * 响应拦截器
 */
instance.interceptors.response.use(
    res => res.status === 200 ? Promise.resolve(res) : Promise.reject(res),
    // 请求失败
    error => {
        const {response} = error;
        if (response) {
            // 请求已发出， 但是不再2**范围内
            errorHandle(response.status, response.data.message);
        } else {
            // 处理断网的情况
            // eg: 请求超出或断网， 更新state的network状态
            if (!window.navigator.onLine) {
                store.commit('NETWORK_FAIL')
            } else {
                return Promise.reject(error)
            }
        }
    }
);


