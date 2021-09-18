import {sendRequest, sortStrings} from '../helpers'

export default () => {
  Alpine.data('syndications', () => ({
    async init () {
      Alpine.store('main').toggleLoading();
      this.syndications = await sendRequest('tourinsoft/v1/syndication') || [];
      this.categories = await sendRequest('wp/v2/categories') || [];
      this.orderedPostTypes = await sendRequest('wp/v2/types') || [];
      this.newSyndication.category_id = this.categories[0]?.id || '';
      this.newSyndication.associated_post_type = this.postTypes[0]?.slug || '';
      this.categories.forEach(cat => {
        this.orderedCategories[cat.id] = cat;
      });
      this.postTypes = Object.values(this.orderedPostTypes);
      Alpine.store('main').toggleLoading();
    },
    syndications: [],
    categories: [],
    orderedCategories: {},
    postTypes: [],
    orderedPostTypes: [],
    add: false,
    toggleAdd () {
      this.add = !this.add;
    },
    newSyndication: {
      name: '',
      category_id: '',
      syndic_id: '',
      associated_post_type: '',
    },
    updatedSyndication: {
      name: '',
      category_id: '',
      syndic_id: '',
      associated_post_type: ''
    },
    resetNewSyndication () {
      this.newSyndication = {
        name: '',
        category_id: this.categories[0].id,
        syndic_id: '',
        associated_post_type: this.postTypes[0].slug
      };
    },
    getCategoryName (id) {
      return this.orderedCategories[id]?.name
    },
    getPostTypeName (slug) {
      return this.orderedPostTypes[slug]?.name
    },
    updating: false,
    updatingId: null,
    startSyndicationUpdate (syndication) {
      this.updatedSyndication = {
        name: syndication.name,
        category_id: syndication.category_id,
        syndic_id: syndication.syndic_id,
        associated_post_type: syndication.associated_post_type
      };
      this.updating = true;
      this.updatingId = syndication.id;
    },
    cancelSyndicationUpdate () {
      this.updatedSyndication = {
        name: '',
        category_id: this.categories[0].id,
        syndic_id: '',
        associated_post_type: this.postTypes[0].slug
      };
      this.updating = false;
      this.updatingId = null;
    },
    async updateSyndication () {
      Alpine.store('main').toggleLoading();
      const myModal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
      const updatedSyndic = await sendRequest('tourinsoft/v1/syndication/' + this.updatingId, 'PUT', {syndication: this.updatedSyndication});
      if (updatedSyndic) {
        this.syndications = this.syndications.map(s => {
          if (s.id === this.updatingId) {
            return updatedSyndic
          }
          return s
        });
        myModal.hide();
      }
      this.cancelSyndicationUpdate();
      Alpine.store('main').toggleLoading();
    },
    async createSyndication () {
      Alpine.store('main').toggleLoading();
      const addedSyndic = await sendRequest('tourinsoft/v1/syndication', 'POST', {syndication: this.newSyndication});
      if (addedSyndic) {
        this.syndications = [...this.syndications, addedSyndic];
      }
      this.resetNewSyndication();
      Alpine.store('main').toggleLoading();
    },
    async deleteSyndication (id) {
      Alpine.store('main').toggleLoading();
      if (confirm('Êtes vous sûr de vouloir supprimer cette syndication ?')) {
        const result = await sendRequest('tourinsoft/v1/syndication/' + id, 'DELETE');
        if (result.success) {
          this.syndications = this.syndications.filter(s => s.id !== id);
          alert('Syndication supprimée avec succès.');
        }
      }
      Alpine.store('main').toggleLoading();
    },
    currentSyndication: {},
    async getCurrentSyndication (id) {
      this.currentSyndication = await sendRequest('tourinsoft/v1/syndication/' + id);
    },
    getCurrentSyndicationFields () {
      return Object.keys(this.currentSyndication?.offers?.raw[0] || []).sort(sortStrings)
    },
    getCurrentSyndicationOffers (type = 'raw') {
      return this.currentSyndication?.offers && type in this.currentSyndication?.offers ? this.currentSyndication?.offers[type].sort((a, b) => sortStrings(a.SyndicObjectName, b.SyndicObjectName)) : []
    },
    getCurrentSyndicationName () {
      return this.currentSyndication?.syndication?.name || ''
    },
    async syncAll () {
      Alpine.store('main').toggleLoading();
      if (confirm('Êtes vous sûr de vouloir importer les offres de toutes les syndications ?')) {
        const result = await sendRequest('tourinsoft/v1/updater', 'POST');
        if (result) {
          alert('Syndications synchronisées');
        } else {
          alert('Erreur lors de la synchronisation');
        }
      }
      Alpine.store('main').toggleLoading();
    },
    async syncOne (id) {
      Alpine.store('main').toggleLoading();
      const syndication = this.syndications.find(s => s.id === id);
      if (confirm('Êtes vous sûr de vouloir importer les offres ' + syndication?.name + ' ?')) {
        const result = await sendRequest('tourinsoft/v1/updater/' + id, 'POST');
        if (result) {
          alert('Syndication ' + syndication?.name + ' synchronisée');
        } else {
          alert('Erreur lors de la synchronisation');
        }
      }
      Alpine.store('main').toggleLoading();
    },
    validateSyndication (syndication) {
      const {name, syndic_id, category_id, associated_post_type} = syndication;
      if (typeof name !== 'string' || name === '') return false
      if (typeof associated_post_type !== 'string' || associated_post_type === '') return false
      if (typeof syndic_id !== 'string' || syndic_id === '') return false
      if (!category_id || Number.isNaN(parseInt(category_id, 10))) return false
      return true
    }
  }));
}
