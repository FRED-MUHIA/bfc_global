import Button from "./Button";

export default function CTABanner({ title, description, primary, secondary }) {
  return (
    <section className="container-base py-8 md:py-12">
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-pine via-sage to-pine px-6 py-10 text-white shadow-soft md:px-12">
        <div className="pointer-events-none absolute -right-16 top-0 h-56 w-56 rounded-full bg-ember/25 blur-3xl" />
        <h2 className="relative text-3xl leading-tight md:text-4xl">{title}</h2>
        <p className="relative mt-4 max-w-2xl text-white/90">{description}</p>
        <div className="relative mt-7 flex flex-wrap gap-3">
          {primary && (
            <Button to={primary.to} variant="light">
              {primary.label}
            </Button>
          )}
          {secondary && (
            <Button to={secondary.to} variant="ghost-light">
              {secondary.label}
            </Button>
          )}
        </div>
      </div>
    </section>
  );
}
