import Vue from 'vue'
import VueRouter from 'vue-router'

import IndexPage from "@/views/IndexPage"
import AboutMe from "@/views/AboutMe";
import GoodsDetail from "@/views/GoodsDetail";
import AllGoods from "@/views/AllGoods";
import LoginRegister from "@/views/LoginRegister";
import UserData from "@/components/UserData";
import SettlementPage from "../views/SettlementPage";
import NopayList from "@/components/NopayList";
import PaidList from "@/components/PaidList";

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
      path:'/settlementPage',
      component:SettlementPage
    },
    {
        path: '/aboutMe',
        component: AboutMe,
        children:[
            {
                path:"NopayList/:list_state",
                name:"Nopay",
                component:NopayList
            },
            {
                path:"PaidList/:list_state",
                name:'Paid',
                component:PaidList,
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
