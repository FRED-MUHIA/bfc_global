import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import CTABanner from "../components/ui/CTABanner";
import { familySupportPrograms, testimonials } from "../data/siteContent";
import TestimonialCard from "../components/ui/TestimonialCard";

const marriagePillars = [
  {
    title: "Healthy Communication",
    description:
      "Learn active listening, emotional validation, and conflict de-escalation tools that protect connection."
  },
  {
    title: "Shared Purpose",
    description:
      "Clarify family values, parenting goals, and long-term vision so couples move forward with unity."
  },
  {
    title: "Financial Partnership",
    description:
      "Build collaborative money habits with budgeting rhythms, honest conversations, and practical planning."
  },
  {
    title: "Faith and Resilience",
    description:
      "Develop spiritual practices and support systems that sustain marriages through life's pressures."
  }
];

export default function MarriageFamilyLifePage() {
  return (
    <>
      <SeoHead
        title="Marriage & Family Life"
        description="Marriage and family life resources for communication, conflict repair, shared purpose, and long-term resilience."
      />
      <PageHeader
        eyebrow="Marriage & Family Life"
        title="Nurturing strong marriages and healthy family rhythms"
        description="Our programs help couples and households build trust, communicate with grace, and grow together through every stage of life."
        primaryAction={{ label: "Join Couples Growth Track", to: "/get-involved" }}
        secondaryAction={{ label: "Request Counseling", to: "/counseling-support" }}
      />

      <Section title="Four Pillars of Family Strength">
        <div className="grid gap-6 md:grid-cols-2">
          {marriagePillars.map((pillar) => (
            <article key={pillar.title} className="glass-panel p-6 md:p-8">
              <h3 className="text-2xl">{pillar.title}</h3>
              <p className="mt-3 text-slate/80">{pillar.description}</p>
            </article>
          ))}
        </div>
      </Section>

      <Section className="bg-white/70" title="Programs for Couples and Families">
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {familySupportPrograms.map((program) => (
            <article key={program.title} className="glass-panel p-6">
              <h3 className="text-2xl">{program.title}</h3>
              <p className="mt-3 text-slate/80">{program.description}</p>
              <p className="mt-4 text-xs font-bold uppercase tracking-[0.12em] text-ember">{program.schedule}</p>
            </article>
          ))}
        </div>
      </Section>

      <Section title="Participant Stories">
        <div className="grid gap-6 lg:grid-cols-3">
          {testimonials.map((story) => (
            <TestimonialCard key={story.name} {...story} />
          ))}
        </div>
      </Section>

      <CTABanner
        title="Healthy families are built one intentional step at a time."
        description="Whether you are preparing for marriage, rebuilding trust, or strengthening your household, we are here to walk with you."
        primary={{ label: "Start Today", to: "/contact" }}
        secondary={{ label: "Explore Counseling", to: "/counseling-support" }}
      />
    </>
  );
}
