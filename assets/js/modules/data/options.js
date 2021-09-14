import {sendRequest} from '../helpers'

export default () => {
  Alpine.data('options', () => ({
    async init() {
      await this.getOptions()
    },
    optionsList: [],
    getBooleanValue(option) {
      return option !== '0'
    },
    setBooleanValue(option) {
      return option ? '1' : '0'
    },
    transformOptionsValues(options) {
      return options.map(option => ({...option, value: option.type === 'boolean' ? option.value ? '1' : '0' : option.value }))
    },
    async saveOptions() {
      const response = await sendRequest('tourinsoft/v1/options', 'POST', {
        options: this.transformOptionsValues(this.optionsList)
      })
      if(response) {
        alert('Options mises à jour avec succès')
        await this.getOptions()
      }
    },
    async getOptions() {
      this.optionsList = await sendRequest('tourinsoft/v1/options')
    }
  }))
}