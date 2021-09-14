export function sortStrings(a, b) {
  return a.localeCompare(b)
}

export async function sendRequest (url, method = 'GET', body = {}, headers = {}) {
  const baseHeaders = {
    'X-WP-Nonce': biwyzeGlobals.rest_nonce,
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    ...headers
  }
  try {
    const {data} = await axios({
      url: biwyzeGlobals.rest_url + url,
      method,
      headers: baseHeaders,
      data: body
    })
    return data
  } catch (e) {
    alert('Erreur lors du traitement de cette opération' + e.message)
    return null
  }
}
