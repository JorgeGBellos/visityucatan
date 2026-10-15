import './bootstrap';
import Alpine from 'alpinejs';

Alpine.data('siteCarousel', () => ({
    dragging: false,
    moved: false,
    startX: 0,
    scrollStart: 0,

    slide(dir) {
        const track = this.$refs.track;
        if (!track) return;

        const card = track.querySelector('[data-card]');
        if (!card) return;

        const styles = getComputedStyle(track);
        const gap = parseFloat(styles.columnGap || styles.gap) || 24;
        track.scrollBy({
            left: dir * (card.getBoundingClientRect().width + gap),
            behavior: 'smooth',
        });
    },

    onPointerDown(event) {
        const track = this.$refs.track;
        if (!track || event.pointerType !== 'mouse' || event.button > 0) return;

        this.dragging = true;
        this.moved = false;
        this.startX = event.clientX;
        this.scrollStart = track.scrollLeft;
        track.classList.remove('scroll-smooth');
        track.setPointerCapture?.(event.pointerId);
    },

    onPointerMove(event) {
        if (!this.dragging) return;

        const track = this.$refs.track;
        if (!track) return;

        const delta = event.clientX - this.startX;
        if (Math.abs(delta) > 4) {
            this.moved = true;
        }

        track.scrollLeft = this.scrollStart - delta;
    },

    onPointerUp(event) {
        if (!this.dragging) return;

        const track = this.$refs.track;
        this.dragging = false;
        track?.releasePointerCapture?.(event.pointerId);
        track?.classList.add('scroll-smooth');
    },

    onClickCapture(event) {
        if (!this.moved) return;

        event.preventDefault();
        event.stopPropagation();
        this.moved = false;
    },
}));

Alpine.data('statCounter', (target, prefix = '', suffix = '', pad = 0, grouped = false) => ({
    current: 0,
    started: false,
    target: Number(target),
    prefix,
    suffix,
    pad: Number(pad) || 0,
    grouped: Boolean(grouped),

    get display() {
        const n = Math.round(this.current);
        const digits = this.pad > 0 ? String(n).padStart(this.pad, '0') : String(n);
        const formatted = this.grouped
            ? digits.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
            : digits;

        return `${this.prefix}${formatted}${this.suffix}`;
    },

    init() {
        if (!Number.isFinite(this.target)) {
            return;
        }

        const io = new IntersectionObserver(
            ([entry]) => {
                if (!entry?.isIntersecting) {
                    return;
                }

                this.start();
                io.disconnect();
            },
            { threshold: 0.35 },
        );

        io.observe(this.$el);
    },

    start() {
        if (this.started) {
            return;
        }

        this.started = true;

        if (this.target <= 0) {
            this.current = this.target;
            return;
        }

        const duration = 1400;
        const from = 0;
        const start = performance.now();

        const tick = (now) => {
            const t = Math.min(1, (now - start) / duration);
            const eased = 1 - (1 - t) ** 3;
            this.current = from + (this.target - from) * eased;

            if (t < 1) {
                requestAnimationFrame(tick);
            } else {
                this.current = this.target;
            }
        };

        requestAnimationFrame(tick);
    },
}));

window.Alpine = Alpine;
Alpine.start();
