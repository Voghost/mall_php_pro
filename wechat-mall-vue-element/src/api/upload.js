import request from '@/utils/request'

export default {
  upload(data) {
    return request({
      // baseURL: 'http://localhost:8000',
      // url: '/admin/upload/file',
      url: '/upload/file',
      // url: '/mytest.php' + '?XDEBUG_SESSION_START=12087',
      method: 'post',
      headers: {
        'Content-Type': 'multipart/form-data'
      },
      data: data
    })
  }
}
