import {sendRequest} from '../helpers'

export default () => {
  Alpine.data('options', () => ({
    async init() {
      await this.getOptions()
    },
    optionsList: [],
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
        await this.getOptions()
      }
    },
    async getOptions() {
      this.optionsList = await sendRequest('tourinsoft/v1/options')
      this.optionsList = this.optionsList.map(option => ({...option, value: option.type === 'boolean' ? this.getBooleanValue(option.value) : option.value}))
    }
  }))
}