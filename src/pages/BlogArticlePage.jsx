import { Link, useParams } from "react-router-dom";
import SeoHead from "../components/SeoHead";
import ArticleTemplate from "../components/blog/ArticleTemplate";
import CTABanner from "../components/ui/CTABanner";
import { blogPosts } from "../data/siteContent";

export default function BlogArticlePage() {
  const { slug } = useParams();
  const article = blogPosts.find((post) => post.slug === slug);

  if (!article) {
    return (
      <section className="container-base py-20">
        <h1 className="text-4xl">Article Not Found</h1>
        <p className="mt-4 text-slate/80">The article you are looking for may have been moved or removed.</p>
        <Link to="/blog" className="mt-6 inline-flex text-sm font-semibold text-pine hover:text-ember">
          Return to blog →
        </Link>
      </section>
    );
  }

  return (
    <>
      <SeoHead title={article.title} description={article.excerpt} />
      <ArticleTemplate post={article} />
      <CTABanner
        title="Need personalized support for your family?"
        description="Our team can connect you to counseling, mentoring, workshops, and trusted local resources."
        primary={{ label: "Contact Us", to: "/contact" }}
        secondary={{ label: "Explore Services", to: "/counseling-support" }}
      />
    </>
  );
}
