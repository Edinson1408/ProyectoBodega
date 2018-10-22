class SellModal extends HTMLElement {
    constructor(){
      super();
    }
  
    connectedCallback(){
      let shadowRoot=this.attachShadow({mode:'open'});
      shadowRoot.innerHTML=``;
    }
}
window.customElements.define('sell-cliente',SellModal)