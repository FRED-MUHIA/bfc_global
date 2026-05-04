import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import ResourceCard from "../components/ui/ResourceCard";
import CTABanner from "../components/ui/CTABanner";
import { parentingTips, featuredResources, familySupportPrograms } from "../data/siteContent";

export default function ParentingResourcesPage() {
  return (
    <>
      <SeoHead
        title="Parenting Resources"
        description="Explore practical parenting tools, tips, and family support programs that build confidence and connection at home."
      />
      <PageHeader
        eyebrow="Parenting Resources"
        title="Encouraging guidance for parents and caregivers"
        description="Find practical strategies that strengthen connection, build routines, and support healthy child development."
        primaryAction={{ label: "Request Support", to: "/counseling-support" }}
        secondaryAction={{ label: "Read Blog", to: "/blog" }}
      />

      <Section
        title="Top Parenting Tips"
        description="These simple practices can lower stress and increase trust between caregivers and children."
      >
        <div className="grid gap-4">
          {parentingTips.map((tip, index) => (
            <article key={tip} className="glass-panel flex items-start gap-4 p-5">
              <span className="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sage text-sm font-bold text-white">
                {index + 1}
              </span>
              <p className="text-slate/85">{tip}</p>
            </article>
          ))}
        </div>
      </Section>

      <Section className="bg-white/70" title="Featured Guides">
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {featuredResources.map((resource) => (
            <ResourceCard key={resource.title} {...resource} />
          ))}
        </div>
      </Section>

      <Section title="Family Support Programs">
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

      <CTABanner
        title="Need one-on-one guidance for your parenting journey?"
        description="Connect with our support team for personalized recommendations, workshops, and counseling pathways."
        primary={{ label: "Talk to Our Team", to: "/contact" }}
        secondary={{ label: "Counseling & Support", to: "/counseling-support" }}
      />
    </>
  );
}
