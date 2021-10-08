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
  },
  getRole() {
    return request({
      url: `/admin/admin/getRole`,
      method: 'post'
    })
  },
  addRole(id, item) {
    return request({
      url: `/admin/admin/addRole?id=${id}&item=${item}`,
      method: 'get'
    })
  },
  deleteRole(id, item) {
    return request({
      url: `/admin/admin/deleteRole?id=${id}&item=${item}`,
      method: 'get'
    })
  }
}
