/**
 * @author 刘凌峰
 */
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    // 用于存储数据
    state: {
        token: '',           // 用户token
        netWorkStatus: true  // 网络状态
    },

    // 用于数据操作
    mutations: {
        // 改变token值
        SET_TOKEN(state, value) {
            state.token = value
        },
        NETWORK_FAIL(state) {
            state.netWorkStatus = false
        }
    },

    // 响应组件动作
    actions: {
        loginSuccess(context, value) {
            context.commit("SET_TOKEN", value)
        },
        tokenOutOfDate(context) {
            context.commit("SET_TOKEN", '')
        }
    },

    modules: {}
})
