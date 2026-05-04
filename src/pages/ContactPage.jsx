import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import ContactForm from "../components/forms/ContactForm";
import CTABanner from "../components/ui/CTABanner";

export default function ContactPage() {
  return (
    <>
      <SeoHead
        title="Contact"
        description="Reach out to Building Families and Community Global Trust for support, program questions, partnerships, and volunteer opportunities."
      />
      <PageHeader
        eyebrow="Contact"
        title="We would love to hear from you"
        description="Connect with our team for support requests, event information, volunteer onboarding, and partnership opportunities."
        primaryAction={{ label: "Get Involved", to: "/get-involved" }}
        secondaryAction={{ label: "Ministry Programs", to: "/ministry-programs" }}
      />

      <Section className="bg-white/70" title="Send a Message">
        <ContactForm />
      </Section>

      <CTABanner
        title="Need immediate guidance for a family situation?"
        description="Use our support inquiry process so we can connect you with timely, compassionate care."
        primary={{ label: "Contact Our Team", to: "/contact" }}
        secondary={{ label: "Get Involved", to: "/get-involved" }}
      />
    </>
  );
}
