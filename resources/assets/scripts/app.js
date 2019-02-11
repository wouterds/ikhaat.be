import Clipboard from 'clipboard';
import '../styles/app.scss';

const wrapper = document.getElementById('wrapper');
const input = document.getElementById('input');
const image = document.getElementById('image');
const urlInput = document.getElementById('urlInput');
const urlInputWrapper = document.getElementById('urlInputWrapper');
const copiedToClipboardMessage = document.getElementById('copiedToClipboardMessage');

let removeCopiedNoticeTimer = null;
const removeCopiedNotice = () => {
  urlInput.blur();
  urlInputWrapper.classList.remove('copied-to-clipboard');

  if (removeCopiedNoticeTimer) {
    clearTimeout(removeCopiedNoticeTimer);
  }

  removeCopiedNoticeTimer = null;
};

const inputOnKeyUp = e => {
  e.preventDefault();

  let { value } = input;

  // No value?
  if (value.length === 0) {
    value = input.getAttribute('placeholder');
  }

  // Always lowercase
  value = value.toLowerCase();

  // Compose url
  const url = `${wrapper.getAttribute('data-app-url')}/${encodeURIComponent(value)}.jpg`;

  image.setAttribute('src', url);
  image.setAttribute('alt', value);
  urlInput.value = url;

  removeCopiedNotice();
};

const inputOnClick = e => {
  e.preventDefault();

  // If clipboard works, stop here
  if (Clipboard.isSupported()) {
    urlInputWrapper.classList.add('copied-to-clipboard');
    copiedToClipboardMessage.innerText = copiedToClipboardMessage.getAttribute('data-text');
    removeCopiedNoticeTimer = setTimeout(removeCopiedNotice, 3000);
    return;
  }

  // Else select contents of input
  urlInput.setSelectionRange(0, urlInput.value.length);
};

// Event listeners
input.addEventListener('keyup', inputOnKeyUp);
urlInput.addEventListener('click', inputOnClick);

// Trigger initial event
input.dispatchEvent(new KeyboardEvent('keyup'));

// Clipboard plugin
new Clipboard(urlInput);
