import {sendRequest} from '../helpers'

export default () => {
  Alpine.data('options', () => ({
    async init() {
      await this.getOptions()
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
      })
      if(response) {
        alert('Options mises à jour avec succès')
        window.location.reload()
      }
    },
    async getOptions() {
      const response = await sendRequest('tourinsoft/v1/options')
      this.optionsList = response.list
      this.optionsList = this.optionsList.map(option => ({...option, value: option.type === 'boolean' ? this.getBooleanValue(option.value) : option.value}))
      this.optionsElementor = response.elementor
      this.optionsElementor = this.optionsElementor.map(option => ({...option, value: option.type === 'boolean' ? this.getBooleanValue(option.value) : option.value}))
    },
    async saveElementorOptions() {
      const response = await sendRequest('tourinsoft/v1/options', 'POST', {
        options: this.transformOptionsValues(this.optionsElementor)
      })
      if(response) {
        alert('Options mises à jour avec succès')
        window.location.reload()
      }
    }
  }))
}