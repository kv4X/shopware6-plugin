const { Module } = Shopware;
import './page/copyright-footer-module-list';
import './page/copyright-footer-module-detail';

Module.register('copyright-footer-module', {
  settingsItem: [{
    name: 'copyright-footer-module',
    label: 'Copyright Footer settings',
    to: 'copyright.footer.module.list',
    group: 'plugins',
    icon: 'default-object-marketing'
  }],
  routes: {
    list: {
      component: 'copyright-footer-module-list',
      path: 'list',
      meta: {
        parentPath: 'sw.settings.index'
      }
    },
    detail: {
      component: 'copyright-footer-module-detail',
      path: 'detail/:id',
      meta: {
        parentPath: 'copyright.footer.module.list'
      }
    },
  }
});
