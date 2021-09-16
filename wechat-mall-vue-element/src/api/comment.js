import request from '@/utils/request'

export default {
  // 页查询
  pageSearchForComment(data, page, limit) {
    return request({
      url: `/admin/comment/page/page/${page}/limit/${limit}`,
      method: 'post',
      data: data
    })
  },
  updateCommentStatus(data) {
    return request({
      url: '/admin/comment/updateCommentStatus',
      method: 'post',
      data: data
    })
  },
  getGoodsAndOrder(data) {
    return request({
      url: '/admin/comment/getGoodsAndOrder',
      method: 'post',
      data: data
    })
  }
}
