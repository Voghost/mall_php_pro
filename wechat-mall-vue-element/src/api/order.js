import request from '@/utils/request'

export default {
  // 页查询
  pageSearchForOrder(data, page, limit) {
    return request({
      url: `/admin/order/page/page/${page}/limit/${limit}`,
      method: 'post',
      data: data
    })
  },
  updateState(id, state, data) {
    return request({
      url: `/admin/order/updateState?id=${id}&state=${state}`,
      method: 'post',
      data: data
    })
  }
}
