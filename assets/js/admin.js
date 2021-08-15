
document.addEventListener('alpine:init', () => {

  Alpine.data('tabs', () => ({
    tab: 'options',

    setTab(tab) {
      this.tab = tab
    }
  }))


  Alpine.data('syndications', () => ({
    async init() {
      this.syndications = await sendRequest('tourinsoft/v1/syndication')
      this.categories = await sendRequest('wp/v2/categories')
      this.categories.forEach(cat => {
        this.orderedCategories[cat.id] = cat
      })
    },
    syndications: [],
    categories: [],
    orderedCategories: [],
    add: false,
    toggleAdd () {
      this.add = !this.add
    },
    newSyndication: {
      name: '',
      category_id: '',
      syndic_id: ''
    },
    loading: false,

    getCategoryName(id) {
      return this.orderedCategories[id].name
    },

    async createSyndication (e) {
      this.loading = true
      const addedSyndic = await sendRequest('tourinsoft/v1/syndication', 'POST', {syndication: this.newSyndication})
      this.syndications = [...this.syndications, addedSyndic]
      this.loading = false
    }
  }))
})


async function sendRequest (url, method= 'GET', body = {}, headers = {}) {
  const baseHeaders = {
    'X-WP_Nonce': biwyzeGlobals.rest_nonce,
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    ...headers
  }
 const {data} = await axios({
   url: biwyzeGlobals.rest_url + url,
   method,
    headers: baseHeaders,
   data:body
})
  return data
}
