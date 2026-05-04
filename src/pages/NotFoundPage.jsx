import { Link } from "react-router-dom";
import SeoHead from "../components/SeoHead";
import Button from "../components/ui/Button";

export default function NotFoundPage() {
  return (
    <section className="container-base py-24">
      <SeoHead title="Page Not Found" description="The page you requested could not be found." />
      <p className="text-sm font-bold uppercase tracking-[0.16em] text-ember">404</p>
      <h1 className="mt-3 text-4xl md:text-5xl">Page Not Found</h1>
      <p className="mt-4 max-w-xl text-slate/80">
        The page you are trying to reach does not exist or may have been moved.
      </p>
      <div className="mt-8 flex flex-wrap gap-3">
        <Button to="/">Back to Home</Button>
        <Link to="/contact" className="inline-flex items-center text-sm font-semibold text-pine hover:text-ember">
          Contact support →
        </Link>
      </div>
    </section>
  );
}
