<modal-dialog>
    <style scope>
        modal-dialog .modal {
            display: none;
            position: fixed;
            left: 0;
            top: var(--margin-top, 10%);
            right: 0;
            background-color: var(--background, #fafafa);
            padding: 0;
            width: var(--width, 55%);
            margin: auto;
            will-change: top, opacity;
            -webkit-box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.3);
            box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.3);
            opacity: 1;
            transform: scaleX(1);
        }

        modal-dialog:not([custom-dialog]) .modal {
            max-height: var(--max-height, 70%);
            overflow-y: var(--overflow-y, auto);

        }

        @media only screen and (max-width: 992px) {
            modal-dialog .modal {
                width: 100%;
                top: 0;
            }

            modal-dialog[full-screen-on-small] .modal {
                max-height: 100%;
                height: 100%;
            }
        }

        modal-dialog .modal .modal-content {
            padding: var(--content-padding, 24px);
        }

        modal-dialog .modal-overlay {
            position: fixed;
            z-index: 999;
            top: -25%;
            left: 0;
            bottom: 0;
            right: 0;
            height: 125%;
            width: 100%;
            background: #000;
            display: none;
            will-change: opacity;
            opacity: 0.5;
        }

        modal-dialog[bottom-sheet] .modal {
            top: auto;
            bottom: 0;
            margin: 0;
            width: 100%;
            max-height: 45%;
            border-radius: 0;
            will-change: bottom, opacity;
        }

        modal-dialog .animate-zoom {
            animation: animatezoom 0.6s
        }

        @keyframes animatezoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        modal-dialog .animate-fading {
            animation: fading 0.6s
        }

        @keyframes fading {
            0% {
                opacity: 0.8
            }
            50% {
                opacity: 0.5
            }
            100% {
                opacity: 0
            }
        }

        modal-dialog .modal-content [fixed-bottom],
        modal-dialog .modal-content [fixed-top] {
            position: absolute;
            right: 0;
            left: 0;
            --overflow-y: hidden;
            --max-height: auto;

        }

        modal-dialog .modal-content [fixed-top] {
            top: 0;
        }

        modal-dialog .modal-content [fixed-bottom] {
            bottom: 0;
        }

        modal-dialog .modal-content [fixed-main] {
            margin-top: var(--fixed-main-top, 48px);
            margin-bottom: var(--fixed-main-bottom, 64px);
            height: var(--fixed-dialog-height, 400px);
            overflow-y: auto;
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
