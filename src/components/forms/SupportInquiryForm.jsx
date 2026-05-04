import { useState } from "react";
import FormField from "./FormField";
import Button from "../ui/Button";

export default function SupportInquiryForm() {
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (event) => {
    event.preventDefault();
    setSubmitted(true);
    event.currentTarget.reset();
  };

  return (
    <section className="glass-panel p-6 md:p-8">
      <h3 className="text-2xl">Support Inquiry Form</h3>
      <p className="mt-2 text-sm text-slate/80">
        Let us know the kind of support you need and we will help you find the best next step.
      </p>
      <form className="mt-6 grid gap-4 md:grid-cols-2" onSubmit={handleSubmit}>
        <FormField name="fullName" label="Full Name" required />
        <FormField name="email" label="Email Address" type="email" required />
        <FormField name="householdSize" label="Household Size" type="number" />
        <FormField name="preferredContact" label="Preferred Contact Method" placeholder="Phone, email, or text" />
        <div className="md:col-span-2">
          <FormField
            name="needs"
            label="How Can We Support You?"
            as="textarea"
            rows={5}
            placeholder="Parenting support, counseling, emergency resources, referrals, etc."
            required
          />
        </div>
        <div className="md:col-span-2">
          <Button type="submit" variant="secondary">
            Submit Inquiry
          </Button>
        </div>
      </form>
      {submitted && (
        <p className="mt-4 text-sm font-semibold text-sage">Thank you. A care coordinator will contact you soon.</p>
      )}
    </section>
  );
}
