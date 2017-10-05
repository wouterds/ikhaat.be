const $wrapper = $('#wrapper');

class App {
  constructor($scope) {
    this.$scope = $scope;

    this.init();
    this.initObjects();
    this.initObservers();

    // Trigger input once to pre-fill url input
    this.$input.trigger('keyup');
  }

  init() {
    this.APP_URL = this.$scope.data('app-url');
    this.$input = this.$scope.find("#input");
    this.$image = this.$scope.find("#image");
    this.$urlInputWrapper = this.$scope.find('#urlInputWrapper');
    this.$urlInput = this.$urlInputWrapper.find('#urlInput');
  }

  initObjects() {
    this.clipboard = new Clipboard(this.$urlInput.get(0));
  }

  initObservers() {
    this.$input.on('keyup', ::this.inputOnKeyup);
    this.$urlInput.on('click', ::this.urlInputClick);
    this.clipboard.on('success', ::this.clipboardSuccess);
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
    this.$urlInputWrapper.removeClass('copied-to-clipboard');
    this.removeCopiedNotice();
  }

  urlInputClick(e) {
    if (Clipboard.isSupported()) {
      return;
    }

    this.$urlInput.select();
  }

  clipboardSuccess(e) {
    this.$urlInputWrapper.addClass('copied-to-clipboard');
    this.removeCopiedNoticeTimer = setTimeout(::this.removeCopiedNotice, 5000);
  }

  removeCopiedNotice() {
    this.$urlInput.blur();
    this.$urlInputWrapper.removeClass('copied-to-clipboard');

    if (this.removeCopiedNoticeTimer) {
      clearTimeout(this.removeCopiedNoticeTimer);
    }

    this.removeCopiedNoticeTimer = null;
  }
}

new App($wrapper);
