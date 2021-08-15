
document.addEventListener('alpine:init', () => {

  Alpine.data('tabs', () => ({
    tab: 'syndications',

    setTab(tab) {
      this.tab = tab
    }
  }))


  Alpine.data('syndications', () => ({
    async init() {
      this.syndications = await sendRequest('tourinsoft/v1/syndication')
      this.categories = await sendRequest('wp/v2/categories')
      this.newSyndication.category_id = this.categories[0]?.id || ''
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
    updatedSyndication: {
      name: '',
      category_id: '',
      syndic_id: ''
    },
    loading: false,

    getCategoryName(id) {
      return this.orderedCategories[id]?.name
    },
    updating: false,
    updatingId: null,
    startSyndicationUpdate(syndication) {
      this.updatedSyndication = {name: syndication.name, category_id: syndication.category_id, syndic_id: syndication.syndic_id}
      this.updating = true
      this.updatingId = syndication.id
      location.href = "#update-syndication";
    },
    cancelSyndicationUpdate() {
      this.updatedSyndication = {
        name: '',
        category_id: '',
        syndic_id: ''
      }
      this.updating = false
      this.updatingId = null
    },
    async updateSyndication () {
      this.loading = true
      const updatedSyndic = await sendRequest('tourinsoft/v1/syndication/' + this.updatingId, 'PUT', {syndication: this.updatedSyndication})
      this.syndications = this.syndications.map(s => {
        if(s.id === this.updatingId) {
          return updatedSyndic
        }
        return s
      })
      this.cancelSyndicationUpdate()
      this.loading = false
    },
    async createSyndication () {
      this.loading = true
      const addedSyndic = await sendRequest('tourinsoft/v1/syndication', 'POST', {syndication: this.newSyndication})
      this.syndications = [...this.syndications, addedSyndic]
      this.newSyndication = {
        name: '',
        category_id: '',
        syndic_id: ''
      }
      this.loading = false
    },
    async deleteSyndication (id) {
      this.loading = true
      if(confirm('Êtes vous sûr de vouloir supprimer cette syndication ?')) {
        const result = await sendRequest('tourinsoft/v1/syndication/' + id, 'DELETE')
        if (result.success) {
          this.syndications = this.syndications.filter(s => s.id !== id)
          alert('Syndication supprimée avec succès.')
        }
      }
      this.loading = false
    }
  }))
})


async function sendRequest (url, method= 'GET', body = {}, headers = {}) {
  const baseHeaders = {
    'X-WP-Nonce': biwyzeGlobals.rest_nonce,
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
