import { useEffect, useMemo, useState } from "react";
import Button from "./Button";

export default function HeroSlider({ slides = [], autoMs = 7000 }) {
  const safeSlides = useMemo(() => (slides.length ? slides : []), [slides]);
  const [activeIndex, setActiveIndex] = useState(0);

  useEffect(() => {
    if (!safeSlides.length || safeSlides.length === 1) {
      return undefined;
    }

    const timer = window.setInterval(() => {
      setActiveIndex((prev) => (prev + 1) % safeSlides.length);
    }, autoMs);

    return () => window.clearInterval(timer);
  }, [safeSlides, autoMs]);

  if (!safeSlides.length) {
    return null;
  }

  const goPrev = () => {
    setActiveIndex((prev) => (prev - 1 + safeSlides.length) % safeSlides.length);
  };

  const goNext = () => {
    setActiveIndex((prev) => (prev + 1) % safeSlides.length);
  };

  return (
    <section className="relative">
      <div className="container-base">
        <div className="relative min-h-[28rem] overflow-hidden rounded-[2rem] border border-sand/80 shadow-soft md:min-h-[34rem]">
          {safeSlides.map((slide, index) => (
            <article
              key={slide.id}
              aria-hidden={activeIndex !== index}
              className={`absolute inset-0 transition-opacity duration-700 ${
                activeIndex === index ? "pointer-events-auto opacity-100" : "pointer-events-none opacity-0"
              }`}
            >
              <img
                src={slide.image}
                alt={slide.title}
                className="h-full w-full object-cover"
                loading={index === 0 ? "eager" : "lazy"}
              />
              <div className="absolute inset-0 bg-gradient-to-r from-pine/90 via-pine/65 to-slate/35" />
              <div className="absolute inset-0 flex items-center">
                <div className="w-full px-6 py-8 md:max-w-2xl md:px-12 lg:px-16">
                  <p className="text-sm font-bold uppercase tracking-[0.16em] text-ember">{slide.eyebrow}</p>
                  <h1 className="mt-3 text-4xl leading-tight text-white md:text-5xl">{slide.title}</h1>
                  <p className="mt-4 text-base text-white/85 md:text-lg">{slide.description}</p>
                  <div className="mt-7 flex flex-wrap gap-3">
                    <Button to={slide.primaryCta.to} size="lg">
                      {slide.primaryCta.label}
                    </Button>
                    <Button to={slide.secondaryCta.to} variant="ghost" size="lg">
                      {slide.secondaryCta.label}
                    </Button>
                  </div>
                </div>
              </div>
            </article>
          ))}

          <button
            type="button"
            onClick={goPrev}
            aria-label="Previous slide"
            className="absolute left-3 top-1/2 z-20 inline-flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/70 bg-white/80 text-2xl text-pine shadow transition hover:bg-white"
          >
            ‹
          </button>
          <button
            type="button"
            onClick={goNext}
            aria-label="Next slide"
            className="absolute right-3 top-1/2 z-20 inline-flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/70 bg-white/80 text-2xl text-pine shadow transition hover:bg-white"
          >
            ›
          </button>

          <div className="absolute bottom-5 left-1/2 z-20 flex -translate-x-1/2 gap-2">
            {safeSlides.map((slide, index) => (
              <button
                key={slide.id}
                type="button"
                onClick={() => setActiveIndex(index)}
                aria-label={`Go to slide ${index + 1}`}
                className={`h-2.5 rounded-full transition ${
                  activeIndex === index ? "w-8 bg-ember" : "w-2.5 bg-white/85 hover:bg-white"
                }`}
              />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
