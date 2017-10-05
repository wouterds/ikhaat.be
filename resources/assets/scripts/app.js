const $wrapper = $('#wrapper');

class App {
  constructor($scope) {
    this.$scope = $scope;

    this.init();
    this.initObservers();

    // Trigger input once to pre-fill url input
    this.$input.trigger('keyup');
  }

  init() {
    this.APP_URL = this.$scope.data('app-url');
    this.$input = this.$scope.find("#input");
    this.$image = this.$scope.find("#image");
    this.$urlInput = this.$scope.find('#urlInput');
  }

  initObservers() {
    this.$input.on('keyup', ::this.inputOnKeyup);
    this.$urlInput.on('click', ::this.urlInputClick);
  }

  inputOnKeyup(e) {
    let val = this.$input.val();

    // No value?
    if (val.length === 0) {
      // Use the one from the placeholder!
      val = this.$input.attr('placeholder');
    }

    val = val.toLowerCase();

    let url = this.APP_URL + '/' + encodeURIComponent(val) + '.jpg';

    this.$image.attr('src', url);
    this.$image.attr('alt', val);
    this.$urlInput.val(url);
  }

  urlInputClick(e) {
    this.$urlInput.select();
  }
}

new App($wrapper);
