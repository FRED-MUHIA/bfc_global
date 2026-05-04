import { Link } from "react-router-dom";
import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import { resourcesHub } from "../data/siteContent";

const cardColors = [
  "bg-pine text-white",
  "bg-ember text-white",
  "bg-white text-slate",
  "bg-sage text-white"
];

export default function ResourcesHubPage() {
  return (
    <>
      <SeoHead
        title="Resources Hub"
        description="Explore Christian literature, program videos, sermons, and family board games from Building Families and Community Global Trust."
      />
      <PageHeader
        eyebrow="Resources Hub"
        title="Discipleship resources for homes, schools, churches, and families"
        description="Access ministry resources that support biblical discipleship, family bonding, teaching, worship, and practical Christian living."
        primaryAction={{ label: "Contact Resource Team", to: "/contact" }}
        secondaryAction={{ label: "Support Resources", to: "/donate" }}
      />

      <Section
        eyebrow="Resource Areas"
        title="Equipping families and communities with practical tools"
        description="The hub brings together materials and media for discipleship, teaching, encouragement, family fellowship, and ministry growth."
      >
        <div className="grid gap-6 md:grid-cols-2">
          {resourcesHub.map((resource, index) => {
            const cardColor = cardColors[index % cardColors.length];
            const isLight = cardColor.includes("bg-white");

            return (
              <article key={resource.title} className={`overflow-hidden rounded-3xl border border-sand shadow-soft transition hover:-translate-y-1 ${cardColor}`}>
                <div className="grid min-h-full md:grid-cols-[0.9fr_1.1fr]">
                  <img src={resource.image} alt={resource.title} className="h-64 w-full object-cover md:h-full" loading="lazy" />
                  <div className="p-6 md:p-8">
                    <p className={`text-xs font-bold uppercase tracking-[0.14em] ${isLight ? "text-ember" : "text-white/75"}`}>Resources</p>
                    <h3 className={`mt-3 text-2xl leading-tight ${isLight ? "text-pine" : "text-white"}`}>{resource.title}</h3>
                    <p className={`mt-4 text-base leading-8 ${isLight ? "text-slate/80" : "text-white/85"}`}>
                      {resource.description}
                    </p>
                    <Link
                      to="/contact"
                      className={`mt-6 inline-flex items-center justify-center rounded-full px-5 py-3 text-sm font-semibold tracking-wide transition ${
                        isLight ? "bg-ember text-white hover:bg-ember/90" : "bg-white/90 text-pine hover:bg-white"
                      }`}
                    >
                      Request Access
                    </Link>
                  </div>
                </div>
              </article>
            );
          })}
        </div>
      </Section>
    </>
  );
}
