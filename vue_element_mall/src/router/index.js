import Vue from 'vue'
import VueRouter from 'vue-router'

import IndexPage from "@/views/IndexPage"
import AboutMe from "@/views/AboutMe";
import GoodsDetail from "@/views/GoodsDetail";
import AllGoods from "@/views/AllGoods";
import LoginRegister from "@/views/LoginRegister";
import UserData from "@/components/UserData";

Vue.use(VueRouter)

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
        path: '/aboutMe',
        component: AboutMe,
        children:[
            {
                path:"UserData",
                component:UserData,
            },
            {
                path:"UserData",
                component:UserData,
            },
            {
                path:"UserData",
                component:UserData,
            },
        ]
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
