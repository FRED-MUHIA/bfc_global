import { useState } from "react";
import FormField from "./FormField";
import Button from "../ui/Button";

export default function ContactForm() {
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (event) => {
    event.preventDefault();
    setSubmitted(true);
    event.currentTarget.reset();
  };

  return (
    <section className="glass-panel p-6 md:p-8">
      <h3 className="text-2xl">Contact Us</h3>
      <p className="mt-2 text-sm text-slate/80">
        Share your question and a team member will respond within two business days.
      </p>
      <form className="mt-6 grid gap-4 md:grid-cols-2" onSubmit={handleSubmit}>
        <FormField name="firstName" label="First Name" required />
        <FormField name="lastName" label="Last Name" required />
        <FormField name="email" label="Email Address" type="email" required />
        <FormField name="phone" label="Phone Number" type="tel" />
        <div className="md:col-span-2">
          <FormField name="message" label="Message" as="textarea" rows={5} required />
        </div>
        <div className="md:col-span-2">
          <Button type="submit">Send Message</Button>
        </div>
      </form>
      {submitted && <p className="mt-4 text-sm font-semibold text-sage">Message sent successfully.</p>}
    </section>
  );
}
