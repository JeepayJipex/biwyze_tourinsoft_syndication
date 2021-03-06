(function () {
  'use strict';

  function sortStrings(a, b) {
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

  async function sendRequest (url, method = 'GET', body = {}, params = {}, headers = {}, returnType = 'data') {
    const baseHeaders = generateHeaders(headers);
    try {
      const response = await axios(generateRequestObject(url, method, baseHeaders, body, params));
      return returnType === 'data' ? response.data : response
    } catch (e) {
      alert('Erreur lors du traitement de cette opération' + e.message);
      return null
    }
  }

  const CATEGORIES_PER_PAGE = 50;
  var syndications = () => {
    Alpine.data('syndications', () => ({
      async init () {
        Alpine.store('main').toggleLoading();
        this.syndications = await sendRequest('tourinsoft/v1/syndication') || [];
        this.categories = await this.fetchCategories();
        this.orderedPostTypes = await sendRequest('wp/v2/types') || [];
        if(this.categories && this.categories.length) {
          this.newSyndication.category_id = this.categories[0]?.id;
        }
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
      async fetchCategories() {
        let categories = [];
        let { headers, data } = await sendRequest('wp/v2/categories', 'GET', {}, { per_page: CATEGORIES_PER_PAGE }, {}, 'all');
        if(data && Array.isArray(data)) {
          categories = [...categories, ...data];
        }
        const totalPages = headers['X-WP-TotalPages'] ?? headers['x-wp-totalpages'];
        if(totalPages > 1) {
          for(let i = 1; i < totalPages; i++) {
            const  data = await sendRequest('wp/v2/categories', 'GET', {}, { per_page: CATEGORIES_PER_PAGE, page: i + 1 });
            categories = [...categories, ...data];
          }
        }
        return categories
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
        console.log(this.currentSyndication);
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
        return !(!category_id || Number.isNaN(parseInt(category_id, 10)));

      }
    }));
  };

  var store = () => {
    Alpine.store('main', {
      loading: false,
      toggleLoading () {
        this.loading = !this.loading;
      }
    });

  };

  var tabs = () => {
    Alpine.data('tabs', () => ({
      tab: 'syndications',

      setTab (tab) {
        this.tab = tab;
      }
    }));
  };

  var options = () => {
    Alpine.data('options', () => ({
      async init() {
        await this.getOptions();
      },
      optionsList: [],
      optionsElementor: [],
      getBooleanValue(value) {
        return value !== '0'
      },
      setBooleanValue(value) {
        return value ? '1' : '0'
      },
      transformOptionsValues(options) {
        return options.map(option => ({...option, value: option.type === 'boolean' ? this.setBooleanValue(option.value) : option.value }))
      },
      async saveOptions() {
        const response = await sendRequest('tourinsoft/v1/options', 'POST', {
          options: this.transformOptionsValues(this.optionsList)
        });
        if(response) {
          alert('Options mises à jour avec succès');
          window.location.reload();
        }
      },
      async getOptions() {
        const response = await sendRequest('tourinsoft/v1/options');
        this.optionsList = response.list;
        this.optionsList = this.optionsList.map(option => ({...option, value: option.type === 'boolean' ? this.getBooleanValue(option.value) : option.value}));
        this.optionsElementor = response.elementor;
        this.optionsElementor = this.optionsElementor.map(option => ({...option, value: option.type === 'boolean' ? this.getBooleanValue(option.value) : option.value}));
      },
      async saveElementorOptions() {
        const response = await sendRequest('tourinsoft/v1/options', 'POST', {
          options: this.transformOptionsValues(this.optionsElementor)
        });
        if(response) {
          alert('Options mises à jour avec succès');
          window.location.reload();
        }
      }
    }));
  };

  var importExport = () => {
    Alpine.data('importExport', () => ({
      importData: null,
      importString: '',
      exportData: null,
      exportParsed: null,
      transformOptionsValues(options) {
        return options.map(option => ({...option, value: option.type === 'boolean' ? option.value ? '1' : '0' : option.value }))
      },
      async launchImport(as = 'string') {
        const data = as === 'string' ? JSON.parse(this.importString) : JSON.parse(this.importData);
        console.log(data);

        if(!data || data === '' ||typeof data !== 'object') {
          alert('Fichier d\'import invalide');
          return
        }
        const result = await sendRequest('tourinsoft/v1/import', 'POST', {...data, options: data.options});
        if(result) {
          console.log(result);
          alert('données importées');
          window.location.reload();
          this.importData = null;
          this.importString = '';
        }
      },
      async generateExport() {
        const result = await sendRequest('tourinsoft/v1/export', 'GET');
        if(result) {
          this.exportData = result;
          this.exportParsed = JSON.stringify(result);
          this.downloadObjectAsJson(this.exportData, Date.now() + '_tourinsoft_syndic_export');
        }
      },
     downloadObjectAsJson(exportObj, exportName){
      let dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(exportObj));
      let downloadAnchorNode = document.createElement('a');
      downloadAnchorNode.setAttribute("href",     dataStr);
      downloadAnchorNode.setAttribute("download", exportName + ".json");
      document.body.appendChild(downloadAnchorNode); // required for firefox
      downloadAnchorNode.click();
      downloadAnchorNode.remove();
    }
    }));
  };

  document.addEventListener('alpine:init', () => {
    syndications();
    store();
    tabs();
    options();
    importExport();
  });

}());
