<script>
    (() => {
        if (typeof window.fluxModal === 'function') {
            return;
        }

        window.fluxModal = (name, scope) => ({
            handleShow(event) {
                const detail = event?.detail ?? {};

                if (detail.name !== name) {
                    return;
                }

                const sameScope = scope && detail.scope === scope;

                if (sameScope || !detail.scope) {
                    this.$el?.showModal?.();
                }
            },

            handleClose(event) {
                const detail = event?.detail ?? {};

                if (!detail.name) {
                    this.$el?.close?.();
                    return;
                }

                if (detail.name !== name) {
                    return;
                }

                const sameScope = scope && detail.scope === scope;

                if (sameScope || !detail.scope) {
                    this.$el?.close?.();
                }
            },
        });

        document.addEventListener('alpine:init', () => {
            if (!window.Alpine) {
                return;
            }

            try {
                window.Alpine.data('fluxModal', window.fluxModal);
            } catch (e) {
                // no-op
            }
        });
    })();
</script>
