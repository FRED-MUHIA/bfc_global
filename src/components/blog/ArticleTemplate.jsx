import { Link } from "react-router-dom";

export default function ArticleTemplate({ post }) {
  return (
    <article className="pb-16">
      <header className="relative overflow-hidden bg-gradient-to-br from-pine via-sage to-pine py-20 text-white">
        <div className="pointer-events-none absolute -right-20 top-0 h-72 w-72 rounded-full bg-ember/20 blur-3xl" />
        <div className="container-base relative">
          <Link to="/blog" className="text-sm font-semibold uppercase tracking-[0.14em] text-cream/80 hover:text-white">
            ← Back to Blog
          </Link>
          <p className="mt-8 text-xs font-bold uppercase tracking-[0.13em] text-cream/80">{post.category}</p>
          <h1 className="mt-3 max-w-4xl text-4xl leading-tight text-white md:text-5xl">{post.title}</h1>
          <p className="mt-5 text-sm text-cream/85">
            By {post.author} • {post.date} • {post.readTime}
          </p>
        </div>
      </header>

      <div className="container-base mt-10">
        <img src={post.image} alt={post.title} className="h-72 w-full rounded-3xl object-cover shadow-soft md:h-[28rem]" />
      </div>

      <div className="container-base mt-10 grid gap-8">
        {post.content.map((section) => (
          <section key={section.heading} className="glass-panel p-6 md:p-8">
            <h2 className="text-2xl">{section.heading}</h2>
            <div className="mt-4 grid gap-4">
              {section.paragraphs.map((paragraph) => (
                <p key={paragraph} className="text-slate/85">
                  {paragraph}
                </p>
              ))}
            </div>
          </section>
        ))}
      </div>
    </article>
  );
}
