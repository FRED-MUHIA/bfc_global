import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import CTABanner from "../components/ui/CTABanner";
import { outreachInitiatives } from "../data/siteContent";

const focusAreas = [
  "Family resource distribution and referral access",
  "Parent education events in neighborhood hubs",
  "Collaborative care with schools and local leaders",
  "Faith-based support networks for vulnerable households"
];

export default function CommunityOutreachPage() {
  return (
    <>
      <SeoHead
        title="Community Outreach"
        description="Explore local outreach initiatives that connect families to practical resources, mentorship, and community support."
      />
      <PageHeader
        eyebrow="Community Outreach"
        title="Mobilizing neighborhoods around family wellbeing"
        description="Our outreach model connects organizations, volunteers, and local leaders to meet real needs and strengthen community bonds."
        primaryAction={{ label: "Partner with Us", to: "/get-involved" }}
        secondaryAction={{ label: "Contact Outreach Team", to: "/contact" }}
      />

      <Section title="Current Outreach Initiatives">
        <div className="grid gap-6 md:grid-cols-2">
          {outreachInitiatives.map((initiative) => (
            <article key={initiative.name} className="glass-panel p-6 md:p-8">
              <h3 className="text-2xl">{initiative.name}</h3>
              <p className="mt-3 text-slate/80">{initiative.description}</p>
            </article>
          ))}
        </div>
      </Section>

      <Section className="bg-white/70" title="Outreach Focus Areas">
        <div className="grid gap-4">
          {focusAreas.map((area, index) => (
            <article key={area} className="glass-panel flex items-center gap-4 p-5">
              <span className="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sage text-sm font-bold text-white">
                {index + 1}
              </span>
              <p className="text-slate/85">{area}</p>
            </article>
          ))}
        </div>
      </Section>

      <CTABanner
        title="Strong communities are built through shared commitment."
        description="Invite BFC Global into your school, church, or local organization to co-create meaningful family impact."
        primary={{ label: "Start Partnership", to: "/get-involved" }}
        secondary={{ label: "Send Inquiry", to: "/contact" }}
      />
    </>
  );
}
