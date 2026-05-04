import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import CTABanner from "../components/ui/CTABanner";
import { youthPrograms } from "../data/siteContent";

const outcomes = [
  "Improved confidence and emotional regulation",
  "Higher school engagement and clearer goals",
  "Healthy peer relationships and leadership growth",
  "Increased service mindset and civic responsibility"
];

export default function YouthProgramsPage() {
  return (
    <>
      <SeoHead
        title="Youth Programs"
        description="Mentoring, leadership, tutoring, and creative programs that equip youth to thrive in life and purpose."
      />
      <PageHeader
        eyebrow="Youth Programs"
        title="Helping young people lead with confidence and character"
        description="Our youth initiatives combine mentorship, academic support, leadership training, and creative expression."
        primaryAction={{ label: "Volunteer as Mentor", to: "/get-involved" }}
        secondaryAction={{ label: "Contact Youth Team", to: "/contact" }}
      />

      <Section title="Current Youth Initiatives">
        <div className="grid gap-6 md:grid-cols-2">
          {youthPrograms.map((program) => (
            <article key={program.title} className="glass-panel p-6 md:p-8">
              <p className="text-xs font-bold uppercase tracking-[0.12em] text-ember">{program.age}</p>
              <h3 className="mt-2 text-2xl">{program.title}</h3>
              <p className="mt-3 text-slate/80">{program.description}</p>
            </article>
          ))}
        </div>
      </Section>

      <Section className="bg-white/70" title="Expected Outcomes for Youth and Families">
        <div className="grid gap-4 md:grid-cols-2">
          {outcomes.map((outcome, index) => (
            <article key={outcome} className="glass-panel flex items-center gap-4 p-5">
              <span className="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-pine text-sm font-bold text-white">
                {index + 1}
              </span>
              <p className="text-slate/85">{outcome}</p>
            </article>
          ))}
        </div>
      </Section>

      <CTABanner
        title="Invest in the next generation of leaders."
        description="Sponsor a youth program, mentor a student, or partner with us to expand opportunity across communities."
        primary={{ label: "Become a Volunteer", to: "/get-involved" }}
        secondary={{ label: "Partnership Inquiry", to: "/contact" }}
      />
    </>
  );
}
