import { Link, useParams } from "react-router-dom";
import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import { ministryPrograms } from "../data/siteContent";
import NotFoundPage from "./NotFoundPage";

export default function MinistryProgramPage() {
  const { programSlug } = useParams();
  const program = ministryPrograms.find((item) => item.slug === programSlug);

  if (!program) {
    return <NotFoundPage />;
  }

  return (
    <>
      <SeoHead title={program.title} description={program.description} />
      <PageHeader
        eyebrow="Ministry Program"
        title={program.title}
        description={program.description}
        primaryAction={{ label: "Join This Program", to: "/contact" }}
        secondaryAction={{ label: "Support Ministry", to: "/donate" }}
      />

      <section className="py-16 md:py-20">
        <div className="container-base">
          <div className="grid gap-8 lg:grid-cols-[0.85fr_1.15fr]">
            <aside className="rounded-3xl bg-ember p-6 text-white shadow-soft md:p-8">
              <p className="text-xs font-bold uppercase tracking-[0.15em] text-white/80">Program Details</p>
              <div className="mt-6 space-y-5">
                <div>
                  <p className="text-sm font-bold uppercase tracking-[0.12em] text-white/70">Audience</p>
                  <p className="mt-2 text-xl font-semibold">{program.audience}</p>
                </div>
                <div className="border-t border-white/25 pt-5">
                  <p className="text-sm font-bold uppercase tracking-[0.12em] text-white/70">Format</p>
                  <p className="mt-2 text-lg leading-7">{program.format}</p>
                </div>
                {program.subtitle && (
                  <div className="border-t border-white/25 pt-5">
                    <p className="text-sm font-bold uppercase tracking-[0.12em] text-white/70">Focus</p>
                    <p className="mt-2 text-lg leading-7">{program.subtitle}</p>
                  </div>
                )}
              </div>
            </aside>

            <article className="glass-panel p-6 md:p-10">
              <p className="text-sm font-bold uppercase tracking-[0.15em] text-ember">Overview</p>
              <h2 className="mt-3 text-3xl leading-tight md:text-4xl">{program.title}</h2>
              <p className="mt-6 text-base leading-8 text-slate/85 md:text-lg">{program.description}</p>

              <div className="mt-8 grid gap-5 md:grid-cols-2">
                <div className="rounded-2xl bg-mist p-5">
                  <h3 className="text-xl text-pine">How to Take Part</h3>
                  <p className="mt-3 text-sm leading-7 text-slate/80">
                    Contact our team to ask about registration, partnership, hosting, or current program dates.
                  </p>
                </div>
                <div className="rounded-2xl bg-pine p-5 text-white">
                  <h3 className="text-xl text-white">Support This Work</h3>
                  <p className="mt-3 text-sm leading-7 text-white/82">
                    You can give toward discipleship training, learning materials, events, and ministry facilitation.
                  </p>
                </div>
              </div>

              <div className="mt-8 flex flex-wrap gap-3">
                <Link to="/contact" className="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-sage">
                  Contact Our Team
                </Link>
                <Link to="/donate" className="inline-flex items-center justify-center rounded-full bg-ember px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-ember/90">
                  Donate
                </Link>
              </div>
            </article>
          </div>
        </div>
      </section>
    </>
  );
}
