import request from '@/utils/request'

export function fetchMedia(uri) {
  uri = uri.replace(/^\/?api/, '')
  return request({
    url: uri,
    method: 'get'
  })
}
