"use strict";var SITENAV=document.querySelector(".main-navigation"),KEYMAP={TAB:9};function initMainNavigation(){if(void 0!==SITENAV){var e=SITENAV.querySelectorAll(".menu ul");if(e.length){var l=getDropdownButton();e.forEach(function(e){var t=e.parentNode,n=t.querySelector(".dropdown");if(!n){(n=document.createElement("span")).classList.add("dropdown");var o=document.createElement("i");o.classList.add("dropdown-symbol"),n.appendChild(o),e.parentNode.insertBefore(n,e)}var a=l.cloneNode(!0);a.innerHTML=n.innerHTML,n.parentNode.replaceChild(a,n),a.addEventListener("click",function(e){toggleSubMenu(this.parentNode)}),t.addEventListener("mouseleave",function(e){toggleSubMenu(this,!1)}),t.querySelector("a").addEventListener("focus",function(e){this.parentNode.parentNode.querySelectorAll("li.toggled-on").forEach(function(e){toggleSubMenu(e,!1)})}),e.addEventListener("keydown",function(e){var t="ul.toggle-show > li > a, ul.toggle-show > li > button";KEYMAP.TAB===e.keyCode&&(!0===e.shiftKey?isfirstFocusableElement(this,document.activeElement,t)&&toggleSubMenu(this.parentNode,!1):islastFocusableElement(this,document.activeElement,t)&&toggleSubMenu(this.parentNode,!1))})}),SITENAV.classList.add("has-dropdown-toggle")}}}function initMenuToggle(){var e=SITENAV.querySelector(".menu-toggle");void 0!==e&&(e.setAttribute("aria-expanded","false"),e.addEventListener("click",function(){SITENAV.classList.toggle("toggled-on"),this.setAttribute("aria-expanded","false"===this.getAttribute("aria-expanded")?"true":"false")},!1))}function toggleSubMenu(e,t){var n=e.querySelector(".dropdown-toggle"),o=e.querySelector("ul"),a=e.classList.contains("toggled-on");void 0!==t&&"boolean"==typeof t&&(a=!t),n.setAttribute("aria-expanded",(!a).toString()),a?(e.classList.remove("toggled-on"),o.classList.remove("toggle-show"),n.setAttribute("aria-label",chilevapeaScreenReaderText.expand),e.querySelectorAll(".toggled-on").forEach(function(e){toggleSubMenu(e,!1)})):(e.parentNode.querySelectorAll("li.toggled-on").forEach(function(e){toggleSubMenu(e,!1)}),e.classList.add("toggled-on"),o.classList.add("toggle-show"),n.setAttribute("aria-label",chilevapeaScreenReaderText.collapse))}function getDropdownButton(){var e=document.createElement("button");return e.classList.add("dropdown-toggle"),e.setAttribute("aria-expanded","false"),e.setAttribute("aria-label",chilevapeaScreenReaderText.expand),e}function isfirstFocusableElement(e,t,n){var o=e.querySelectorAll(n);return 0<o.length&&t===o[0]}function islastFocusableElement(e,t,n){var o=e.querySelectorAll(n);return 0<o.length&&t===o[o.length-1]}initMainNavigation(),initMenuToggle();