import Button from "../ui/Button";

export default function PageHeader({
  eyebrow,
  title,
  description,
  primaryAction,
  secondaryAction,
  image = "https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=2000&q=80"
}) {
  return (
    <header className="relative overflow-hidden bg-pine py-20 text-white md:py-24">
      <img src={image} alt="" className="absolute inset-0 h-full w-full object-cover" loading="eager" />
      <div className="absolute inset-0 bg-gradient-to-r from-pine/95 via-pine/80 to-pine/35" />
      <div className="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/30" />
      <div className="container-base relative z-10">
        <p className="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-cream/80">{eyebrow}</p>
        <h1 className="max-w-3xl animate-rise text-4xl leading-tight md:text-5xl">{title}</h1>
        <p className="mt-6 max-w-3xl text-base text-cream/90 md:text-lg">{description}</p>
        {(primaryAction || secondaryAction) && (
          <div className="mt-8 flex flex-wrap gap-3">
            {primaryAction && (
              <Button to={primaryAction.to} variant="light">
                {primaryAction.label}
              </Button>
            )}
            {secondaryAction && (
              <Button to={secondaryAction.to} variant="ghost-light">
                {secondaryAction.label}
              </Button>
            )}
          </div>
        )}
      </div>
    </header>
  );
}
