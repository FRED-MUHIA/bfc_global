import { Link } from "react-router-dom";
import SeoHead from "../components/SeoHead";
import Section from "../components/ui/Section";
import ResourceCard from "../components/ui/ResourceCard";
import TestimonialCard from "../components/ui/TestimonialCard";
import ImpactStatCard from "../components/ui/ImpactStatCard";
import BlogCard from "../components/ui/BlogCard";
import HeroSlider from "../components/ui/HeroSlider";
import NewsletterSignup from "../components/forms/NewsletterSignup";
import CTABanner from "../components/ui/CTABanner";
import {
  homeHeroSlides,
  featuredResources,
  impactStats,
  testimonials,
  blogPosts,
  organization
} from "../data/siteContent";

export default function HomePage() {
  const blogPreviews = blogPosts.slice(0, 3);

  return (
    <>
      <SeoHead
        title="Home"
        description="Faith-rooted family and community support with parenting resources, counseling, youth mentoring, and practical outreach."
      />

      <div className="py-8 md:py-10">
        <HeroSlider slides={homeHeroSlides} />
      </div>

      <Section className="bg-white/70" eyebrow="About Us" title="Building families, touching communities, changing the world">
        <div className="grid items-center gap-10 lg:grid-cols-[1.02fr_0.98fr]">
          <div className="reveal-item is-visible">
            <p className="text-base leading-8 text-slate/85 md:text-lg">{organization.aboutIntro}</p>
            <blockquote className="reveal-item is-visible mt-6 rounded-3xl border-l-4 border-ember bg-cream/80 p-5 shadow-soft" style={{ "--reveal-delay": "120ms" }}>
              <p className="text-sm font-bold uppercase tracking-[0.15em] text-ember">Nehemiah 2:18</p>
              <p className="mt-3 text-base leading-8 text-slate/85">
                Then I said to them, "You see the trouble we are in: Jerusalem lies in ruins, and its gates have been burned with fire. Come, let us rebuild the wall of Jerusalem, and we will no longer be in disgrace." I also told them about the gracious hand of my God on me and what the king had said to me. They replied, "Let us start rebuilding." So they began this good work.
              </p>
            </blockquote>
            <div className="mt-7 flex flex-wrap gap-3">
              <Link to="/about" className="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-sage">
                Learn More
              </Link>
              <Link to="/contact" className="inline-flex items-center justify-center rounded-full border border-sage/30 px-6 py-3 text-base font-semibold tracking-wide text-pine transition hover:bg-sage/10">
                Contact Us
              </Link>
            </div>
          </div>
          <div className="reveal-item is-visible float-soft overflow-hidden rounded-3xl shadow-soft" style={{ "--reveal-delay": "180ms" }}>
            <img
              src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80"
              alt="Families and community members gathered in support"
              className="h-80 w-full object-cover md:h-[28rem]"
              loading="lazy"
            />
          </div>
        </div>
      </Section>

      <Section
        eyebrow="Featured Resources"
        title="Practical tools for everyday family life"
        description="Explore our most requested guides designed for busy parents, couples, and caregivers."
      >
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {featuredResources.map((resource) => (
            <ResourceCard key={resource.title} {...resource} />
          ))}
        </div>
      </Section>

      <Section
        className="bg-white/70"
        eyebrow="Our Impact"
        title="Serving families with measurable care"
        description="By combining compassionate support with practical programs, we are seeing meaningful outcomes across communities."
      >
        <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
          {impactStats.map((stat, index) => (
            <ImpactStatCard key={stat.label} index={index} {...stat} />
          ))}
        </div>
      </Section>

      <Section
        eyebrow="Stories of Hope"
        title="Families sharing real transformation"
        description="Every testimony reflects resilience, renewed trust, and a stronger sense of belonging."
      >
        <div className="grid gap-6 lg:grid-cols-3">
          {testimonials.map((item) => (
            <TestimonialCard key={item.name} {...item} />
          ))}
        </div>
      </Section>

      <Section
        className="bg-white/60"
        eyebrow="Latest from Our Blog"
        title="Encouragement and insight for your next step"
        description="Read articles from our team on parenting, marriage, youth development, and community wellbeing."
      >
        <div className="grid gap-6 lg:grid-cols-3">
          {blogPreviews.map((post) => (
            <BlogCard key={post.slug} post={post} />
          ))}
        </div>
        <div className="mt-8">
          <Link to="/blog" className="text-sm font-semibold text-pine hover:text-ember">
            View all articles →
          </Link>
        </div>
      </Section>

      <Section
        eyebrow="Stay Connected"
        title="Monthly support for your family journey"
        description="Receive practical encouragement, upcoming events, and free resources."
      >
        <NewsletterSignup />
      </Section>

      <CTABanner
        title="Together we can build healthier homes and stronger communities."
        description="Partner with us through volunteering, sponsorship, prayer, or organizational collaboration."
        primary={{ label: "Get Involved", to: "/get-involved" }}
        secondary={{ label: "Contact Our Team", to: "/contact" }}
      />
    </>
  );
}
