import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.toggle('hidden') === false;
            mobileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    const revealItems = Array.from(document.querySelectorAll('[data-reveal]'));

    if (revealItems.length) {
        if (!('IntersectionObserver' in window)) {
            revealItems.forEach((item) => item.classList.add('is-visible'));
        } else {
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            }, {
                threshold: 0.18,
                rootMargin: '0px 0px -8% 0px',
            });

            revealItems.forEach((item) => revealObserver.observe(item));
        }
    }

    document.querySelectorAll('[data-hero-slider]').forEach((slider) => {
        const slides = Array.from(slider.querySelectorAll('[data-slide]'));
        const dots = Array.from(slider.querySelectorAll('[data-slider-dot]'));
        const prevButton = slider.querySelector('[data-slider-prev]');
        const nextButton = slider.querySelector('[data-slider-next]');
        const autoMs = Number(slider.getAttribute('data-auto-ms') ?? '7000');

        if (!slides.length) {
            return;
        }

        let activeIndex = 0;
        let timerId = null;

        const render = (index) => {
            activeIndex = index;

            slides.forEach((slide, slideIndex) => {
                const active = slideIndex === activeIndex;
                slide.setAttribute('aria-hidden', active ? 'false' : 'true');
                slide.classList.toggle('opacity-100', active);
                slide.classList.toggle('pointer-events-auto', active);
                slide.classList.toggle('opacity-0', !active);
                slide.classList.toggle('pointer-events-none', !active);
            });

            dots.forEach((dot, dotIndex) => {
                const active = dotIndex === activeIndex;
                dot.classList.toggle('w-8', active);
                dot.classList.toggle('bg-ember', active);
                dot.classList.toggle('w-2.5', !active);
                dot.classList.toggle('bg-white/85', !active);
            });
        };

        const goTo = (index) => {
            const safeIndex = (index + slides.length) % slides.length;
            render(safeIndex);
        };

        const startAuto = () => {
            if (slides.length <= 1) {
                return;
            }

            timerId = window.setInterval(() => {
                goTo(activeIndex + 1);
            }, autoMs);
        };

        const restartAuto = () => {
            if (timerId) {
                window.clearInterval(timerId);
            }
            startAuto();
        };

        prevButton?.addEventListener('click', () => {
            goTo(activeIndex - 1);
            restartAuto();
        });

        nextButton?.addEventListener('click', () => {
            goTo(activeIndex + 1);
            restartAuto();
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                goTo(index);
                restartAuto();
            });
        });

        render(0);
        startAuto();
    });

    const closeTestimonialModal = (modal) => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    };

    document.querySelectorAll('[data-testimonial-open]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const modal = document.getElementById(trigger.getAttribute('data-testimonial-open'));

            if (!modal) {
                return;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            modal.querySelector('[data-testimonial-close]')?.focus();
        });
    });

    document.querySelectorAll('[data-testimonial-modal]').forEach((modal) => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal || event.target.closest('[data-testimonial-close]')) {
                closeTestimonialModal(modal);
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        document.querySelectorAll('[data-testimonial-modal]:not(.hidden)').forEach(closeTestimonialModal);
    });

    document.querySelectorAll('[data-donation-form]').forEach((form) => {
        const typeField = form.querySelector('[data-donation-type]');
        const programField = form.querySelector('[data-program-field]');
        const eventField = form.querySelector('[data-event-field]');
        const amountField = form.querySelector('[data-donation-amount]');
        const message = form.querySelector('[data-donation-message]');
        const statusField = form.querySelector('[data-donation-status]');
        const orderField = form.querySelector('[data-paypal-order-id]');
        const payerField = form.querySelector('[data-paypal-payer-id]');
        const currency = form.getAttribute('data-paypal-currency') || 'USD';

        const setMessage = (text, tone = 'text-slate/80') => {
            if (!message) {
                return;
            }

            message.className = `mt-4 text-sm font-semibold ${tone}`;
            message.textContent = text;
        };

        const renderTypeFields = () => {
            const type = typeField?.value || 'general';
            programField?.classList.toggle('hidden', type === 'event');
            eventField?.classList.toggle('hidden', type !== 'event');
        };

        typeField?.addEventListener('change', renderTypeFields);
        renderTypeFields();

        form.querySelectorAll('[data-preset-amount]').forEach((preset) => {
            preset.addEventListener('change', () => {
                if (preset.checked && amountField) {
                    amountField.value = Number(preset.value).toFixed(2);
                }
            });
        });

        if (!window.paypal || !form.querySelector('[data-paypal-buttons]')) {
            return;
        }

        window.paypal.Buttons({
            style: {
                layout: 'vertical',
                shape: 'pill',
                label: 'donate',
            },
            onClick: () => {
                if (!form.reportValidity()) {
                    setMessage('Please complete the required fields before continuing to PayPal.', 'text-rose-700');
                    return false;
                }

                return true;
            },
            createOrder: (data, actions) => {
                const amount = Number(amountField?.value || 0);

                if (!amount || amount < 1) {
                    setMessage('Enter a donation amount of at least 1.00.', 'text-rose-700');
                    throw new Error('Invalid donation amount');
                }

                return actions.order.create({
                    purchase_units: [
                        {
                            amount: {
                                currency_code: currency,
                                value: amount.toFixed(2),
                            },
                        },
                    ],
                    application_context: {
                        shipping_preference: 'NO_SHIPPING',
                    },
                });
            },
            onApprove: async (data, actions) => {
                const details = await actions.order.capture();

                orderField.value = data.orderID || details.id || '';
                payerField.value = details.payer?.payer_id || '';
                statusField.value = details.status === 'COMPLETED' ? 'completed' : 'approved';

                const payload = new FormData(form);

                try {
                    const response = await window.fetch(form.action, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: payload,
                    });

                    if (!response.ok) {
                        throw new Error('Donation save failed');
                    }

                    form.reset();
                    renderTypeFields();
                    setMessage('Thank you. Your PayPal donation was completed and recorded.', 'text-sage');
                } catch (error) {
                    setMessage('PayPal completed, but we could not save the donation details. Please contact our team with your PayPal receipt.', 'text-rose-700');
                }
            },
            onError: () => {
                setMessage('PayPal could not process the donation. Please try again in a moment.', 'text-rose-700');
            },
        }).render(form.querySelector('[data-paypal-buttons]'));
    });
});
