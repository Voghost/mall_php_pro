import request from '@/utils/request'

export default {
  allSwiper() {
    return request({
      url: `/admin/home/allSwiper`,
      method: 'post'
    })
  },
  allFloor() {
    return request({
      url: `/admin/home/allFloor`,
      method: 'post'
    })
  },
  deleteSwiper(data) {
    return request({
      url: '/admin/home/deleteSwiper',
      method: 'post',
      data: data
    })
  },
  deleteFloor(data) {
    return request({
      url: '/admin/home/deleteFloor',
      method: 'post',
      data: data
    })
  },
  updateSwiper(data) {
    return request({
      url: '/admin/home/saveOrUpdateSwiper',
      method: 'post',
      data: data
    })
  },
  updateFloor(data) {
    return request({
      url: '/admin/home/saveOrUpdateFloor',
      method: 'post',
      data: data
    })
  },
  saveOrUpdateSwiper(data) {
    return request({
      url: '/admin/home/saveOrUpdateSwiper',
      method: 'post',
      data: data
    })
  },
  saveOrUpdateFloor(data) {
    return request({
      url: '/admin/home/saveOrUpdateFloor',
      method: 'post',
      data: data
    })
  }
}
