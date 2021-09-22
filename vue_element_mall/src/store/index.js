/**
 * @author 刘凌峰
 */
import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate"

Vue.use(Vuex)

export default new Vuex.Store({
    // 用于存储数据
    state: {
        token: '',           // 用户token
        netWorkStatus: true,  // 网络状态,
        userInfo: {}        // 用户信息
    },

    // 用于数据操作
    mutations: {
        // 改变token值
        SET_TOKEN(state, value) {
            state.token = value
        },
        NETWORK_FAIL(state) {
            state.netWorkStatus = false
        },
        SET_USER_INFO(state, value) {
            state.userInfo = value
        }
    },

    // 响应组件动作
    actions: {
        loginSuccess(context, token, info) {
            context.commit("SET_TOKEN", token)
            context.commit("SET_USER_INFO", info)
        },
        tokenOutOfDate(context) {
            context.commit("SET_TOKEN", '')
        },
        logout(context) {
            context.commit("SET_TOKEN", '')
            context.commit("SET_USER_INFO", {})
        }
    },

    modules: {},

    plugins: [createPersistedState()]
})
