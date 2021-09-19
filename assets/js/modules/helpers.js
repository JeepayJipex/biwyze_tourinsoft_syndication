export function sortStrings(a, b) {
  return a.localeCompare(b)
}

function generateHeaders (headers) {
  return {
    'X-WP-Nonce': biwyzeGlobals.rest_nonce,
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    ...headers
  }
}

function generateRequestObject (url, method, baseHeaders, body, params) {
  return {
    url: biwyzeGlobals.rest_url + url,
    method,
    headers: baseHeaders,
    data: body,
    params
  }
}

export async function sendRequest (url, method = 'GET', body = {}, params = {}, headers = {}, returnType = 'data') {
  const baseHeaders = generateHeaders(headers)
  try {
    const response = await axios(generateRequestObject(url, method, baseHeaders, body, params))
    return returnType === 'data' ? response.data : response
  } catch (e) {
    alert('Erreur lors du traitement de cette opération' + e.message)
    return null
  }
}

