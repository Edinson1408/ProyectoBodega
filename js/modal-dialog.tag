<modal-dialog>
    <style scope>
       modal-dialog .materialboxed:hover:not(.active) {
            opacity: .8;
            }
        modal-dialog .modal {
            display: none;
            position: fixed;
            left: 0;
            right: 0;
            background-color: #fafafa;
            padding: 0;
            max-height: 70%;
            width: 55%;
            margin: auto;
            overflow-y: auto;
            border-radius: 2px;
            will-change: top, .8;
        }

       modal-dialog .z-depth-4, .modal {
  box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.3);
}

    @media only screen and (max-width: 992px) {
        modal-dialog .modal {
        width: 80%;
    }
    }

 modal-dialog .modal h1, .modal h2, .modal h3, .modal h4 {
  margin-top: 0;
}

 modal-dialog .modal .modal-content {
  padding: 24px;
}

 modal-dialog .modal .modal-close {
  cursor: pointer;
}

 modal-dialog .modal .modal-footer {
  border-radius: 0 0 2px 2px;
  background-color: #fafafa;
  padding: 4px 6px;
  height: 56px;
  width: 100%;
}

 modal-dialog .modal .modal-footer .btn, .modal .modal-footer .btn-large, .modal .modal-footer .btn-flat {
  float: right;
  margin: 6px 0;
}

 modal-dialog .modal-overlay {
  position: fixed;
  z-index: 999;
  top: -100px;
  left: 0;
  bottom: 0;
  right: 0;
  height: 125%;
  width: 100%;
  background: #000;
  display: none;
  will-change: .8;
}
modal-dialog .modal.modal-fixed-footer {
  padding: 0;
  height: 70%;
}

modal-dialog .modal.modal-fixed-footer .modal-content {
  position: absolute;
  height: calc(100% - 56px);
  max-height: 100%;
  width: 100%;
  overflow-y: auto;
}

modal-dialog .modal.modal-fixed-footer .modal-footer {
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  position: absolute;
  bottom: 0;
}

modal-dialog .modal.bottom-sheet {
  top: auto;
  bottom: -100%;
  margin: 0;
  width: 100%;
  max-height: 45%;
  border-radius: 0;
  will-change: bottom, .8;
}

modal-dialog .z-depth-4, .modal {
  box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.3);
}
       

    </style>
    <div ref="dialog" class="modal">
        <div class="modal-content">
            <yield/>
        </div>
    </div>
    <div class="modal-overlay" ref="modal-overlay"></div>
    <script>
        this.multiDialog = opts.multiDialog || false;
        this.zIndex = opts.zIndex || 3000;
        this.customDialog = opts.customDialog || false;
        this.on("mount", () => {
            this.onResize = () => {
                console.log("dialog event", window.innerWidth);
                if (window.innerWidth > 996) return;
                this.refs.dialog.children[0].style.height = (window.innerHeight - 96) + 'px';
            };
            if (this.customDialog) {
                let height = (window.innerWidth > 996) ? (window.innerHeight / 2) + 20 : window.innerHeight - 96;

                this.refs.dialog.children[0].style.height = height + 'px';

            }
            if (this.multiDialog) {
                this.refs.dialog.addEventListener('click', () => {
                    this.zIndex++;
                    this.refs.dialog.style.zIndex = this.zIndex;
                });
            }
            this.handleListener = () => {
                this.close();
            };
            this.refs.dialog.style.zIndex = this.zIndex;
        });
        open() {
            this.root.style.display="block";
            this.refs.dialog.style.display = "block";
            this.refs.dialog.classList.add("animate-zoom");
            this.refs['modal-overlay'].style.display = "block";
            setTimeout(() => {
                this.refs.dialog.classList.remove("animate-zoom");
            }, 250);
            this.refs['modal-overlay'].addEventListener("click", this.handleListener);
            if (this.customDialog) {
                window.addEventListener('resize', this.onResize);
            }
        }
        removeListeners() {
            this.refs['modal-overlay'].removeEventListener("click", this.handleListener);
            if (this.customDialog) {
                window.removeEventListener('resize', this.onResize);
            }
        }
        destroy(){
            this.removeListeners();
            this.root.remove();
        }
        close() {
            this.refs.dialog.classList.add("animate-fading");
            setTimeout(() => {
                this.refs.dialog.style.display = "none";
                this.refs.dialog.classList.remove("animate-fading");
            }, 500);
            this.refs['modal-overlay'].style.display = "none";
            this.removeListeners();
        }

    </script>
</modal-dialog>
