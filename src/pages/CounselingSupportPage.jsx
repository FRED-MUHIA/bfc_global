import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import { Link } from "react-router-dom";
import SupportInquiryForm from "../components/forms/SupportInquiryForm";
import CTABanner from "../components/ui/CTABanner";
import { counselingServices } from "../data/siteContent";

const steps = [
  {
    title: "1. Initial Connection",
    detail:
      "Submit a support inquiry and our care team schedules a confidential intake conversation."
  },
  {
    title: "2. Personalized Care Plan",
    detail:
      "We identify immediate needs, goals, and recommended support options for your family."
  },
  {
    title: "3. Ongoing Support",
    detail:
      "Families receive counseling sessions, practical resources, and progress check-ins."
  }
];

export default function CounselingSupportPage() {
  return (
    <>
      <SeoHead
        title="Counseling & Support"
        description="Compassionate counseling, care coordination, and support pathways for families, couples, and youth."
      />
      <PageHeader
        eyebrow="Counseling & Support"
        title="Compassionate care for families in every season"
        description="Whether you are facing conflict, stress, grief, or urgent family challenges, our team is here to walk with you."
        primaryAction={{ label: "Submit Support Inquiry", to: "#support-form" }}
        secondaryAction={{ label: "Contact Team", to: "/contact" }}
      />

      <Section title="Our Counseling Services">
        <div className="grid gap-6 md:grid-cols-2">
          {counselingServices.map((service) => (
            <Link key={service.title} to={`/counseling-support/${service.slug}`} className="glass-panel block p-6 transition hover:-translate-y-1 hover:shadow-soft md:p-8">
              <h3 className="text-2xl">{service.title}</h3>
              <p className="mt-3 text-slate/80">{service.description}</p>
              <span className="mt-5 inline-flex text-sm font-semibold text-ember">Learn more →</span>
            </Link>
          ))}
        </div>
      </Section>

      <Section className="bg-white/70" title="How Support Works">
        <div className="grid gap-4">
          {steps.map((step) => (
            <article key={step.title} className="glass-panel p-6">
              <h3 className="text-xl">{step.title}</h3>
              <p className="mt-2 text-slate/80">{step.detail}</p>
            </article>
          ))}
        </div>
      </Section>

      <Section id="support-form" title="Request Family Support">
        <SupportInquiryForm />
      </Section>

      <CTABanner
        title="You do not have to navigate hard seasons alone."
        description="Reach out today and let us connect your family to trusted, practical support."
        primary={{ label: "Submit Inquiry", to: "#support-form" }}
        secondary={{ label: "Call Our Team", to: "/contact" }}
      />
    </>
  );
}
