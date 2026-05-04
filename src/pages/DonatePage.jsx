import { useState } from "react";
import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";

const programs = [
  "General Family Support",
  "Parenting Resources",
  "Marriage & Family Life",
  "Youth Programs",
  "Counseling & Support",
  "Community Outreach"
];

export default function DonatePage() {
  const [amount, setAmount] = useState("");
  const [type, setType] = useState("general");

  return (
    <>
      <SeoHead
        title="Donate"
        description="Give to a BFC Global program, event, or general family support fund through PayPal."
      />
      <PageHeader
        eyebrow="Donate"
        title="Fuel practical care for families and communities"
        description="Choose a program, event, or general donation amount. Your gift helps deliver counseling, mentoring, outreach, and practical support."
        primaryAction={{ label: "Donation Form", to: "#donation-form" }}
        secondaryAction={{ label: "Explore Programs", to: "/community-outreach" }}
      />

      <section id="donation-form" className="py-16 md:py-20">
        <div className="container-base">
          <div className="grid gap-8 lg:grid-cols-[0.92fr_1.08fr]">
            <aside className="glass-panel h-fit p-6 md:p-8">
              <p className="text-sm font-bold uppercase tracking-[0.15em] text-ember">Giving Options</p>
              <h2 className="mt-3 text-3xl leading-tight">Where your donation can go</h2>
              <div className="mt-6 grid gap-4">
                {["Programs", "Events", "General Fund"].map((item) => (
                  <article key={item} className="rounded-2xl border border-sand bg-white/70 p-4">
                    <h3 className="text-xl">{item}</h3>
                    <p className="mt-2 text-sm text-slate/80">
                      Support focused family care, community events, or urgent needs across the mission.
                    </p>
                  </article>
                ))}
              </div>
            </aside>

            <section className="glass-panel p-6 md:p-8">
              <h2 className="text-3xl leading-tight">Make a Donation</h2>
              <p className="mt-2 text-sm text-slate/80">Complete the form, then connect it to your PayPal client ID in Laravel.</p>
              <form className="mt-6 grid gap-4 md:grid-cols-2">
                <label className="block">
                  <span className="mb-2 block text-sm font-semibold text-pine">Donation Type</span>
                  <select className="field-input" value={type} onChange={(event) => setType(event.target.value)}>
                    <option value="general">General Donation</option>
                    <option value="program">Specific Program</option>
                    <option value="event">Specific Event</option>
                  </select>
                </label>
                {type === "event" ? (
                  <label className="block">
                    <span className="mb-2 block text-sm font-semibold text-pine">Event Name</span>
                    <input className="field-input" placeholder="Family night, workshop, outreach event..." />
                  </label>
                ) : (
                  <label className="block">
                    <span className="mb-2 block text-sm font-semibold text-pine">Program</span>
                    <select className="field-input">
                      {programs.map((program) => (
                        <option key={program}>{program}</option>
                      ))}
                    </select>
                  </label>
                )}
                <label className="block">
                  <span className="mb-2 block text-sm font-semibold text-pine">Frequency</span>
                  <select className="field-input">
                    <option>One-time</option>
                    <option>Monthly pledge</option>
                  </select>
                </label>
                <label className="block">
                  <span className="mb-2 block text-sm font-semibold text-pine">Amount</span>
                  <input className="field-input" type="number" min="1" step="0.01" value={amount} onChange={(event) => setAmount(event.target.value)} />
                </label>
                <label className="block">
                  <span className="mb-2 block text-sm font-semibold text-pine">Full Name</span>
                  <input className="field-input" />
                </label>
                <label className="block">
                  <span className="mb-2 block text-sm font-semibold text-pine">Email Address</span>
                  <input className="field-input" type="email" />
                </label>
                <label className="block md:col-span-2">
                  <span className="mb-2 block text-sm font-semibold text-pine">Message or Dedication</span>
                  <textarea className="field-input" rows="4" />
                </label>
                <div className="md:col-span-2 rounded-2xl border border-ember/30 bg-ember/10 p-4 text-sm text-slate/85">
                  PayPal checkout is enabled in the Laravel Blade donation page when PAYPAL_CLIENT_ID is configured.
                </div>
              </form>
            </section>
          </div>
        </div>
      </section>
    </>
  );
}
