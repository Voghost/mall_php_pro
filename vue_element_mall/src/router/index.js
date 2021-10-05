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
        component: IndexPage
    },
    {
        path: '/allGoods',
        component: AllGoods
    },
    {
        path: '/goodsDetail',
        component: GoodsDetail
    },
    {
        path: '/settlementPage',
        component: SettlementPage
    },
    {
        path: '/aboutMe',
        component: AboutMe,

    },
    {
        path: '/login_register',
        component: LoginRegister
    },
]

const router = new VueRouter({
    routes,
    mode: "history"
})

export default router
