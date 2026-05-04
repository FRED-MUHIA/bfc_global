import { useEffect, useId, useState } from "react";

export default function TestimonialCard({ quote, name, role, image, detail }) {
  const [open, setOpen] = useState(false);
  const titleId = useId();

  useEffect(() => {
    if (!open) {
      return undefined;
    }

    document.body.classList.add("overflow-hidden");

    const closeOnEscape = (event) => {
      if (event.key === "Escape") {
        setOpen(false);
      }
    };

    document.addEventListener("keydown", closeOnEscape);

    return () => {
      document.body.classList.remove("overflow-hidden");
      document.removeEventListener("keydown", closeOnEscape);
    };
  }, [open]);

  return (
    <>
      <article className="glass-panel flex h-full flex-col justify-between p-6">
        <p className="text-lg leading-relaxed text-slate/90">"{quote}"</p>
        <button
          type="button"
          onClick={() => setOpen(true)}
          className="mt-6 flex w-full items-center gap-4 border-t border-sand pt-4 text-left transition hover:text-pine focus:outline-none focus:ring-2 focus:ring-sage/30"
        >
          <img
            src={image}
            alt={name}
            className="h-14 w-14 shrink-0 rounded-full object-cover ring-2 ring-white shadow"
            loading="lazy"
          />
          <div>
            <p className="font-semibold text-pine">{name}</p>
            <p className="text-sm text-slate/70">{role}</p>
          </div>
        </button>
      </article>

      {open && (
        <div
          className="fixed inset-0 z-[70] flex items-center justify-center bg-slate/65 px-4 py-8"
          role="dialog"
          aria-modal="true"
          aria-labelledby={titleId}
          onClick={(event) => {
            if (event.target === event.currentTarget) {
              setOpen(false);
            }
          }}
        >
          <div className="w-full max-w-2xl rounded-3xl bg-white p-6 shadow-soft md:p-8">
            <div className="flex items-start justify-between gap-4">
              <div className="flex items-center gap-4">
                <img src={image} alt={name} className="h-16 w-16 shrink-0 rounded-full object-cover ring-2 ring-sand" />
                <div>
                  <h3 id={titleId} className="text-2xl">
                    {name}
                  </h3>
                  <p className="text-sm font-semibold uppercase tracking-[0.12em] text-sage">{role}</p>
                </div>
              </div>
              <button
                type="button"
                onClick={() => setOpen(false)}
                className="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-sand text-2xl text-pine transition hover:bg-mist"
                aria-label="Close testimonial"
              >
                &times;
              </button>
            </div>
            <p className="mt-6 text-lg leading-8 text-slate/90">"{quote}"</p>
            <p className="mt-4 text-base leading-8 text-slate/80">{detail}</p>
          </div>
        </div>
      )}
    </>
  );
}
