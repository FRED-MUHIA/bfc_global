import { useState } from "react";
import Button from "../ui/Button";

export default function NewsletterSignup() {
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (event) => {
    event.preventDefault();
    setSubmitted(true);
    event.currentTarget.reset();
  };

  return (
    <div className="glass-panel p-6 md:p-8">
      <h3 className="text-2xl">Stay Encouraged Every Month</h3>
      <p className="mt-3 text-sm text-slate/80">
        Get practical family tips, upcoming workshops, and community stories delivered to your inbox.
      </p>
      <form className="mt-6 flex flex-col gap-3 sm:flex-row" onSubmit={handleSubmit}>
        <input
          type="email"
          required
          placeholder="Enter your email address"
          className="w-full rounded-full border border-sand px-4 py-3 text-sm outline-none focus:border-sage focus:ring-2 focus:ring-sage/20"
        />
        <Button type="submit" className="shrink-0">
          Subscribe
        </Button>
      </form>
      {submitted && (
        <p className="mt-3 text-sm font-semibold text-sage">
          Thank you for subscribing. We are glad to stay connected.
        </p>
      )}
    </div>
  );
}
