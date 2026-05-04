export default function Section({ id, eyebrow, title, description, children, className = "" }) {
  return (
    <section id={id} className={`py-16 md:py-20 ${className}`}>
      <div className="container-base">
        {(eyebrow || title || description) && (
          <div className="mb-10 max-w-3xl">
            {eyebrow && <p className="text-sm font-bold uppercase tracking-[0.15em] text-ember">{eyebrow}</p>}
            {title && <h2 className="mt-3 text-3xl leading-tight md:text-4xl">{title}</h2>}
            {description && <p className="mt-4 text-base text-slate/80 md:text-lg">{description}</p>}
          </div>
        )}
        {children}
      </div>
    </section>
  );
}
