import { Link } from "react-router-dom";

export default function BlogCard({ post }) {
  return (
    <article className="overflow-hidden rounded-3xl border border-sand bg-white shadow-soft transition hover:-translate-y-1">
      <img src={post.image} alt={post.title} className="h-52 w-full object-cover" loading="lazy" />
      <div className="p-6">
        <p className="text-xs font-bold uppercase tracking-[0.12em] text-ember">{post.category}</p>
        <h3 className="mt-2 text-2xl leading-tight">{post.title}</h3>
        <p className="mt-3 text-sm text-slate/80">{post.excerpt}</p>
        <p className="mt-4 text-xs text-slate/60">
          {post.date} • {post.readTime}
        </p>
        <Link
          to={`/blog/${post.slug}`}
          className="mt-5 inline-flex text-sm font-semibold text-pine transition hover:text-ember"
        >
          Read article →
        </Link>
      </div>
    </article>
  );
}
