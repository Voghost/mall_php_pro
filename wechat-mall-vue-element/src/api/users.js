import request from '@/utils/request'

export default {
  // 页查询
  pageSearchForUsers(data, page, limit) {
    return request({
      url: `/admin/users/page/page/${page}/limit/${limit}`,
      method: 'post',
      data: data
    })
  },
  updateState(id, state) {
    return request({
      url: `/admin/users/updateState?id=${id}&state=${state}`,
      method: 'get'
    })
  }
}
