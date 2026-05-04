import { Link } from "react-router-dom";
import { navigationLinks, organization } from "../../data/siteContent";

export default function Footer() {
  return (
    <footer className="border-t border-sand bg-white/80">
      <div className="container-base grid gap-10 py-14 md:grid-cols-3">
        <div>
          <h3 className="text-2xl">{organization.shortName}</h3>
          <p className="mt-3 max-w-sm text-sm text-slate/80">{organization.mission}</p>
        </div>

        <div>
          <h4 className="text-lg">Explore</h4>
          <div className="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">
            {navigationLinks.map((item) => (
              <Link key={item.path} to={item.path} className="text-sm text-slate/80 hover:text-pine">
                {item.label}
              </Link>
            ))}
          </div>
        </div>

        <div>
          <h4 className="text-lg">Contact</h4>
          <p className="mt-3 text-sm text-slate/80">{organization.contact.location}</p>
          <p className="mt-2 text-sm text-slate/80">{organization.contact.phone}</p>
          <p className="mt-2 text-sm text-slate/80">{organization.contact.email}</p>
          <p className="mt-2 text-sm text-slate/70">{organization.contact.hours}</p>
        </div>
      </div>
      <div className="border-t border-sand py-4">
        <p className="container-base text-xs tracking-wide text-slate/60">
          © {new Date().getFullYear()} {organization.name}. All rights reserved.
        </p>
      </div>
    </footer>
  );
}
