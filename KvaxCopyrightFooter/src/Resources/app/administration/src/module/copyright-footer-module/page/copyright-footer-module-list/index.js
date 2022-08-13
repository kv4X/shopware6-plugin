import template from './copyright-footer-module-list.html.twig';
const { Component } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('copyright-footer-module-list', {
  template,
  inject: [
    'repositoryFactory',
  ],
  data() {
    return {
      total: 0,
      copyrightModuleCollection: null,
      repository: null,
      isLoading: false,
      processSuccess: false
    }
  },
  computed: {
    columns() {
      return [{
        property: 'name',
        dataIndex: 'name',
        label: 'Name',
        allowResize: true,
        sortable: false,
      }];
    }
  },
  created() {
    this.repository = this.repositoryFactory.create('sales_channel');
    this.getCopyRightTextModuleList();
  },
  methods: {
    getCopyRightTextModuleList: function () {
      const criteria = new Criteria();
      this.repository.search(criteria, Shopware.Context.api).then((result) =>{
        this.copyrightModuleCollection = result;
        this.total = result.total;
      })
    }
  }
});