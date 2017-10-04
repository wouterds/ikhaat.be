const $wrapper = $('#wrapper');

class App {
  constructor($scope) {
    this.$scope = $scope;

    this.init();
    this.initObservers();
  }

  init() {
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

    if (val.length === 0) {
      val = 'Ik haat alles!';
    }

    val = val.toLowerCase();

    let url = location.protocol + '//' + location.host + '/' + encodeURIComponent(val) + '.jpg';

    this.$image.attr('src', url);
    this.$image.attr('alt', val);
    this.$urlInput.val(url);
  }

  urlInputClick(e) {
    this.$urlInput.select();
  }
}

new App($wrapper);
