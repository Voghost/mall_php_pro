import request from '@/utils/request'

export default {
  // 页查询
  pageSearchForGoods(data, page, limit) {
    return request({
      url: `/admin/goods/page/page/${page}/limit/${limit}`,
      method: 'post',
      data: data
    })
  },
  deleteGoods(data) {
    return request({
      url: '/admin/goods/saveOrUpdate',
      method: 'post',
      data: data
    })
  },
  updateGoods(data) {
    return request({
      url: '/admin/goods/saveOrUpdate',
      method: 'post',
      data: data
    })
  },
  getCategory(level, catId) {
    return request({
      url: `/admin/goods/getCategory?level=${level}&catId=${catId}`,
      method: 'get'
    })
  },
  saveOrUpdateGoods(data) {
    return request({
      url: '/admin/goods/saveOrUpdate',
      method: 'post',
      data: data
    })
  },
  deletePic(picId) {
    return request({
      url: `/admin/goods/deletePic?id=${picId}`,
    })
  }
}

