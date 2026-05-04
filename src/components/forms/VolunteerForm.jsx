import { useState } from "react";
import FormField from "./FormField";
import Button from "../ui/Button";

export default function VolunteerForm() {
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (event) => {
    event.preventDefault();
    setSubmitted(true);
    event.currentTarget.reset();
  };

  return (
    <section className="glass-panel p-6 md:p-8">
      <h3 className="text-2xl">Volunteer Sign-Up</h3>
      <p className="mt-2 text-sm text-slate/80">
        Tell us about your availability, strengths, and how you would like to serve.
      </p>
      <form className="mt-6 grid gap-4 md:grid-cols-2" onSubmit={handleSubmit}>
        <FormField name="fullName" label="Full Name" required />
        <FormField name="email" label="Email Address" type="email" required />
        <FormField name="phone" label="Phone Number" type="tel" required />
        <FormField name="availability" label="Availability" placeholder="Weeknights, weekends, mornings..." />
        <div className="md:col-span-2">
          <FormField
            name="interests"
            label="Volunteer Interests"
            as="textarea"
            rows={4}
            placeholder="Mentorship, events, tutoring, admin support, family care, etc."
            required
          />
        </div>
        <div className="md:col-span-2">
          <Button type="submit">Submit Volunteer Form</Button>
        </div>
      </form>
      {submitted && (
        <p className="mt-4 text-sm font-semibold text-sage">Thank you for volunteering. We will follow up with next steps.</p>
      )}
    </section>
  );
}
