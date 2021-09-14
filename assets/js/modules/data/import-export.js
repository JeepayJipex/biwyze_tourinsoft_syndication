import {sendRequest} from '../helpers'

export default () => {
  Alpine.data('importExport', () => ({
    importData: null,
    importString: '',
    exportData: null,
    exportParsed: null,
    transformOptionsValues(options) {
      return options.map(option => ({...option, value: option.type === 'boolean' ? option.value ? '1' : '0' : option.value }))
    },
    async launchImport(as = 'string') {
      const data = as === 'string' ? JSON.parse(this.importString) : JSON.parse(this.importData)
      console.log(data)

      if(!data || data === '' ||typeof data !== 'object') {
        alert('Fichier d\'import invalide')
        return
      }
      const result = await sendRequest('tourinsoft/v1/import', 'POST', {...data, options: data.options})
      if(result) {
        console.log(result)
        alert('données importées')
        window.location.reload()
        this.importData = null
        this.importString = ''
      }
    },
    async generateExport() {
      const result = await sendRequest('tourinsoft/v1/export', 'GET')
      if(result) {
        this.exportData = result
        this.exportParsed = JSON.stringify(result)
        this.downloadObjectAsJson(this.exportData, Date.now() + '_tourinsoft_syndic_export')
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
  }))
}