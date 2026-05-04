import SeoHead from "../components/SeoHead";
import PageHeader from "../components/layout/PageHeader";
import Section from "../components/ui/Section";
import BlogCard from "../components/ui/BlogCard";
import NewsletterSignup from "../components/forms/NewsletterSignup";
import { blogPosts } from "../data/siteContent";

export default function BlogPage() {
  return (
    <>
      <SeoHead
        title="Blog"
        description="Read encouragement, practical tips, and thought leadership on parenting, marriage, youth mentorship, counseling, and community care."
      />
      <PageHeader
        eyebrow="Blog"
        title="Insight and encouragement for family and community life"
        description="Explore articles from our team of practitioners, counselors, and community leaders."
        primaryAction={{ label: "Contact Us", to: "/contact" }}
        secondaryAction={{ label: "Get Involved", to: "/get-involved" }}
      />

      <Section title="Latest Articles">
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {blogPosts.map((post) => (
            <BlogCard key={post.slug} post={post} />
          ))}
        </div>
      </Section>

      <Section className="bg-white/70" title="Never Miss an Update">
        <NewsletterSignup />
      </Section>
    </>
  );
}
