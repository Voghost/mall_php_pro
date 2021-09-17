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
      url: `/admin/goods/deletePic?id=${picId}`
    })
  },
  getAllSpecKey() {
    return request({
      url: `/admin/spec/allKey`
    })
  },
  getSpecKeyByIds(ids) {
    return request({
      url: `/admin/spec/getSpecKeyByIds`,
      method: 'post',
      data: { 'ids': ids }
    })
  },
  getSpecTree() {
    return request({
      url: `/admin/spec/specTree`,
      method: 'get'
    })
  },
  addSpecKey(specName) {
    return request({
      url: `/admin/spec/addSpecKey`,
      method: 'post',
      data: { 'spec_name': specName }
    })
  },
  addSpecValue(specVal, specKid) {
    return request({
      url: `/admin/spec/addSpecValue`,
      method: 'post',
      data: {
        'specValName': specVal,
        'specKid': specKid
      }
    })
  },
  removeSpecKey(id) {
    return request({
      url: `/admin/spec/deleteSpecKey?id=${id}`,
      method: 'get'
    })
  },
  removeSpecValue(id) {
    return request({
      url: `/admin/spec/deleteSpecValue?id=${id}`,
      method: 'get'
    })
  }
}

