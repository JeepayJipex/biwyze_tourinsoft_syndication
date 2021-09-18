export default () => {
  Alpine.store('main', {
    loading: false,
    toggleLoading () {
      this.loading = !this.loading;
    }
  });

}