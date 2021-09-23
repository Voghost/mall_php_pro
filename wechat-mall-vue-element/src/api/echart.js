import request from '@/utils/request'

export default {
  getSearch() {
    return request({
      url: `/admin/echart/getSearch`,
      method: 'post'
    })
  },
  getWeekData() {
    return request({
      url: `/admin/echart/getWeekData`,
      method: 'post'
    })
  },
  getTenOrder() {
    return request({
      url: `/admin/echart/getTenOrder`,
      method: 'post'
    })
  },
  getTenComment() {
    return request({
      url: `/admin/echart/getTenComment`,
      method: 'post'
    })
  },
}
