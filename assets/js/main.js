import syndications from './modules/data/syndications'
import store from './modules/stores/mainStore'
import tabs from './modules/data/tabs'
import options from './modules/data/options'
import importExport from './modules/data/import-export'

document.addEventListener('alpine:init', () => {
  syndications()
  store()
  tabs()
  options()
  importExport()
})

