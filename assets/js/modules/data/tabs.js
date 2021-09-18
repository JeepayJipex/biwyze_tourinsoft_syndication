export default () => {
  Alpine.data('tabs', () => ({
    tab: 'syndications',

    setTab (tab) {
      this.tab = tab;
    }
  }));
}