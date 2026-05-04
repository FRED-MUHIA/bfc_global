import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import CTABanner from "../components/ui/CTABanner";
import { organization } from "../data/siteContent";

export default function AboutPage() {
  return (
    <>
      <SeoHead title="About" description="Learn about the mission, vision, values, and discipleship mandate of Building Families and Community Global Trust." />
      <PageHeader
        eyebrow="About Us"
        title="Building families, touching communities, changing the world"
        description={organization.aboutIntro}
      />

      <Section eyebrow="Who We Are" title="A Christian fellowship for family-based discipleship">
        <article className="mb-12 bg-white p-6 md:p-10">
          <h2 className="text-3xl leading-tight md:text-4xl">
            <span className="font-bold text-pine">Message of the</span>
            <span className="font-medium text-pine"> Founders</span>
          </h2>
          <div className="mt-10 grid items-center gap-8 lg:grid-cols-[18rem_1fr]">
            <div className="relative mx-auto h-64 w-64 lg:mx-0">
              <img
                src={organization.foundersMessage.image}
                alt={organization.foundersMessage.signature}
                className="relative h-full w-full rounded-full object-cover shadow-soft"
                loading="lazy"
              />
            </div>
            <div className="text-pine">
              <p className="text-lg font-bold">Greetings in the Lord's name!</p>
              <div className="mt-5 grid gap-4 text-base leading-8 text-slate/85 md:text-lg">
                {organization.foundersMessage.paragraphs.slice(0, 2).map((paragraph) => (
                  <p key={paragraph}>{paragraph}</p>
                ))}
              </div>
            </div>
          </div>
          <div className="mt-8 grid gap-4 text-base leading-8 text-slate/85 md:text-lg">
            {organization.foundersMessage.paragraphs.slice(2).map((paragraph) => (
              <p key={paragraph}>{paragraph}</p>
            ))}
          </div>
          <p className="mt-8 font-heading text-xl text-pine">{organization.foundersMessage.signature}</p>
        </article>
        <article className="glass-panel p-6 md:p-8">
          <p className="text-base leading-8 text-slate/85 md:text-lg">{organization.aboutIntro}</p>
          <p className="mt-4 text-base leading-8 text-slate/80 md:text-lg">{organization.aboutSummary}</p>
        </article>
      </Section>

      <section className="bg-ember py-16 md:py-20">
        <div className="container-base">
          <div className="mb-10 max-w-3xl">
            <p className="text-sm font-extrabold uppercase tracking-[0.15em] text-white">Our Mandate</p>
            <h2 className="mt-3 text-3xl leading-tight text-white md:text-4xl">Build. Community. Global. Partnership.</h2>
          </div>
          <div className="grid gap-6 md:grid-cols-2">
            {organization.aboutThemes.map((theme) => (
              <article key={theme.title} className="rounded-3xl border border-white bg-white p-6 shadow-soft md:p-8">
                <h3 className="text-2xl">{theme.title}</h3>
                <p className="mt-4 text-slate">{theme.description}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <Section>
        <div className="grid gap-6 md:grid-cols-2">
          <article className="glass-panel p-6 md:p-8">
            <p className="text-sm font-bold uppercase tracking-[0.15em] text-ember">Our Mission</p>
            <h3 className="mt-3 text-2xl">Equipping families for influence</h3>
            <p className="mt-4 text-slate/85">{organization.mission}</p>
          </article>
          <article className="glass-panel p-6 md:p-8">
            <p className="text-sm font-bold uppercase tracking-[0.15em] text-ember">Our Vision</p>
            <h3 className="mt-3 text-2xl">Strong disciples in healthy families</h3>
            <p className="mt-4 text-slate/85">{organization.vision}</p>
            <p className="mt-5 rounded-2xl bg-mist p-4 font-heading text-xl text-pine">"{organization.visionStatement}"</p>
          </article>
        </div>
      </Section>

      <Section className="bg-white/70" eyebrow="Core Values" title="Convictions that guide our work">
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {organization.values.map((value) => (
            <article key={value.title} className="glass-panel p-6 md:p-8">
              <h3 className="text-2xl">{value.title}</h3>
              <p className="mt-3 text-slate/80">{value.description}</p>
            </article>
          ))}
        </div>
      </Section>

      <Section eyebrow="Main Objectives" title="What we are building toward" description="Our work is directed toward family discipleship that touches communities and nations.">
        <div className="grid gap-6 md:grid-cols-3">
          {organization.objectives.map((objective) => (
            <article key={objective.title} className="glass-panel p-6 md:p-8">
              <h3 className="text-2xl">{objective.title}</h3>
              <p className="mt-3 text-slate/80">{objective.description}</p>
            </article>
          ))}
        </div>
      </Section>

      <CTABanner
        title="Everyone can take part in this noble work."
        description="Use your resources, influence, prayer, and service to help build strong families through family-based discipleship."
        primary={{ label: "Volunteer", to: "/get-involved" }}
        secondary={{ label: "Donate", to: "/donate" }}
      />
    </>
  );
}
