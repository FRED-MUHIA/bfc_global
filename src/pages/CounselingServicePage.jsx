import { Link, useParams } from "react-router-dom";
import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import CTABanner from "../components/ui/CTABanner";
import { counselingServices } from "../data/siteContent";

export default function CounselingServicePage() {
  const { serviceSlug } = useParams();
  const service = counselingServices.find((item) => item.slug === serviceSlug);

  if (!service) {
    return null;
  }

  return (
    <>
      <SeoHead title={service.title} description={service.description} />
      <PageHeader
        eyebrow="Counseling & Support"
        title={service.title}
        description={service.description}
        primaryAction={{ label: "Request Support", to: "/counseling-support#support-form" }}
        secondaryAction={{ label: "All Services", to: "/counseling-support" }}
      />

      <Section>
        <div className="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
          <div className="glass-panel p-6 md:p-8">
            <p className="text-sm font-bold uppercase tracking-[0.15em] text-ember">Overview</p>
            <h2 className="mt-3 text-3xl leading-tight">How this care helps</h2>
            <p className="mt-4 text-base leading-8 text-slate/85 md:text-lg">{service.overview}</p>
            <div className="mt-7 flex flex-wrap gap-3">
              <Link to="/counseling-support#support-form" className="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-sage">
                Start Inquiry
              </Link>
              <Link to="/contact" className="inline-flex items-center justify-center rounded-full border border-sage/30 px-6 py-3 text-base font-semibold tracking-wide text-pine transition hover:bg-sage/10">
                Talk to Our Team
              </Link>
            </div>
          </div>

          <div className="grid gap-5">
            <article className="glass-panel p-6 md:p-8">
              <h2 className="text-2xl">Who This Is For</h2>
              <ul className="mt-4 grid gap-3 text-slate/80">
                {service.whoFor.map((item) => (
                  <li key={item} className="rounded-2xl bg-white/70 p-4">{item}</li>
                ))}
              </ul>
            </article>
            <article className="glass-panel p-6 md:p-8">
              <h2 className="text-2xl">What to Expect</h2>
              <ul className="mt-4 grid gap-3 text-slate/80">
                {service.whatToExpect.map((item) => (
                  <li key={item} className="rounded-2xl bg-white/70 p-4">{item}</li>
                ))}
              </ul>
            </article>
          </div>
        </div>
      </Section>

      <Section className="bg-white/70" eyebrow="Care Outcomes" title="The change we work toward">
        <div className="grid gap-6 md:grid-cols-3">
          {service.outcomes.map((outcome) => (
            <article key={outcome} className="glass-panel p-6">
              <p className="text-slate/85">{outcome}</p>
            </article>
          ))}
        </div>
      </Section>

      <CTABanner
        title="Ready to take the next step?"
        description="Share what your family is facing and our care team will help you identify the best support pathway."
        primary={{ label: "Submit Support Inquiry", to: "/counseling-support#support-form" }}
        secondary={{ label: "Back to Services", to: "/counseling-support" }}
      />
    </>
  );
}
