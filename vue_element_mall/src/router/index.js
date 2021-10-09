import Vue from 'vue'
import VueRouter from 'vue-router'

import IndexPage from "@/views/IndexPage"
import AboutMe from "@/views/AboutMe";
import GoodsDetail from "@/views/GoodsDetail";
import AllGoods from "@/views/AllGoods";
import LoginRegister from "@/views/LoginRegister";

import SettlementPage from "../views/SettlementPage";


Vue.use(VueRouter)

const originalPush = VueRouter.prototype.push

VueRouter.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
}


const routes = [
    {
        path: '*',
        name: '404',
        component: () => import('@/views/404.vue')
    },
    {
        path: '/',
        component: IndexPage,
        meta: {title: 'DGUT 小卖部 | 首页'}

    },
    {
        path: '/allGoods',
        component: AllGoods,
        meta: {title: '全部商品'}
    },
    {
        path: '/goodsDetail',
        component: GoodsDetail,
        meta: {title: '商品详情'}
    },
    {
        path: '/settlementPage',
        component: SettlementPage,
        meta: {title: '结算'}
    },
    {
        path: '/aboutMe',
        component: AboutMe,
        meta: {title: '我'}
    },
    {
        path: '/login_register',
        component: LoginRegister,
        meta: {title: '登录 | 注册'}
    },
]

const router = new VueRouter({
    routes,
    mode: "history"
})

router.beforeEach((to, from, next) => {  /* 路由发生变化修改页面title */
    if (to.meta.title) {
        document.title = to.meta.title
    }
    next()
})

export default router
