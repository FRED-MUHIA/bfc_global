import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import VolunteerForm from "../components/forms/VolunteerForm";
import PartnershipForm from "../components/forms/PartnershipForm";
import CTABanner from "../components/ui/CTABanner";
import { involvementOpportunities } from "../data/siteContent";

const opportunityStyles = [
  {
    card: "bg-pine text-white border-pine",
    title: "text-white",
    text: "text-white/85"
  },
  {
    card: "bg-ember text-white border-ember",
    title: "text-white",
    text: "text-white/90"
  },
  {
    card: "bg-sage text-white border-sage",
    title: "text-white",
    text: "text-white/85"
  },
  {
    card: "bg-mist text-pine border-sage/20",
    title: "text-pine",
    text: "text-slate"
  }
];

export default function GetInvolvedPage() {
  return (
    <>
      <SeoHead
        title="Get Involved"
        description="Volunteer, partner, sponsor, and support programs that strengthen families and communities."
      />
      <PageHeader
        eyebrow="Get Involved"
        title="Join hands with us to uplift families and communities"
        description="Your time, expertise, and partnership can help deliver hope, practical care, and sustainable support to households in need."
        primaryAction={{ label: "Volunteer Form", to: "#volunteer-form" }}
        secondaryAction={{ label: "Partnership Form", to: "#partnership-form" }}
      />

      <Section title="Ways You Can Serve">
        <div className="grid gap-6 md:grid-cols-2">
          {involvementOpportunities.map((opportunity, index) => {
            const style = opportunityStyles[index % opportunityStyles.length];

            return (
            <article key={opportunity.title} className={`rounded-3xl border p-6 shadow-soft transition hover:-translate-y-1 md:p-8 ${style.card}`}>
              <h3 className={`text-2xl ${style.title}`}>{opportunity.title}</h3>
              <p className={`mt-3 ${style.text}`}>{opportunity.description}</p>
            </article>
            );
          })}
        </div>
      </Section>

      <Section id="volunteer-form" className="bg-white/70" title="Volunteer with BFC Global">
        <VolunteerForm />
      </Section>

      <Section id="partnership-form" title="Partnership Inquiry">
        <PartnershipForm />
      </Section>

      <CTABanner
        title="Every contribution helps a family move from survival to stability."
        description="Serve monthly, join outreach events, or partner your organization with our mission."
        primary={{ label: "Contact Team", to: "/contact" }}
        secondary={{ label: "Community Outreach", to: "/community-outreach" }}
      />
    </>
  );
}
