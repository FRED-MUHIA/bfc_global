import { useState } from "react";
import { NavLink, Link, useLocation } from "react-router-dom";
import { ministryPrograms, navigationLinks, organization } from "../../data/siteContent";
import Button from "../ui/Button";

const linkClass = ({ isActive }) =>
  `rounded-full px-3 py-2 text-sm font-semibold transition ${
    isActive ? "bg-mist text-pine" : "text-slate hover:bg-mist/70 hover:text-pine"
  }`;

const programPaths = [
  "/ministry-programs"
];

const mainNavigationBeforePrograms = navigationLinks.filter((item) => ["/", "/about"].includes(item.path));
const mainNavigationAfterPrograms = navigationLinks.filter((item) => ["/events", "/gallery", "/resources-hub", "/blog", "/get-involved", "/contact"].includes(item.path));
const programNavigation = navigationLinks.filter((item) => programPaths.includes(item.path));

export default function Navbar() {
  const [menuOpen, setMenuOpen] = useState(false);
  const location = useLocation();
  const programIsActive = programPaths.some((path) => location.pathname === path || location.pathname.startsWith(`${path}/`));

  return (
    <nav className="fixed inset-x-0 top-0 z-50 border-b border-sand/70 bg-cream/90 backdrop-blur-md">
      <div className="container-base flex h-20 items-center justify-between gap-6">
        <Link to="/" className="group">
          <p className="font-heading text-lg font-semibold text-pine transition group-hover:text-ember md:text-xl">
            {organization.shortName}
          </p>
          <p className="text-xs font-semibold uppercase tracking-[0.12em] text-sage">
            Family and Community Care
          </p>
        </Link>

        <button
          className="inline-flex h-11 items-center justify-center rounded-lg border border-sand px-4 text-sm font-semibold text-pine lg:hidden"
          onClick={() => setMenuOpen((prev) => !prev)}
          aria-expanded={menuOpen}
          aria-label="Toggle menu"
        >
          Menu
        </button>

        <div className="hidden items-center gap-2 lg:flex">
          {mainNavigationBeforePrograms.map((item) => (
            <NavLink key={item.path} to={item.path} className={linkClass}>
              {item.label}
            </NavLink>
          ))}
          <div className="group relative">
            <button
              type="button"
              className={`rounded-full px-3 py-2 text-sm font-semibold transition hover:bg-mist/70 hover:text-pine group-focus-within:bg-mist group-focus-within:text-pine ${
                programIsActive ? "bg-mist text-pine" : "text-slate"
              }`}
            >
              Our Programs
            </button>
            <div className="invisible absolute left-0 top-full z-30 mt-3 max-h-[75vh] w-80 translate-y-2 overflow-y-auto rounded-2xl border border-sand bg-white p-3 opacity-0 shadow-soft transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
              {programNavigation.map((item) => (
                <NavLink
                  key={item.path}
                  to={item.path}
                  className={({ isActive }) =>
                    `block rounded-xl px-4 py-3 text-sm font-semibold transition ${
                      isActive ? "bg-mist text-pine" : "text-slate hover:bg-mist/70 hover:text-pine"
                    }`
                  }
                >
                  {item.label}
                </NavLink>
              ))}
              <div className="my-2 border-t border-sand" />
              <p className="px-4 pb-2 pt-1 text-xs font-bold uppercase tracking-[0.13em] text-ember">Ministry Programs</p>
              {ministryPrograms.map((program) => (
                <NavLink
                  key={program.slug}
                  to={`/ministry-programs/${program.slug}`}
                  className={({ isActive }) =>
                    `block rounded-xl px-4 py-3 text-sm font-semibold transition ${
                      isActive ? "bg-mist text-pine" : "text-slate hover:bg-mist/70 hover:text-pine"
                    }`
                  }
                >
                  {program.menuLabel ?? program.title}
                </NavLink>
              ))}
            </div>
          </div>
          {mainNavigationAfterPrograms.map((item) => (
            <NavLink key={item.path} to={item.path} className={linkClass}>
              {item.label}
            </NavLink>
          ))}
        </div>

        <div className="hidden items-center gap-2 md:flex">
          <Button to="/get-involved" size="sm">
            Join Us
          </Button>
          <Link
            to="/donate"
            className="inline-flex items-center justify-center rounded-full bg-ember px-4 py-2 text-sm font-semibold tracking-wide text-white transition hover:bg-ember/90"
          >
            Donate
          </Link>
        </div>
      </div>

      {menuOpen && (
        <div className="border-t border-sand bg-cream px-4 pb-5 pt-3 lg:hidden">
          <div className="container-base grid gap-2 px-0">
            {mainNavigationBeforePrograms.map((item) => (
              <NavLink
                key={item.path}
                to={item.path}
                className={({ isActive }) =>
                  `rounded-lg px-3 py-2 text-sm font-semibold ${
                    isActive ? "bg-mist text-pine" : "text-slate hover:bg-mist/60"
                  }`
                }
                onClick={() => setMenuOpen(false)}
              >
                {item.label}
              </NavLink>
            ))}
            <div className="rounded-xl border border-sand/80 bg-white/50 p-2">
              <p className="px-3 pb-1 text-xs font-bold uppercase tracking-[0.13em] text-ember">Our Programs</p>
              <div className="grid gap-1">
                {programNavigation.map((item) => (
                  <NavLink
                    key={item.path}
                    to={item.path}
                    className={({ isActive }) =>
                      `rounded-lg px-3 py-2 text-sm font-semibold ${
                        isActive ? "bg-mist text-pine" : "text-slate hover:bg-mist/60"
                      }`
                    }
                    onClick={() => setMenuOpen(false)}
                  >
                    {item.label}
                  </NavLink>
                ))}
                <p className="px-3 pb-1 pt-3 text-xs font-bold uppercase tracking-[0.13em] text-ember">Ministry Programs</p>
                {ministryPrograms.map((program) => (
                  <NavLink
                    key={program.slug}
                    to={`/ministry-programs/${program.slug}`}
                    className={({ isActive }) =>
                      `rounded-lg px-3 py-2 text-sm font-semibold ${
                        isActive ? "bg-mist text-pine" : "text-slate hover:bg-mist/60"
                      }`
                    }
                    onClick={() => setMenuOpen(false)}
                  >
                    {program.menuLabel ?? program.title}
                  </NavLink>
                ))}
              </div>
            </div>
            {mainNavigationAfterPrograms.map((item) => (
              <NavLink
                key={item.path}
                to={item.path}
                className={({ isActive }) =>
                  `rounded-lg px-3 py-2 text-sm font-semibold ${
                    isActive ? "bg-mist text-pine" : "text-slate hover:bg-mist/60"
                  }`
                }
                onClick={() => setMenuOpen(false)}
              >
                {item.label}
              </NavLink>
            ))}
            <div className="mt-2 flex flex-wrap gap-2">
              <Button to="/get-involved" className="flex-1" onClick={() => setMenuOpen(false)}>
                Join Us
              </Button>
              <Link
                to="/donate"
                className="inline-flex flex-1 items-center justify-center rounded-full bg-ember px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-ember/90"
                onClick={() => setMenuOpen(false)}
              >
                Donate
              </Link>
            </div>
          </div>
        </div>
      )}
    </nav>
  );
}
