import syndications from './modules/data/syndications'
import store from './modules/stores/mainStore'
import tabs from './modules/data/tabs'

document.addEventListener('alpine:init', () => {
  syndications()
  store()
  tabs()
})

