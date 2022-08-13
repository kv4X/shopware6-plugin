import template from './copyright-footer-module-detail.html.twig';
const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('copyright-footer-module-detail', {
  template,
  inject: [
    'repositoryFactory',
  ],
  mixins: [
    Mixin.getByName('notification')
  ],
  metaInfo() {
    return {
      title: this.$createTitle()
    };
  },
  data() {
    return {
      salesChannel: null,
      color: '#eb4034',
      form: [],
      test: null,
      isLoading: false,
      processSuccess: false,
    };
  },
  computed: {
    salesChannelRepository() {
      return this.repositoryFactory.create('sales_channel');
    },
    salesChannelCopyRightTextRepository() {
      return this.repositoryFactory.create('sales_channel_copyright_texts');
    },
    salesChannelCopyRightSettingsRepository() {
      return this.repositoryFactory.create('sales_channel_copyright_settings');
    }
  },
  created() {
    this.getCopyrightFooterModuleDetail();
  },
  methods: {
    getCopyrightFooterModuleDetail() {
      const criteria = new Criteria()
        .addAssociation('languages')
        .addAssociation('copyRightTexts')
        .addAssociation('copyRightSettings');

      this.salesChannelRepository
        .get(this.$route.params.id, Shopware.Context.api, criteria)
        .then((entity) => {
          this.salesChannel = entity;

          if(entity.extensions.copyRightSettings && entity.extensions.copyRightSettings.color) {
            this.color = entity.extensions.copyRightSettings.color;
          }

          this.handleInputs();
        });
      },
    handleInputs(){
      this.form = [];
      this.salesChannel.languages.map(item => {
        this.form.push({
          languageId: item.id,
          name: item.name,
          value: this.findValue(item.id)
        });
      })
    },
    findValue(id) {
      let index = this.salesChannel.extensions.copyRightTexts.findIndex(item => {
        return item.languageId === id;
      });

      if(index !== -1){
        return this.salesChannel.extensions.copyRightTexts[index].text;
      }

      return 'Copyright © signundsinn GmbH';
    },
    addNewCopyRightText(el) {
      let newCopyRightText = this.salesChannelCopyRightTextRepository.create(Shopware.Context.api);
      newCopyRightText.languageId = el.languageId;
      newCopyRightText.text = el.value;
      newCopyRightText.salesChannelId = this.$route.params.id;

      this.salesChannelCopyRightTextRepository
        .save(newCopyRightText, Shopware.Context.api)
          .then(this.getCopyrightFooterModuleDetail());
    },
    addNewCopyRightSetting(color) {
      let newCopyRightSetting = this.salesChannelCopyRightSettingsRepository.create(Shopware.Context.api);
      newCopyRightSetting.color = color;
      newCopyRightSetting.salesChannelId = this.$route.params.id;

      this.salesChannelCopyRightSettingsRepository
          .save(newCopyRightSetting, Shopware.Context.api);
    },
    onClickSave() {
      this.isLoading = true;

      // updateOrCreate copyRightSettings color
      if(this.salesChannel.extensions.copyRightSettings && this.salesChannel.extensions.copyRightSettings.color){
        this.salesChannel.extensions.copyRightSettings.color = this.color;
      }else{
        this.addNewCopyRightSetting(this.color);
      }

      // updateOrCreate copyRightTexts
      this.form.forEach(el => {
        let index = this.salesChannel.extensions.copyRightTexts.findIndex(item => {
          return item.languageId === el.languageId;
        });

        if(index !== -1){
          this.salesChannel.extensions.copyRightTexts[index].text = el.value;
        }else{
          return this.addNewCopyRightText(el);
        }
      });

      // save
      this.salesChannelRepository
        .save(this.salesChannel, Shopware.Context.api)
        .then(() => {
          this.getCopyrightFooterModuleDetail();
          this.isLoading = false;
          this.processSuccess = true;
        }).catch((exception) => {
          this.isLoading = false;
          this.createNotificationError({
            title: 'Error',
            message: exception
          });
      });
    },
    saveFinish() {
      this.processSuccess = false;
    }
  }
});