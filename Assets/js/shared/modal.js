class Modal {
  show(title, content) {
    const modal = document.createElement("div");
    modal.classList.add("modal");

    modal.innerHTML = `
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2>${title}</h2>
        </div>
        <div class="modal-body">
          ${content}
        </div>
      </div>
    `;

    document.querySelector("body").appendChild(modal);

    modal.querySelector(".close").addEventListener("click", () => this.close());

    this.__onCloseEventListener = event => {
      if (event.target === modal) {
        this.close();
      }
    };

    window.addEventListener("click", this.__onCloseEventListener);

    this.__modal = modal;
  }

  close() {
    window.removeEventListener("click", this.__onCloseEventListener);

    this.__modal.remove();
  }
}
