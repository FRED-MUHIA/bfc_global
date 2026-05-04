import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import { galleryPhotos } from "../data/siteContent";

export default function GalleryPage() {
  return (
    <>
      <SeoHead
        title="Gallery"
        description="View ministry photos from BFC Global Trust discipleship programs, family workshops, youth gatherings, worship, outreach, and training moments."
      />
      <PageHeader
        eyebrow="Gallery"
        title="Ministry photos from BUILD discipleship moments"
        description="A glimpse into gatherings, training spaces, worship, outreach, and discipleship programs serving families, young people, campuses, and communities."
        primaryAction={{ label: "Join a Program", to: "/ministry-programs" }}
        secondaryAction={{ label: "Support Ministry", to: "/donate" }}
      />

      <Section
        eyebrow="Ministry Moments"
        title="Photos from discipleship, training, and community life"
        description="These photos represent the heart of our ministry: building families, touching communities, and equipping disciples for global influence."
      >
        <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
          {galleryPhotos.map((photo) => (
            <article key={photo.title} className="group overflow-hidden rounded-3xl border border-sand bg-white shadow-soft transition hover:-translate-y-1">
              <div className="relative aspect-[4/3] overflow-hidden">
                <img src={photo.image} alt={photo.title} className="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" />
                <div className="absolute inset-0 bg-gradient-to-t from-pine/75 via-pine/10 to-transparent opacity-90" />
                <div className="absolute inset-x-0 bottom-0 p-5 text-white">
                  <p className="text-xs font-bold uppercase tracking-[0.13em] text-white/80">{photo.category}</p>
                  <h3 className="mt-2 text-xl leading-tight text-white">{photo.title}</h3>
                </div>
              </div>
            </article>
          ))}
        </div>
      </Section>
    </>
  );
}
