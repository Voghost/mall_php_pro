import request from '@/utils/request'

export default {
  // 页查询
  pageSearchForUsers(data, page, limit) {
    return request({
      url: `/admin/admin/page/page/${page}/limit/${limit}`,
      method: 'post',
      data: data
    })
  },
  saveAdmin(data) {
    return request({
      url: `/admin/admin/saveAdmin`,
      method: 'post',
      data: data
    })
  }
}
