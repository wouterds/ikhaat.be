// this.APP_URL = this.$scope.data('app-url');
// this.clipboard = new Clipboard(this.$urlInput.get(0));

// inputOnKeyup(e) {
//   let val = this.$input.val();

//   // No value?
//   if (val.length === 0) {
//     // Use the one from the placeholder!
//     val = this.$input.attr('placeholder');
//   }

//   val = val.toLowerCase();

//   let url = this.APP_URL + '/' + encodeURIComponent(val) + '.jpg';

//   this.$image.attr('src', url);
//   this.$image.attr('alt', val);
//   this.$urlInput.val(url);
//   this.$urlInputWrapper.removeClass('copied-to-clipboard');
//   this.removeCopiedNotice();
// }

// urlInputClick(e) {
//   if (Clipboard.isSupported()) {
//     return;
//   }

//   this.$urlInput.select();
// }

// clipboardSuccess(e) {
//   this.$urlInputWrapper.addClass('copied-to-clipboard');
//   this.removeCopiedNoticeTimer = setTimeout(::this.removeCopiedNotice, 5000);
// }

// removeCopiedNotice() {
//   this.$urlInput.blur();
//   this.$urlInputWrapper.removeClass('copied-to-clipboard');

//   if (this.removeCopiedNoticeTimer) {
//     clearTimeout(this.removeCopiedNoticeTimer);
//   }

//   this.removeCopiedNoticeTimer = null;
// }
