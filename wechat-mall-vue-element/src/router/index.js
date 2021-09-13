import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/* Layout */
import Layout from '@/layout'

/**
 * Note: sub-menu only appear when route children.length >= 1
 * Detail see: https://panjiachen.github.io/vue-element-admin-site/guide/essentials/router-and-nav.html
 *
 * hidden: true                   if set true, item will not show in the sidebar(default is false)
 * alwaysShow: true               if set true, will always show the root menu
 *                                if not set alwaysShow, when item has more than one children route,
 *                                it will becomes nested mode, otherwise not show the root menu
 * redirect: noRedirect           if set noRedirect will no redirect in the breadcrumb
 * name:'router-name'             the name is used by <keep-alive> (must set!!!)
 * meta : {
    roles: ['admin','editor']    control the page roles (you can set multiple roles)
    title: 'title'               the name show in sidebar and breadcrumb (recommend set)
    icon: 'svg-name'/'el-icon-x' the icon show in the sidebar
    breadcrumb: false            if set false, the item will hidden in breadcrumb(default is true)
    activeMenu: '/example/list'  if set path, the sidebar will highlight the path you set
  }
 */

/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 */
export const constantRoutes = [
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    hidden: true
  },

  {
    path: '/404',
    component: () => import('@/views/404'),
    hidden: true
  },

  {
    path: '/',
    component: Layout,
    redirect: '/dashboardd',
    children: [{
      path: '/dashboardd',
      name: '面板',
      component: () => import('@/views/dashboard/index'),
      meta: { title: '面板', icon: 'dashboard' }
    }]
  }
  // 404 page must be placed at the end !!!
  // { path: '*', redirect: '/404', hidden: true }
]

export const asyncRoutes = [
  {
    path: '/goodsManager',
    component: Layout,
    meta: { 'title': '商品管理', icon: 'el-icon-goods', roles: ['ADMIN'] },
    children: [
      {
        path: 'goodsList',
        component: () => import('@/views/goods/goodsList'),
        meta: { 'title': '商品列表', icon: 'el-icon-tickets', roles: ['ADMIN', 'ADMIN'] }
      },
      {
        path: 'goodsEditor',
        component: () => import('@/views/goods/goodsEdit'),
        meta: { 'title': '商品编辑', icon: 'el-icon-edit-outline' }
      }
    ]
  },
  {
    path: '/homeManager',
    component: Layout,
    meta: { 'title': '主页管理', icon: 'el-icon-s-home', roles: ['ADMIN'] },
    children: [
      {
        path: 'swapList',
        component: () => import('@/views/home/swiperList'),
        meta: { 'title': '轮播图', icon: 'el-icon-menu', roles: ['ADMIN', 'ADMIN'] }
      },
      {
        path: 'floorList',
        component: () => import('@/views/home/floorList'),
        meta: { 'title': '楼层', icon: 'el-icon-office-building' }
      }
    ]
  },
  {
    path: '/categoryManager',
    component: Layout,
    meta: { 'title': '分类管理', icon: 'el-icon-c-scale-to-original', roles: ['ADMIN'] },
    children: [
      {
        path: 'goodsList',
        component: () => import('@/views/category/categoryList'),
        meta: { 'title': '分类管理', icon: 'el-icon-c-scale-to-original', roles: ['ADMIN', 'ADMIN'] }
      }
    ]
  },
  {
    path: '/userManager',
    component: Layout,
    meta: { 'title': '用户管理', icon: 'el-icon-goods', roles: ['ADMIN'] },
    children: [
      {
        path: 'userList',
        component: () => import('@/views/user/index'),
        meta: { 'title': '用户管理', icon: 'el-icon-user', roles: ['ADMIN', 'ADMIN'] }
      }
    ]
  },
  {
    path: '/orderManager',
    component: Layout,
    meta: { 'title': '订单管理', icon: 'el-icon-s-order', roles: ['ADMIN'] },
    children: [
      {
        path: 'userList',
        component: () => import('@/views/order/index'),
        meta: { 'title': '订单管理', icon: 'el-icon-s-order', roles: ['ADMIN', 'ADMIN'] }
      }
    ]
  },
  // 404 页面必须放置在最后一个页面
  { path: '*', redirect: '/404', hidden: true }
]

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

const router = createRouter()

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router
