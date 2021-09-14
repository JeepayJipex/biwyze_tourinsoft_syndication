import {sendRequest} from '../helpers'

export default () => {
  Alpine.data('importExport', () => ({
    importData: null,
    exportData: null,
    async import() {
      const result = await sendRequest('tourinsoft/v1/import', '¨POST', JSON.parse(this.importData))
      if(result) {
        alert('données importées')
        window.location.reload()
      }
    },
    async generateExport() {
      const result = await sendRequest('tourinsoft/v1/export', '¨GET')
      if(result) {
        this.exportData = result
      }
    }
  }))
}