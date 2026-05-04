export default function ResourceCard({ title, description, category, readTime }) {
  return (
    <article className="glass-panel h-full p-6 transition hover:-translate-y-1 hover:shadow-soft">
      <p className="text-xs font-bold uppercase tracking-[0.13em] text-sage">{category}</p>
      <h3 className="mt-3 text-2xl leading-tight">{title}</h3>
      <p className="mt-4 text-sm text-slate/80">{description}</p>
      {readTime && <p className="mt-5 text-xs font-semibold uppercase tracking-[0.12em] text-ember">{readTime}</p>}
    </article>
  );
}
