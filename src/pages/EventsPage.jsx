import { Link } from "react-router-dom";
import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import { events } from "../data/siteContent";

export default function EventsPage() {
  return (
    <>
      <SeoHead
        title="Events"
        description="Upcoming BFC Global Trust workshops, family forums, youth gatherings, and community discipleship events."
      />
      <PageHeader
        eyebrow="Events"
        title="Gatherings that equip families for discipleship and influence"
        description="Join our upcoming workshops, forums, and community gatherings for parents, young people, Christian leaders, churches, and families."
        primaryAction={{ label: "Contact Events Team", to: "/contact" }}
        secondaryAction={{ label: "Donate to an Event", to: "/donate" }}
      />

      <Section
        eyebrow="Upcoming Events"
        title="Training, fellowship, and transformation spaces"
        description="These gatherings are designed to equip homes, churches, young people, and leaders with practical family-based discipleship."
      >
        <div className="grid gap-6 lg:grid-cols-3">
          {events.map((event) => (
            <article key={event.title} className="overflow-hidden rounded-3xl border border-sand bg-white shadow-soft transition hover:-translate-y-1">
              <img src={event.image} alt={event.title} className="h-52 w-full object-cover" loading="lazy" />
              <div className="p-6">
                <p className="text-xs font-bold uppercase tracking-[0.12em] text-ember">{event.category}</p>
                <h3 className="mt-2 text-2xl leading-tight">{event.title}</h3>
                <div className="mt-4 grid gap-1 text-sm text-slate/75">
                  <p><span className="font-semibold text-pine">Date:</span> {event.date}</p>
                  <p><span className="font-semibold text-pine">Time:</span> {event.time}</p>
                  <p><span className="font-semibold text-pine">Venue:</span> {event.location}</p>
                </div>
                <p className="mt-4 text-sm text-slate/80">{event.description}</p>
                <div className="mt-6 flex flex-wrap gap-3">
                  <Link to="/contact" className="inline-flex items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-sage">
                    Register Interest
                  </Link>
                  <Link to="/donate" className="inline-flex items-center justify-center rounded-full border border-sage/30 px-5 py-3 text-sm font-semibold tracking-wide text-pine transition hover:bg-sage/10">
                    Sponsor Event
                  </Link>
                </div>
              </div>
            </article>
          ))}
        </div>
      </Section>

      <Section className="bg-white/70" eyebrow="Host or Partner" title="Bring a BFC Global Trust event to your church, school, or organization">
        <article className="glass-panel p-6 md:p-8">
          <p className="text-base leading-8 text-slate/85 md:text-lg">
            We partner with churches, learning institutions, community leaders, and organizations to facilitate deliberations, training, and equipping around family-based discipleship.
          </p>
          <div className="mt-7 flex flex-wrap gap-3">
            <Link to="/contact" className="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-sage">
              Plan an Event
            </Link>
            <Link to="/get-involved" className="inline-flex items-center justify-center rounded-full border border-sage/30 px-6 py-3 text-base font-semibold tracking-wide text-pine transition hover:bg-sage/10">
              Volunteer
            </Link>
          </div>
        </article>
      </Section>
    </>
  );
}
