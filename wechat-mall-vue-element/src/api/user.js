import request from '@/utils/request'

export function login(data) {
  return request({
    // url: '/vue-admin-template/user/login',
    // baseURL: 'http://wechat_mall.php.test',
    url: '/admin/user/login',
    method: 'post',
    data
  })
}

export function getInfo() {
  return request({
    // url: '/vue-admin-template/user/info',
    // baseURL: 'http://wechat_mall.php.test',
    url: '/admin/user/info',
    method: 'get'
    // params: { token }
  })
}

export function logout() {
  return request({
    // url: '/vue-admin-template/user/logout',
    // baseURL: 'http://wechat_mall.php.test',
    // baseURL: 'http://localhost:8222',
    url: '/admin/user/logout',
    method: 'post'
  })
}
