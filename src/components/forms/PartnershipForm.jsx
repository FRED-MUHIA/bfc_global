import { useState } from "react";
import FormField from "./FormField";
import Button from "../ui/Button";

export default function PartnershipForm() {
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (event) => {
    event.preventDefault();
    setSubmitted(true);
    event.currentTarget.reset();
  };

  return (
    <section className="glass-panel p-6 md:p-8">
      <h3 className="text-2xl">Partnership Inquiry</h3>
      <p className="mt-2 text-sm text-slate/80">
        We collaborate with schools, churches, health providers, and organizations committed to family wellbeing.
      </p>
      <form className="mt-6 grid gap-4 md:grid-cols-2" onSubmit={handleSubmit}>
        <FormField name="organizationName" label="Organization Name" required />
        <FormField name="contactName" label="Primary Contact Name" required />
        <FormField name="email" label="Email Address" type="email" required />
        <FormField name="phone" label="Phone Number" type="tel" />
        <div className="md:col-span-2">
          <FormField
            name="partnershipGoals"
            label="Partnership Goals"
            as="textarea"
            rows={5}
            placeholder="Tell us how you would like to partner with BFC Global."
            required
          />
        </div>
        <div className="md:col-span-2">
          <Button type="submit" variant="secondary">
            Submit Partnership Request
          </Button>
        </div>
      </form>
      {submitted && (
        <p className="mt-4 text-sm font-semibold text-sage">
          Partnership request received. Our outreach lead will contact you shortly.
        </p>
      )}
    </section>
  );
}
