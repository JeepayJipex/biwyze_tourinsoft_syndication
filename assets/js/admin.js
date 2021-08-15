document.addEventListener('alpine:init', () => {

  Alpine.store('main', {
    loading: false,
    toggleLoading () {
      this.loading = !this.loading
    }
  })

  Alpine.data('tabs', () => ({
    tab: 'syndications',

    setTab (tab) {
      this.tab = tab
    }
  }))


  Alpine.data('syndications', () => ({
    async init () {
      Alpine.store('main').toggleLoading()
      this.syndications = await sendRequest('tourinsoft/v1/syndication') || []
      this.categories = await sendRequest('wp/v2/categories') || []
      this.newSyndication.category_id = this.categories[0]?.id || ''
      this.categories.forEach(cat => {
        this.orderedCategories[cat.id] = cat
      })
      Alpine.store('main').toggleLoading()
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

    getCategoryName (id) {
      return this.orderedCategories[id]?.name
    },
    updating: false,
    updatingId: null,
    startSyndicationUpdate (syndication) {
      this.updatedSyndication = {
        name: syndication.name,
        category_id: syndication.category_id,
        syndic_id: syndication.syndic_id
      }
      this.updating = true
      this.updatingId = syndication.id
      location.href = "#update-syndication";
    },
    cancelSyndicationUpdate () {
      this.updatedSyndication = {
        name: '',
        category_id: '',
        syndic_id: ''
      }
      this.updating = false
      this.updatingId = null
    },
    async updateSyndication () {
      Alpine.store('main').toggleLoading()
      const updatedSyndic = await sendRequest('tourinsoft/v1/syndication/' + this.updatingId, 'PUT', {syndication: this.updatedSyndication})
      if (updatedSyndic) {
        this.syndications = this.syndications.map(s => {
          if (s.id === this.updatingId) {
            return updatedSyndic
          }
          return s
        })
      }
      this.cancelSyndicationUpdate()
      Alpine.store('main').toggleLoading()
    },
    async createSyndication () {
      Alpine.store('main').toggleLoading()
      const addedSyndic = await sendRequest('tourinsoft/v1/syndication', 'POST', {syndication: this.newSyndication})
      if (addedSyndic) {
        this.syndications = [...this.syndications, addedSyndic]
      }
      this.newSyndication = {
        name: '',
        category_id: '',
        syndic_id: ''
      }
      Alpine.store('main').toggleLoading()
    },
    async deleteSyndication (id) {
      Alpine.store('main').toggleLoading()
      if (confirm('Êtes vous sûr de vouloir supprimer cette syndication ?')) {
        const result = await sendRequest('tourinsoft/v1/syndication/' + id, 'DELETE')
        if (result.success) {
          this.syndications = this.syndications.filter(s => s.id !== id)
          alert('Syndication supprimée avec succès.')
        }
      }
      Alpine.store('main').toggleLoading()
    }
  }))
})


async function sendRequest (url, method = 'GET', body = {}, headers = {}) {
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
