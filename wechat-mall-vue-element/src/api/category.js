import request from '@/utils/request'

export default {
  getCategory(level, pid) {
    return request({
      url: `/admin/category/getCategory?level=${level}&pid=${pid}`,
      method: 'get'
    })
  },
  updateState(cid, state) {
    return request({
      url: `/admin/category/updateState?cid=${cid}&state=${state}`,
      method: 'get'
    })
  },
  saveOrUpdateCategory(data) {
    return request({
      url: `/admin/category/saveOrUpdate`,
      method: 'put',
      data: data
    })
  }
}
