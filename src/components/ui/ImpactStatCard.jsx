const styles = [
  {
    card: "border-pine bg-pine text-white",
    label: "text-white/85"
  },
  {
    card: "border-ember bg-ember text-white",
    label: "text-white/90"
  },
  {
    card: "border-sage bg-sage text-white",
    label: "text-white/85"
  },
  {
    card: "border-sage/20 bg-mist text-pine",
    label: "text-sage"
  }
];

export default function ImpactStatCard({ value, label, index = 0 }) {
  const style = styles[index % styles.length];

  return (
    <article className={`rounded-2xl border p-6 text-center shadow-soft transition hover:-translate-y-1 ${style.card}`}>
      <p className="text-4xl font-bold md:text-5xl">{value}</p>
      <p className={`mt-3 text-sm font-semibold uppercase tracking-[0.11em] ${style.label}`}>{label}</p>
    </article>
  );
}
